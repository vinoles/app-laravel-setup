<?php

namespace Tests\Feature;

use Tests\Feature\Concerns\CreatesUsers;
use Tests\Feature\Concerns\SendsRequests;
use Tests\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    use CreatesUsers, SendsRequests;

    /**
     * The authenticated user.
     *
     * @var \App\Models\User
     */
    protected $user;
}
