@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-8 text-center" style="margin-bottom: 30px;">
        <h1 class="text-5xl font-bold text-red-800">Daily Report</h1>
        <p class="mt-2 text-xl text-red-700">{{ $date->format('F d, Y') }}</p>
    </div>

    <div class="mb-6">
        <a href="{{ route('reports.index') }}" class="text-red-600 hover:text-red-800 font-medium">← Back to Reports</a>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-green-500">
            <h3 class="text-sm font-semibold text-red-700 uppercase tracking-wider">Total Income</h3>
            <p class="mt-2 text-3xl font-bold text-green-600">
                @if($incomeByCurrency->count() > 0)
                    @foreach($incomeByCurrency as $currency => $amount)
                        {{ number_format($amount, 2) }} {{ $currency }}<br>
                    @endforeach
                @else
                    0.00
                @endif
            </p>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-red-500">
            <h3 class="text-sm font-semibold text-red-700 uppercase tracking-wider">Total Expenses</h3>
            <p class="mt-2 text-3xl font-bold text-red-600">
                @if($expensesByCurrency->count() > 0)
                    @foreach($expensesByCurrency as $currency => $amount)
                        {{ number_format($amount, 2) }} {{ $currency }}<br>
                    @endforeach
                @else
                    0.00
                @endif
            </p>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-blue-500">
            <h3 class="text-sm font-semibold text-red-700 uppercase tracking-wider">Net Balance</h3>
            <p class="mt-2 text-3xl font-bold {{ $netBalance >= 0 ? 'text-green-600' : 'text-red-600' }}">
                {{ number_format($netBalance, 2) }}
            </p>
        </div>
    </div>

    <!-- Income Section -->
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-red-800 mb-4">Income Transactions</h2>
        @if($incomes->count() > 0)
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-red-200">
                        <thead class="bg-red-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-red-800 uppercase">Source</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-red-800 uppercase">Amount</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-red-800 uppercase">Bank</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-red-800 uppercase">Currency</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-red-100">
                            @foreach($incomes as $income)
                            <tr class="hover:bg-red-50">
                                <td class="px-6 py-4 text-sm text-red-900">{{ $income->source->name ?? 'N/A' }}</td>
                                <td class="px-6 py-4 text-sm font-semibold text-red-800">{{ number_format($income->amount, 2) }}</td>
                                <td class="px-6 py-4 text-sm text-red-900">{{ $income->bank->bank_name ?? 'N/A' }}</td>
                                <td class="px-6 py-4 text-sm text-red-700">{{ $income->currency }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            <div class="bg-white rounded-xl shadow-lg p-8 text-center">
                <p class="text-red-700">No income transactions for this date.</p>
            </div>
        @endif
    </div>

    <!-- Expenses Section -->
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-red-800 mb-4">Expense Transactions</h2>
        @if($expenses->count() > 0)
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-red-200">
                        <thead class="bg-red-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-red-800 uppercase">Category</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-red-800 uppercase">Amount</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-red-800 uppercase">Bank</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-red-800 uppercase">Currency</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-red-100">
                            @foreach($expenses as $expense)
                            <tr class="hover:bg-red-50">
                                <td class="px-6 py-4 text-sm text-red-900">{{ $expense->category->name ?? 'N/A' }}</td>
                                <td class="px-6 py-4 text-sm font-semibold text-red-800">{{ number_format($expense->amount, 2) }}</td>
                                <td class="px-6 py-4 text-sm text-red-900">{{ $expense->bank->bank_name ?? 'N/A' }}</td>
                                <td class="px-6 py-4 text-sm text-red-700">{{ $expense->currency }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            <div class="bg-white rounded-xl shadow-lg p-8 text-center">
                <p class="text-red-700">No expense transactions for this date.</p>
            </div>
        @endif
    </div>

    <!-- Repayments Section -->
    @if($repayments->count() > 0)
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-red-800 mb-4">Loan Repayments</h2>
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-red-200">
                    <thead class="bg-red-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-red-800 uppercase">Loan</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-red-800 uppercase">Amount</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-red-800 uppercase">Currency</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-red-100">
                        @foreach($repayments as $repayment)
                        <tr class="hover:bg-red-50">
                            <td class="px-6 py-4 text-sm text-red-900">{{ $repayment->loan->person_name ?? 'N/A' }}</td>
                            <td class="px-6 py-4 text-sm font-semibold text-red-800">{{ number_format($repayment->amount, 2) }}</td>
                            <td class="px-6 py-4 text-sm text-red-700">{{ $repayment->currency }}</td>
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

