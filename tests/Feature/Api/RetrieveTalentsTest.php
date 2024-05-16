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

    // /**
    //  * A user with the required permissions can retrieve the list of talents.
    //  *
    //  * @test
    //  * @return void
    //  */
    // public function can_retrieve_talents(): void
    // {
    //     $this->signIn(null);

    //     $account = $this->user->getTalent();

    //     $talents = Talent::factory()
    //         ->randomAmount()
    //         ->for($account)
    //         ->withPrices()
    //         ->create();

    //     $response = $this->sendRequest($account);

    //     $response->assertSuccessful();

    //     $this->assertCount($talents->count(), $response->json('data'));
    // }

}
