<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Subspec;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\SubspecController
 */
class SubspecControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function index_displays_view()
    {
        $subspecs = Subspec::factory()->count(3)->create();

        $response = $this->get(route('subspec.index'));

        $response->assertOk();
        $response->assertViewIs('subspec.index');
        $response->assertViewHas('subspecs');
    }
}
