<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\LogSystem;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{
    function index(Request $request)
    {
        $data =  Agent::query();

//        return view('portal.users.index', [
//                'data' => $data,
//                'breadcrumb' => ['url_lists' => [__('all.home'), __('all.usersList')], 'url_current' => __('all.usersList')],
//                'title' => __('all.usersList'),
//            ]
//        );

        return view('portal.users.index', [
                'data' => $data->paginate(10)->appends(request()->query()),
                'breadcrumb' =>  [ __('all.main'), __('all.list').' '.__('all.users')],
                'title' => __('all.list').' '.__('all.users'),
                'description' => 'Connections Tickets open by Customer Care Team'
            ]
        );
    }

    function store(Request $request)
    {

        $validated = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ]);

        if ($validated->fails())
        {
            return redirect()->route('users.index')->withErrors($validated);
        }

        error_log($request->input('password'));

        $data = array(
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'enabled' => $request->input('enabled', 1),
            'type'   => $request->input('type', 2),
            'password'   => Hash::make($request->input('password'))
        );

        Agent::create($data);

        return redirect()->route('users.index');

    }


    function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('users.index')
                ->withErrors($validator)
                ->withInput();
        }
//        $validated = Validator::make($request->all(), [
//            'username' => 'required',
//        ]);
//
//        if ($validated->fails())
//        {
//            return redirect()->route('users.index')->withErrors($validated->errors());
//        }

//        $validated = $request->validate([
//            'username' => 'required',
//        ]);
//
//        if ($validated->fails())
//        {
//            error_log('enter here to validate ');
//            error_log(print_r($validated, true));
////            return redirect()->route('users.index')->withErrors($validated->errors());
//            return redirect()->route('users.index')->withErrors($validated);
//        }
        $data = array(
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'enabled' => $request->input('enabled'),
            'type'   => $request->input('type'),
        );
        if ($request->input('password')){
            $data['password'] = Hash::make($request->input('password'));
        }

        Agent::where('id', $id)->update($data);

        return redirect()->route('users.index');

    }

    function delete($id)
    {
        if ($id==1) {
            return redirect()
                ->route('users.index')
                ->withErrors()
                ->withInput();
        }
        Agent::where('id', $id)->delete();
        return redirect()->route('users.index');
    }

    function getSetting()
    {
        $data = new \stdClass();
        $data->min_ratio = Setting::where('key','min_ratio')->first()->value;
        $data->max_ratio = Setting::where('key','max_ratio')->first()->value;
        $data->profit_release_day = Setting::where('key','profit_release_day')->first()->value;
        return view('portal.setting.view', [
                'data' => $data,
                'breadcrumb' =>  [ __('all.main'), __('all.list').' '.__('all.setting')],
                'title' => __('all.list').' '.__('all.setting'),
                'description' => 'Connections Tickets open by Customer Care Team'
            ]
        );
    }

    function updateSetting(Request $request)
    {
        Setting::where('key','min_ratio')->update(['value'=>$request->input('min_ratio')]);
        Setting::where('key','max_ratio')->update(['value'=>$request->input('max_ratio')]);
        Setting::where('key','profit_release_day')->update(['value'=>$request->input('profit_release_day')]);
        $data = new \stdClass();
        $data->min_ratio = Setting::where('key','min_ratio')->first()->value;
        $data->max_ratio = Setting::where('key','max_ratio')->first()->value;
        $data->profit_release_day = Setting::where('key','profit_release_day')->first()->value;
        return view('portal.setting.view', [
                'data' => $data,
                'breadcrumb' =>  [ __('all.main'), __('all.list').' '.__('all.setting')],
                'title' => __('all.list').' '.__('all.setting'),
                'description' => 'Connections Tickets open by Customer Care Team'
            ]
        );
    }


    function systemIndex(Request $request)
    {


        $investor = $request->input('investor');
        $date_from = $request->input('date_from');
        $date_to = $request->input('date_to');
        $status = $request->input('status');

        $filter = new \stdClass();
        $filter->investor = $investor;
        $filter->date_from = $date_from;
        $filter->date_to = $date_to;
        $filter->status = $status;


        $data =  LogSystem::query();

        if ($status > -1) {
            $data->where('status', $status);
        }
        if ($date_from) {
            $data->whereDate('created_at', '>=',  $date_from);
        }
        if ($date_to) {
            $data->whereDate('created_at', '<=',  $date_to);
        }

        return view('portal.system-log.index', [
                'data' => $data->orderBy('id', 'desc')->paginate(10)->appends(request()->query()),
                'breadcrumb' =>  [ __('all.main'), __('all.list').' '.__('all.log-system')],
                'filter' => $filter,
                'title' => __('all.list').' '.__('all.log-system'),
                'description' => 'Connections Tickets open by Customer Care Team'
            ]
        );
    }
}
