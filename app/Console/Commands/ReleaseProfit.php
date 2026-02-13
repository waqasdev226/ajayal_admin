<?php

namespace App\Console\Commands;

use App\Http\Controllers\LogController;
use App\Models\ProfitRatioLog;
use App\Models\Setting;
use App\Models\Transactions;
use App\Models\User;
use App\Models\Withdraw;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ReleaseProfit extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:release-profit';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Release profit to investors after 25th or month';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if (Carbon::now()->day >= (int)Setting::where('key','profit_release_day')->first()->value ) {
//            $investors = User::where('enabled',1)->get();
            $profits = ProfitRatioLog::whereMonth('created_at', Carbon::now()->month)->get();
            foreach ($profits as $profit) {
                $user = User::find($profit->user_id);
                ProfitRatioLog::where('id', $profit->id)->update(['status'=>1]);
                User::where('id', $profit->user_id)->increment('profit', $profit->total);
                User::where('id', $profit->user_id)->increment('total_profit', $profit->total);
//                $post_data = User::find($profit->user_id);
//                LogController::Auditlog( 'update', 'User', $profit->user_id, $user, $post_data, 'update user: '.$profit->user_id, $request);

                $transaction = new Transactions();
                $transaction->from = 0;
                $transaction->to = $profit->user_id;
                $transaction->amount = $profit->total;
                $transaction->current_profit = $user->profit;
                $transaction->type = 'profit';
                $transaction->status = 1;
                $transaction->save();
                LogController::Auditlog( 'store', 'Transactions', $transaction->id, null, $transaction, 'add profit ot user: '.$profit->user_id, $request);

            }
//            $profitReleases = ProfitRatioLog::whereMonth('created_at', Carbon::now()->month)->get();
//            foreach ($profitReleases as $profitRelease)
//            {
//                $investor = User::find($profitRelease->user_id);
//                $profit_log_first = ProfitRatioLog::where('user_id',$profitRelease->user_id)->whereMonth('created_at', Carbon::now()->month)->first();
//                $total_profit = $profit_log_first->total;
//                $total_sum = ProfitRatioLog::where('user_id',$profitRelease->user_id)->whereMonth('created_at', Carbon::now()->month)->sum('amount');
//                if ($total_profit > $total_sum)
//                {
//                    $remain = $total_profit-$total_sum;
//                    ProfitRatioLog::where('user_id',$profitRelease->user_id)->whereMonth('created_at', Carbon::now()->month)->order('days_to_calculate', 'desc')->increment($remain);
//                }
////                Withdraw::where('id', $profitRelease->id)->update(['amount'=>$total_profit]);
//                $transaction_x = new Transactions();
//                $transaction_x->from = 1;
//                $transaction_x->to = $profitRelease->user_id;
//                $transaction_x->amount = $total_profit;
//                $transaction_x->current_profit = User::find($profitRelease->user_id)->profit;
//                $transaction_x->type = 'withdraw';
//                $transaction_x->status = 0;
//                $transaction_x->save();
//
//            }
        }
    }
}
