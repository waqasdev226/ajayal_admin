<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use App\Models\Withdraw;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function index(Request $request): View
    {
        $data = new \stdClass();
        $data->total = User::where('enabled',1)->count();
        $data->cash_iqd = User::where(['enabled'=>1, 'currency'=>'IQD'])->sum('cash');
        $data->cash_usd = User::where(['enabled'=>1, 'currency'=>'USD'])->sum('cash');
        $data->profit_iqd = User::where(['enabled'=>1, 'currency'=>'IQD'])->sum('profit');
        $data->profit_usd = User::where(['enabled'=>1, 'currency'=>'USD'])->sum('profit');
        $data->profit = User::where('enabled',1)->sum('total_profit');
        $data->withdraw_count = Withdraw::where(['status'=>1])->count();
        return view('portal.dashboard.index', ['data'=>$data]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
