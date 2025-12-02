<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\IncomeSourceController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BankController;
use App\Http\Controllers\RepaymentController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Auth;
use App\Models\Income;
use App\Models\Expense;

// Redirect to login
Route::get('/', function () {
    return redirect('/login');
});

Auth::routes();
// Breeze already registers login, logout, register routes

// Protected routes
Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', function () {
        $incomes = Income::where('user_id', auth()->id())->get();
        $expenses = Expense::where('user_id', auth()->id())->get();
        
        $totalIncome = $incomes->sum('amount');
        $totalExpenses = $expenses->sum('amount');
        
        // Group by currency
        $incomeByCurrency = $incomes->groupBy('currency')->map->sum('amount');
        $expensesByCurrency = $expenses->groupBy('currency')->map->sum('amount');
        
        return view('dashboard', compact('totalIncome', 'totalExpenses', 'incomeByCurrency', 'expensesByCurrency'));
    })->name('dashboard');

    // Income
    Route::get('/income/create', [IncomeController::class, 'create'])->name('income.create');
    Route::post('/income/store', [IncomeController::class, 'store'])->name('income.store');
    Route::get('/income/index', [IncomeController::class, 'index'])->name('income.index');

    // Expense
    Route::get('/expenses/create', [ExpenseController::class, 'create'])->name('expenses.create');
    Route::post('/expenses/store', [ExpenseController::class, 'store'])->name('expenses.store');
    Route::get('/expenses/index', [ExpenseController::class, 'index'])->name('expenses.index');

    // Loan
    Route::get('/loans/create', [LoanController::class, 'create'])->name('loans.create');
    Route::post('/loans/store', [LoanController::class, 'store'])->name('loans.store');
    Route::get('/loans/index', [LoanController::class, 'index'])->name('loans.index');

    // Categories
    Route::get('/categories/index', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories/store', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{id}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/{id}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');

    // Repayments
    Route::get('/repayments/index', [RepaymentController::class, 'index'])->name('repayments.index');
    Route::get('/loans/{loanId}/repayments', [RepaymentController::class, 'loanIndex'])->name('repayments.loan-index');
    Route::get('/loans/{loanId}/repayments/create', [RepaymentController::class, 'create'])->name('repayments.create');
    Route::post('/loans/{loanId}/repayments', [RepaymentController::class, 'store'])->name('repayments.store');
    Route::delete('/loans/{loanId}/repayments/{id}', [RepaymentController::class, 'destroy'])->name('repayments.destroy');

    // Reports
    Route::get('/reports/index', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/daily/{date?}', [ReportController::class, 'daily'])->name('reports.daily');
    Route::get('/reports/weekly/{startDate?}', [ReportController::class, 'weekly'])->name('reports.weekly');
    Route::get('/reports/monthly/{month?}/{year?}', [ReportController::class, 'monthly'])->name('reports.monthly');
    Route::get('/reports/forecast', [ReportController::class, 'forecast'])->name('reports.forecast');
});
