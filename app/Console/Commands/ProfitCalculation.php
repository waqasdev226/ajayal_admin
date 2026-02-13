<?php

namespace App\Console\Commands;

use App\Http\Controllers\CalculationController;
use App\Http\Controllers\LogController;
use App\Models\ProfitRatioLog;
use App\Models\Setting;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ProfitCalculation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:profit-calculation';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'spread the profit to all investors';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $investors = User::where('enabled',1)->where('cash','>',0)->whereDate('expire_contract', '>', Carbon::now())->whereNot('id',1)->get();
        $now = Carbon::parse(Carbon::now())->format('Y-m');
        $controller = new CalculationController();
        foreach ($investors as $investor) {
            error_log('----------------- '.$investor->id);
            $expire = Carbon::parse($investor->expire_contract)->format('Y-m');
            if ( Carbon::parse($investor->created_at)->format('Y-m-d') < $now.(string)Setting::where('key','profit_release_day')->first()->value )
            {
                if ($expire == $now) {

                error_log('cash: '.$investor->cash);
                $month_days = Carbon::now()->daysInMonth;
                $ratio = $controller->getInvestorCurrentRatio($investor->id);
                error_log('ratio: '.$ratio);
                $total_month_profit = $investor->cash / $ratio;
                error_log('total_month_profit: '.$total_month_profit);
                $profit_per_day = $total_month_profit / $month_days;
                error_log('profit_per_day: '.$profit_per_day);
                $days = Carbon::now()->day;
                error_log('days: '.$days);
                $total_days_profit = $days * $profit_per_day;
                error_log('total_days_profit: '.$total_days_profit);


                $data = array(
                    'user_id' => $investor->id,
                    'cash' => $investor->cash,
                    'ratio' => $ratio,
                    'ratio_per_day' => $profit_per_day,
                    'days_to_calculate' => $days,
                    'total' => $total_days_profit,
                    'status' => 0,
                );
                $profit_create = ProfitRatioLog::create($data);
                LogController::AuditLogConsole( 'store', 'ProfitRatioLog', $profit_create->id, $profit_create, 'user profit: '.$investor->id. ', name: '.$investor->name);


                } else {
                    $controller->investorCalculate($investor->id);
                }
            }

//            $controller->investorCalculatePerDay($investor->id);
        }

    }
}
