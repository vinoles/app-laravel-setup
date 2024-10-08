<?php

namespace Tests\Feature\Auth;

use App\Constants\UserRole;
use App\Models\User;
use Illuminate\Support\Facades\Queue;
use Tests\Feature\Requests\Auth\RegisterRequest;
use Tests\Feature\TestCase;

class RegisterTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Queue::fake();

        $this->artisan('db:seed', ['--class' => 'ShieldSeeder']);
    }

    /**
     * Sign up happy path
     *
     * @test
     * @return void
     */
    public function sign_up_happy_path(): void
    {
        $user = User::factory()->make();

        $request = RegisterRequest::make($user);

        $response = $this->sendRequest($request);

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
     * Sign up and create user profile
     *
     * @test
     * @return void
     */
    public function sign_up_and_create_user_profile(): void
    {
        $user = User::factory()->make();

        $request = RegisterRequest::make($user)->setRole(UserRole::USER);

        $response = $this->sendRequest($request);

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
}
