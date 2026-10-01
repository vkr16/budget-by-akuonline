<?php

namespace Tests\Feature;

use App\Models\Pocket;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PwaTest extends TestCase
{
    use RefreshDatabase;

    public function test_manifest_webmanifest_is_accessible_and_valid_json(): void
    {
        $response = $this->get('/manifest.webmanifest');

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/manifest+json');

        $data = $response->json();
        $this->assertSame('Budget by AkuOnline', $data['name']);
        $this->assertSame('Budget', $data['short_name']);
        $this->assertSame('#312c85', $data['theme_color']);
        $this->assertSame('#ffffff', $data['background_color']);
        $this->assertSame('standalone', $data['display']);
        $this->assertSame('/', $data['start_url']);
        $this->assertNotEmpty($data['icons']);
        $this->assertNotEmpty($data['shortcuts']);
    }

    public function test_manifest_json_is_accessible(): void
    {
        $response = $this->get('/manifest.json');

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/manifest+json');
    }

    public function test_service_worker_is_accessible_with_correct_headers(): void
    {
        $response = $this->get('/sw.js');

        $response->assertStatus(200);
        $this->assertStringContainsString('javascript', $response->headers->get('Content-Type'));
        $this->assertSame('/', $response->headers->get('Service-Worker-Allowed'));
        $this->assertStringContainsString('budget-pwa-v2', $response->getContent());
        $this->assertStringContainsString('/offline.html', $response->getContent());
        $this->assertStringContainsString('/icons/', $response->getContent());
        $this->assertStringContainsString('/splash/', $response->getContent());
    }

    public function test_offline_page_exists_and_contains_expected_content(): void
    {
        $this->assertFileExists(public_path('offline.html'));
        $content = file_get_contents(public_path('offline.html'));
        $this->assertStringContainsString('Koneksi Terputus', $content);
        $this->assertStringContainsString('Budget by AkuOnline', $content);
    }

    public function test_guest_layout_renders_pwa_meta_tags(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
        $response->assertSee('manifest.json', false);
        $response->assertSee('<meta name="theme-color" content="#312c85">', false);
        $response->assertSee('<meta name="apple-mobile-web-app-capable" content="yes">', false);
        $response->assertSee('icons/icon-180x180.png', false);
    }

    public function test_app_layout_renders_pwa_meta_and_install_banner(): void
    {
        $user = User::factory()->create();
        Pocket::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertStatus(200);
        $response->assertSee('manifest.json', false);
        $response->assertSee('<meta name="theme-color" content="#312c85">', false);
        $response->assertSee('id="pwa-install-banner"', false);
        $response->assertSee('window.installPwa()', false);
        $response->assertSee('icons/icon-48x48.png', false);
    }

    public function test_pwa_icon_assets_exist(): void
    {
        $this->assertFileExists(public_path('icons/icon-192x192.png'));
        $this->assertFileExists(public_path('icons/icon-512x512.png'));
        $this->assertFileExists(public_path('icons/icon-180x180.png'));
        $this->assertFileExists(public_path('icons/icon-192x192-maskable.png'));
        $this->assertFileExists(public_path('icons/icon-512x512-maskable.png'));
        $this->assertFileExists(public_path('icons/icon-48x48.png'));
        $this->assertFileExists(public_path('splash/splash-1290x2796.png'));
        $this->assertFileExists(public_path('splash/splash-1179x2556.png'));
    }
}
