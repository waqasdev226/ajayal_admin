<?php

namespace App\Console\Commands;

use App\Http\Controllers\LogController;
use App\Models\MonthlyProfitRate;
use App\Models\ProfitRatioLog;
use App\Models\Setting;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ProfitCalculation extends Command
{
    protected $signature = 'app:profit-calculation';

    protected $description = 'Calculate monthly profit for all active investors (fixed monthly % or legacy ratio).';

    public function handle()
    {
        $excludeIds = config('app.exclude_investor_user_ids', [1]);
        $now = Carbon::now();
        $yearMonth = $now->format('Y-m');

        $investors = User::where('enabled', 1)->where('cash', '>', 0)
            ->whereDate('expire_contract', '>', Carbon::now())
            ->when(!empty($excludeIds), fn ($q) => $q->whereNotIn('id', $excludeIds))
            ->get();

        $monthlyRate = MonthlyProfitRate::where('year_month', $yearMonth)->first();

        $now = Carbon::now();
        foreach ($investors as $investor) {
            // Prevent duplicate: skip if this user already has a profit record for this month
            $exists = ProfitRatioLog::where('user_id', $investor->id)
                ->where(function ($q) use ($yearMonth, $now) {
                    $q->where('year_month', $yearMonth)
                        ->orWhere(function ($q2) use ($now) {
                            $q2->whereNull('year_month')
                                ->whereMonth('created_at', $now->month)
                                ->whereYear('created_at', $now->year);
                        });
                })
                ->exists();
            if ($exists) {
                continue;
            }

            if ($monthlyRate && (float) $monthlyRate->percentage > 0) {
                // New logic: fixed monthly percentage for all — Profit = Investment × Monthly Rate
                $profitAmount = $investor->cash * ((float) $monthlyRate->percentage / 100);
                $data = [
                    'user_id' => $investor->id,
                    'year_month' => $yearMonth,
                    'cash' => $investor->cash,
                    'ratio' => 0,
                    'ratio_per_day' => 0,
                    'days_to_calculate' => 0,
                    'total' => round($profitAmount, 2),
                    'status' => 0,
                ];
                $profit_create = ProfitRatioLog::create($data);
                LogController::AuditLogConsole('store', 'ProfitRatioLog', $profit_create->id, $profit_create, 'user profit (monthly %): ' . $investor->id . ', name: ' . $investor->name);
                continue;
            }

            // Legacy ratio-based logic (when no monthly rate is set)
            $setting = Setting::where('key', 'profit_release_day')->first();
            $releaseDay = $setting ? (string) $setting->value : '01';
            $createdStr = Carbon::parse($investor->created_at)->format('Y-m-d');
            if ($createdStr >= $yearMonth . $releaseDay) {
                continue;
            }
            $expire = Carbon::parse($investor->expire_contract)->format('Y-m');
            $controller = new \App\Http\Controllers\CalculationController();
            if ($expire === $now) {
                $month_days = Carbon::now()->daysInMonth;
                $ratio = $controller->getInvestorCurrentRatio($investor->id);
                $total_month_profit = $investor->cash / $ratio;
                $profit_per_day = $total_month_profit / $month_days;
                $days = Carbon::now()->day;
                $total_days_profit = $days * $profit_per_day;
                $data = [
                    'user_id' => $investor->id,
                    'year_month' => $yearMonth,
                    'cash' => $investor->cash,
                    'ratio' => $ratio,
                    'ratio_per_day' => $profit_per_day,
                    'days_to_calculate' => $days,
                    'total' => $total_days_profit,
                    'status' => 0,
                ];
                $profit_create = ProfitRatioLog::create($data);
                LogController::AuditLogConsole('store', 'ProfitRatioLog', $profit_create->id, $profit_create, 'user profit: ' . $investor->id . ', name: ' . $investor->name);
            } else {
                $controller->investorCalculate($investor->id);
            }
        }

        return 0;
    }
}
