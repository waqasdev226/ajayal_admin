<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WithdrawController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


//Route::get('/', function () {
//    return view('portal.dashboard.index');
//});
//
//Route::get('/dashboard', function () {
//    return view('dashboard');
//})->middleware(['auth', 'verified'])->name('dashboard');
//require __DIR__.'/auth.php';
Route::middleware('guest')->group(function () {
//    Route::get('register', [RegisteredUserController::class, 'create'])
//        ->name('register');
//
//    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);

//    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
//        ->name('password.request');
//
//    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
//        ->name('password.email');
//
//    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
//        ->name('password.reset');

//    Route::post('reset-password', [NewPasswordController::class, 'store'])
//        ->name('password.store');
});
Route::middleware('auth')->group(function () {
//    Route::get('verify-email', EmailVerificationPromptController::class)
//        ->name('verification.notice');
//
//    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
//        ->middleware(['signed', 'throttle:6,1'])
//        ->name('verification.verify');
//
//    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
//        ->middleware('throttle:6,1')
//        ->name('verification.send');
//
//    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
//        ->name('password.confirm');
//
//    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);
//
//    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    Route::get('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});

Route::middleware('auth')->group(function () {
    Route::get('/', [\App\Http\Controllers\DashboardController::class, 'index'])->name('home');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/pass-change', [ProfileController::class, 'passwordChange'])->name('profile.password');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('investor')->group(function () {
        Route::get('/list', [\App\Http\Controllers\InvestorController::class, 'index'])->name('investor.index');
        Route::get('/detail-general/{id}', [\App\Http\Controllers\InvestorController::class, 'showGeneral'])->name('investor.showGeneral');
        Route::get('/detail-profit/{id}', [\App\Http\Controllers\InvestorController::class, 'showProfit'])->name('investor.showProfit');
        Route::get('/detail-withdraw/{id}', [\App\Http\Controllers\InvestorController::class, 'showWithdraw'])->name('investor.showWithdraw');
        Route::get('/detail-transfer/{id}', [\App\Http\Controllers\InvestorController::class, 'showTransfer'])->name('investor.showTransfer');
        Route::get('/cancel-contract/{id}', [\App\Http\Controllers\InvestorController::class, 'cancelContract'])->name('investor.cancelContract');
        Route::post('/cancel-contract/{id}', [\App\Http\Controllers\InvestorController::class, 'finishContract'])->name('investor.finishContract');
        Route::post('/detail/{id}', [\App\Http\Controllers\InvestorController::class, 'update'])->name('investor.update');
        Route::post('/', [\App\Http\Controllers\InvestorController::class, 'store'])->name('investor.store');
    });

    Route::prefix('profit-check')->group(function () {
        Route::get('/list', [\App\Http\Controllers\ProfitController::class, 'index'])->name('profit-check.index');
        Route::get('/release-profit', [\App\Http\Controllers\ProfitController::class, 'release'])->name('profit-check.release');
        Route::get('/approve/{id}', [\App\Http\Controllers\ProfitController::class, 'approve'])->name('profit-check.approve');
    });

    Route::prefix('transaction-check')->group(function () {
        Route::get('/list', [\App\Http\Controllers\TransactionController::class, 'index'])->name('transaction-check.index');
        Route::post('/approve/{id}', [\App\Http\Controllers\TransactionController::class, 'approve'])->name('transaction-check.approve');
    });

    Route::prefix('withdraw-check')->group(function () {
        Route::get('/list', [\App\Http\Controllers\WithdrawController::class, 'index'])->name('withdraw-check.index');
        Route::get('/view/{id}', [\App\Http\Controllers\WithdrawController::class, 'show'])->name('withdraw-check.show');
        Route::post('/approve/{id}', [\App\Http\Controllers\WithdrawController::class, 'approve'])->name('withdraw-check.approve');
        Route::get('/export/', [WithdrawController::class, 'export'])->name('withdraw-check.export');

    });


    Route::prefix('system-users')->name('users.')->group(function(){
        Route::get('/', [\App\Http\Controllers\UsersController::class, 'index'])->name('index');
        Route::post('/add', [\App\Http\Controllers\UsersController::class, 'store'])->name('store');
        Route::post('/update/{id}', [\App\Http\Controllers\UsersController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [\App\Http\Controllers\UsersController::class, 'delete'])->name('delete');

    });

    Route::get('/setting', [\App\Http\Controllers\UsersController::class, 'getSetting'])->name('getSetting');
    Route::post('/setting', [\App\Http\Controllers\UsersController::class, 'updateSetting'])->name('updateSetting');
    Route::get('/system-log', [\App\Http\Controllers\UsersController::class, 'systemIndex'])->name('systemIndex');
});

