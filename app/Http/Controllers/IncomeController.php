<?php

namespace App\Http\Controllers;

use App\Models\Income;
use App\Models\IncomeSource;
use App\Models\Bank;
use Illuminate\Http\Request;
use Carbon\Carbon;

class IncomeController extends Controller
{
    /**
     * Display a listing of the incomes with chart data and search.
     */
    public function index(Request $request)
    {
        $query = Income::where('user_id', auth()->id())
            ->with(['bank', 'source'])
            ->latest();

        // 🔍 Search filter
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->whereHas('source', fn($s) => $s->where('name', 'like', "%{$search}%"))
                  ->orWhereHas('bank', fn($b) => $b->where('bank_name', 'like', "%{$search}%"))
                  ->orWhere('currency', 'like', "%{$search}%");
            });
        }

        // 💰 Currency filter
        if ($request->filled('currency')) {
            $query->where('currency', $request->currency);
        }

        if ($request->has('show_all') && $request->show_all == '1') {
            $incomes = $query->paginate(1000); // effectively "all"
        } else {
            $incomes = $query->paginate(10);
        }

        // 📊 Monthly income chart data
        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul',
                   'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $monthlyAmounts = array_fill(0, 12, 0);

        $monthlyData = Income::where('user_id', auth()->id())
            ->selectRaw('MONTH(occurred_at) as month, SUM(amount) as total')
            ->groupBy('month')
            ->pluck('total', 'month');

        foreach ($monthlyData as $month => $total) {
            $monthlyAmounts[$month - 1] = $total;
        }

        // Totals for summary cards
        $etbTotal = Income::where('user_id', auth()->id())
            ->where('currency', 'ETB')
            ->sum('amount');

        $usdTotal = Income::where('user_id', auth()->id())
            ->where('currency', 'USD')
            ->sum('amount');

        return view('income.index', compact(
            'incomes', 'months', 'monthlyAmounts', 'etbTotal', 'usdTotal'
        ));
    }

    /**
     * Show the form for creating a new income.
     */
    public function create()
    {
        $sources = IncomeSource::where('user_id', auth()->id())->get();
        $banks = Bank::where('user_id', auth()->id())->get();
        return view('income.create', compact('sources', 'banks'));
    }

    /**
     * Store a newly created income in storage.
     */
    public function store(Request $request)

    {
        $validated = $request->validate([
            'bank_id' => 'nullable|exists:banks,id',
            'bank_name' => 'sometimes|required_without:bank_id|string|max:255',
            'source_id' => 'nullable|exists:income_sources,id',
            'source_name' => 'sometimes|required_without:source_id|string|max:255',
            'amount' => 'required|numeric|min:0',
            'currency' => 'required|string|in:ETB,USD',
            'occurred_at' => 'required|date',
        ]);

        $validated = $this->resolveBank($validated);
        $validated = $this->resolveSource($validated);

        $validated['user_id'] = auth()->id();
        $validated['income_source_id'] = $validated['source_id'];
        unset($validated['bank_name'], $validated['source_name'], $validated['source_id']);

        Income::create($validated);

        return redirect()->route('income.index')->with('success', 'Income added successfully!');
    }



    /**
     * Display a single income.
     */
    public function show($id)
    {
        $income = Income::where('user_id', auth()->id())
            ->with(['bank', 'source'])
            ->findOrFail($id);

        return view('income.show', compact('income'));
    }

    /**
     * Show the form for editing an income.
     */
    public function edit($id)
    {
        $income = Income::where('user_id', auth()->id())->findOrFail($id);
        $sources = IncomeSource::where('user_id', auth()->id())->get();
        $banks = Bank::where('user_id', auth()->id())->get();
        return view('income.edit', compact('income', 'sources', 'banks'));
    }

    /**
     * Update an existing income.
     */
    public function update(Request $request, $id)
    {
        $income = Income::where('user_id', auth()->id())->findOrFail($id);

        $validated = $request->validate([
            'bank_id' => 'nullable|exists:banks,id',
            'bank_name' => 'sometimes|required_without:bank_id|string|max:255',
            'source_id' => 'nullable|exists:income_sources,id',
            'source_name' => 'sometimes|required_without:source_id|string|max:255',
            'amount' => 'required|numeric|min:0',
            'currency' => 'required|string|in:ETB,USD',
            'occurred_at' => 'required|date',
        ]);

        $validated = $this->resolveBank($validated);
        $validated = $this->resolveSource($validated);

        $validated['income_source_id'] = $validated['source_id'];
        unset($validated['bank_name'], $validated['source_name'], $validated['source_id']);

        $income->update($validated);

        return redirect()->route('income.index')->with('status', 'Income updated successfully!');
    }

    /**
     * Remove an income.
     */
    public function destroy($id)
    {
        $income = Income::where('user_id', auth()->id())->findOrFail($id);
        $income->delete();

        return redirect()->route('income.index')->with('status', 'Income deleted successfully!');
    }

    /**
     * Helper: Resolve bank creation.
     */
    private function resolveBank(array $validated)
    {
        if (empty($validated['bank_id']) && !empty($validated['bank_name'])) {
            $bank = Bank::firstOrCreate(
                ['user_id' => auth()->id(), 'bank_name' => $validated['bank_name']],
                ['currency' => $validated['currency']]
            );
            $validated['bank_id'] = $bank->id;
        }
        return $validated;
    }

    /**
     * Helper: Resolve source creation.
     */
    private function resolveSource(array $validated)
    {
        if (empty($validated['source_id']) && !empty($validated['source_name'])) {
            $source = IncomeSource::firstOrCreate(
                ['user_id' => auth()->id(), 'name' => $validated['source_name']]
            );
            $validated['source_id'] = $source->id;
        }
        return $validated;
    }
}