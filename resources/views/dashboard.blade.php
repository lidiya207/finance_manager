@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    @if (session('status'))
        <div class="mb-6 bg-green-50 border-l-4 border-green-400 p-4 rounded-r-lg">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-green-700">{{ session('status') }}</p>
                </div>
            </div>
        </div>
    @endif

    <!-- Total Income and Expenses - Modern Clean Design -->
    <div class="flex flex-col gap-8 mb-8">
        <!-- Total Income Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-bold text-gray-900">TOTAL INCOME</h3>
                <div class="w-8 h-8 flex items-center justify-center">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                </div>
            </div>
            
            @if($incomeByCurrency->count() > 0)
                <div class="space-y-4 mb-4">
                    @foreach($incomeByCurrency as $currency => $amount)
                        <div class="flex items-center justify-between">
                            <span class="text-base font-medium text-gray-700">{{ $currency }}</span>
                            <span class="text-base font-semibold text-gray-900">{{ number_format($amount, 2) }}</span>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="flex items-center justify-between mb-4">
                    <span class="text-base font-medium text-gray-700">No income recorded</span>
                    <span class="text-base font-semibold text-gray-900">0.00</span>
                </div>
            @endif
            
            <p class="text-sm text-gray-500 mt-6 mb-4">Total earned amount</p>
            <a href="{{ route('income.create') }}" class="inline-flex items-center text-sm font-medium text-blue-600 hover:text-blue-700">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Add Income
            </a>
        </div>

        <!-- Divider -->
        <div class="border-t border-gray-200"></div>

        <!-- Total Expenses Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-bold text-gray-900">TOTAL EXPENSES</h3>
                <div class="w-8 h-8 flex items-center justify-center">
                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                    </svg>
                </div>
            </div>
            
            @if($expensesByCurrency->count() > 0)
                <div class="space-y-4 mb-4">
                    @foreach($expensesByCurrency as $currency => $amount)
                        <div class="flex items-center justify-between">
                            <span class="text-base font-medium text-gray-700">{{ $currency }}</span>
                            <span class="text-base font-semibold text-gray-900">{{ number_format($amount, 2) }}</span>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="flex items-center justify-between mb-4">
                    <span class="text-base font-medium text-gray-700">No expenses recorded</span>
                    <span class="text-base font-semibold text-gray-900">0.00</span>
                </div>
            @endif
            
            <p class="text-sm text-gray-500 mt-6 mb-4">Total spent amount</p>
            <a href="{{ route('expenses.create') }}" class="inline-flex items-center text-sm font-medium text-blue-600 hover:text-blue-700">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Add Expense
            </a>
        </div>
    </div>

    <!-- Management Cards - Modern Design -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <!-- Income Management Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-shadow duration-200">
            <div class="p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-1">Income</h3>
                <p class="text-sm text-gray-500 mb-6">Add new income transactions or view your income records</p>
                <div class="flex flex-col gap-3">
                    <a href="{{ route('income.create') }}" class="w-full bg-gray-900 hover:bg-gray-800 px-5 py-3 rounded-xl font-medium transition-colors duration-200 text-center flex items-center justify-center" style="color: white !important;">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: white !important;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        <span style="color: white !important;">Add Income</span>
                    </a>
                    <a href="{{ route('income.index') }}" class="w-full bg-white border-2 border-gray-200 hover:border-gray-300 text-gray-700 hover:bg-gray-50 px-5 py-3 rounded-xl font-medium transition-all duration-200 text-center flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        View Income
                    </a>
                </div>
            </div>
        </div>

        <!-- Expense Management Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-shadow duration-200">
            <div class="p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-1">Expense</h3>
                <p class="text-sm text-gray-500 mb-6">Add new expense transactions or view your expense records</p>
                <div class="flex flex-col gap-3">
                    <a href="{{ route('expenses.create') }}" class="w-full bg-gray-900 hover:bg-gray-800 px-5 py-3 rounded-xl font-medium transition-colors duration-200 text-center flex items-center justify-center" style="color: white !important;">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: white !important;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        <span style="color: white !important;">Add Expense</span>
                    </a>
                    <a href="{{ route('expenses.index') }}" class="w-full bg-white border-2 border-gray-200 hover:border-gray-300 text-gray-700 hover:bg-gray-50 px-5 py-3 rounded-xl font-medium transition-all duration-200 text-center flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        View Expense
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Loan Management Card - Modern Design -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-shadow duration-200">
        <div class="p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-1">Loan</h3>
            <p class="text-sm text-gray-500 mb-6">Add new loans or view your loan records</p>
            <div class="flex flex-col sm:flex-row gap-3">
                <a href="{{ route('loans.create') }}" class="flex-1 bg-gray-900 hover:bg-gray-800 px-5 py-3 rounded-xl font-medium transition-colors duration-200 text-center flex items-center justify-center" style="color: white !important;">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: white !important;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    <span style="color: white !important;">Add Loan</span>
                </a>
                <a href="{{ route('loans.index') }}" class="flex-1 bg-white border-2 border-gray-200 hover:border-gray-300 text-gray-700 hover:bg-gray-50 px-5 py-3 rounded-xl font-medium transition-all duration-200 text-center flex items-center justify-center">
                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                    View Loans
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
