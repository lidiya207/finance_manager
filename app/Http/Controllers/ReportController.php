<?php

namespace App\Http\Controllers;

use App\Models\Income;
use App\Models\Expense;
use App\Models\Loan;
use App\Models\Repayment;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        // Get current month data
        $startDate = Carbon::now()->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();
        
        $incomes = Income::where('user_id', auth()->id())
            ->whereBetween('occurred_at', [$startDate, $endDate])
            ->get();
        
        $expenses = Expense::where('user_id', auth()->id())
            ->whereBetween('occurred_at', [$startDate, $endDate])
            ->get();
        
        // Calculate totals
        $totalIncome = $incomes->sum('amount');
        $totalExpenses = $expenses->sum('amount');
        $netBalance = $totalIncome - $totalExpenses;
        
        // Get last 7 days data for chart
        $last7Days = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $dayIncome = Income::where('user_id', auth()->id())
                ->whereDate('occurred_at', $date)
                ->sum('amount');
            $dayExpenses = Expense::where('user_id', auth()->id())
                ->whereDate('occurred_at', $date)
                ->sum('amount');
            
            $last7Days[] = [
                'date' => $date->format('M d'),
                'day' => $date->format('D'),
                'income' => $dayIncome,
                'expenses' => $dayExpenses,
            ];
        }
        
        // Group expenses by category
        $expensesByCategory = $expenses->groupBy(function($expense) {
            return $expense->category->name ?? 'Other';
        })->map->sum('amount')->take(5);
        
        // Group income by source
        $incomeBySource = $incomes->groupBy(function($income) {
            return $income->source->name ?? 'Other';
        })->map->sum('amount')->take(5);
        
        return view('reports.index', compact(
            'totalIncome', 'totalExpenses', 'netBalance',
            'last7Days', 'expensesByCategory', 'incomeBySource'
        ));
    }

    public function daily($date = null)
    {
        $date = $date ? Carbon::parse($date) : Carbon::today();
        
        $incomes = Income::where('user_id', auth()->id())
            ->whereDate('occurred_at', $date)
            ->with(['bank', 'source'])
            ->get();
        
        $expenses = Expense::where('user_id', auth()->id())
            ->whereDate('occurred_at', $date)
            ->with(['bank', 'category'])
            ->get();
        
        $loans = Loan::where('user_id', auth()->id())
            ->whereHas('repayments', function($query) use ($date) {
                $query->whereDate('occurred_at', $date);
            })
            ->with(['repayments' => function($query) use ($date) {
                $query->whereDate('occurred_at', $date);
            }])
            ->get();
        
        $repayments = Repayment::whereHas('loan', function($query) {
                $query->where('user_id', auth()->id());
            })
            ->whereDate('occurred_at', $date)
            ->with('loan')
            ->get();
        
        // Calculate totals
        $totalIncome = $incomes->sum('amount');
        $totalExpenses = $expenses->sum('amount');
        $netBalance = $totalIncome - $totalExpenses;
        
        // Group by currency
        $incomeByCurrency = $incomes->groupBy('currency')->map->sum('amount');
        $expensesByCurrency = $expenses->groupBy('currency')->map->sum('amount');
        
        return view('reports.daily', compact(
            'date', 'incomes', 'expenses', 'loans', 'repayments',
            'totalIncome', 'totalExpenses', 'netBalance',
            'incomeByCurrency', 'expensesByCurrency'
        ));
    }

    public function weekly($startDate = null)
    {
        $startDate = $startDate ? Carbon::parse($startDate) : Carbon::now()->startOfWeek();
        $endDate = $startDate->copy()->endOfWeek();
        
        $incomes = Income::where('user_id', auth()->id())
            ->whereBetween('occurred_at', [$startDate, $endDate])
            ->with(['bank', 'source'])
            ->get();
        
        $expenses = Expense::where('user_id', auth()->id())
            ->whereBetween('occurred_at', [$startDate, $endDate])
            ->with(['bank', 'category'])
            ->get();
        
        $repayments = Repayment::whereHas('loan', function($query) {
                $query->where('user_id', auth()->id());
            })
            ->whereBetween('occurred_at', [$startDate, $endDate])
            ->with('loan')
            ->get();
        
        // Group expenses by category
        $expensesByCategory = $expenses->groupBy('category.name')->map(function($items) {
            return $items->sum('amount');
        });
        
        // Group income by source
        $incomeBySource = $incomes->groupBy('source.name')->map(function($items) {
            return $items->sum('amount');
        });
        
        // Daily breakdown
        $dailyIncome = $incomes->groupBy(function($item) {
            return Carbon::parse($item->occurred_at)->format('Y-m-d');
        })->map->sum('amount');
        
        $dailyExpenses = $expenses->groupBy(function($item) {
            return Carbon::parse($item->occurred_at)->format('Y-m-d');
        })->map->sum('amount');
        
        $totalIncome = $incomes->sum('amount');
        $totalExpenses = $expenses->sum('amount');
        $totalRepayments = $repayments->sum('amount');
        $netBalance = $totalIncome - $totalExpenses;
        
        return view('reports.weekly', compact(
            'startDate', 'endDate', 'incomes', 'expenses', 'repayments',
            'expensesByCategory', 'incomeBySource', 'dailyIncome', 'dailyExpenses',
            'totalIncome', 'totalExpenses', 'totalRepayments', 'netBalance'
        ));
    }

    public function monthly($month = null, $year = null)
    {
        $date = $month && $year ? Carbon::create($year, $month, 1) : Carbon::now()->startOfMonth();
        $startDate = $date->copy()->startOfMonth();
        $endDate = $date->copy()->endOfMonth();
        
        $incomes = Income::where('user_id', auth()->id())
            ->whereBetween('occurred_at', [$startDate, $endDate])
            ->with(['bank', 'source'])
            ->get();
        
        $expenses = Expense::where('user_id', auth()->id())
            ->whereBetween('occurred_at', [$startDate, $endDate])
            ->with(['bank', 'category'])
            ->get();
        
        $loans = Loan::where('user_id', auth()->id())
            ->where('status', 'open')
            ->with('bank')
            ->get();
        
        $repayments = Repayment::whereHas('loan', function($query) {
                $query->where('user_id', auth()->id());
            })
            ->whereBetween('occurred_at', [$startDate, $endDate])
            ->with('loan')
            ->get();
        
        // Group expenses by category
        $expensesByCategory = $expenses->groupBy('category.name')->map(function($items) {
            return $items->sum('amount');
        });
        
        // Group income by source
        $incomeBySource = $incomes->groupBy('source.name')->map(function($items) {
            return $items->sum('amount');
        });
        
        // Weekly breakdown
        $weeklyIncome = [];
        $weeklyExpenses = [];
        $currentWeek = $startDate->copy();
        
        while ($currentWeek->lte($endDate)) {
            $weekEnd = $currentWeek->copy()->endOfWeek();
            if ($weekEnd->gt($endDate)) $weekEnd = $endDate;
            
            $weekIncome = $incomes->filter(function($item) use ($currentWeek, $weekEnd) {
                $itemDate = Carbon::parse($item->occurred_at);
                return $itemDate->gte($currentWeek) && $itemDate->lte($weekEnd);
            })->sum('amount');
            
            $weekExpenses = $expenses->filter(function($item) use ($currentWeek, $weekEnd) {
                $itemDate = Carbon::parse($item->occurred_at);
                return $itemDate->gte($currentWeek) && $itemDate->lte($weekEnd);
            })->sum('amount');
            
            $weekLabel = $currentWeek->format('M d') . ' - ' . $weekEnd->format('M d');
            $weeklyIncome[$weekLabel] = $weekIncome;
            $weeklyExpenses[$weekLabel] = $weekExpenses;
            
            $currentWeek->addWeek()->startOfWeek();
        }
        
        $totalIncome = $incomes->sum('amount');
        $totalExpenses = $expenses->sum('amount');
        $totalRepayments = $repayments->sum('amount');
        $netBalance = $totalIncome - $totalExpenses;
        $savings = $netBalance;
        
        // Outstanding loans
        $outstandingGiven = $loans->where('type', 'given')->sum('outstanding_balance');
        $outstandingTaken = $loans->where('type', 'taken')->sum('outstanding_balance');
        
        return view('reports.monthly', compact(
            'date', 'startDate', 'endDate', 'incomes', 'expenses', 'loans', 'repayments',
            'expensesByCategory', 'incomeBySource', 'weeklyIncome', 'weeklyExpenses',
            'totalIncome', 'totalExpenses', 'totalRepayments', 'netBalance', 'savings',
            'outstandingGiven', 'outstandingTaken'
        ));
    }

    public function forecast()
    {
        // Get last 3 months of data
        $threeMonthsAgo = Carbon::now()->subMonths(3)->startOfMonth();
        $lastMonth = Carbon::now()->subMonth()->endOfMonth();
        
        $historicalIncomes = Income::where('user_id', auth()->id())
            ->whereBetween('occurred_at', [$threeMonthsAgo, $lastMonth])
            ->get();
        
        $historicalExpenses = Expense::where('user_id', auth()->id())
            ->whereBetween('occurred_at', [$threeMonthsAgo, $lastMonth])
            ->get();
        
        // Calculate average monthly income and expenses
        $months = [];
        $current = $threeMonthsAgo->copy();
        
        while ($current->lte($lastMonth)) {
            $monthStart = $current->copy()->startOfMonth();
            $monthEnd = $current->copy()->endOfMonth();
            
            $monthIncome = $historicalIncomes->filter(function($item) use ($monthStart, $monthEnd) {
                $itemDate = Carbon::parse($item->occurred_at);
                return $itemDate->gte($monthStart) && $itemDate->lte($monthEnd);
            })->sum('amount');
            
            $monthExpenses = $historicalExpenses->filter(function($item) use ($monthStart, $monthEnd) {
                $itemDate = Carbon::parse($item->occurred_at);
                return $itemDate->gte($monthStart) && $itemDate->lte($monthEnd);
            })->sum('amount');
            
            $months[] = [
                'month' => $current->format('F Y'),
                'income' => $monthIncome,
                'expenses' => $monthExpenses,
                'net' => $monthIncome - $monthExpenses
            ];
            
            $current->addMonth();
        }
        
        // Calculate averages
        $avgIncome = $months ? array_sum(array_column($months, 'income')) / count($months) : 0;
        $avgExpenses = $months ? array_sum(array_column($months, 'expenses')) / count($months) : 0;
        $avgNet = $avgIncome - $avgExpenses;
        
        // Forecast next month
        $nextMonth = Carbon::now()->addMonth();
        $forecastedIncome = $avgIncome;
        $forecastedExpenses = $avgExpenses;
        $forecastedNet = $forecastedIncome - $forecastedExpenses;
        
        // Get current balance (simplified - sum of all income minus expenses)
        $allIncomes = Income::where('user_id', auth()->id())->sum('amount');
        $allExpenses = Expense::where('user_id', auth()->id())->sum('amount');
        $currentBalance = $allIncomes - $allExpenses;
        $projectedBalance = $currentBalance + $forecastedNet;
        
        return view('reports.forecast', compact(
            'months', 'avgIncome', 'avgExpenses', 'avgNet',
            'nextMonth', 'forecastedIncome', 'forecastedExpenses', 'forecastedNet',
            'currentBalance', 'projectedBalance'
        ));
    }
}

