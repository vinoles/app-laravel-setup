<?php

namespace Tests\Feature\Api;

use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Tests\Feature\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{

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
