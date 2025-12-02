@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-6 text-center">
        <h1 class="text-5xl font-bold text-red-800">Repayment Records</h1>
        <p class="mt-2 text-xl text-red-700">View and manage all your loan repayments</p>
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
                            <th class="px-6 py-3 text-left text-xs font-semibold text-red-800 uppercase tracking-wider">Loan</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-red-800 uppercase tracking-wider">Person</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-red-800 uppercase tracking-wider">Amount</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-red-800 uppercase tracking-wider">Type</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-red-800 uppercase tracking-wider">Loan Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-red-100">
                        @foreach($repayments as $repayment)
                        <tr class="hover:bg-red-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-red-900">
                                {{ \Carbon\Carbon::parse($repayment->occurred_at)->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-red-900">
                                <a href="{{ route('loans.index') }}" class="text-red-600 hover:text-red-800 font-medium">
                                    Loan #{{ $repayment->loan->id }}
                                </a>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-red-900">
                                {{ $repayment->loan->person_name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-red-800">
                                {{ number_format($repayment->amount, 2) }} {{ $repayment->loan->currency }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $repayment->type == 'full' ? 'bg-red-100 text-red-800' : 'bg-red-200 text-red-900' }}">
                                    {{ ucfirst($repayment->type) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $repayment->loan->status == 'open' ? 'bg-red-100 text-red-800' : 'bg-red-200 text-red-900' }}">
                                    {{ ucfirst($repayment->loan->status) }}
                                </span>
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
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            <h3 class="mt-2 text-sm font-medium text-red-800">No repayment records</h3>
            <p class="mt-1 text-sm text-red-700">Repayments will appear here once you start making loan payments.</p>
            <div class="mt-6">
                <a href="{{ route('loans.index') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-red-50 bg-red-600 hover:bg-red-700 rounded-md shadow-sm">
                    View Loans
                </a>
            </div>
        </div>
    @endif
</div>
@endsection

