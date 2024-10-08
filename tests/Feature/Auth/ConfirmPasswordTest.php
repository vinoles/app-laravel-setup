<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Http\Response;
use Tests\Feature\Requests\Auth\ConfirmPasswordRequest;
use Tests\Feature\TestCase;

class ConfirmPasswordTest extends TestCase
{
    /**
     * A user can confirm password with the correct password.
     *
     * @test
     * @return void
     */
    public function can_confirm_password_with_the_correct_password(): void
    {
        $user = User::factory()->withPassword()->create();

        $request = ConfirmPasswordRequest::make($user, 'password');

        $response = $this->signIn($user)->sendRequestApiPostWithPayload($request);

        $response->assertSuccessful();

        $data = $response->json('meta');

        $this->assertTrue($data["status"]);

    }

    /**
     * A user cannot confirm password with the incorrect password.
     *
     * @test
     * @return void
     */
    public function cannot_confirm_password_with_the_incorrect_password(): void
    {
        $user = User::factory()->withPassword()->create();

        $request = ConfirmPasswordRequest::make($user, 'error_password');

        $response = $this->signIn($user)->sendRequestApiPostWithPayload($request);

        $response->assertSuccessful();

        $data = $response->json('meta');

        $this->assertFalse($data["status"]);

    }

    /**
     * A user cannot confirm password another user
     *
     * @test
     * @return void
     */
    public function cannot_confirm_password_another_user(): void
    {
        $user = User::factory()->withPassword()->create();

        $otherUser = User::factory()->withPassword()->create();

        $request = ConfirmPasswordRequest::make($otherUser, 'error_password');

        $response = $this->signIn($user)->sendRequestApiPostWithPayload($request);

        $response->assertForbidden();

        $response->assertStatus(Response::HTTP_FORBIDDEN);

    }
}
