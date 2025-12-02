@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Reports</h1>
        <p class="text-gray-600 text-sm mt-1">Analyze your financial data with detailed reports</p>
    </div>

    <!-- Summary Cards Row -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Total Income Widget -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Total Income</h3>
                <a href="{{ route('reports.monthly') }}" class="text-xs text-gray-500 hover:text-gray-700">Report ></a>
            </div>
            <p class="text-3xl font-bold text-gray-900 mb-2">{{ number_format($totalIncome, 2) }}</p>
            <div class="flex items-center text-sm text-green-600">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                </svg>
                <span>This month</span>
            </div>
        </div>

        <!-- Total Expenses Widget -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Total Expenses</h3>
                <a href="{{ route('reports.monthly') }}" class="text-xs text-gray-500 hover:text-gray-700">Report ></a>
            </div>
            <p class="text-3xl font-bold text-gray-900 mb-2">{{ number_format($totalExpenses, 2) }}</p>
            <div class="flex items-center text-sm text-red-600">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"></path>
                </svg>
                <span>This month</span>
            </div>
        </div>

        <!-- Net Balance Widget -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Net Balance</h3>
                <a href="{{ route('reports.monthly') }}" class="text-xs text-gray-500 hover:text-gray-700">Report ></a>
            </div>
            <p class="text-3xl font-bold {{ $netBalance >= 0 ? 'text-green-600' : 'text-red-600' }} mb-2">
                {{ number_format($netBalance, 2) }}
            </p>
            <div class="flex items-center text-sm {{ $netBalance >= 0 ? 'text-green-600' : 'text-red-600' }}">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
                <span>This month</span>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Income Summary Chart -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-900">Income Summary</h3>
                <a href="{{ route('reports.weekly') }}" class="text-xs text-gray-500 hover:text-gray-700">Report ></a>
            </div>
            <!-- Simple Bar Chart -->
            <div class="space-y-4">
                @foreach($last7Days as $day)
                <div>
                    <div class="flex items-center justify-between mb-1">
                        <span class="text-xs text-gray-600">{{ $day['day'] }}</span>
                        <span class="text-xs font-semibold text-gray-900">{{ number_format($day['income'], 0) }}</span>
                    </div>
                    <div class="w-full bg-gray-100 rounded-full h-2">
                        <div class="bg-green-500 h-2 rounded-full" style="width: {{ $totalIncome > 0 ? ($day['income'] / $totalIncome * 100) : 0 }}%"></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Expense Summary Chart -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-900">Expense Summary</h3>
                <a href="{{ route('reports.weekly') }}" class="text-xs text-gray-500 hover:text-gray-700">Report ></a>
            </div>
            <!-- Simple Bar Chart -->
            <div class="space-y-4">
                @foreach($last7Days as $day)
                <div>
                    <div class="flex items-center justify-between mb-1">
                        <span class="text-xs text-gray-600">{{ $day['day'] }}</span>
                        <span class="text-xs font-semibold text-gray-900">{{ number_format($day['expenses'], 0) }}</span>
                    </div>
                    <div class="w-full bg-gray-100 rounded-full h-2">
                        <div class="bg-red-500 h-2 rounded-full" style="width: {{ $totalExpenses > 0 ? ($day['expenses'] / $totalExpenses * 100) : 0 }}%"></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Breakdown Row -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Expenses by Category -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-900">Expenses by Category</h3>
                <a href="{{ route('reports.weekly') }}" class="text-xs text-gray-500 hover:text-gray-700">Report ></a>
            </div>
            @if($expensesByCategory->count() > 0)
                <div class="space-y-4">
                    @foreach($expensesByCategory as $category => $amount)
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-2 h-2 bg-red-500 rounded-full"></div>
                            <span class="text-sm text-gray-700">{{ $category }}</span>
                        </div>
                        <span class="text-sm font-semibold text-gray-900">{{ number_format($amount, 2) }}</span>
                    </div>
                    @endforeach
                </div>
            @else
                <p class="text-sm text-gray-500 text-center py-4">No expense data available</p>
            @endif
        </div>

        <!-- Income by Source -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-900">Income by Source</h3>
                <a href="{{ route('reports.weekly') }}" class="text-xs text-gray-500 hover:text-gray-700">Report ></a>
            </div>
            @if($incomeBySource->count() > 0)
                <div class="space-y-4">
                    @foreach($incomeBySource as $source => $amount)
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                            <span class="text-sm text-gray-700">{{ $source }}</span>
                        </div>
                        <span class="text-sm font-semibold text-gray-900">{{ number_format($amount, 2) }}</span>
                    </div>
                    @endforeach
                </div>
            @else
                <p class="text-sm text-gray-500 text-center py-4">No income data available</p>
            @endif
        </div>
    </div>

    <!-- Report Links -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <a href="{{ route('reports.daily') }}" class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow duration-200 group">
            <div class="flex items-center justify-between mb-4">
                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center group-hover:bg-blue-200 transition-colors">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
            </div>
            <h3 class="text-base font-semibold text-gray-900 group-hover:text-blue-600 transition-colors">Daily Report</h3>
            <p class="text-sm text-gray-500 mt-2">View today's transactions</p>
        </a>

        <a href="{{ route('reports.weekly') }}" class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow duration-200 group">
            <div class="flex items-center justify-between mb-4">
                <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center group-hover:bg-purple-200 transition-colors">
                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
            </div>
            <h3 class="text-base font-semibold text-gray-900 group-hover:text-purple-600 transition-colors">Weekly Report</h3>
            <p class="text-sm text-gray-500 mt-2">This week's performance</p>
        </a>

        <a href="{{ route('reports.monthly') }}" class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow duration-200 group">
            <div class="flex items-center justify-between mb-4">
                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center group-hover:bg-green-200 transition-colors">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
            </div>
            <h3 class="text-base font-semibold text-gray-900 group-hover:text-green-600 transition-colors">Monthly Report</h3>
            <p class="text-sm text-gray-500 mt-2">Monthly trends and analysis</p>
        </a>

        <a href="{{ route('reports.forecast') }}" class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow duration-200 group">
            <div class="flex items-center justify-between mb-4">
                <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center group-hover:bg-orange-200 transition-colors">
                    <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
            </div>
            <h3 class="text-base font-semibold text-gray-900 group-hover:text-orange-600 transition-colors">Forecast</h3>
            <p class="text-sm text-gray-500 mt-2">Future financial projections</p>
        </a>
    </div>
</div>
@endsection
