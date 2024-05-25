<?php

namespace Tests\Feature\Requests\Auth;

use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Laravel\Fortify\RoutePath;
use Tests\Feature\Requests\PostRequest;

class SignUpRequest extends PostRequest
{
    /**
     * Create a new instance of the request.
     *
     * @param  User  $user
     */
    public function __construct(User $user = null)
    {
        if ($user !== null) {
            $this->fillPayload($user);
        }
    }

    /**
     * Retrieve the endpoint of the request.
     *
     * @return string
     */
    public function endpoint(): string
    {
        return RoutePath::for('register', '/register');
    }

    /**
     * Fill the payload of the request based on the given user.
     *
     * @param  User  $user
     * @return static
     */
    protected function fillPayload(User $user): static
    {
        $this->payload = array_filter(
            Arr::except($user->getAttributes(), 'uuid'),
            static fn ($value) => $value !== null
        );

        $password = Str::random(mt_rand(8, 31)).'!';

        $this->set('password', $password)
            ->set('password_confirmation', $password);

        return $this;
    }
}
