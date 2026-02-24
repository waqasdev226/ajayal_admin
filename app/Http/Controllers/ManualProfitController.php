<?php

namespace App\Http\Controllers;

use App\Models\Transactions;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ManualProfitController extends Controller
{
    public function index()
    {
        $investors = User::where('enabled', 1)
            ->when(config('app.exclude_investor_user_ids'), fn ($q) => $q->whereNotIn('id', config('app.exclude_investor_user_ids', [])))
            ->orderBy('name')
            ->get(['id', 'name', 'phone', 'profit', 'total_profit', 'currency']);

        return view('portal.manual-profit.index', [
            'investors' => $investors,
            'breadcrumb' => [__('all.main'), 'إضافة ربح يدوي'],
            'title' => 'إضافة ربح يدوي',
            'description' => 'Manual Profit Credit',
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => ['required', 'integer', Rule::exists('users', 'id')],
            'amount' => ['required', 'numeric', 'min:0.01'],
            'currency' => ['required', Rule::in(['IQD', 'USD'])],
            'note' => ['nullable', 'string', 'max:500'],
        ], [
            'user_id.required' => 'يرجى اختيار المستثمر',
            'user_id.exists' => 'المستثمر غير موجود',
            'amount.required' => 'يرجى إدخال المبلغ',
            'amount.min' => 'المبلغ يجب أن يكون أكبر من صفر',
            'currency.required' => 'يرجى اختيار العملة',
            'currency.in' => 'العملة غير صالحة',
        ]);

        $user = User::findOrFail($validated['user_id']);
        $amount = (float) $validated['amount'];
        $currency = $validated['currency'];
        $note = $request->input('note', '');

        $user->increment('profit', $amount);
        $user->increment('total_profit', $amount);
        $user->refresh();

        $transaction = new Transactions();
        $transaction->from = null;
        $transaction->to = $user->id;
        $transaction->amount = $amount;
        $transaction->currency = $currency;
        $transaction->current_profit = (float) $user->profit;
        $transaction->type = 'profit';
        $transaction->status = 1;
        $transaction->note = $note ?: 'ربح يدوي - إضافة من لوحة التحكم';
        $transaction->method = 'manual_credit';
        if (Auth::guard('agent')->check()) {
            $transaction->created_by_guard = 'agent';
            $transaction->created_by_id = Auth::guard('agent')->id();
        } elseif (Auth::guard('web')->check()) {
            $transaction->created_by_guard = 'web';
            $transaction->created_by_id = Auth::guard('web')->id();
        }
        $transaction->save();

        LogController::Auditlog('store', 'Transactions', $transaction->id, null, $transaction, 'manual profit credit to user: ' . $user->id . ' - ' . $amount . ' ' . $currency, $request);

        return redirect()->route('manual-profit.index')->with('status', 'تم إضافة الربح بنجاح إلى رصيد المستثمر.');
    }
}
