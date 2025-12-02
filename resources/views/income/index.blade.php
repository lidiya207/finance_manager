@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-18">
        <div class="text-center">
           <h1 class="text-lg font-extrabold text-gray-900 text-center mt-10 p-4">
    Income
</h1><p class="text-gray-600 text-lg text-center mt-2">
    View and manage your income transactions
</p>

        </div>
        <a href="{{ route('income.create') }}" class="inline-flex items-center gap-2 font-semibold px-6 py-3 rounded-lg transition-colors duration-200 shadow-md hover:shadow-lg no-underline" style="background-color:rgba(6, 37, 239, 0.84) !important; color: white !important;">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: white !important;">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            <span style="color: white !important;">Add Income</span>
        </a>
    </div>

    @if (session('status'))
        <div class="mb-6 bg-green-50 border-l-4 border-green-400 p-4 rounded-r-lg">
            <p class="text-sm text-green-700">{{ session('status') }}</p>
        </div>
    @endif

    @if($incomes->count() > 0)
        <!-- Recent Transactions Section -->
        <div class="mb-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold text-gray-900">Recent transactions</h2>
                <button class="text-sm text-gray-600 hover:text-gray-900 font-medium">Show All</button>
            </div>

            <!-- Transaction Cards -->
            <div class="space-y-3">
                @foreach($incomes as $income)
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 hover:shadow-md transition-shadow duration-200">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-4 flex-1">
                            <!-- Icon -->
                            <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                            </div>
                            
                            <!-- Transaction Details -->
                            <div class="flex-1 min-w-0">
                                <h3 class="text-base font-semibold text-gray-900 truncate">
                                    {{ $income->source->name ?? 'Income' }}
                                </h3>
                                <div class="flex items-center gap-2 mt-1">
                                    <p class="text-sm text-gray-500">
                                        {{ \Carbon\Carbon::parse($income->occurred_at)->format('M d, Y') }}
                                    </p>
                                    <span class="text-gray-400">•</span>
                                    <p class="text-sm text-gray-500">
                                        {{ \Carbon\Carbon::parse($income->occurred_at)->format('g:i A') }}
                                    </p>
                                </div>
                                @if($income->bank)
                                <p class="text-xs text-gray-400 mt-1">
                                    {{ $income->bank->bank_name }}
                                </p>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Amount -->
                        <div class="text-right ml-4">
                            <p class="text-lg font-bold text-green-600">
                                + {{ number_format($income->amount, 2) }}
                            </p>
                            <p class="text-xs text-gray-500 mt-1">{{ $income->currency }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Pagination -->
        <div class="mt-6 flex justify-center">
            {{ $incomes->links() }}
        </div>

        <!-- Summary Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mt-8">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Summary</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="p-4 bg-gray-50 rounded-lg">
                    <p class="text-sm text-gray-600 mb-1">Total Income</p>
                    <p class="text-2xl font-bold text-gray-900">
                        {{ number_format(\App\Models\Income::where('user_id', auth()->id())->sum('amount'), 2) }}
                    </p>
                </div>
                <div class="p-4 bg-gray-50 rounded-lg">
                    <p class="text-sm text-gray-600 mb-1">Total Transactions</p>
                    <p class="text-2xl font-bold text-gray-900">{{ \App\Models\Income::where('user_id', auth()->id())->count() }}</p>
                </div>
                <div class="p-4 bg-gray-50 rounded-lg">
                    <p class="text-sm text-gray-600 mb-1">This Month</p>
                    <p class="text-2xl font-bold text-gray-900">
                        {{ number_format(\App\Models\Income::where('user_id', auth()->id())->where('occurred_at', '>=', \Carbon\Carbon::now()->startOfMonth())->sum('amount'), 2) }}
                    </p>
                </div>
            </div>
        </div>
    @else
        <!-- Empty State -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">No income records</h3>
            <p class="text-sm text-gray-600 mb-6">Get started by adding your first income transaction.</p>
            <a href="{{ route('income.create') }}" class="inline-flex items-center px-5 py-2.5 font-semibold rounded-lg transition-colors duration-200" style="background-color: #2563eb !important; color: white !important;">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: white !important;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                <span style="color: white !important;">Add Income</span>
            </a>
        </div>
    @endif
</div>
@endsection
