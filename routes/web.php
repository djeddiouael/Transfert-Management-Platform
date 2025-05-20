<?php

use App\Http\Controllers\auth\LoginController;
use App\Http\Controllers\AutherController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BookIssueController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\dashboardController;
use App\Http\Controllers\PublisherController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ChefDomaineController;
use App\Http\Controllers\FaculteController;
use App\Http\Controllers\TransferRequestController;
use App\Http\Controllers\TransferTypeController;
use App\Http\Controllers\LanguageController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

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

// Language switching route
Route::get('language/{locale}', [LanguageController::class, 'switch'])->name('language.switch');

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale()
    ], function(){
Route::get('/', function () {
    $categories=\App\Models\category::whereStatus('1')->get();
    return view('front.index',compact('categories'));
})->name('/');

Route::get('/login', function () {
    return view('welcome');
})->name('view_login');
Route::post('/', [LoginController::class, 'login'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout_get');
Route::post('/change-password', [LoginController::class, 'changePassword'])->name('change_password');
Route::post('/student/register', [StudentController::class, 'register'])->name('student.register');
Route::post('/search', [BookController::class, 'search'])->name('book.search');
Route::get('/register', function () {
    return view('register');
})->name('register');

Route::post('/register', [App\Http\Controllers\Auth\RegisterController::class, 'store'])->name('register.submit');
});




Route::get('student/profile', [StudentController::class, 'showProfile'])
    ->name('student.profile')
    ->middleware(['auth', 'agent']);

Route::middleware('auth')->group(function () {
    Route::get('change-password',[dashboardController::class,'change_password_view'])->name('change_password_view');
    Route::post('change-password',[dashboardController::class,'change_password'])->name('change_password');
    Route::get('/dashboard', [dashboardController::class, 'index'])->name('dashboard');
    Route::post('/dashboard/filter', [dashboardController::class, 'filter'])->name('dashboard.filter');

    Route::resource('chefdomaine',ChefDomaineController::class);
    Route::resource('studenttransfere',TransferRequestController::class);

    // author CRUD
    Route::get('/authors', [AutherController::class, 'index'])->name('authors');
    Route::get('/authors/create', [AutherController::class, 'create'])->name('authors.create');
    Route::get('/authors/edit/{auther}', [AutherController::class, 'edit'])->name('authors.edit');
    Route::post('/authors/update/{id}', [AutherController::class, 'update'])->name('authors.update');
    Route::post('/authors/delete/{id}', [AutherController::class, 'destroy'])->name('authors.destroy');
    Route::post('/authors/create', [AutherController::class, 'store'])->name('authors.store');

    Route::resource('faculte',FaculteController::class);

    // publisher crud
    Route::get('/publishers', [PublisherController::class, 'index'])->name('publishers');
    Route::get('/publisher/create', [PublisherController::class, 'create'])->name('publisher.create');
    Route::get('/publisher/edit/{publisher}', [PublisherController::class, 'edit'])->name('publisher.edit');
    Route::post('/publisher/update/{id}', [PublisherController::class, 'update'])->name('publisher.update');
    Route::post('/publisher/delete/{id}', [PublisherController::class, 'destroy'])->name('publisher.destroy');
    Route::post('/publisher/create', [PublisherController::class, 'store'])->name('publisher.store');

    // Category CRUD
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories');
    Route::get('/category/create', [CategoryController::class, 'create'])->name('category.create');
    Route::get('/category/edit/{category}', [CategoryController::class, 'edit'])->name('category.edit');
    Route::put('/category/update/{id}', [CategoryController::class, 'update'])->name('category.update');
    Route::post('/category/delete/{id}', [CategoryController::class, 'destroy'])->name('category.destroy');
    Route::post('/category/create', [CategoryController::class, 'store'])->name('category.store');

    // books CRUD
    Route::get('/books', [BookController::class, 'index'])->name('books');
    Route::get('/book/create', [BookController::class, 'create'])->name('book.create');
    Route::get('/book/edit/{book}', [BookController::class, 'edit'])->name('book.edit');
    Route::post('/book/update/{id}', [BookController::class, 'update'])->name('book.update');
    Route::post('/book/delete/{id}', [BookController::class, 'destroy'])->name('book.destroy');
    Route::post('/book/create', [BookController::class, 'store'])->name('book.store');

    // students CRUD
    Route::get('/students', [StudentController::class, 'index'])->name('students');
    Route::get('/student/create', [StudentController::class, 'create'])->name('student.create');
    Route::get('/student/edit/{student}', [StudentController::class, 'edit'])->name('student.edit');
    Route::post('/student/update/{id}', [StudentController::class, 'update'])->name('student.update');
    Route::post('/student/delete/{id}', [StudentController::class, 'destroy'])->name('student.destroy');
    Route::post('/student/create', [StudentController::class, 'store'])->name('student.store');
    Route::get('/student/show/{id}', [StudentController::class, 'show'])->name('student.show');



    // Route::get('/book_issue', [BookIssueController::class, 'index'])->name('book_issued');
    // Route::get('/book-issue/create', [BookIssueController::class, 'create'])->name('book_issue.create');
    // Route::get('/book-issue/edit/{id}', [BookIssueController::class, 'edit'])->name('book_issue.edit');
    // Route::post('/book-issue/update/{id}', [BookIssueController::class, 'update'])->name('book_issue.update');
    // Route::post('/book-issue/delete/{id}', [BookIssueController::class, 'destroy'])->name('book_issue.destroy');
    // Route::post('/book-issue/create', [BookIssueController::class, 'store'])->name('book_issue.store');

    // Route::get('/reports', [ReportsController::class, 'index'])->name('reports');
    // Route::get('/reports/Date-Wise', [ReportsController::class, 'date_wise'])->name('reports.date_wise');
    // Route::post('/reports/Date-Wise', [ReportsController::class, 'generate_date_wise_report'])->name('reports.date_wise_generate');
    // Route::get('/reports/monthly-Wise', [ReportsController::class, 'month_wise'])->name('reports.month_wise');
    // Route::post('/reports/monthly-Wise', [ReportsController::class, 'generate_month_wise_report'])->name('reports.month_wise_generate');
    // Route::get('/reports/not-returned', [ReportsController::class, 'not_returned'])->name('reports.not_returned');

    // Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
    // Route::post('/settings', [SettingsController::class, 'update'])->name('settings');

    // // Transfer Type Routes
    // Route::get('/transfer/type', [TransferTypeController::class, 'index'])->name('transfer.type');
    // Route::post('/transfer/type', [TransferTypeController::class, 'store'])->name('transfer.type.store');

    // Transfer Verification Routes
    Route::get('/transfer/verification/{transferRequest}', [TransferRequestController::class, 'verification'])->name('transfer.verification');
    Route::post('/transfer/verify/{transferRequest}', [TransferRequestController::class, 'verify'])->name('transfer.verify');
});

// Routes pour les demandes de transfert
Route::middleware(['auth'])->group(function () {
    Route::post('/transfer-request', [TransferRequestController::class, 'store'])->name('transfer-request.store');
    Route::get('/student/transfer-status', [TransferRequestController::class, 'studentStatus'])->name('student.transfer-status');
    Route::get('/transfer-request/check-status', [TransferRequestController::class, 'checkTransferStatus'])->name('transfer-request.check-status');
    Route::get('/transfer-request/detailed-tracking', [TransferRequestController::class, 'detailedTracking'])->name('transfer-request.detailed-tracking');
    Route::get('/transfer-requests/step7', [TransferRequestController::class, 'step7'])->name('transfer-requests.step7');
    Route::get('/transfer/decision/{transferRequest}', [TransferRequestController::class, 'decision'])->name('transfer.decision');
    Route::get('/transfer-request/{transferRequest}/download-acceptance', [TransferRequestController::class, 'downloadAcceptance'])->name('transfer-request.download-acceptance');
});

// Routes admin pour les demandes de transfert
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/transfer-requests', [TransferRequestController::class, 'index'])->name('admin.transfer-requests.index');
    Route::get('/transfer-requests/{transferRequest}', [TransferRequestController::class, 'show'])->name('admin.transfer-requests.show');
    Route::put('/transfer-requests/{transferRequest}/status', [TransferRequestController::class, 'updateStatus'])->name('admin.transfer-requests.update-status');
    Route::get('/transfer-requests/{transferRequest}/download/{documentType}', [TransferRequestController::class, 'downloadDocument'])->name('admin.transfer-requests.download');
    Route::post('/transfer-requests/export', [TransferRequestController::class, 'export'])->name('admin.transfer-requests.export');
});
