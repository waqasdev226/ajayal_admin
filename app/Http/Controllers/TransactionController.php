<?php

namespace App\Http\Controllers;

use App\Models\ProfitRatioLog;
use App\Models\Transactions;
use App\Models\User;
use Illuminate\Http\Request;

class TransactionController extends Controller
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

        $data = Transactions::with('fromUser', 'toUser');

        if ($investor) {
            $data->whereHas('fromUser', function($q) use ($investor){
                $q->where('name', 'like', "%$investor%" );
            })->orWhereHas('toUser', function($q) use ($investor){
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
        return view('portal.transaction.index', [
                'data' => $data->paginate(10)->appends(request()->query()),
                'breadcrumb' =>  [ __('all.main'), __('all.list').' '.__('all.transaction')],
                'filter' => $filter,
                'title' => __('all.list').' '.__('all.transaction'),
                'description' => 'Connections Tickets open by Customer Care Team'
            ]
        );
    }

    public function approve(Request $request ,$id)
    {
        $transaction = Transactions::where('id', $id)->first();
        Transactions::where('id', $id)->update(['status'=>1]);
        $post_data = Transactions::find($id);
        LogController::Auditlog( 'update', 'Transactions', $id, $transaction, $post_data, 'edit transaction: '.$id, $request);

        return redirect()->route('transaction-check.index');

    }
}
