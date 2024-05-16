<?php

namespace Tests\Feature\Api\Talent;

use App\Models\Talent;
use App\Models\User;
use Tests\Feature\Api\TestCase;
use Tests\Feature\Requests\Api\RetrieveTalentsRequest;

class RetrieveTalentsTest extends TestCase
{

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

        $user = User::factory()->create();

        $response = $this->signIn($user)
            ->sendRequestApiGetList($request);

        $response->assertSuccessful();

        $this->assertEquals(count($response->json('data')), count($talents));

        foreach ($talents as $talent) {

            $this->assertDatabaseHas('talents', [
                'id' => $talent->id,
                'first_name' => $talent->first_name,
                'last_name' => $talent->last_name,
                'address' => $talent->address,
                'city' => $talent->city,
                'province' => $talent->province,
                'postal_code' => $talent->postal_code,
                'phone' => $talent->phone,
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

        $user = User::factory()->create();

        $response = $this->signIn($user)
            ->sendRequestApiGetList($request);

        $response->assertSuccessful();

        $links = $response->json('links');

        $pageMetaInformation = $response->json('meta.page');

        $this->assertEquals($page, $pageMetaInformation['currentPage']);
        $this->assertEquals($total, $pageMetaInformation['total']);
        $this->assertEquals($size, $pageMetaInformation['perPage']);
        $this->assertEquals($pages , $pageMetaInformation['lastPage']);

        $this->assertIsArray($links);

    }


    /**
     * A user logged in can retrieve the talents filtered by firs_name
     *
     * @test
     * @return void
     */
    public function can_retrieve_talents_if_is_logged_in_filtered_by_first_name(): void
    {
        $firstName = fake()->firstName(). '1' ;

        $talent = Talent::factory()->withFirstName($firstName)->create();

        $talents = Talent::factory()->count(random_int(10, 100))->create();

        $page = 1;

        $size = random_int(5, 10);

        $filter = ['first_name' => $firstName];

        $listFiltered = $talents
            ->push($talent)->where('first_name', $firstName);

        $total = $listFiltered->count();

        $pages = ceil($total / $size);

        $queryPage = ['page' => ['number' => $page, 'size' => $size]];

        $request = RetrieveTalentsRequest::make($queryPage, $filter);

        $user = User::factory()->create();

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

}
