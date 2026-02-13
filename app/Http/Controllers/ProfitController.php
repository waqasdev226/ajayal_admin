<?php

namespace App\Http\Controllers;

use App\Models\ProfitRatioLog;
use App\Models\Transactions;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class ProfitController extends Controller
{
    public function index(Request $request){
        $investor = $request->input('investor');
        $date_from = $request->input('date_from');
        $date_to = $request->input('date_to');
        $status = $request->input('status');

        $filter = new \stdClass();
        $filter->investor = $investor;
        $filter->date_from = $date_from;
        $filter->date_to = $date_to;
        $filter->status = $status;


        $data = ProfitRatioLog::with('userDetail');

        if ($investor) {
            $data->whereHas('userDetail', function($q) use ($investor){
                $q->where('name', 'like', "%$investor%" );
            });
        }
        if ($status > -1) {
            $data->where('status', $status);
        }
        if ($date_from) {
            $data->whereDate('created_at', '>=',  $date_from);
        }
        if ($date_to) {
            $data->whereDate('created_at', '<=',  $date_to);
        }
        return view('portal.profit.index', [
                'data' => $data->orderBy('id','desc')->paginate(10)->appends(request()->query()),
                'breadcrumb' =>  [ __('all.main'), __('all.list').' '.__('all.profit')],
                'filter' => $filter,
                'title' => __('all.list').' '.__('all.profit'),
                'description' => 'Connections Tickets open by Customer Care Team'
            ]
        );
    }

    public function approve(Request $request, $id){
        $profits = ProfitRatioLog::where('id', $id)->get();
        foreach ($profits as $profit) {
            $user = User::find($profit->user_id);
            ProfitRatioLog::where('id', $profit->id)->update(['status'=>1]);
            User::where('id', $profit->user_id)->increment('profit', $profit->total);
            User::where('id', $profit->user_id)->increment('total_profit', $profit->total);
            $post_data = User::find($profit->user_id);
            LogController::Auditlog( 'update', 'User', $profit->user_id, $user, $post_data, 'update user: '.$profit->user_id, $request);

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

        return redirect()->route('profit-check.index');

    }

    public function release(): \Illuminate\Http\RedirectResponse
    {
        Artisan::call('app:profit-calculation');
        return redirect()->route('profit-check.index');
    }
}
