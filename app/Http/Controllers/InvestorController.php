<?php

namespace App\Http\Controllers;

use App\Models\ProfitRatioLog;
use App\Models\Setting;
use App\Models\Transactions;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Validator;

class InvestorController extends Controller
{
    public function index (Request $request) {
        $search = $request->input('search');

        $filter = new \stdClass();
        $filter->search = $search;

        $data = User::withTrashed();

        if ($search) {
            $data->where('name', 'like', "%$search%")
                ->orWhere('reference', 'like', "%$search%")
                ->orWhere('phone', 'like', "%$search%");
        }

        return view('portal.investor.index', [
                'data' => $data->paginate(10)->appends(request()->query()),
                'breadcrumb' =>  [ __('all.main'), __('all.list').' '.__('all.investors')],
                'filter' => $filter,
                'title' => __('all.list').' '.__('all.investors'),
                'description' => 'Connections Tickets open by Customer Care Team'
            ]
        );
    }

    public function showGeneral (Request $request, $id) {
        $data = Transactions::where('to', $id)->orWhere('from', $id)
            ->with('fromUser', 'toUser')
            ->orderBy('id', 'desc');

        return view('portal.investor.detail.general', [
                'data' => User::where('id', $id)->first(),
                'trans' => $data->paginate(10)->appends(request()->query()),
                'breadcrumb' =>  [__('all.main'), __('all.list').' '.__('all.investors'), __('all.show').' '.__('all.investor')],
            ]
        );
    }

    public function showProfit (Request $request, $id) {
        $data = Transactions::where('to', $id)
            ->where('type', '=', 'profit')
            ->with('fromUser')
            ->orderBy('id', 'desc');

        return view('portal.investor.detail.profit', [
                'data' => User::where('id', $id)->first(),
                'trans' => $data->paginate(10)->appends(request()->query()),
                'breadcrumb' =>  [__('all.main'), __('all.list').' '.__('all.investors'), __('all.show').' '.__('all.investor')],
            ]
        );
    }

    public function showWithdraw (Request $request, $id) {
        $data = Transactions::where('from', $id)
            ->where('type', '=', 'withdraw')
            ->with('fromUser')
            ->orderBy('id', 'desc');

        return view('portal.investor.detail.withdraw', [
                'data' => User::where('id', $id)->first(),
                'trans' => $data->paginate(10)->appends(request()->query()),
                'breadcrumb' =>  [__('all.main'), __('all.list').' '.__('all.investors'), __('all.show').' '.__('all.investor')],
            ]
        );
    }

    public function showTransfer (Request $request, $id) {
        $data = Transactions::where('from', $id)
            ->where('type', '=', 'transfer')
            ->with('fromUser')
            ->orderBy('id', 'desc');

        return view('portal.investor.detail.transfer', [
                'data' => User::where('id', $id)->first(),
                'trans' => $data->paginate(10)->appends(request()->query()),
                'breadcrumb' =>  [__('all.main'), __('all.list').' '.__('all.investors'), __('all.show').' '.__('all.investor')],
            ]
        );
    }
    public function cancelContract (Request $request, $id) {
        $investor = User::find($id);
        $calculation = new CalculationController();

        $user = User::where('id',$id)->first();
        error_log('cash: '.$user->cash);
        $month_days = Carbon::now()->daysInMonth;
        $ratio = $calculation->getInvestorCurrentRatio($id);
        error_log('ratio: '.$ratio);
if($ratio==0)$ratio=1;
        $total_month_profit = $user->cash / $ratio;
        error_log('total_month_profit: '.$total_month_profit);
        $profit_per_day = $total_month_profit / $month_days;
        error_log('profit_per_day: '.$profit_per_day);
        $days = Carbon::now()->day;
        error_log('days: '.$days);
        $total_days_profit = $days * $profit_per_day;
        error_log('total_days_profit: '.$total_days_profit);



        $data = new \stdClass();
        $data->id = $id;
        $data->cash = $investor->cash;
        $data->currency = $investor->currency;
        $data->expire_contract = $investor->expire_contract;
        $data->profit = $investor->profit;
        $data->total_profit = $investor->total_profit;
        $data->days = $days;
        $data->profit_per_day = round($profit_per_day, 2);
        $data->net_profit = round($investor->profit + $total_days_profit, 0);

        return view('portal.investor.detail.cancelContract', [
                'data' => User::where('id', $id)->first(),
                'cancel' => $data,
                'breadcrumb' =>  [__('all.main'), __('all.list').' '.__('all.investors'), __('all.show').' '.__('all.investor')],
            ]
        );
    }
    public function finishContract (Request $request, $id) {
        $investor = User::find($id);
        $calculation = new CalculationController();

        $user = User::where('id',$id)->first();
        error_log('cash: '.$user->cash);
        $month_days = Carbon::now()->daysInMonth;
        $ratio = $calculation->getInvestorCurrentRatio($id);
        error_log('ratio: '.$ratio);
if($ratio==0)$ratio=1;
        $total_month_profit = $user->cash / $ratio;
        error_log('total_month_profit: '.$total_month_profit);
        $profit_per_day = $total_month_profit / $month_days;
        error_log('profit_per_day: '.$profit_per_day);
        $days = Carbon::now()->day;
        error_log('days: '.$days);
        $total_days_profit = $days * $profit_per_day;
        error_log('total_days_profit: '.$total_days_profit);


        $data = array(
            'user_id' => $id,
            'cash' => $user->cash,
            'ratio' => $ratio,
            'ratio_per_day' => $profit_per_day,
            'days_to_calculate' => $days,
            'total' => $total_days_profit,
            'status' => 0,
        );
        ProfitRatioLog::create($data);


        $investor->phone = 'del_'.$investor->phone;
        $investor->enabled = 0;

        $investor->update();

        User::where('id',$id)->delete();




        return redirect()->route('investor.index');
    }


    public function store (Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|unique:users,phone',
            'cash' => 'required|numeric|min:0',
            'currency' => 'required|in:IQD,USD',
            'expire_contract' => 'required|date',
            'contract_ref' => 'nullable|string|max:255',
        ], [
            'name.required' => __('Please enter the investor name.'),
            'phone.unique' => __('This phone number is already registered.'),
        ]);

        if ($validator->fails()) {
            return redirect()->route('investor.index')
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $minRatioSetting = Setting::where('key', 'min_ratio')->first();
            $maxRatioSetting = Setting::where('key', 'max_ratio')->first();
            $minRatio = $minRatioSetting ? (float) $minRatioSetting->value : 5;
            $maxRatio = $maxRatioSetting ? (float) $maxRatioSetting->value : 15;
        } catch (\Throwable $e) {
            return redirect()->route('investor.index')
                ->with('error', __('Something went wrong. Please try again.'))
                ->withInput();
        }

        $data = array(
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make('1@#$1Q'),
            'phone' => $request->input('phone'),
            'reference' => 'AL_'.(string)((User::count() * 5) + 2500),
            'cash' => (float)$request->input('cash'),
            'min_ratio' => $minRatio,
            'max_ratio' => $maxRatio,
            'currency' => $request->input('currency'),
            'expire_contract' => $request->input('expire_contract'),
            'city' => $request->input('city'),
            'insurance' => $request->input('insurance'),
            'enabled' => $request->input('enabled', 1),
            'contract_ref' => $request->input('contract_ref'),
        );

        $user = User::create($data);

        LogController::Auditlog( 'add', 'User', $user->id, $user, $user, 'update user', $request);

        return redirect()->route('investor.showGeneral', $user->id);
    }

    public function update (Request $request, $id) {
        error_log($request->input('cash'));
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'phone' => 'required',
            'expire_contract' => 'required',
            'cash' => 'required|numeric|gt:0',
            'currency' => 'required',
        ])->validate();

        $post_data = User::find($id);
        $data = array(
            'name' => $request->input('name'),
            'email' => $request->input('email'),
//            'password' => $request->input('password'),
            'phone' => $request->input('phone'),
            'enabled' => $request->input('enabled'),
            'reference' => $request->input('reference'),
//            'profit' => $request->input('profit'),
//            'total_profit' => $request->input('total_profit'),
            'min_ratio' => (float)$request->input('min_ratio'),
            'max_ratio' => (float)$request->input('max_ratio'),
            'currency' => $request->input('currency'),
            'contract_ref' => $request->input('contract_ref'),
            'expire_contract' => $request->input('expire_contract'),
            'city' => $request->input('city'),
            'insurance' => $request->input('insurance'),
            'wdr_method' => $request->input('wdr_method'),
            'wdr_phone' => $request->input('wdr_phone'),
            'wdr_name' => $request->input('wdr_name'),
            'wdr_passport' => $request->input('wdr_passport'),
            'wdr_bank_account' => $request->input('wdr_bank_account'),
            'wdr_swift' => $request->input('wdr_swift'),
            'wdr_card_no' => $request->input('wdr_card_no'),
            'document_type' => $request->input('document_type'),
        );

        if ($post_data->cash != (float)$request->input('cash') && $request->input('cash') != null){
            $validator = Validator::make($request->all(), [
                'cash' => 'required|min:1',
                'currency' => 'required',
            ])->validate();
            $data['cash'] = (float)$request->input('cash');
            $data['currency'] = $request->input('currency');
        }


        $pre_data = User::find($id);

        $user = User::find($id);
        if ($post_data->cash == 0) {
            $data['cash'] = (float)$request->input('cash');
            if ((float)$request->input('cash') > $post_data->cash) {
                $data['cash'] = (float)$request->input('cash');
                $calculation = new CalculationController();

                error_log('cash: '.(float)$request->input('cash'));
                $month_days = Carbon::now()->daysInMonth;
                $ratio = $calculation->getInvestorCurrentRatio($id);
                error_log('ratio: '.$ratio);
                $total_month_profit = $user->cash / $ratio;
                error_log('total_month_profit: '.$total_month_profit);
                $profit_per_day = $total_month_profit / $month_days;
                error_log('profit_per_day: '.$profit_per_day);
                $days = Carbon::now()->day;
                error_log('days: '.$days);
                $total_days_profit = ($month_days - $days) * $profit_per_day;
                error_log('total_days_profit: '.$total_days_profit);
                $data = array(
                    'user_id' => $id,
                    'cash' => (float)$request->input('cash'),
                    'ratio' => $ratio,
                    'ratio_per_day' => $profit_per_day,
                    'days_to_calculate' => $days,
                    'total' => $total_days_profit,
                    'status' => 0,
                );
                ProfitRatioLog::create($data);
//            $data['profit'] = round($total_days_profit,0);
            }

        }

        if ($request->hasFile('id_back_image')) {
            $destinationPath = public_path() . '/attachments/'. $user->id . '/';
            $file = $request->file('id_back_image');
            $name = $pre_data->id.'-back_image-' .$pre_data->reference. '.' . $file->getClientOriginalExtension();
            $name = str_replace(' ', '-',$name);
            $file->move($destinationPath, $name);
            $data['id_back_image'] = '/attachments/'. $user->id .'/'. $name;
        }

        if ($request->hasFile('id_front_image')) {
            $destinationPath = public_path() . '/attachments/'. $user->id . '/';
            $file = $request->file('id_front_image');
            $name = $pre_data->id.'-front_image-' .$pre_data->reference. '.' . $file->getClientOriginalExtension();
            $name = str_replace(' ', '-',$name);
            $file->move($destinationPath, $name);
            $data['id_front_image'] = '/attachments/'. $user->id .'/'. $name;
        }

        $user->update($data);

        LogController::Auditlog( 'update', 'User', $id, $user, $post_data, 'update user', $request);

        return redirect()->route('investor.showGeneral', $id);
    }
}
