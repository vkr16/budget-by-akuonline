<?php

namespace Tests\Feature;

use App\Models\Pocket;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TransactionTest extends TestCase
{
    use RefreshDatabase;

    public function test_unauthenticated_user_cannot_access_transactions(): void
    {
        $response = $this->get('/transaksi');

        $response->assertRedirect('/login');
    }

    public function test_user_can_view_transactions_page(): void
    {
        $user = User::factory()->create();
        $pocket = Pocket::factory()->create(['user_id' => $user->id]);
        $trx = Transaction::factory()->create([
            'user_id' => $user->id,
            'pocket_id' => $pocket->id,
            'description' => 'Makan Siang Soto Betawi',
        ]);

        $response = $this->actingAs($user)->get('/transaksi');

        $response->assertStatus(200);
        $response->assertSee('Makan Siang Soto Betawi');
    }

    public function test_user_can_record_out_expense_and_pocket_balance_decreases(): void
    {
        $user = User::factory()->create();
        $pocket = Pocket::factory()->create([
            'user_id' => $user->id,
            'initial_balance' => 500000,
            'current_balance' => 500000,
        ]);

        $response = $this->actingAs($user)->post('/transaksi', [
            'type' => 'out',
            'pocket_id' => $pocket->id,
            'amount' => 50000,
            'date' => now()->format('Y-m-d H:i:s'),
            'description' => 'Beli Bensin Pertamax',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('transactions', [
            'user_id' => $user->id,
            'pocket_id' => $pocket->id,
            'type' => 'out',
            'amount' => 50000,
            'description' => 'Beli Bensin Pertamax',
        ]);

        $pocket->refresh();
        $this->assertSame('450000.00', (string) $pocket->current_balance);
    }

    public function test_user_can_record_in_income_and_pocket_balance_increases(): void
    {
        $user = User::factory()->create();
        $pocket = Pocket::factory()->create([
            'user_id' => $user->id,
            'initial_balance' => 100000,
            'current_balance' => 100000,
        ]);

        $response = $this->actingAs($user)->post('/transaksi', [
            'type' => 'in',
            'pocket_id' => $pocket->id,
            'amount' => 300000,
            'date' => now()->format('Y-m-d H:i:s'),
            'description' => 'Gaji Tambahan Freelance',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('transactions', [
            'user_id' => $user->id,
            'pocket_id' => $pocket->id,
            'type' => 'in',
            'amount' => 300000,
        ]);

        $pocket->refresh();
        $this->assertSame('400000.00', (string) $pocket->current_balance);
    }

    public function test_recording_transaction_validates_required_fields(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/transaksi', []);

        $response->assertSessionHasErrors(['type', 'pocket_id', 'amount', 'date']);
    }

    public function test_deleting_transaction_recalculates_pocket_balance(): void
    {
        $user = User::factory()->create();
        $pocket = Pocket::factory()->create([
            'user_id' => $user->id,
            'initial_balance' => 200000,
            'current_balance' => 150000,
        ]);

        $trx = Transaction::factory()->create([
            'user_id' => $user->id,
            'pocket_id' => $pocket->id,
            'type' => 'out',
            'amount' => 50000,
        ]);

        $response = $this->actingAs($user)->delete(route('transactions.destroy', $trx));

        $response->assertRedirect();
        $this->assertDatabaseMissing('transactions', ['id' => $trx->id]);

        $pocket->refresh();
        // Since the 50.000 out transaction is deleted, balance goes back to 200.000
        $this->assertSame('200000.00', (string) $pocket->current_balance);
    }

    public function test_user_cannot_delete_another_users_transaction(): void
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $pocket2 = Pocket::factory()->create(['user_id' => $user2->id]);
        $trx2 = Transaction::factory()->create([
            'user_id' => $user2->id,
            'pocket_id' => $pocket2->id,
        ]);

        $response = $this->actingAs($user1)->delete(route('transactions.destroy', $trx2));

        $response->assertStatus(403);
        $this->assertDatabaseHas('transactions', ['id' => $trx2->id]);
    }

    public function test_transactions_can_be_filtered_by_type_and_pocket(): void
    {
        $user = User::factory()->create();
        $pocketA = Pocket::factory()->create(['user_id' => $user->id, 'name' => 'Kantong A']);
        $pocketB = Pocket::factory()->create(['user_id' => $user->id, 'name' => 'Kantong B']);

        Transaction::factory()->create([
            'user_id' => $user->id,
            'pocket_id' => $pocketA->id,
            'type' => 'in',
            'description' => 'Transfer Masuk A',
        ]);
        Transaction::factory()->create([
            'user_id' => $user->id,
            'pocket_id' => $pocketB->id,
            'type' => 'out',
            'description' => 'Beli Martabak B',
        ]);

        $response = $this->actingAs($user)->get('/transaksi?type=in&pocket_id='.$pocketA->id);

        $response->assertStatus(200);
        $response->assertSee('Transfer Masuk A');
        $response->assertDontSee('Beli Martabak B');
    }
}
