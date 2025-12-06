@extends('layouts.app')

@section('content')

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 bg-gray-50">

    <!-- Header -->
    <div class="mb-16 text-center" style="margin-top: 2rem; margin-bottom: 2rem;">
        <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900 tracking-wide " style="font-size: 25px">
            Loans
        </h1>
        <p class="text-gray-600 text-lg mt-2">Track and manage your loan transactions</p>

        <div class="mt-12 flex justify-center gap-4"style="margin-top: 2rem; margin-bottom: 1rem">
            <a href="{{ route('loans.create') }}" class="inline-flex items-center gap-2 font-semibold px-6 py-3 rounded-2xl bg-blue-800 text-white hover:bg-blue-900" style="background-color: #03205c">
                Add Loan
            </a>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12" style=" margin-top: 4rem; margin-bottom: 4rem">
        <div class="bg-green-50 rounded-xl shadow-md p-6 flex items-center justify-between border border-gray-100">
            <div>
                <p class="text-sm text-gray-500">Total Given</p>
                <p class="text-3xl font-bold text-gray-900">{{ number_format($total_given ?? 0, 2) }} Br</p>
            </div>
        </div>

        <div class="bg-red-50 rounded-xl shadow-md p-6 flex items-center justify-between border border-gray-100">
            <div>
                <p class="text-sm text-gray-500">Total Taken</p>
                <p class="text-3xl font-bold text-gray-900">{{ number_format($total_taken ?? 0, 2) }} Br</p>
            </div>
        </div>

        <div class="bg-blue-50 rounded-xl shadow-md p-6 flex items-center justify-between border border-gray-100">
            <div>
                <p class="text-sm text-gray-500">Balance</p>
                <p class="text-3xl font-bold text-gray-900">{{ number_format(($total_given ?? 0) - ($total_taken ?? 0), 2) }} Br</p>
            </div>
        </div>
    </div>

    <!-- Search Filters -->
    <form method="GET" action="{{ route('loans.index') }}" class="flex flex-wrap gap-4 mb-10 items-center justify-between">
        <input type="text" name="person_name" value="{{ request('person_name') }}" placeholder="Search by person name" class="px-4 py-2 border rounded-lg w-64">
        <select name="type" class="px-4 py-2 border rounded-lg w-48">
            <option value="">All Types</option>
            <option value="given" {{ request('type') == 'given' ? 'selected' : '' }}>Given</option>
            <option value="taken" {{ request('type') == 'taken' ? 'selected' : '' }}>Taken</option>
        </select>
        <select name="status" class="px-4 py-2 border rounded-lg w-48">
            <option value="">All Status</option>
            <option value="open" {{ request('status') == 'open' ? 'selected' : '' }}>Open</option>
            <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>Closed</option>
        </select>
        <button class="bg-gray-800 text-white px-4 py-2 rounded-lg hover:bg-gray-900">Search</button>
        <a href="{{ route('loans.index') }}" class="bg-gray-300 px-4 py-2 rounded-lg hover:bg-gray-400">Reset</a>
    </form>

    <!-- Recent Transactions -->
    @if($loans->count() > 0)
        <div class="space-y-4 mb-6" style="margin-top: 4rem; margin-bottom: 4rem">
            @foreach($loans as $loan)
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 hover:shadow-md transition flex justify-between items-center">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 {{ $loan->type == 'given' ? 'bg-green-100' : 'bg-red-100' }} rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 {{ $loan->type == 'given' ? 'text-green-600' : 'text-red-600' }}" fill="none" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="text-base font-semibold text-gray-900 truncate">{{ $loan->person_name }}</h3>
                        <p class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($loan->date)->format('M d, Y') }}</p>
                        @if($loan->bank)
                            <p class="text-xs text-gray-400 mt-1">{{ $loan->bank->bank_name ?? '' }}</p>
                        @endif
                        <p class="text-xs text-gray-400 mt-1">{{ ucfirst($loan->status) }}</p>
                    </div>
                </div>
                <div class="text-right flex flex-col items-end gap-2" style="margin-top: 4rem " >
                    <p class="text-lg font-bold {{ $loan->type == 'given' ? 'text-green-600' : 'text-red-600' }}">
                        {{ number_format($loan->principal_amount, 2) }}
                    </p>
                    <div class="flex gap-2 ">
                        <a href="{{ route('loans.edit', $loan->id) }}" class="bg-yellow-500 text-white px-3 py-1 rounded-lg hover:bg-yellow-600" style="background-color: #03205c" </style>>Edit</a>
                        <form action="{{ route('loans.destroy', $loan->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded-lg hover:bg-red-700">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-6 flex justify-center">
            {{ $loans->links() }}
        </div>
    @else
        <div class="bg-white rounded-xl shadow-md border border-gray-200 p-12 text-center">
            <h3 class="text-lg font-semibold text-gray-900 mb-2">No loan records</h3>
            <p class="text-sm text-gray-600 mb-6">Get started by adding your first loan transaction.</p>
            <a href="{{ route('loans.create') }}" class="inline-flex items-center px-5 py-2.5 font-semibold rounded-lg bg-blue-600 text-white hover:bg-blue-700 transition">
                Add Loan
            </a>
        </div>
    @endif

    <!-- Chart Section -->
    <div class="bg-white rounded-xl shadow-md border border-gray-200 p-6 mt-16">
        <h3 class="text-xl md:text-2xl font-extrabold text-gray-900 mb-4">Loan Overview (Monthly)</h3>
        <div class="relative h-64 md:h-80">
            <canvas id="loanChart"></canvas>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('loanChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json($monthlyLabels),
            datasets: [{
                label: 'Loan Amount',
                data: @json($monthlyTotals),
                backgroundColor: 'rgba(37, 99, 235, 0.7)',
                borderColor: 'rgba(37, 99, 235, 1)',
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
                y: { beginAtZero: true }
            }
        }
    });
</script>

@endsection
