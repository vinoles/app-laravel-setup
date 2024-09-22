<?php

namespace Tests\Feature\Auth;

use App\Constants\UserRole;
use App\Models\User;
use Illuminate\Support\Facades\Queue;
use Tests\Feature\Requests\Api\CreateUserRequest;
use Tests\Feature\TestCase;

class CreateUserTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Queue::fake();

        $this->artisan('db:seed', ['--class' => 'ShieldSeeder']);
    }

    /**
    * A user not logged in cannot create the user
    *
    * @test
    * @return void
    */
    public function cannot_create_user_if_not_logged_in(): void
    {
        $request = CreateUserRequest::make();

        $this->signIn(null)
            ->sendRequestApiPost($request)
            ->assertUnauthorized();
    }

    /**
     * Create user happy path
     *
     * @test
     * @return void
     */
    public function create_user_happy_path(): void
    {
        $user = User::factory()->make();

        $request = CreateUserRequest::make($user);

        $authUser = User::factory()->create()
            ->assignRole(UserRole::ADMIN);

        $response = $this->signIn($authUser)
            ->sendRequestApiPost($request);

        $response->assertSuccessful();

        $this->assertDatabaseHas('users', [
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'address' => $user->address,
            'city' => $user->city,
            'country' => $user->country,
            'postal_code' => $user->postal_code,
            'phone' => $user->phone,
        ]);
    }

    /**
     * Cannot create user if without the required data.
     *
     * @test
     * @return void
     */
    public function cannot_create_user_if_without_the_required_data(): void
    {
        $user = User::factory()->create();

        $request = CreateUserRequest::make()
            ->fillPayloadAndRemoveAttribute(
                $user,
                [
                    'email',
                    'first_name',
                    'last_name',
                    'birthdate',
                ]
            );

        $authUser = User::factory()->create()
                ->assignRole(UserRole::ADMIN);

        $response = $this->signIn($authUser)
            ->sendRequestApiPost($request);

        $response->assertUnprocessable();

        $errors = collect($response->json('errors'))->pluck('detail')->all();

        $this->assertContainsEquals(
            trans('validation.required', ['attribute' => 'first name']),
            $errors
        );

        $this->assertContainsEquals(
            trans('validation.required', ['attribute' => 'last name']),
            $errors
        );

        $this->assertContainsEquals(
            trans('validation.required', ['attribute' => 'email']),
            $errors
        );

        $this->assertContainsEquals(
            trans('validation.required', ['attribute' => 'birthdate']),
            $errors
        );
    }
}
