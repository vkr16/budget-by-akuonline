<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the financial dashboard overview.
     */
    public function index(Request $request): View
    {
        /** @var User $user */
        $user = Auth::user();

        $pockets = $user->pockets()
            ->where('is_active', true)
            ->withCount('transactions')
            ->orderBy('name')
            ->get();

        $totalBalance = (float) $pockets->sum('current_balance');

        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        $monthIncome = (float) $user->transactions()
            ->where('type', 'in')
            ->whereBetween('date', [$startOfMonth, $endOfMonth])
            ->sum('amount');

        $monthExpense = (float) $user->transactions()
            ->where('type', 'out')
            ->whereBetween('date', [$startOfMonth, $endOfMonth])
            ->sum('amount');

        $recentTransactions = $user->transactions()
            ->with('pocket')
            ->latest('date')
            ->latest('id')
            ->take(10)
            ->get();

        return view('dashboard', [
            'user' => $user,
            'pockets' => $pockets,
            'totalBalance' => $totalBalance,
            'monthIncome' => $monthIncome,
            'monthExpense' => $monthExpense,
            'netFlow' => $monthIncome - $monthExpense,
            'recentTransactions' => $recentTransactions,
        ]);
    }
}
