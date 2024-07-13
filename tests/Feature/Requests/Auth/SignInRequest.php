<?php

namespace Tests\Feature\Requests\Auth;

use Laravel\Fortify\RoutePath;
use Tests\Feature\Requests\PostRequest;

class SignInRequest extends PostRequest
{
    /**
     * Create a new request instance.
     */
    public function __construct(string $email, string $password)
    {
        $this->with([
            'email' => $email,
            'password' => $password,
        ]);
    }

    /**
     * Retrieve the endpoint of the request.
     *
     * @return string
     */
    public function endpoint(): string
    {
        $prefix = config('dogme.prefix_api');

        return RoutePath::for('login', "{$prefix}/login");
    }
}
