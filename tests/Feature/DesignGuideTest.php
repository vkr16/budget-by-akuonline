<?php

namespace Tests\Feature;

use Tests\TestCase;

class DesignGuideTest extends TestCase
{
    /**
     * Test that the design guide page is accessible and renders successfully.
     */
    public function test_design_guide_page_renders_successfully(): void
    {
        $response = $this->get('/design-guide');

        $response->assertStatus(200);
        $response->assertSee('Design Guide');
        $response->assertSee('Budget');
        $response->assertSee('#312E81');
        $response->assertSee('35.9% 0.144 278.697');
        $response->assertSee('assets/vendor/fontawesome/css/all.css');
        $response->assertSee('assets/vendor/notiflix/notiflix.min.js');
    }
}
