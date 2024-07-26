<?php

namespace Tests\Feature\Api\Talent;

use App\Constants\UserRole;
use App\Models\Talent;
use App\Models\User;
use Tests\Feature\Requests\Api\RetrieveTalentsRequest;
use Tests\Feature\TestCase;

class RetrieveTalentsTest extends TestCase
{
    /**
     * Sets up the testing environment by calling the parent setUp method and seeding the database with initial data using ShieldSeeder.
     *
     * This ensures that every test starts with a consistent set of data, particularly focusing on the permissions and roles setup required by the application.
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('db:seed', ['--class' => 'ShieldSeeder']);
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
            ->sendRequestApiGetList($request)
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

        $user = User::factory()->create()
            ->assignRole(UserRole::ADMIN);

        $response = $this->signIn($user)
            ->sendRequestApiGetList($request);

        $response->assertSuccessful();

        $this->assertEquals(count($response->json('data')), count($talents));

        foreach ($talents as $talent) {

            $this->assertDatabaseHas('talents', [
                'id' => $talent->id,
                'hand_preference' => $talent->hand_preference,
            ]);
        }
    }

    /**
     * A user logged in can retrieve the talents paged
     *
     * @test
     * @return void
     */
    public function can_retrieve_talents_if_is_logged_paged(): void
    {
        $talents = Talent::factory()->count(random_int(10, 100))->create();

        $page = random_int(1, 10);

        $size = random_int(5, 10);

        $total = $talents->count();

        $pages = ceil($total / $size);

        $queryPage = ['page' => ['number' => $page, 'size' => $size]];

        $request = RetrieveTalentsRequest::make($queryPage);

        $user = User::factory()->create()
            ->assignRole(UserRole::ADMIN);

        $response = $this->signIn($user)
            ->sendRequestApiGetList($request);

        $response->assertSuccessful();

        $links = $response->json('links');

        $pageMetaInformation = $response->json('meta.page');

        $this->assertEquals($page, $pageMetaInformation['currentPage']);
        $this->assertEquals($total, $pageMetaInformation['total']);
        $this->assertEquals($size, $pageMetaInformation['perPage']);
        $this->assertEquals($pages, $pageMetaInformation['lastPage']);

        $this->assertIsArray($links);
    }


    //TODO DEJARLO COMO EJEMPLO PARA FUTUROS TEST Y LUEGO BORRARLO
    // /**
    //  * A user logged in can retrieve the talents filtered by firs_name
    //  *
    //  * @test
    //  * @return void
    //  */
    // public function can_retrieve_talents_if_is_logged_in_filtered_by_first_name(): void
    // {
    //     $firstName = fake()->firstName() . '1';

    //     $talent = Talent::factory()->withFirstName($firstName)->create();

    //     $talents = Talent::factory()->count(random_int(10, 100))->create();

    //     $page = 1;

    //     $size = random_int(5, 10);

    //     $filter = ['first_name' => $firstName];

    //     $listFiltered = $talents
    //         ->push($talent)->where('first_name', $firstName);

    //     $total = $listFiltered->count();

    //     $pages = ceil($total / $size);

    //     $queryPage = ['page' => ['number' => $page, 'size' => $size]];

    //     $request = RetrieveTalentsRequest::make($queryPage, $filter);

    //     $user = User::factory()->create()
    //         ->assignRole(UserRole::ADMIN);

    //     $response = $this->signIn($user)
    //         ->sendRequestApiGetList($request);

    //     $response->assertSuccessful();

    //     $links = $response->json('links');

    //     $pageMetaInformation = $response->json('meta.page');

    //     $this->assertEquals($page, $pageMetaInformation['currentPage']);
    //     $this->assertEquals($total, $pageMetaInformation['total']);
    //     $this->assertEquals($size, $pageMetaInformation['perPage']);
    //     $this->assertEquals($pages, $pageMetaInformation['lastPage']);

    //     $this->assertIsArray($links);
    // }
}
