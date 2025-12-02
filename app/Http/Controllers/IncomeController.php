<?php

namespace App\Http\Controllers;

use App\Models\Income;
use App\Models\IncomeSource;
use App\Models\Bank;
use Illuminate\Http\Request;

class IncomeController extends Controller
{
    public function index()
    {
        $incomes = Income::where('user_id', auth()->id())->with(['bank', 'source'])->latest()->paginate(10);
        return view('income.index', compact('incomes'));
    }

    public function create()
    {
        $sources = IncomeSource::where('user_id', auth()->id())->get();
        $banks = Bank::where('user_id', auth()->id())->get();
        return view('income.create', compact('sources', 'banks'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'bank_id' => 'nullable|exists:banks,id',
            'bank_name' => 'nullable|string|max:255',
            'source_id' => 'nullable|exists:income_sources,id',
            'source_name' => 'nullable|string|max:255',
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

        // Handle dynamic income source creation
        if (!$validated['source_id'] && $validated['source_name']) {
            $source = IncomeSource::firstOrCreate(
                [
                    'user_id' => auth()->id(),
                    'name' => $validated['source_name']
                ]
            );
            $validated['source_id'] = $source->id;
        }

        if (!$validated['bank_id'] || !$validated['source_id']) {
            return back()->withErrors(['error' => 'Please provide either select or enter a new bank and income source.'])->withInput();
        }

        $validated['user_id'] = auth()->id();
        $validated['income_source_id'] = $validated['source_id'];
        unset($validated['bank_name'], $validated['source_name'], $validated['source_id']);

        Income::create($validated);

        return redirect()->route('income.index')->with('status', 'Income added successfully!');
    }

    public function show($id)
    {
        $income = Income::where('user_id', auth()->id())
            ->with(['bank', 'source'])
            ->findOrFail($id);
        return view('income.show', compact('income'));
    }

    public function edit($id)
    {
        $income = Income::where('user_id', auth()->id())->findOrFail($id);
        $sources = IncomeSource::where('user_id', auth()->id())->get();
        $banks = Bank::where('user_id', auth()->id())->get();
        return view('income.edit', compact('income', 'sources', 'banks'));
    }

    public function update(Request $request, $id)
    {
        $income = Income::where('user_id', auth()->id())->findOrFail($id);

        $validated = $request->validate([
            'bank_id' => 'nullable|exists:banks,id',
            'bank_name' => 'nullable|string|max:255',
            'source_id' => 'nullable|exists:income_sources,id',
            'source_name' => 'nullable|string|max:255',
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

        // Handle dynamic income source creation
        if (!$validated['source_id'] && $validated['source_name']) {
            $source = IncomeSource::firstOrCreate(
                [
                    'user_id' => auth()->id(),
                    'name' => $validated['source_name']
                ]
            );
            $validated['source_id'] = $source->id;
        }

        if (!$validated['bank_id'] || !$validated['source_id']) {
            return back()->withErrors(['error' => 'Please provide either select or enter a new bank and income source.'])->withInput();
        }

        $validated['income_source_id'] = $validated['source_id'];
        unset($validated['bank_name'], $validated['source_name'], $validated['source_id']);
        $income->update($validated);

        return redirect()->route('income.index')->with('status', 'Income updated successfully!');
    }

    public function destroy($id)
    {
        $income = Income::where('user_id', auth()->id())->findOrFail($id);
        $income->delete();

        return redirect()->route('income.index')->with('status', 'Income deleted successfully!');
    }
}
