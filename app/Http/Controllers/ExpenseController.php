<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Category;
use App\Models\Bank;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ExpenseController extends Controller
{
   public function index(Request $request)
{
    $query = Expense::where('user_id', auth()->id())->with(['bank', 'category']);

    // Filter by currency if requested
    if ($request->currency) {
        $query->where('currency', $request->currency);
    }

    // Filter by category if requested
    if ($request->category_id) {
        $query->where('category_id', $request->category_id);
    }

    // Filter by search keyword
    if ($request->search) {
        $query->where(function($q) use ($request) {
            $q->whereHas('category', fn($q) => $q->where('name', 'like', '%'.$request->search.'%'))
              ->orWhereHas('bank', fn($q) => $q->where('bank_name', 'like', '%'.$request->search.'%'))
              ->orWhere('currency', 'like', '%'.$request->search.'%');
        });
    }

    $expenses = $query->latest()->paginate(10);

    // Totals
    $etbTotal = Expense::where('user_id', auth()->id())->where('currency', 'ETB')->sum('amount');
    $usdTotal = Expense::where('user_id', auth()->id())->where('currency', 'USD')->sum('amount');

    // Monthly data for chart
    $months = [];
    $monthlyAmounts = [];
    for ($i = 1; $i <= 12; $i++) {
        $months[] = date('M', mktime(0, 0, 0, $i, 1));
        $monthlyAmounts[] = Expense::where('user_id', auth()->id())
            ->whereMonth('occurred_at', $i)
            ->sum('amount');
    }

    // Fetch all categories for filter dropdown
    $categories = Category::where('user_id', auth()->id())->get();

    return view('expenses.index', compact('expenses', 'etbTotal', 'usdTotal', 'months', 'monthlyAmounts', 'categories'));
}


    public function create()
    {
        $categories = Category::where('user_id', auth()->id())->get();
        $banks = Bank::where('user_id', auth()->id())->get();
        return view('expenses.create', compact('categories', 'banks'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'bank_id' => 'nullable|exists:banks,id',
            'bank_name' => 'nullable|string|max:255',
            'amount' => 'required|numeric',
            'currency' => 'required|string',
            'occurred_at' => 'required|date',
        ]);

        // Handle dynamic bank creation
        if (!$validated['bank_id'] && $validated['bank_name']) {
            $bank = Bank::firstOrCreate(
                [
                    'user_id' => auth()->id(),
                    'bank_name' => $validated['bank_name']
                ],
                [
                    'currency' => $validated['currency']
                ]
            );
            $validated['bank_id'] = $bank->id;
        }

        if (!$validated['bank_id']) {
            return back()->withErrors(['error' => 'Please provide either select or enter a new bank.'])->withInput();
        }

        $validated['user_id'] = auth()->id();
        unset($validated['bank_name']);

        Expense::create($validated);

        return redirect()->route('expenses.index')->with('status', 'Expense added successfully!');
    }

    public function show($id)
    {
        $expense = Expense::where('user_id', auth()->id())
            ->with(['bank', 'category'])
            ->findOrFail($id);
        return view('expenses.show', compact('expense'));
    }

    public function edit($id)
    {
        $expense = Expense::where('user_id', auth()->id())->findOrFail($id);
        $categories = Category::where('user_id', auth()->id())->get();
        $banks = Bank::where('user_id', auth()->id())->get();
        return view('expenses.edit', compact('expense', 'categories', 'banks'));
    }

    public function update(Request $request, $id)
    {
        $expense = Expense::where('user_id', auth()->id())->findOrFail($id);

        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'bank_id' => 'nullable|exists:banks,id',
            'bank_name' => 'nullable|string|max:255',
            'amount' => 'required|numeric',
            'currency' => 'required|string',
            'occurred_at' => 'required|date',
        ]);

        // Handle dynamic bank creation
        if (!$validated['bank_id'] && $validated['bank_name']) {
            $bank = Bank::firstOrCreate(
                [
                    'user_id' => auth()->id(),
                    'bank_name' => $validated['bank_name']
                ],
                [
                    'currency' => $validated['currency']
                ]
            );
            $validated['bank_id'] = $bank->id;
        }

        if (!$validated['bank_id']) {
            return back()->withErrors(['error' => 'Please provide either select or enter a new bank.'])->withInput();
        }

        unset($validated['bank_name']);
        $expense->update($validated);

        return redirect()->route('expenses.index')->with('status', 'Expense updated successfully!');
    }

    public function destroy($id)
    {
        $expense = Expense::where('user_id', auth()->id())->findOrFail($id);
        $expense->delete();

        return redirect()->route('expenses.index')->with('status', 'Expense deleted successfully!');
    }
}
