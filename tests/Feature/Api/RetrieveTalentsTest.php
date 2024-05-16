<?php

namespace Tests\Feature\Api;

use App\Models\Talent;
use App\Models\User;
use Tests\Feature\Requests\Api\RetrieveTalentsRequest;

class RetrieveTalentsTest extends TestCase
{
    /**
     * A user without the required permissions cannot retrieve the list of
     * talents.
     *
     * @test
     * @return void
     */
    public function cannot_retrieve_talents(): void
    {
        $this->sendRequest()->assertUnauthorized();
    }

    /**
     * A user not logged in cannot retrieve the talents
     *
     * @test
     * @return void
     */
    public function cannot_retrieve_talents_if_not_logged_in(): void
    {
        $request = RetrieveTalentsRequest::make();

        $this->signIn(null)
            ->sendRequestApiGet($request)
            ->assertUnauthorized();
    }

    /**
     * A user logged in can retrieve the talents
     *
     * @test
     * @return void
     */
    public function can_retrieve_talents_if_is_logged_in(): void
    {
        $talents = Talent::factory()->count(3)->create();

        $request = RetrieveTalentsRequest::make();

        $user = User::factory()->create();

        $response = $this->signIn($user)
            ->sendRequestApiGet($request);

        $response->assertSuccessful();

        $this->assertEquals(count($response->json('data')), count($talents));

        foreach ($talents as $talent) {

            $this->assertDatabaseHas('talents', [
                'id' => $talent->id,
                'first_name' => $talent->first_name,
                'last_name' => $talent->last_name,
            ]);
        }
    }

}
