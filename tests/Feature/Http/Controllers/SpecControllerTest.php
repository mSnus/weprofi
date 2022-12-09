<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Spec;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\SpecController
 */
class SpecControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function index_displays_view()
    {
        $specs = Spec::factory()->count(3)->create();

        $response = $this->get(route('spec.index'));

        $response->assertOk();
        $response->assertViewIs('spec.index');
        $response->assertViewHas('specs');
    }
}
