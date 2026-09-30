<?php

namespace App\Http\Controllers;

use App\Models\Pocket;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PocketController extends Controller
{
    /**
     * Display a listing of all pockets.
     */
    public function index(): View
    {
        /** @var User $user */
        $user = Auth::user();

        $pockets = $user->pockets()
            ->withCount('transactions')
            ->orderBy('name')
            ->get();

        $totalBalance = (float) $pockets->sum('current_balance');

        return view('pockets.index', [
            'pockets' => $pockets,
            'totalBalance' => $totalBalance,
        ]);
    }

    /**
     * Store a newly created pocket.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'initial_balance' => ['nullable', 'numeric', 'min:0'],
            'color' => ['nullable', 'string', 'in:zinc,emerald,blue,amber,purple,rose,indigo,teal'],
            'icon' => ['nullable', 'string', 'max:50'],
            'description' => ['nullable', 'string', 'max:255'],
        ]);

        $initialBalance = (float) ($validated['initial_balance'] ?? 0);

        /** @var User $user */
        $user = Auth::user();

        $user->pockets()->create([
            'name' => $validated['name'],
            'initial_balance' => $initialBalance,
            'current_balance' => $initialBalance,
            'color' => $validated['color'] ?? 'zinc',
            'icon' => $validated['icon'] ?? 'fa-wallet',
            'description' => $validated['description'] ?? null,
            'is_active' => true,
        ]);

        return redirect()->route('pockets.index')
            ->with('success', 'Kantong "'.$validated['name'].'" berhasil dibuat!');
    }

    /**
     * Display the specified pocket with its transaction history.
     */
    public function show(Pocket $pocket): View|RedirectResponse
    {
        if ($pocket->user_id !== Auth::id()) {
            abort(403);
        }

        $pocket->loadCount('transactions');

        $transactions = $pocket->transactions()
            ->latest('date')
            ->latest('id')
            ->paginate(15);

        $totalIn = (float) $pocket->transactions()->where('type', 'in')->sum('amount');
        $totalOut = (float) $pocket->transactions()->where('type', 'out')->sum('amount');

        return view('pockets.show', [
            'pocket' => $pocket,
            'transactions' => $transactions,
            'totalIn' => $totalIn,
            'totalOut' => $totalOut,
        ]);
    }

    /**
     * Update the specified pocket in storage.
     */
    public function update(Request $request, Pocket $pocket): RedirectResponse
    {
        if ($pocket->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'initial_balance' => ['required', 'numeric', 'min:0'],
            'color' => ['nullable', 'string', 'in:zinc,emerald,blue,amber,purple,rose,indigo,teal'],
            'icon' => ['nullable', 'string', 'max:50'],
            'description' => ['nullable', 'string', 'max:255'],
        ]);

        $pocket->update([
            'name' => $validated['name'],
            'initial_balance' => (float) $validated['initial_balance'],
            'color' => $validated['color'] ?? $pocket->color,
            'icon' => $validated['icon'] ?? $pocket->icon,
            'description' => $validated['description'] ?? null,
        ]);

        $pocket->recalculateBalance();

        return redirect()->back()
            ->with('success', 'Kantong "'.$pocket->name.'" berhasil diperbarui!');
    }

    /**
     * Remove the specified pocket from storage.
     */
    public function destroy(Pocket $pocket): RedirectResponse
    {
        if ($pocket->user_id !== Auth::id()) {
            abort(403);
        }

        /** @var User $user */
        $user = Auth::user();

        if ($user->pockets()->count() <= 1) {
            return redirect()->back()
                ->with('error', 'Anda harus memiliki minimal satu kantong aktif.');
        }

        $name = $pocket->name;
        $pocket->delete();

        return redirect()->route('pockets.index')
            ->with('success', 'Kantong "'.$name.'" berhasil dihapus.');
    }
}
