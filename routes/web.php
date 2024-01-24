<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ManageController;
use App\Http\Controllers\PDFExportController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SendMailController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

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
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::prefix('/')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/attendence-record', [HomeController::class, 'show'])->name('attendence');
    Route::get('/attendence-record/create', [HomeController::class, 'create'])->name('attendence.create');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('company', CompanyController::class);
    Route::resource('manage', ManageController::class);
    Route::resource('user', UserController::class);
    Route::resource('attendance', AttendanceController::class);
    Route::resource('role', RoleController::class);
    Route::resource('manage', ManageController::class);
    Route::get('/attendance/fetch/{id}', [AttendanceController::class, 'fetchAttendance'])->name('attendance.fetch');
    Route::get('/attendance_view', [AttendanceController::class, 'show'])->name('attendance_view');
    Route::post('attendance/create/{user_id}', [AttendanceController::class, 'update'])->name('attendance.update_id');
    Route::get('/companies/{id}', 'CompanyController@index')->name('company.index_id');


    # Email verification goes here
    Route::get('/send-mail', [SendMailController::class, 'index'])->name('send_mail');
    Route::get('/admin-mail', [SendMailController::class, 'response'])->name('admin_mail');


    Route::get('/export-attendance', [AttendanceController::class, 'exportAttendance'])->name('export-attendance');
    Route::get('/export-pdfs', [AttendanceController::class, 'pdfAttendance'])->name('export-pdfs');

    // Route::get('/generate-pdf', function () {
    //     return $pdf->download('sample.pdf');
    // })->name('export-pdf');
});
require __DIR__ . '/auth.php';
