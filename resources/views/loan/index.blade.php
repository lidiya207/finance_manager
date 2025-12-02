@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 pt-26">
    <!-- Header -->
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Loans</h1>
            <p class="text-gray-600 text-sm mt-1">View and manage your loan transactions</p>
        </div>
        <a href="{{ route('loans.create') }}" class="inline-flex items-center gap-2 font-semibold px-6 py-3 rounded-lg transition-colors duration-200 shadow-md hover:shadow-lg no-underline" style="background-color: #2563eb !important; color: white !important;">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: white !important;">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            <span style="color: white !important;">Add Loan</span>
        </a>
    </div>

    @if (session('status'))
        <div class="mb-6 bg-green-50 border-l-4 border-green-400 p-4 rounded-r-lg">
            <p class="text-sm text-green-700">{{ session('status') }}</p>
        </div>
    @endif

    @if($loans->count() > 0)
        <!-- Recent Loans Section -->
        <div class="mb-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold text-gray-900">Recent loans</h2>
                <button class="text-sm text-gray-600 hover:text-gray-900 font-medium">Show All</button>
            </div>

            <!-- Loan Cards -->
            <div class="space-y-3">
                @foreach($loans as $loan)
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 hover:shadow-md transition-shadow duration-200">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-4 flex-1">
                            <!-- Icon -->
                            <div class="w-12 h-12 {{ $loan->type == 'given' ? 'bg-blue-100' : 'bg-orange-100' }} rounded-xl flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 {{ $loan->type == 'given' ? 'text-blue-600' : 'text-orange-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            
                            <!-- Loan Details -->
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2 mb-1">
                                    <h3 class="text-base font-semibold text-gray-900 truncate">
                                        {{ $loan->person_name }}
                                    </h3>
                                    <span class="px-2 py-0.5 text-xs font-medium rounded-full {{ $loan->type == 'given' ? 'bg-blue-100 text-blue-800' : 'bg-orange-100 text-orange-800' }}">
                                        {{ ucfirst($loan->type) }}
                                    </span>
                                    <span class="px-2 py-0.5 text-xs font-medium rounded-full {{ $loan->status == 'open' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                        {{ ucfirst($loan->status) }}
                                    </span>
                                </div>
                                @if($loan->bank)
                                <p class="text-xs text-gray-400 mt-1">
                                    {{ $loan->bank->bank_name }}
                                </p>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Amount -->
                        <div class="text-right ml-4">
                            <p class="text-lg font-bold {{ $loan->type == 'given' ? 'text-blue-600' : 'text-orange-600' }}">
                                {{ number_format($loan->principal_amount, 2) }}
                            </p>
                            <p class="text-xs text-gray-500 mt-1">{{ $loan->currency }}</p>
                            <p class="text-sm text-gray-600 mt-1">Outstanding: {{ number_format($loan->outstanding_balance, 2) }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Pagination -->
        <div class="mt-6 flex justify-center">
            {{ $loans->links() }}
        </div>

        <!-- Summary Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mt-8">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Summary</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="p-4 bg-gray-50 rounded-lg">
                    <p class="text-sm text-gray-600 mb-1">Total Loans</p>
                    <p class="text-2xl font-bold text-gray-900">{{ \App\Models\Loan::where('user_id', auth()->id())->count() }}</p>
                </div>
                <div class="p-4 bg-gray-50 rounded-lg">
                    <p class="text-sm text-gray-600 mb-1">Given</p>
                    <p class="text-2xl font-bold text-blue-600">
                        {{ number_format(\App\Models\Loan::where('user_id', auth()->id())->where('type', 'given')->sum('outstanding_balance'), 2) }}
                    </p>
                </div>
                <div class="p-4 bg-gray-50 rounded-lg">
                    <p class="text-sm text-gray-600 mb-1">Taken</p>
                    <p class="text-2xl font-bold text-orange-600">
                        {{ number_format(\App\Models\Loan::where('user_id', auth()->id())->where('type', 'taken')->sum('outstanding_balance'), 2) }}
                    </p>
                </div>
            </div>
        </div>
    @else
        <!-- Empty State -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">No loan records</h3>
            <p class="text-sm text-gray-600 mb-6">Get started by adding your first loan transaction.</p>
            <a href="{{ route('loans.create') }}" class="inline-flex items-center px-5 py-2.5 font-semibold rounded-lg transition-colors duration-200" style="background-color: #2563eb !important; color: white !important;">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: white !important;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                <span style="color: white !important;">Add Loan</span>
            </a>
        </div>
    @endif
</div>
@endsection
