@extends('layouts.app')

@section('title', 'Expense Management - Finance Manager')

@section('content')

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 bg-gray-50">

<!-- Header -->
<div class="mb-16 text-center">
    <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900 tracking-wide" style="margin-top: 2rem; margin-bottom: 1rem; font-size: 25px;">
        Expenses
    </h1>
    <p class="text-gray-600 text-lg mt-2">Track and manage your expense transactions</p>

    <div class="mt-12 flex justify-center gap-4" style="margin-top: 2rem; margin-bottom: 4rem;">
        <!-- Add Expense Button -->
        <a href="{{ route('expenses.create') }}" class="inline-flex items-center gap-2 font-semibold px-6 py-3 rounded-2xl transition-colors duration-200 shadow-md hover:shadow-lg no-underline" style="background-color: #dc2626; color: white;">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: white;">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            <span style="color: white;"> Add Expense</span>
        </a>
    </div>
</div>

<!-- Summary Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
    <!-- Total ETB -->
    <div class="bg-red-100 rounded-xl shadow-md p-6 border border-gray-100 flex items-center justify-between">
        <div>
            <p class="text-sm text-gray-500">Total Expenses (ETB)</p>
            <p class="text-3xl md:text-4xl font-bold text-gray-900">
                {{ number_format($etbTotal ?? 0, 2) }}
            </p>
        </div>
    </div>

    <!-- Total USD -->
    <div class="bg-white rounded-xl shadow-md p-6 border border-gray-100 flex items-center justify-between">
        <div>
            <p class="text-sm text-gray-500">Total Expenses (USD)</p>
            <p class="text-3xl md:text-4xl font-bold text-gray-900">
                {{ number_format($usdTotal ?? 0, 2) }}
            </p>
        </div>
    </div>
</div>

<!-- Filters + Search -->
<form method="GET" action="{{ route('expenses.index') }}" class="flex flex-wrap gap-4 mb-12 items-center justify-between" style="margin-top: 2rem; margin-bottom: 2rem;"> 
    <div class="flex gap-4 text-sm">
        
        <a href="{{ route('expenses.index') }}" class="px-4 py-2 rounded-full border border-gray-300 hover:bg-gray-100 {{ request()->currency ? '' : 'bg-gray-200 font-semibold' }}">
            All Time
        </a>
        <a href="{{ route('expenses.index', ['currency' => 'ETB']) }}" class="px-4 py-2 rounded-full border border-gray-300 hover:bg-red-100 {{ request('currency') == 'ETB' ? 'bg-red-200 font-semibold' : '' }}">
            ETB
        </a>
        <a href="{{ route('expenses.index', ['currency' => 'USD']) }}" class="px-4 py-2 rounded-full border border-gray-300 hover:bg-blue-100 {{ request('currency') == 'USD' ? 'bg-blue-200 font-semibold' : '' }}">
            USD
        </a>
         <select name="category_id" class="px-4 py-2 border rounded-full">
        <option value="">All Categories</option>
        @foreach($categories as $category)
            <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                {{ $category->name }}
            </option>
        @endforeach
    </select>
    </div>
    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by category, bank, or currency..."
           class="px-4 py-2 border rounded-lg text-sm w-64 focus:outline-none focus:ring-2 focus:ring-blue-600" />
</form>

<!-- Recent Transactions -->
@if($expenses->count() > 0)
    <div class="space-y-4 mb-6">
        @foreach($expenses as $expense)
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4 flex-1">
                    <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="text-base font-semibold text-gray-900 truncate">
                            {{ $expense->category->name ?? 'Expense' }}
                        </h3>
                        <p class="text-sm text-gray-500">
                            {{ \Carbon\Carbon::parse($expense->occurred_at)->format('M d, Y • g:i A') }}
                        </p>
                        @if($expense->bank)
                        <p class="text-xs text-gray-400 mt-1">
                            {{ $expense->bank->bank_name }}
                        </p>
                        @endif
                    </div>
                </div>
                <div class="text-right ml-4">
                    <p class="text-lg font-bold text-red-600">
                        - {{ number_format($expense->amount, 2) }}
                    </p>
                    <p class="text-xs text-gray-500 mt-1">{{ $expense->currency }}</p>
                    <form action="{{ route('expenses.destroy', $expense->id) }}" method="POST" class="inline-block mt-2" onsubmit="return confirm('Are you sure you want to delete this record?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-500 hover:text-red-700 transition-colors" title="Delete Record">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="mt-6 flex flex-col items-center gap-4">
        {{ $expenses->appends(request()->query())->links() }}
        
        @if($expenses->total() > 10)
            <div class="text-center">
                @if(request('show_all'))
                    <a href="{{ route('expenses.index', array_merge(request()->except('show_all'))) }}" 
                       class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                        Show Less
                    </a>
                @else
                    <a href="{{ route('expenses.index', array_merge(request()->query(), ['show_all' => 1])) }}" 
                       class="inline-flex items-center px-4 py-2 border border-red-600 shadow-sm text-sm font-medium rounded-md text-red-600 bg-white hover:bg-red-50">
                        Show All
                    </a>
                @endif
            </div>
        @endif
    </div>
@else
    <!-- Empty State -->
    <div class="bg-white rounded-xl shadow-md border border-gray-200 p-12 text-center">
        <div class="w-16 h-16 bg-gray-100 rounded-full mx-auto mb-4 flex items-center justify-center">
            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
            </svg>
        </div>
        <h3 class="text-lg font-semibold text-gray-900 mb-2">No expense records</h3>
        <p class="text-sm text-gray-600 mb-6">Get started by adding your first expense transaction.</p>
        <a href="{{ route('expenses.create') }}" class="inline-flex items-center px-5 py-2.5 font-semibold rounded-lg bg-red-600 text-white hover:bg-red-700 transition">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Add Expense
        </a>
    </div>
@endif

<!-- Chart Section -->
<div class="bg-white rounded-xl shadow-md border border-gray-200 p-6 mt-16">
    <h3 class="text-xl md:text-2xl font-extrabold text-gray-900 mb-4">Expense Overview (Monthly)</h3>
    <div class="relative h-64 md:h-80">
        <canvas id="expenseChart"></canvas>
    </div>
</div>

</div>

<!-- Chart.js Script -->

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const ctx = document.getElementById('expenseChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json($months),
            datasets: [{
                label: 'Monthly Expenses',
                data: @json($monthlyAmounts),
                backgroundColor: 'rgba(220, 38, 38, 0.7)',
                borderColor: 'rgba(220, 38, 38, 1)',
                borderWidth: 2,
                borderRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: { mode: 'index', intersect: false }
            },
            scales: {
                y: { beginAtZero: true, ticks: { stepSize: 100 } }
            }
        }
    });
</script>

@endsection
