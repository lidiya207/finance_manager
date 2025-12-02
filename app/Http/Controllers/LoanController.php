<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Bank;
use Illuminate\Http\Request;

class LoanController extends Controller
{
    public function index()
    {
        $loans = Loan::where('user_id', auth()->id())->with('bank')->latest()->paginate(10);
        return view('loan.index', compact('loans'));
    }

    public function create()
    {
        $banks = Bank::where('user_id', auth()->id())->get();
        return view('loan.create', compact('banks'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:given,taken',
            'person_name' => 'required|string',
            'person_contact' => 'nullable|string',
            'reason' => 'nullable|string',
            'principal_amount' => 'required|numeric',
            'outstanding_balance' => 'required|numeric',
            'currency' => 'required|string',
            'bank_id' => 'required|exists:banks,id',
            'status' => 'required|in:open,closed'
        ]);

        $validated['user_id'] = auth()->id();

        Loan::create($validated);

        return redirect()->route('loans.index')->with('status', 'Loan added successfully!');
    }

    public function show($id)
    {
        $loan = Loan::where('user_id', auth()->id())
            ->with('bank')
            ->findOrFail($id);
        return view('loan.show', compact('loan'));
    }

    public function edit($id)
    {
        $loan = Loan::where('user_id', auth()->id())->findOrFail($id);
        $banks = Bank::where('user_id', auth()->id())->get();
        return view('loan.edit', compact('loan', 'banks'));
    }

    public function update(Request $request, $id)
    {
        $loan = Loan::where('user_id', auth()->id())->findOrFail($id);

        $validated = $request->validate([
            'type' => 'required|in:given,taken',
            'person_name' => 'required|string',
            'person_contact' => 'nullable|string',
            'reason' => 'nullable|string',
            'principal_amount' => 'required|numeric',
            'outstanding_balance' => 'required|numeric',
            'currency' => 'required|string',
            'bank_id' => 'required|exists:banks,id',
            'status' => 'required|in:open,closed'
        ]);

        $loan->update($validated);

        return redirect()->route('loans.index')->with('status', 'Loan updated successfully!');
    }

    public function destroy($id)
    {
        $loan = Loan::where('user_id', auth()->id())->findOrFail($id);
        $loan->delete();

        return redirect()->route('loans.index')->with('status', 'Loan deleted successfully!');
    }
}
