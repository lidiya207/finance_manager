@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-8 text-center" style="margin-bottom: 30px;">
        <h1 class="text-5xl font-bold text-red-800">Weekly Report</h1>
        <p class="mt-2 text-xl text-red-700">{{ $startDate->format('M d') }} - {{ $endDate->format('M d, Y') }}</p>
    </div>

    <div class="mb-6">
        <a href="{{ route('reports.index') }}" class="text-red-600 hover:text-red-800 font-medium">← Back to Reports</a>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-green-500">
            <h3 class="text-sm font-semibold text-red-700 uppercase tracking-wider">Total Income</h3>
            <p class="mt-2 text-3xl font-bold text-green-600">{{ number_format($totalIncome, 2) }}</p>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-red-500">
            <h3 class="text-sm font-semibold text-red-700 uppercase tracking-wider">Total Expenses</h3>
            <p class="mt-2 text-3xl font-bold text-red-600">{{ number_format($totalExpenses, 2) }}</p>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-purple-500">
            <h3 class="text-sm font-semibold text-red-700 uppercase tracking-wider">Repayments</h3>
            <p class="mt-2 text-3xl font-bold text-purple-600">{{ number_format($totalRepayments, 2) }}</p>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-blue-500">
            <h3 class="text-sm font-semibold text-red-700 uppercase tracking-wider">Net Balance</h3>
            <p class="mt-2 text-3xl font-bold {{ $netBalance >= 0 ? 'text-green-600' : 'text-red-600' }}">
                {{ number_format($netBalance, 2) }}
            </p>
        </div>
    </div>

    <!-- Daily Breakdown -->
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-red-800 mb-4">Daily Breakdown</h2>
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-red-200">
                    <thead class="bg-red-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-red-800 uppercase">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-red-800 uppercase">Income</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-red-800 uppercase">Expenses</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-red-800 uppercase">Net</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-red-100">
                        @foreach($dailyIncome as $date => $income)
                        <tr class="hover:bg-red-50">
                            <td class="px-6 py-4 text-sm text-red-900">{{ \Carbon\Carbon::parse($date)->format('M d, Y') }}</td>
                            <td class="px-6 py-4 text-sm font-semibold text-green-600">{{ number_format($income, 2) }}</td>
                            <td class="px-6 py-4 text-sm font-semibold text-red-600">{{ number_format($dailyExpenses[$date] ?? 0, 2) }}</td>
                            <td class="px-6 py-4 text-sm font-semibold {{ ($income - ($dailyExpenses[$date] ?? 0)) >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                {{ number_format($income - ($dailyExpenses[$date] ?? 0), 2) }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Expenses by Category -->
    @if($expensesByCategory->count() > 0)
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-red-800 mb-4">Expenses by Category</h2>
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-red-200">
                    <thead class="bg-red-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-red-800 uppercase">Category</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-red-800 uppercase">Amount</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-red-100">
                        @foreach($expensesByCategory as $category => $amount)
                        <tr class="hover:bg-red-50">
                            <td class="px-6 py-4 text-sm text-red-900">{{ $category }}</td>
                            <td class="px-6 py-4 text-sm font-semibold text-red-800">{{ number_format($amount, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif

    <!-- Income by Source -->
    @if($incomeBySource->count() > 0)
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-red-800 mb-4">Income by Source</h2>
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-red-200">
                    <thead class="bg-red-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-red-800 uppercase">Source</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-red-800 uppercase">Amount</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-red-100">
                        @foreach($incomeBySource as $source => $amount)
                        <tr class="hover:bg-red-50">
                            <td class="px-6 py-4 text-sm text-red-900">{{ $source }}</td>
                            <td class="px-6 py-4 text-sm font-semibold text-green-600">{{ number_format($amount, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection

