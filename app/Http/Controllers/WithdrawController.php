<?php

namespace App\Http\Controllers;

use App\Exports\WithdrawExport;
use App\Models\ProfitRatioLog;
use App\Models\Transactions;
use App\Models\User;
use App\Models\Withdraw;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;

class WithdrawController extends Controller
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


        $data = Withdraw::with(['userDetail' => function($query) use ($investor){
            $query->where('name', 'like', '%'.$investor.'%');
        }]);

        if ($status > -1) {
            $data->where('status', $status);
        }
        if ($date_from) {
            $data->whereDate('created_at', '>=',  $date_from);
        }
        if ($date_to) {
            $data->whereDate('created_at', '<=',  $date_to);
        }
        return view('portal.withdraw.index', [
                'data' => $data->orderBy('id', 'desc')->paginate(10)->appends(request()->query()),
                'breadcrumb' =>  [ __('all.main'), __('all.list').' '.__('all.withdraw')],
                'filter' => $filter,
                'title' => __('all.list').' '.__('all.withdraw'),
                'description' => 'Connections Tickets open by Customer Care Team'
            ]
        );
    }


    public function show($id): View
    {
        $data = Withdraw::with('userDetail')->where('id',$id)->first();
        return view('portal.withdraw.view', [
                'data' => $data,
                'breadcrumb' =>  [ __('all.main'), __('all.list').' '.__('all.withdraw')],
                'title' => __('all.list').' '.__('all.withdraw'),
                'description' => 'Connections Tickets open by Customer Care Team'
            ]
        );
    }

    public function approve(Request $request ,$id)
    {
        $transaction = Withdraw::where('id', $id)->first();
        Withdraw::where('id', $id)->update(['status'=>1]);
        $post_data = Withdraw::find($id);
        LogController::Auditlog( 'update', 'Withdraw', $id, $transaction, $post_data, 'edit withdraw: '.$id, $request);

        $user = User::find($transaction->user_id);

        $transaction_x = new Transactions();
        $transaction_x->from = $transaction->user_id;
        $transaction_x->to = 0;
        $transaction_x->amount = $transaction->amount;
        $transaction_x->current_profit = $user->profit;
        $transaction_x->type = 'withdraw';
        $transaction_x->status = 1;
        $transaction_x->save();
        LogController::Auditlog( 'store', 'Transactions', $transaction->id, null, $transaction_x, 'withdraw profit from user: '.$transaction->user_id, $request);



        User::where('id', $transaction->user_id)->decrement('profit', $transaction->amount);
        $post_user = User::find($transaction->user_id);
        LogController::Auditlog( 'update', 'User', $transaction->user_id, $user, $post_user, 'update user: '.$transaction->user_id, $request);

        return redirect()->route('withdraw-check.index');

    }


    public function export(Request $request)
    {
        $investor = $request->input('investor');
        $date_from = $request->input('date_from');
        $date_to = $request->input('date_to');
        $status = $request->input('status');
        return Excel::download(new WithdrawExport(), 'withdraw.xlsx');
    }


}
