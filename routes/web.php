<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    // If authenticated, continue to the dashboard. Otherwise send guests to login.
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }

    return redirect()->route('login');
});

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\LeaveRequestController;
use App\Http\Controllers\AdminController;

// Auth
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected routes (interns & admins)
Route::middleware(['auth'])->group(function() {
    Route::get('/dashboard', function(){
        $user = auth()->user();
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('attendances.today');
    })->name('dashboard');

    Route::get('/attendances', [AttendanceController::class,'index'])->name('attendances.index');
    Route::get('/attendances/today', [AttendanceController::class,'today'])->name('attendances.today');
    Route::post('/attendances/checkin', [AttendanceController::class,'checkin'])->name('attendances.checkin');
    Route::post('/attendances/checkout', [AttendanceController::class,'checkout'])->name('attendances.checkout');

    Route::get('/leave-requests', [LeaveRequestController::class,'index'])->name('leave_requests.index');
    Route::get('/leave-requests/create', [LeaveRequestController::class,'create'])->name('leave_requests.create');
    Route::post('/leave-requests', [LeaveRequestController::class,'store'])->name('leave_requests.store');
    Route::post('/leave-requests/{leaveRequest}/status', [LeaveRequestController::class,'updateStatus'])->name('leave_requests.updateStatus');
});

Route::middleware(['auth'])->group(function(){
    Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');
    Route::post('/profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
});

// Admin only
Route::middleware(['auth','role:admin'])->prefix('admin')->group(function() {
    Route::get('/dashboard', [AdminController::class,'dashboard'])->name('admin.dashboard');
    Route::get('/export', [AdminController::class,'exportCsv'])->name('admin.export');
    Route::get('/export/pdf', [AdminController::class,'exportPdf'])->name('admin.export.pdf');
    Route::get('/users/{id}/activity', [AdminController::class,'showUserActivity'])->name('admin.user.activity');
});
