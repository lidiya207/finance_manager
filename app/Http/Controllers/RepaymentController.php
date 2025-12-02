<?php

namespace App\Http\Controllers;

use App\Models\Repayment;
use App\Models\Loan;
use Illuminate\Http\Request;

class RepaymentController extends Controller
{
    public function index()
    {
        $repayments = Repayment::whereHas('loan', function($query) {
                $query->where('user_id', auth()->id());
            })
            ->with('loan')
            ->orderBy('occurred_at', 'desc')
            ->get();
        
        return view('repayments.index', compact('repayments'));
    }

    public function loanIndex($loanId)
    {
        $loan = Loan::where('user_id', auth()->id())->findOrFail($loanId);
        $repayments = Repayment::where('loan_id', $loanId)
            ->orderBy('occurred_at', 'desc')
            ->get();
        
        return view('repayments.loan-index', compact('loan', 'repayments'));
    }

    public function create($loanId)
    {
        $loan = Loan::where('user_id', auth()->id())->findOrFail($loanId);
        return view('repayments.create', compact('loan'));
    }

    public function store(Request $request, $loanId)
    {
        $loan = Loan::where('user_id', auth()->id())->findOrFail($loanId);
        
        $validated = $request->validate([
            'amount' => 'required|numeric|min:0.01|max:' . $loan->outstanding_balance,
            'occurred_at' => 'required|date',
            'type' => 'required|in:partial,full'
        ]);

        $validated['loan_id'] = $loanId;

        $repayment = Repayment::create($validated);

        // Update loan outstanding balance
        $loan->outstanding_balance -= $validated['amount'];

        if ($validated['type'] == 'full' || $loan->outstanding_balance <= 0) {
            $loan->status = 'closed';
            $loan->outstanding_balance = 0;
        }

        $loan->save();

        return redirect()->route('repayments.loan-index', $loanId)
            ->with('status', 'Repayment recorded successfully!');
    }

    public function destroy($loanId, $id)
    {
        $loan = Loan::where('user_id', auth()->id())->findOrFail($loanId);
        $repayment = Repayment::where('loan_id', $loanId)->findOrFail($id);
        
        // Restore the balance
        $loan->outstanding_balance += $repayment->amount;
        if ($loan->status == 'closed') {
            $loan->status = 'open';
        }
        $loan->save();
        
        $repayment->delete();

        return redirect()->route('repayments.loan-index', $loanId)
            ->with('status', 'Repayment deleted successfully!');
    }
}
