<?php

namespace Tests\Feature;

use App\Models\Pocket;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PocketTest extends TestCase
{
    use RefreshDatabase;

    public function test_unauthenticated_user_cannot_access_pockets(): void
    {
        $response = $this->get('/kantong');

        $response->assertRedirect('/login');
    }

    public function test_user_can_view_pockets_list(): void
    {
        $user = User::factory()->create();
        $pocket = Pocket::factory()->create([
            'user_id' => $user->id,
            'name' => 'Tabungan Menikah',
        ]);

        $response = $this->actingAs($user)->get('/kantong');

        $response->assertStatus(200);
        $response->assertSee('Tabungan Menikah');
    }

    public function test_user_can_create_a_new_pocket(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/kantong', [
            'name' => 'Dana Liburan',
            'initial_balance' => 500000,
            'color' => 'emerald',
            'icon' => 'fa-wallet',
            'description' => 'Untuk jalan-jalan akhir tahun',
        ]);

        $response->assertRedirect(route('pockets.index'));
        $this->assertDatabaseHas('pockets', [
            'user_id' => $user->id,
            'name' => 'Dana Liburan',
            'initial_balance' => 500000,
            'current_balance' => 500000,
        ]);
    }

    public function test_user_can_view_pocket_details(): void
    {
        $user = User::factory()->create();
        $pocket = Pocket::factory()->create([
            'user_id' => $user->id,
            'name' => 'Kas Harian',
            'current_balance' => 250000,
        ]);

        $response = $this->actingAs($user)->get(route('pockets.show', $pocket));

        $response->assertStatus(200);
        $response->assertSee('Kas Harian');
        $response->assertSee('250.000');
    }

    public function test_user_can_update_a_pocket(): void
    {
        $user = User::factory()->create();
        $pocket = Pocket::factory()->create([
            'user_id' => $user->id,
            'name' => 'Dompet Lama',
            'initial_balance' => 100000,
            'current_balance' => 100000,
        ]);

        $response = $this->actingAs($user)->put(route('pockets.update', $pocket), [
            'name' => 'Dompet Baru',
            'initial_balance' => 200000,
            'icon' => 'fa-wallet',
        ]);

        $response->assertRedirect();
        $pocket->refresh();
        $this->assertSame('Dompet Baru', $pocket->name);
        $this->assertSame('200000.00', (string) $pocket->initial_balance);
        $this->assertSame('200000.00', (string) $pocket->current_balance);
    }

    public function test_user_cannot_view_or_modify_another_users_pocket(): void
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        $pocket2 = Pocket::factory()->create(['user_id' => $user2->id]);

        $responseShow = $this->actingAs($user1)->get(route('pockets.show', $pocket2));
        $responseShow->assertStatus(403);

        $responseUpdate = $this->actingAs($user1)->put(route('pockets.update', $pocket2), [
            'name' => 'Hacked Name',
            'initial_balance' => 1000,
        ]);
        $responseUpdate->assertStatus(403);
    }

    public function test_user_cannot_delete_their_only_pocket(): void
    {
        $user = User::factory()->create();
        $pocket = Pocket::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->delete(route('pockets.destroy', $pocket));

        $response->assertRedirect();
        $response->assertSessionHas('error');
        $this->assertDatabaseHas('pockets', ['id' => $pocket->id]);
    }

    public function test_user_can_delete_pocket_when_they_have_multiple_pockets(): void
    {
        $user = User::factory()->create();
        $pocket1 = Pocket::factory()->create(['user_id' => $user->id]);
        $pocket2 = Pocket::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->delete(route('pockets.destroy', $pocket2));

        $response->assertRedirect(route('pockets.index'));
        $this->assertDatabaseMissing('pockets', ['id' => $pocket2->id]);
    }
}
