<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use Illuminate\Http\Request;

class BankController extends Controller
{
    public function index()
    {
        $banks = Bank::where('user_id', auth()->id())->latest()->get();
        return view('banks.index', compact('banks'));
    }

    public function create()
    {
        return view('banks.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'bank_name' => 'required|string|max:255',
            'currency' => 'required|string|max:10'
        ]);

        $validated['user_id'] = auth()->id();

        Bank::create($validated);

        return redirect()->route('banks.index')->with('status', 'Bank added successfully!');
    }

    public function edit($id)
    {
        $bank = Bank::where('user_id', auth()->id())->findOrFail($id);
        return view('banks.edit', compact('bank'));
    }

    public function update(Request $request, $id)
    {
        $bank = Bank::where('user_id', auth()->id())->findOrFail($id);

        $validated = $request->validate([
            'bank_name' => 'required|string|max:255',
            'currency' => 'required|string|max:10'
        ]);

        $bank->update($validated);

        return redirect()->route('banks.index')->with('status', 'Bank updated successfully!');
    }

    public function destroy($id)
    {
        $bank = Bank::where('user_id', auth()->id())->findOrFail($id);
        
        // Check if bank has transactions
        $hasTransactions = $bank->incomes()->count() > 0 || 
                          $bank->expenses()->count() > 0 || 
                          $bank->loans()->count() > 0;
        
        if ($hasTransactions) {
            return redirect()->route('banks.index')
                ->with('error', 'Cannot delete bank that has associated transactions.');
        }
        
        $bank->delete();

        return redirect()->route('banks.index')->with('status', 'Bank deleted successfully!');
    }
}
