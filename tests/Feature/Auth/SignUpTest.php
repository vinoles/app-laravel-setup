<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Tests\Feature\Api\TestCase;
use Tests\Feature\Requests\Auth\SignUpRequest;

class SignUpTest extends TestCase
{
    /**
     * A user logged in can retrieve the talents
     *
     * @test
     * @return void
     */
    public function can_make_sign_up(): void
    {
        $user = User::factory()->make();

        $request = SignUpRequest::make($user);

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
