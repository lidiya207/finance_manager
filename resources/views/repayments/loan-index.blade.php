@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-6">
        <a href="{{ route('loans.index') }}" class="inline-flex items-center text-red-600 hover:text-red-800 transition-colors mb-4">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Back to Loans
        </a>
        <div class="flex items-center justify-between">
            <div class="text-center flex-1">
                <h1 class="text-5xl font-bold text-red-800">Repayments for Loan #{{ $loan->id }}</h1>
                <p class="mt-2 text-xl text-red-700">Person: {{ $loan->person_name }} | Outstanding: {{ number_format($loan->outstanding_balance, 2) }} {{ $loan->currency }}</p>
            </div>
            @if($loan->outstanding_balance > 0)
            <a href="{{ route('repayments.create', $loan->id) }}" class="bg-gradient-to-r from-red-600 to-red-800 hover:from-red-700 hover:to-red-900 text-red-50 px-6 py-3 rounded-lg font-medium shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200">
                + Add Repayment
            </a>
            @endif
        </div>
    </div>

    @if (session('status'))
        <div class="mb-6 bg-red-50 border-l-4 border-red-400 p-4 rounded-r-lg">
            <p class="text-sm text-red-700">{{ session('status') }}</p>
        </div>
    @endif

    @if($repayments->count() > 0)
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-red-200">
                    <thead class="bg-red-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-red-800 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-red-800 uppercase tracking-wider">Amount</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-red-800 uppercase tracking-wider">Type</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-red-800 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-red-100">
                        @foreach($repayments as $repayment)
                        <tr class="hover:bg-red-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-red-900">
                                {{ \Carbon\Carbon::parse($repayment->occurred_at)->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-red-800">
                                {{ number_format($repayment->amount, 2) }} {{ $loan->currency }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $repayment->type == 'full' ? 'bg-red-100 text-red-800' : 'bg-red-200 text-red-900' }}">
                                    {{ ucfirst($repayment->type) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <form action="{{ route('repayments.destroy', [$loan->id, $repayment->id]) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this repayment?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-4v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <div class="bg-white rounded-xl shadow-lg p-12 text-center">
            <svg class="mx-auto h-12 w-12 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <h3 class="mt-2 text-sm font-medium text-red-800">No repayments for this loan</h3>
            <p class="mt-1 text-sm text-red-700">Start tracking repayments for this loan.</p>
            @if($loan->outstanding_balance > 0)
            <div class="mt-6">
                <a href="{{ route('repayments.create', $loan->id) }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-red-50 bg-red-600 hover:bg-red-700 rounded-md shadow-sm">
                    Add Repayment
                </a>
            </div>
            @endif
        </div>
    @endif
</div>
@endsection

