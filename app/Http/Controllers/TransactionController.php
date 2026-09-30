<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class TransactionController extends Controller
{
    /**
     * Display a listing of transactions with filters.
     */
    public function index(Request $request): View
    {
        /** @var User $user */
        $user = Auth::user();

        $query = $user->transactions()->with('pocket');

        if ($request->filled('type') && in_array($request->query('type'), ['in', 'out'], true)) {
            $query->where('type', $request->query('type'));
        }

        if ($request->filled('pocket_id')) {
            $query->where('pocket_id', $request->query('pocket_id'));
        }

        if ($request->filled('date_from')) {
            $query->whereDate('date', '>=', $request->query('date_from'));
        }

        if ($request->filled('date_to')) {
            $query->whereDate('date', '<=', $request->query('date_to'));
        }

        if ($request->filled('search')) {
            $search = $request->query('search');
            $query->where('description', 'like', "%{$search}%");
        }

        $transactions = $query->latest('date')
            ->latest('id')
            ->paginate(20)
            ->withQueryString();

        $pockets = $user->pockets()->where('is_active', true)->orderBy('name')->get();

        $totalFilteredIn = (float) (clone $query)->where('type', 'in')->sum('amount');
        $totalFilteredOut = (float) (clone $query)->where('type', 'out')->sum('amount');

        return view('transactions.index', [
            'transactions' => $transactions,
            'pockets' => $pockets,
            'totalFilteredIn' => $totalFilteredIn,
            'totalFilteredOut' => $totalFilteredOut,
            'filters' => $request->only(['type', 'pocket_id', 'date_from', 'date_to', 'search']),
        ]);
    }

    /**
     * Store a newly created transaction.
     */
    public function store(Request $request): RedirectResponse|JsonResponse
    {
        /** @var User $user */
        $user = Auth::user();

        $validated = $request->validate([
            'type' => ['required', 'in:in,out'],
            'pocket_id' => ['required', 'integer', 'exists:pockets,id'],
            'amount' => ['required', 'numeric', 'min:1'],
            'date' => ['required', 'date'],
            'description' => ['nullable', 'string', 'max:255'],
        ]);

        $pocket = $user->pockets()->findOrFail($validated['pocket_id']);

        $transaction = DB::transaction(function () use ($validated, $user, $pocket) {
            $trx = $user->transactions()->create([
                'pocket_id' => $pocket->id,
                'type' => $validated['type'],
                'amount' => $validated['amount'],
                'date' => $validated['date'],
                'description' => $validated['description'] ?? null,
            ]);

            if ($validated['type'] === 'in') {
                $pocket->increment('current_balance', $validated['amount']);
            } else {
                $pocket->decrement('current_balance', $validated['amount']);
            }

            return $trx;
        });

        $message = $validated['type'] === 'in'
            ? 'Pemasukan Rp '.number_format($validated['amount'], 0, ',', '.').' berhasil ditambahkan ke '.$pocket->name.'!'
            : 'Pengeluaran Rp '.number_format($validated['amount'], 0, ',', '.').' berhasil dicatat dari '.$pocket->name.'!';

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'transaction' => $transaction->load('pocket'),
                'new_balance' => (float) $pocket->fresh()->current_balance,
            ]);
        }

        return redirect()->back()->with('success', $message);
    }

    /**
     * Remove the specified transaction from storage.
     */
    public function destroy(Transaction $transaction): RedirectResponse|JsonResponse
    {
        if ($transaction->user_id !== Auth::id()) {
            abort(403);
        }

        $pocket = $transaction->pocket;

        DB::transaction(function () use ($transaction, $pocket) {
            $transaction->delete();
            $pocket->recalculateBalance();
        });

        $message = 'Transaksi berhasil dihapus dan saldo kantong diperbarui.';

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'new_balance' => (float) $pocket->fresh()->current_balance,
            ]);
        }

        return redirect()->back()->with('success', $message);
    }
}
