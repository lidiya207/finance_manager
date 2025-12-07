@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Monthly Report</h1>
            <p class="text-gray-600 text-sm mt-1">
                {{ $startDate->format('F Y') }}
            </p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('reports.monthly', ['month' => $startDate->copy()->subMonth()->month, 'year' => $startDate->copy()->subMonth()->year]) }}" class="px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50">
                Previous Month
            </a>
            <a href="{{ route('reports.monthly', ['month' => $startDate->copy()->addMonth()->month, 'year' => $startDate->copy()->addMonth()->year]) }}" class="px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50">
                Next Month
            </a>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <!-- Income -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-2">Total Income</h3>
            <p class="text-2xl font-bold text-gray-900">{{ number_format($totalIncome, 2) }}</p>
        </div>
        
        <!-- Expenses -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-2">Total Expenses</h3>
            <p class="text-2xl font-bold text-gray-900">{{ number_format($totalExpenses, 2) }}</p>
        </div>

        <!-- Net Balance -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-2">Net Balance</h3>
            <p class="text-2xl font-bold {{ $netBalance >= 0 ? 'text-green-600' : 'text-red-600' }}">
                {{ number_format($netBalance, 2) }}
            </p>
        </div>

        <!-- Savings Rate -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-2">Savings Rate</h3>
            <p class="text-2xl font-bold text-blue-600">
                {{ $totalIncome > 0 ? number_format(($netBalance / $totalIncome) * 100, 1) : 0 }}%
            </p>
        </div>
    </div>

    <!-- Weekly Breakdown -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-8">
        <h3 class="text-lg font-semibold text-gray-900 mb-6">Weekly Breakdown</h3>
        <div class="space-y-4">
            @foreach($weeklyIncome as $week => $income)
            <div class="flex items-center justify-between text-sm">
                <span class="text-gray-600 w-32">{{ $week }}</span>
                <div class="flex-1 mx-4 flex flex-col gap-1">
                    <!-- Income Bar -->
                    <div class="w-full bg-gray-100 rounded-full h-2">
                        <div class="bg-green-500 h-2 rounded-full" style="width: {{ $totalIncome > 0 ? ($income / $totalIncome * 100) : 0 }}%"></div>
                    </div>
                    <!-- Expense Bar -->
                    <div class="w-full bg-gray-100 rounded-full h-2">
                        <div class="bg-red-500 h-2 rounded-full" style="width: {{ $totalExpenses > 0 ? (($weeklyExpenses[$week] ?? 0) / $totalExpenses * 100) : 0 }}%"></div>
                    </div>
                </div>
                <div class="text-right w-32">
                    <div class="text-green-600">+{{ number_format($income, 0) }}</div>
                    <div class="text-red-600">-{{ number_format($weeklyExpenses[$week] ?? 0, 0) }}</div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Expenses by Category -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-6">Expenses by Category</h3>
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
            <h3 class="text-lg font-semibold text-gray-900 mb-6">Income by Source</h3>
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
</div>
@endsection
