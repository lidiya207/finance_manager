@extends('layouts.app')

@section('content')
<!-- Modern Dashboard with Gradient Background -->
<div class="min-h-screen bg-gradient-to-br from-indigo-50 via-purple-50 to-pink-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Dashboard Header -->
        <div class="mb-8 fade-in-up">
            <h1 class="text-4xl font-bold text-gray-900 mb-2">
                <span class="gradient-text">Financial Dashboard</span>
            </h1>
            <p class="text-gray-600 text-lg">Welcome back! Here's your financial overview</p>
        </div>

        <!-- STATUS MESSAGE -->
        @if (session('status'))
            <div class="mb-6 glass-card p-4 rounded-2xl border-l-4 border-green-500 fade-in-up">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-6 w-6 text-green-500" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                  d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586
                                     7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                  clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-green-800">{{ session('status') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Main Stats Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">

            <!-- TOTAL INCOME CARD -->
            <div class="stat-card rounded-3xl p-8 fade-in-up delay-100">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <p class="text-sm font-semibold text-gray-600 uppercase tracking-wider mb-2">Total Income</p>
                        <div class="flex items-center">
                            <span class="status-indicator bg-green-500 mr-2"></span>
                            <span class="text-xs text-gray-500">Active</span>
                        </div>
                    </div>
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-green-400 to-emerald-600 flex items-center justify-center icon-pulse shadow-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                        </svg>
                    </div>
                </div>

                @if($incomeByCurrency->count() > 0)
                    <div class="space-y-4 mb-6">
                        @foreach($incomeByCurrency as $currency => $amount)
                            <div class="bg-white/50 rounded-2xl p-4 backdrop-blur-sm">
                                <div class="flex justify-between items-center mb-2">
                                    <span class="currency-badge bg-green-100 text-green-700">{{ $currency }}</span>
                                    <span class="text-3xl font-bold text-gray-900 counter-number">{{ number_format($amount, 2) }}</span>
                                </div>
                                <div class="progress-bar mt-3">
                                    <div class="progress-fill" style="width: 75%;"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="bg-white/50 rounded-2xl p-6 backdrop-blur-sm text-center">
                        <svg class="w-12 h-12 text-gray-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                        </svg>
                        <p class="text-gray-600 font-medium">No income recorded yet</p>
                    </div>
                @endif

                <a href="{{ route('income.create') }}"
                   class="action-btn block w-full bg-gradient-to-r from-green-500 to-emerald-600 text-white py-4 rounded-2xl text-center font-semibold shadow-lg hover:shadow-xl transition-all">
                    <span class="flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Add Income
                    </span>
                </a>
            </div>

            <!-- TOTAL EXPENSE CARD -->
            <div class="stat-card rounded-3xl p-8 fade-in-up delay-200">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <p class="text-sm font-semibold text-gray-600 uppercase tracking-wider mb-2">Total Expenses</p>
                        <div class="flex items-center">
                            <span class="status-indicator bg-red-500 mr-2"></span>
                            <span class="text-xs text-gray-500">Tracking</span>
                        </div>
                    </div>
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-red-400 to-pink-600 flex items-center justify-center icon-pulse shadow-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M20 12H4"/>
                        </svg>
                    </div>
                </div>

                @if($expensesByCurrency->count() > 0)
                    <div class="space-y-4 mb-6">
                        @foreach($expensesByCurrency as $currency => $amount)
                            <div class="bg-white/50 rounded-2xl p-4 backdrop-blur-sm">
                                <div class="flex justify-between items-center mb-2">
                                    <span class="currency-badge bg-red-100 text-red-700">{{ $currency }}</span>
                                    <span class="text-3xl font-bold text-gray-900 counter-number">{{ number_format($amount, 2) }}</span>
                                </div>
                                <div class="progress-bar mt-3">
                                    <div class="progress-fill" style="width: 60%; background: linear-gradient(135deg, #ee0979 0%, #ff6a00 100%);"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="bg-white/50 rounded-2xl p-6 backdrop-blur-sm text-center">
                        <svg class="w-12 h-12 text-gray-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                        </svg>
                        <p class="text-gray-600 font-medium">No expenses recorded yet</p>
                    </div>
                @endif

                <a href="{{ route('expenses.create') }}"
                   class="action-btn block w-full bg-gradient-to-r from-red-500 to-pink-600 text-white py-4 rounded-2xl text-center font-semibold shadow-lg hover:shadow-xl transition-all">
                    <span class="flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Add Expense
                    </span>
                </a>
            </div>

        </div>

        <!-- Quick Actions Section -->
        <div class="mb-8 fade-in-up delay-300">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Quick Actions</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <!-- Income Quick Action -->
                <div class="quick-action group">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-green-400 to-emerald-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <span class="text-xs font-semibold text-green-600 bg-green-100 px-3 py-1 rounded-full">Income</span>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Manage Income</h3>
                    <p class="text-sm text-gray-600 mb-4">Track and manage your income sources</p>
                    <div class="flex gap-2">
                        <a href="{{ route('income.create') }}"
                           class="flex-1 bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded-xl text-center text-sm font-semibold transition-colors">
                            Add
                        </a>
                        <a href="{{ route('income.index') }}"
                           class="flex-1 border-2 border-gray-300 hover:border-green-600 text-gray-700 hover:text-green-600 py-2 px-4 rounded-xl text-center text-sm font-semibold transition-colors">
                            View
                        </a>
                    </div>
                </div>

                <!-- Expense Quick Action -->
                <div class="quick-action group">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-red-400 to-pink-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                            </svg>
                        </div>
                        <span class="text-xs font-semibold text-red-600 bg-red-100 px-3 py-1 rounded-full">Expense</span>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Manage Expenses</h3>
                    <p class="text-sm text-gray-600 mb-4">Monitor and control your spending</p>
                    <div class="flex gap-2">
                        <a href="{{ route('expenses.create') }}"
                           class="flex-1 bg-red-600 hover:bg-red-700 text-white py-2 px-4 rounded-xl text-center text-sm font-semibold transition-colors">
                            Add
                        </a>
                        <a href="{{ route('expenses.index') }}"
                           class="flex-1 border-2 border-gray-300 hover:border-red-600 text-gray-700 hover:text-red-600 py-2 px-4 rounded-xl text-center text-sm font-semibold transition-colors">
                            View
                        </a>
                    </div>
                </div>

                <!-- Loan Quick Action -->
                <div class="quick-action group">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-400 to-indigo-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <span class="text-xs font-semibold text-blue-600 bg-blue-100 px-3 py-1 rounded-full">Loan</span>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Manage Loans</h3>
                    <p class="text-sm text-gray-600 mb-4">Keep track of your loan records</p>
                    <div class="flex gap-2">
                        <a href="{{ route('loans.create') }}"
                           class="flex-1 bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-xl text-center text-sm font-semibold transition-colors">
                            Add
                        </a>
                        <a href="{{ route('loans.index') }}"
                           class="flex-1 border-2 border-gray-300 hover:border-blue-600 text-gray-700 hover:text-blue-600 py-2 px-4 rounded-xl text-center text-sm font-semibold transition-colors">
                            View
                        </a>
                    </div>
                </div>

            </div>
        </div>

        <!-- Additional Info Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 fade-in-up delay-400">
            
            <!-- Financial Health Card -->
            <div class="glass-card rounded-3xl p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-gray-900">Financial Health</h3>
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                </div>
                <div class="space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Overall Status</span>
                        <span class="text-sm font-semibold text-green-600">Good</span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill" style="width: 70%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);"></div>
                    </div>
                    <p class="text-xs text-gray-500 mt-2">Your financial health is looking good. Keep tracking your expenses!</p>
                </div>
            </div>

            <!-- Quick Stats Card -->
            <div class="glass-card rounded-3xl p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-gray-900">Quick Stats</h3>
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                    </svg>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl p-4">
                        <p class="text-xs text-gray-600 mb-1">Transactions</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $incomeByCurrency->count() + $expensesByCurrency->count() }}</p>
                    </div>
                    <div class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-2xl p-4">
                        <p class="text-xs text-gray-600 mb-1">Categories</p>
                        <p class="text-2xl font-bold text-gray-900">Active</p>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>
@endsection
