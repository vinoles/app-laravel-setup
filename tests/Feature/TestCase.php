<?php

namespace Tests\Feature;

use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Tests\Feature\Concerns\CreatesUsers;
use Tests\Feature\Concerns\SendsRequests;
use Tests\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    use CreatesUsers, SendsRequests;

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('db:seed', ['--class' => 'ShieldSeeder']);
    }

    /**
     * The authenticated user.
     *
     * @var \App\Models\User
     */
    protected $user;

    /**
     * Simulate the request from the user's perspective.
     *
     * @param  \App\Models\User|null  $user
     * @param  array|null  $scopes
     * @return static
     */
    protected function signIn(User $user = null, $scopes = []): static
    {
        $this->user = $user;

        if($user !== null) {
            Sanctum::actingAs($this->user, $scopes);
        }

        return $this;
    }
}
