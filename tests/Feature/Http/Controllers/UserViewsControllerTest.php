<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Source;
use App\Models\Target;
use App\Models\UserFeedback;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\UserViewsController
 */
class UserViewsControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\UserViewsController::class,
            'store',
            \App\Http\Requests\UserViewsStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves()
    {
        $source = Source::factory()->create();
        $target = Target::factory()->create();

        $response = $this->post(route('user-view.store'), [
            'source_id' => $source->id,
            'target_id' => $target->id,
        ]);

        $this->assertDatabaseHas(userFeedbacks, [ /* ... */ ]);
    }
}
