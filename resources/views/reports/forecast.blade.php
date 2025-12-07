@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Financial Forecast</h1>
        <p class="text-gray-600 text-sm mt-1">Projections based on your last 3 months of activity</p>
    </div>

    <!-- Forecast Summary -->
    <div class="bg-gradient-to-br from-indigo-600 to-purple-700 rounded-2xl shadow-lg text-white p-8 mb-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div>
                <p class="text-indigo-200 text-sm font-medium uppercase tracking-wider mb-1">Projected Balance</p>
                <h2 class="text-4xl font-bold">{{ number_format($projectedBalance, 2) }}</h2>
                <p class="text-indigo-200 text-sm mt-2">Expected by {{ $nextMonth->endOfMonth()->format('M d, Y') }}</p>
            </div>
            <div class="md:col-span-2 flex items-center justify-around bg-white/10 rounded-xl p-4 backdrop-blur-sm">
                <div class="text-center">
                    <p class="text-indigo-200 text-xs uppercase">Next Month Income</p>
                    <p class="text-xl font-bold text-green-300">+{{ number_format($forecastedIncome, 2) }}</p>
                </div>
                <div class="w-px h-10 bg-indigo-400/30"></div>
                <div class="text-center">
                    <p class="text-indigo-200 text-xs uppercase">Next Month Expenses</p>
                    <p class="text-xl font-bold text-red-300">-{{ number_format($forecastedExpenses, 2) }}</p>
                </div>
                <div class="w-px h-10 bg-indigo-400/30"></div>
                <div class="text-center">
                    <p class="text-indigo-200 text-xs uppercase">Net Change</p>
                    <p class="text-xl font-bold {{ $forecastedNet >= 0 ? 'text-green-300' : 'text-red-300' }}">
                        {{ $forecastedNet >= 0 ? '+' : '' }}{{ number_format($forecastedNet, 2) }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Historical Data -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-8">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Historical Basis (Last 3 Months)</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Month</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Income</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Expenses</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Net</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($months as $month)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $month['month'] }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-right text-green-600">{{ number_format($month['income'], 2) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-right text-red-600">{{ number_format($month['expenses'], 2) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-medium {{ $month['net'] >= 0 ? 'text-green-600' : 'text-red-600' }}">
                            {{ number_format($month['net'], 2) }}
                        </td>
                    </tr>
                    @endforeach
                    <!-- Averages Row -->
                    <tr class="bg-gray-50 font-semibold">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Average</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-right text-green-700">{{ number_format($avgIncome, 2) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-right text-red-700">{{ number_format($avgExpenses, 2) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-right {{ $avgNet >= 0 ? 'text-green-700' : 'text-red-700' }}">
                            {{ number_format($avgNet, 2) }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="bg-blue-50 border-l-4 border-blue-400 p-4 rounded-r-lg">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm text-blue-700">
                    This forecast is a simple projection based on your average income and expenses over the last 3 months. Actual results may vary.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
