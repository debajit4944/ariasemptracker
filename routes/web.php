<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\DistrictController;
use App\Http\Controllers\DesignationController;
use App\Http\Controllers\OfficeController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\EmployeeDesignationController;
use App\Http\Controllers\EmployeeOfficeController;
use App\Http\Controllers\EmployeeDistrictController;
use App\Http\Controllers\CtpController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\EmployeeLeaveController;
use App\Http\Controllers\ResignationController;
use App\Http\Controllers\PdfController;


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
    return view('welcome');
});
Route::get('/test', function () {
    return view('test');
});
Route::controller(LoginController::class)->group(function(){

    Route::get('login', 'index')->name('login');

    Route::get('registration', 'registration')->name('registration');

    Route::get('logout', 'logout')->name('logout');

    Route::post('validate_registration', 'validate_registration')->name('login.validate_registration');

    Route::post('validate_login', 'validate_login')->name('login.validate_login');

    Route::get('dashboard', 'dashboard')->name('dashboard');

})->middleware('auth');

Route::resource('project', ProjectController::class)->middleware('auth');
Route::resource('district', DistrictController::class)->middleware('auth');
Route::resource('designation', DesignationController::class)->middleware('auth');
Route::resource('office', OfficeController::class)->middleware('auth');
Route::resource('employee', EmployeeController::class)->middleware('auth');
Route::get('employee/download_emp_file/{id}', [EmployeeController::class, 'downloadEmpFile'])->name('employee.downloadEmpFile')->middleware('auth');
Route::get('employees/displayAllEmp', [EmployeeController::class, 'displayAllEmp'])->name('employees.displayAllEmp')->middleware('auth');
Route::get('employees/export/', [EmployeeController::class, 'export'])->name('employees.export')->middleware('auth');
Route::resource('leave', LeaveController::class)->middleware('auth');

Route::get('/employee_designation/{employee}/create', [EmployeeDesignationController::class, 'create'])->name('employee_designation.create')->middleware('auth');
Route::post('/employee_designation/store', [EmployeeDesignationController::class, 'store'])->name('employee_designation.store')->middleware('auth');
Route::get('/employee_designation/{employee_designation_id}/edit', [EmployeeDesignationController::class, 'edit'])->name('employee_designation.edit')->middleware('auth');
Route::match(['put', 'patch'],'/employee_designation/{employee_designation_id}', [EmployeeDesignationController::class, 'update'])->name('employee_designation.update')->middleware('auth');
Route::delete('/employee_designation/{employee_designation_id}/{employee_id}', [EmployeeDesignationController::class, 'destroy'])->name('employee_designation.destroy')->middleware('auth');
Route::get('/employee_designation/download_emp_designation_file/{empDesgId}', [EmployeeDesignationController::class, 'downloadEmpDesgFile'])->name('employee_designation.downloadEmpDesgFile')->middleware('auth');

Route::get('/employee_office/{employee}/create', [EmployeeOfficeController::class, 'create'])->name('employee_office.create')->middleware('auth');
Route::post('/employee_office/store', [EmployeeOfficeController::class, 'store'])->name('employee_office.store')->middleware('auth');
Route::get('/employee_office/{employee_office_id}/edit', [EmployeeOfficeController::class, 'edit'])->name('employee_office.edit')->middleware('auth');
Route::match(['put', 'patch'],'/employee_office/{employee_office_id}', [EmployeeOfficeController::class, 'update'])->name('employee_office.update')->middleware('auth');
Route::delete('/employee_office/{employee_office_id}/{employee_id}', [EmployeeOfficeController::class, 'destroy'])->name('employee_office.destroy')->middleware('auth');
Route::get('/employee_office/download_emp_office_file/{empOfficeId}', [EmployeeOfficeController::class, 'downloadEmpOfficeFile'])->name('employee_office.downloadEmpOfficeFile')->middleware('auth');

Route::get('/employee_district/{employee}/create', [EmployeeDistrictController::class, 'create'])->name('employee_district.create')->middleware('auth');
Route::post('/employee_district/store', [EmployeeDistrictController::class, 'store'])->name('employee_district.store')->middleware('auth');
Route::get('/employee_district/{employee_district_id}/edit', [EmployeeDistrictController::class, 'edit'])->name('employee_district.edit')->middleware('auth');
Route::match(['put', 'patch'],'/employee_district/{employee_district_id}', [EmployeeDistrictController::class, 'update'])->name('employee_district.update')->middleware('auth');
Route::delete('/employee_district/{employee_district_id}/{employee_id}', [EmployeeDistrictController::class, 'destroy'])->name('employee_district.destroy')->middleware('auth');
Route::get('/employee_district/test', [EmployeeDistrictController::class, 'test'])->name('employee_district.test')->middleware('auth');
Route::get('/employee_district/download_emp_district_file/{empDistId}', [EmployeeDistrictController::class, 'downloadEmpDistFile'])->name('employee_district.downloadEmpDistFile')->middleware('auth');


Route::get('/employee_ctp/{employee}/create', [CtpController::class, 'create'])->name('employee_ctp.create')->middleware('auth');
Route::post('/employee_ctp/store', [CtpController::class, 'store'])->name('employee_ctp.store')->middleware('auth');
Route::get('/employee_ctp/{ctp}/edit', [CtpController::class, 'edit'])->name('employee_ctp.edit')->middleware('auth');
Route::match(['put', 'patch'],'/employee_ctp/{ctp}', [CtpController::class, 'update'])->name('employee_ctp.update')->middleware('auth');
Route::delete('/employee_ctp/{ctp}', [CtpController::class, 'destroy'])->name('employee_ctp.destroy')->middleware('auth');
Route::get('/employee_ctp/download_emp_ctp_file/{empCtpId}', [CtpController::class, 'downloadEmpCtpFile'])->name('employee_ctp.downloadEmpCtpFile')->middleware('auth');

Route::get('/employee_leave/index', [EmployeeLeaveController::class, 'index'])->name('employee_leave.index')->middleware('auth');
Route::get('/employee_leave/{employee}/create', [EmployeeLeaveController::class, 'create'])->name('employee_leave.create')->middleware('auth');
Route::post('/employee_leave/store', [EmployeeLeaveController::class, 'store'])->name('employee_leave.store')->middleware('auth');
Route::get('/employee_leave/{employee_leave_id}/edit', [EmployeeLeaveController::class, 'edit'])->name('employee_leave.edit')->middleware('auth');
Route::match(['put', 'patch'],'/employee_leave/{employee_leave_id}', [EmployeeLeaveController::class, 'update'])->name('employee_leave.update')->middleware('auth');
Route::delete('/employee_leave/{employee_leave_id}/{employee_id}', [EmployeeLeaveController::class, 'destroy'])->name('employee_leave.destroy')->middleware('auth');
Route::get('/employee_leave/download_emp_leave_file/{empLeaveId}', [EmployeeLeaveController::class, 'downloadEmpLeaveFile'])->name('employee_leave.downloadEmpLeaveFile')->middleware('auth');

Route::get('/employee_resignation/{employee}/create', [ResignationController::class, 'create'])->name('employee_resignation.create')->middleware('auth');
Route::post('/employee_resignation/store', [ResignationController::class, 'store'])->name('employee_resignation.store')->middleware('auth');
Route::get('/employee_resignation/{resignation}/edit', [ResignationController::class, 'edit'])->name('employee_resignation.edit')->middleware('auth');
Route::match(['put', 'patch'],'/employee_resignation/{resignation}', [ResignationController::class, 'update'])->name('employee_resignation.update')->middleware('auth');
Route::delete('/employee_resignation/{resignation}', [ResignationController::class, 'destroy'])->name('employee_resignation.destroy')->middleware('auth');
Route::get('/employee_resignation/download_emp_resignation_file/{empResignationId}', [ResignationController::class, 'downloadEmpResignationFile'])->name('employee_resignation.downloadEmpResignationFile')->middleware('auth');

// Route::get("/test/leave", function(){
//     return view('employee_leave.create');
//  });
Route::get('generate-pdf/{employee}',[PdfController::class, 'generateEmployeeDetailPdf'])->name('generate-pdf');