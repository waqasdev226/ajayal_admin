<?php

namespace App\Http\Controllers;

use App\Models\ProfitRatioLog;
use App\Models\Setting;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use function Psy\debug;

class CalculationController extends Controller
{
    public function investorCalculate($id){
        $investor = User::where('id',$id)->first();
        error_log('cash: '.$investor->cash);
        $month_days = Carbon::now()->daysInMonth;
        $ratio = $this->getInvestorCurrentRatio($id);
        error_log('ratio: '.$ratio);
        $total_month_profit = $investor->cash / $ratio;
        error_log('total_month_profit: '.$total_month_profit);
        $profit_per_day = $total_month_profit / $month_days;
        error_log('profit_per_day: '.$profit_per_day);
        $days = $this->getInvestorDays($id, $ratio);
        error_log('days: '.$days);
        $total_days_profit = $days * $profit_per_day;
        error_log('total_days_profit: '.$total_days_profit);
        $data = array(
            'user_id' => $id,
            'cash' => $investor->cash,
            'ratio' => $ratio,
            'ratio_per_day' => $profit_per_day,
            'days_to_calculate' => $days,
            'total' => $total_days_profit,
            'status' => 0,
        );
        $profit_create = ProfitRatioLog::create($data);
        LogController::AuditLogConsole( 'store', 'ProfitRatioLog', $profit_create->id, $profit_create, 'user profit: '.$investor->id. ', name: '.$investor->name);

    }

    public function investorCalculatePerDay($id){
        $user = User::where('id',$id)->first();
        error_log('cash: '.$user->cash);
        $month_days = Carbon::now()->daysInMonth;
        $ratio = $this->getInvestorCurrentRatio($id);
        error_log('ratio: '.$ratio);
        $total_month_profit = $user->cash / $ratio;
        error_log('total_month_profit: '.$total_month_profit);
        $profit_per_day = $total_month_profit / $month_days;
        error_log('profit_per_day: '.$profit_per_day);
        $days = $this->getInvestorDays($id, $ratio);
        error_log('days: '.$days);
        $total_days_profit = $days * $profit_per_day;
        error_log('total_days_profit: '.$total_days_profit);
        for ($i=1; $i<=$month_days;$i++) {
            $data = array(
                'user_id' => $id,
                'cash' => $user->cash,
                'ratio' => $ratio,
                'ratio_per_day' => $profit_per_day,
                'days_to_calculate' => $i,
                'total' => $total_month_profit,
                'status' => 0,
            );
            ProfitRatioLog::create($data);
        }

    }

    public function investorCalculatePerDayAdjestCash($id){
        $user = User::where('id',$id)->first();
        error_log('cash: '.$user->cash);
        $month_days = Carbon::now()->daysInMonth;
        $ratio = $this->getInvestorCurrentRatio($id);
        error_log('ratio: '.$ratio);
        $total_month_profit = $user->cash / $ratio;
        error_log('total_month_profit: '.$total_month_profit);
        $profit_per_day = $total_month_profit / $month_days;
        error_log('profit_per_day: '.$profit_per_day);
        $days = $this->getInvestorDays($id, $ratio);
        error_log('days: '.$days);
        $total_days_profit = $days * $profit_per_day;
        error_log('total_days_profit: '.$total_days_profit);
        for ($i=1; $i<=$month_days;$i++) {
            $data = array(
                'user_id' => $id,
                'cash' => $user->cash,
                'ratio' => $ratio,
                'ratio_per_day' => $profit_per_day,
                'days_to_calculate' => $i,
                'total' => $total_month_profit,
                'status' => 0,
            );
            ProfitRatioLog::create($data);
        }

    }

    function getInvestorCurrentRatio($id): float
    {
        $user = User::where('id',$id)->first();
        if(ProfitRatioLog::where('user_id', $id)->orderBy('id', 'desc')->exists()){
            $previous_ratio = ProfitRatioLog::where('user_id', $id)->orderBy('id', 'desc')->first()->ratio;
            if ($previous_ratio == $user->max_ratio){
                $ratio = $user->min_ratio;
            } else {
                $ratio = $previous_ratio + 0.1;
            }
        } else {
            $ratio = $user->min_ratio;
            if ($ratio==0){
                $ratio = (float)Setting::where('key','min_ratio')->first()->value;
            }
        }
        return $ratio;
    }

    function getInvestorDays($id, $ratio, $type=null): float
    {
        $user = User::where('id',$id)->first();
        $month_days = Carbon::now()->daysInMonth;
        error_log($month_days);
        if ($type=='cancel'){

        } else {
            if(ProfitRatioLog::where('user_id', $id)->orderBy('id', 'desc')->exists()){
                $days = $month_days;
            } else {
                $day_start = new Carbon($user->created_at);
                $days = $month_days - $day_start->day;
            }
        }
        return $days;
    }
}
