<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Tests\Feature\Requests\Auth\SignInRequest;
use Tests\Feature\TestCase;

class SignInTest extends TestCase
{
    /**
     * A user can sign in with the correct credentials.
     *
     * @test
     * @return void
     */
    public function can_sign_in_with_the_correct_email_and_password(): void
    {
        $user = User::factory()->withPassword()->create();

        $response = $this->sendRequest($user->email, 'password');

        $response->assertSuccessful();

        $this->assertAuthenticatedAs($user);
    }

    /**
     * A user cannot sign in with the wrong login credentials.
     *
     * @test
     * @return void
     */
    public function cannot_sign_in_with_the_wrong_credentials(): void
    {
        $user = User::factory()->create();

        $request = SignInRequest::make($user->email, 'wrong-password');

        $response = $this->sendRequest($request);

        $response->assertUnprocessable();

        $response->assertJsonPath('message', trans('auth.failed'));

        $this->assertGuest();
    }
}
