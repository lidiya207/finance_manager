<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Category;
use App\Models\Bank;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function index()
    {
        $expenses = Expense::where('user_id', auth()->id())->with(['bank', 'category'])->latest()->paginate(10);
        return view('expenses.index', compact('expenses'));
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
