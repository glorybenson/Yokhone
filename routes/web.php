<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
    // return view('welcome');
});


Auth::routes();

Route::get('/language/{locale}', function ($locale) {
    app()->setLocale($locale);
    session()->put('locale', $locale);
    return redirect()->back();
});

Route::group(['middleware' => ['auth']], function () {

    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
    Route::group(['middleware' => ['report']], function () {

        //Dashboard Routes
        Route::match(['get', 'post'], '/report-salaries', [App\Http\Controllers\DashboardController::class, 'salary'])->name('salary');
        Route::match(['get', 'post'], '/report-expense', [App\Http\Controllers\DashboardController::class, 'expenses'])->name('expense');
        Route::match(['get', 'post'], '/report-client', [App\Http\Controllers\DashboardController::class, 'client'])->name('client');
        Route::match(['get', 'post'], '/report-employee', [App\Http\Controllers\DashboardController::class, 'employee'])->name('employee');
        Route::match(['get', 'post'], '/report-farm', [App\Http\Controllers\DashboardController::class, 'farm'])->name('farm');
        Route::match(['get', 'post'], '/report-income', [App\Http\Controllers\DashboardController::class, 'income'])->name('income');
        Route::match(['get', 'post'], '/report-tree', [App\Http\Controllers\DashboardController::class, 'trees'])->name('tree');
    });

    Route::group(['middleware' => ['user']], function () {
        //Dashboard

        // Route::match(['get', 'post'], '/edit-user/{id}', [App\Http\Controllers\HomeController::class, 'edit_user'])->name('edit.user');
        // Route::match(['get', 'post'], '/create-user', [App\Http\Controllers\HomeController::class, 'create_user'])->name('create.user');
        // Route::get('/delete-user/{id}', [App\Http\Controllers\HomeController::class, 'delete_user'])->name('delete.user');

        //User Routes
        Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
        Route::match(['get', 'post'], '/edit-user/{id}', [App\Http\Controllers\HomeController::class, 'edit_user'])->name('edit.user');
        Route::match(['get', 'post'], '/create-user', [App\Http\Controllers\HomeController::class, 'create_user'])->name('create.user');
        Route::get('/delete-user/{id}', [App\Http\Controllers\HomeController::class, 'delete_user'])->name('delete.user');
    });


    Route::group(['middleware' => ['employee']], function () {
        //Employee Routes
        Route::get('/employees', [App\Http\Controllers\HomeController::class, 'employees'])->name('employees');
        Route::match(['get', 'post'], '/edit-employee/{id}', [App\Http\Controllers\HomeController::class, 'edit_employee'])->name('edit.employee');
        Route::match(['get', 'post'], '/view-employee/{id}', [App\Http\Controllers\HomeController::class, 'view_employee'])->name('view.employee');
        Route::match(['get', 'post'], '/create-employee', [App\Http\Controllers\HomeController::class, 'create_employee'])->name('create.employee');
        Route::match(['get'], '/destroy-employee/{id}', [App\Http\Controllers\HomeController::class, 'destroy_employee'])->name('destroy.employee');

        //Salary Route
        Route::match(['get', 'post'], '/view-employees-salary/{id}', [App\Http\Controllers\HomeController::class, 'employee_salary'])->name('salary.employee');
        Route::post('/add-salary', [App\Http\Controllers\HomeController::class, 'add_salary'])->name('add.salary');

        //Record Route
        Route::match(['get', 'post'], '/view-employees-record/{id}', [App\Http\Controllers\HomeController::class, 'employee_record'])->name('record.employee');
        Route::post('/add-record', [App\Http\Controllers\HomeController::class, 'add_record'])->name('add.record');

        //Payment Route
        Route::match(['get', 'post'], '/view-employees-payment/{id}', [App\Http\Controllers\HomeController::class, 'employee_payment'])->name('payment.employee');
        Route::post('/add-payment', [App\Http\Controllers\HomeController::class, 'add_payment'])->name('add.payment');

        //Absence Route
        Route::match(['get', 'post'], '/view-employees-absence/{id}', [App\Http\Controllers\HomeController::class, 'employee_absence'])->name('absence.employee');
        Route::post('/add-absence', [App\Http\Controllers\HomeController::class, 'add_absence'])->name('add.absence');
    });


    Route::group(['middleware' => ['farm']], function () {
        //Farms Routes
        Route::get('/farms', [App\Http\Controllers\HomeController::class, 'farms'])->name('farms');
        Route::match(['get', 'post'], '/create-farm', [App\Http\Controllers\HomeController::class, 'create_farm'])->name('create.farm');
        Route::match(['get', 'post'], '/edit-farm/{id}', [App\Http\Controllers\HomeController::class, 'edit_farm'])->name('edit.farm');

        //Trees Routes
        Route::get('/trees', [App\Http\Controllers\HomeController::class, 'trees'])->name('trees');
        Route::match(['get', 'post'], '/create-tree', [App\Http\Controllers\HomeController::class, 'create_tree'])->name('create.tree');
        Route::match(['get', 'post'], '/edit-tree/{id}', [App\Http\Controllers\HomeController::class, 'edit_tree'])->name('edit.tree');

        //Crops Routes
        Route::get('/crops', [App\Http\Controllers\HomeController::class, 'crops'])->name('crops');
        Route::match(['get', 'post'], '/create-crop', [App\Http\Controllers\HomeController::class, 'create_crop'])->name('create.crop');
        Route::match(['get', 'post'], '/edit-crop/{id}', [App\Http\Controllers\HomeController::class, 'edit_crop'])->name('edit.crop');
    });


    Route::group(['middleware' => ['client']], function () {
        //Clent Routes
        Route::get('/clients', [App\Http\Controllers\HomeController::class, 'clients'])->name('clients');
        Route::match(['get', 'post'], '/create-client', [App\Http\Controllers\HomeController::class, 'create_client'])->name('create.client');
        Route::match(['get', 'post'], '/edit-client/{id}', [App\Http\Controllers\HomeController::class, 'edit_client'])->name('edit.client');
        Route::match(['get'], '/view-client/{id}', [App\Http\Controllers\HomeController::class, 'view_client'])->name('view.client');
        Route::match(['get'], '/delete-client/{id}', [App\Http\Controllers\HomeController::class, 'destroy_client'])->name('destroy.client');
    });

    Route::group(['middleware' => ['finance']], function () {
        //Expense Routes
        Route::get('/expenses', [App\Http\Controllers\HomeController::class, 'expenses'])->name('expenses');
        Route::match(['get', 'post'], '/create-expense', [App\Http\Controllers\HomeController::class, 'create_expense'])->name('create.expense');
        Route::match(['get', 'post'], '/edit-expense/{id}', [App\Http\Controllers\HomeController::class, 'edit_expense'])->name('edit.expense');

        //Invoice Routes
        Route::get('/invoices', [App\Http\Controllers\HomeController::class, 'invoices'])->name('invoices');
        Route::match(['get', 'post'], '/create-invoice', [App\Http\Controllers\HomeController::class, 'create_invoice'])->name('create.invoice');
        Route::match(['get', 'post'], '/edit-invoice/{id}', [App\Http\Controllers\HomeController::class, 'edit_invoice'])->name('edit.invoice');
        Route::match(['post'], '/get_farm_crop', [App\Http\Controllers\HomeController::class, 'get_farm_crop'])->name('get.crop.farm');
    });


    //Settings
    Route::match(['get', 'post'], '/my-profile', [App\Http\Controllers\HomeController::class, 'my_profile'])->name('my.profile');
    Route::match(['get', 'post'], '/change-password', [App\Http\Controllers\HomeController::class, 'change_password'])->name('change.password');
    Route::match(['post'], '/delete-notification', [App\Http\Controllers\HomeController::class, 'delete_notification'])->name('delete.notification');
    Route::match(['get'], '/delete-all-notification', [App\Http\Controllers\HomeController::class, 'delete_all_notification'])->name('delete.all.notification');
});