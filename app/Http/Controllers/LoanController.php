<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Bank;
use Illuminate\Http\Request;
use Carbon\Carbon;

class LoanController extends Controller
{
    public function index(Request $request)
    {
        $query = Loan::where('user_id', auth()->id())->with('bank');

        // SEARCH → person name
        if ($request->person_name) {
            $query->where('person_name', 'like', '%' . $request->person_name . '%');
        }

        // SEARCH → type
        if ($request->type) {
            $query->where('type', $request->type);
        }

        // SEARCH → status
        if ($request->status) {
            $query->where('status', $request->status);
        }

        // SEARCH → bank
        if ($request->bank) {
            $query->whereHas('bank', function ($q) use ($request) {
                $q->where('bank_name', 'like', '%' . $request->bank . '%');
            });
        }

        // SEARCH → date
        if ($request->date) {
            $query->whereDate('created_at', $request->date);
        }

        // SEARCH → Amount range
        if ($request->min_amount) {
            $query->where('principal_amount', '>=', $request->min_amount);
        }

        if ($request->max_amount) {
            $query->where('principal_amount', '<=', $request->max_amount);
        }

        $loans = $query->latest()->paginate(10);

        // SUMMARY CALCULATIONS
        $total_given = Loan::where('user_id', auth()->id())
            ->where('type', 'given')
            ->sum('principal_amount');

        $total_taken = Loan::where('user_id', auth()->id())
            ->where('type', 'taken')
            ->sum('principal_amount');

        // MONTHLY BAR CHART DATA
        $monthlyLabels = [];
        $monthlyTotals = [];

        for ($i = 1; $i <= 12; $i++) {
            $month_name = Carbon::create()->month($i)->format('F');
            $monthlyLabels[] = $month_name;

            $monthlyTotals[] = Loan::where('user_id', auth()->id())
                ->whereMonth('created_at', $i)
                ->sum('principal_amount');
        }

        return view('loan.index', compact(
            'loans',
            'total_given',
            'total_taken',
            'monthlyLabels',
            'monthlyTotals'
        ));
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
