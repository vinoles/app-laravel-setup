<?php

namespace Tests\Feature\Api\Talent;

use App\Models\Talent;
use App\Models\User;
use Tests\Feature\Api\TestCase;
use Tests\Feature\Requests\Api\RetrieveTalentRequest;

class RetrieveTalentTest extends TestCase
{

    /**
     * A user not logged in cannot retrieve the talent
     *
     * @test
     * @return void
     */
    public function cannot_retrieve_talent_if_not_logged_in(): void
    {
        $request = RetrieveTalentRequest::make();

        $this->signIn(null)
            ->sendRequestApiGetShow($request)
            ->assertUnauthorized();
    }

    /**
     * A user logged in can retrieve the talent
     *
     * @test
     * @return void
     */
    public function can_retrieve_talent_if_is_logged_in(): void
    {
        $talent = Talent::factory()->create();

        $request = RetrieveTalentRequest::make($talent);

        $user = User::factory()->create();

        $response = $this->signIn($user)
            ->sendRequestApiGetShow($request);

        $response->assertSuccessful();

        $data = $response->json('data');

        $this->assertEquals($data['id'], $talent->uuid);

        $this->assertDatabaseHas('talents', [
            'id' => $talent->id,
            'first_name' => $talent->first_name,
            'last_name' => $talent->last_name,
        ]);

    }

    /**
     * A user cannot see a talent that doesn't exist
     *
     * @test
     * @return void
     */
    public function cannot_see_a_talent_that_doesnt_exist(): void
    {
        $talent = Talent::factory()->create();

        $request = RetrieveTalentRequest::make($talent);

        $talent->delete();

        $user = User::factory()->create();

        $response = $this->signIn($user)
            ->sendRequestApiGetShow($request);

        $response->assertNotFound();

        $data = $response->json('errors');

        $response->assertStatus($data[0]["status"]);
    }

}
