<?php

namespace Tests\Feature\Api\Talent;

use App\Constants\UserRole;
use App\Models\Talent;
use App\Models\User;
use Illuminate\Http\Response;
use Tests\Feature\Requests\Api\RetrieveTalentRequest;
use Tests\Feature\TestCase;

class RetrieveTalentTest extends TestCase
{

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('db:seed', ['--class' => 'ShieldSeeder']);

    }

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
            ->assertUnauthorized()
            ->assertStatus(Response::HTTP_UNAUTHORIZED);

    }

    /**
     * A user logged in can retrieve the talent with permissions
     *
     * @test
     * @return void
     */
    public function can_retrieve_talent_if_is_logged_with_permissions (): void
    {
        $talent = Talent::factory()->create();

        $request = RetrieveTalentRequest::make($talent);

        $user = User::factory()->create()
            ->assignRole(UserRole::ADMIN);

        $response = $this->signIn($user)
            ->sendRequestApiGetShow($request);

        $response->assertSuccessful();

        $response->assertStatus(Response::HTTP_OK);

        $data = $response->json('data');

        $this->assertEquals($data['id'], $talent->uuid);

        $this->assertDatabaseHas('talents', [
            'id' => $talent->id,
            'hand_preference' => $talent->hand_preference,
        ]);

    }

    /**
     * A user cannot retrieve the talent without permissions
     *
     * @test
     * @return void
     */
    public function cannot_retrieve_talent_without_permissions(): void
    {
        $talent = Talent::factory()->create();

        $request = RetrieveTalentRequest::make($talent);

        $user = User::factory()->create();

        $response = $this->signIn($user)
            ->sendRequestApiGetShow($request);

        $response->assertForbidden();

        $response->assertStatus(Response::HTTP_FORBIDDEN);

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

        $response->assertStatus(Response::HTTP_NOT_FOUND);

        $data = $response->json('errors');

        $response->assertStatus($data[0]["status"]);
    }

}
