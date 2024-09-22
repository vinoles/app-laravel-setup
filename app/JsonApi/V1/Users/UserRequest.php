<?php

namespace App\JsonApi\V1\Users;

use App\Constants\UserRole;
use Illuminate\Validation\Rule;
use LaravelJsonApi\Laravel\Http\Requests\ResourceRequest;

class UserRequest extends ResourceRequest
{
    /**
     * Get the validation rules for the resource.
     *
     * @return array
     */
    public function rules(): array
    {

        $allowedBirthdate = now()
                    ->subYears(config('app_laravel_setup.minimum_age'))->format('Y-m-d');

        return [
            'email' => [
                'bail',
                'required',
                'string',
                'email',
                'unique:users',
            ],
            'first_name' => ['required', 'max:50'],
            'last_name' => ['required', 'max:50'],
            'phone' => ['required', 'string', 'min:10', 'max:20'],
            'address' => ['required', 'string', 'max:150'],
            'city' => ['required', 'string', 'max:100'],
            'country' => ['required', 'string', 'max:100'],
            'postal_code' => ['nullable', 'string', 'max:25'],
            'birthdate' => [
                'required',
                'date',
                "before_or_equal:{$allowedBirthdate}",
            ],
            'role' => ['required', 'string', Rule::enum(UserRole::class)],
            'password' => $this->passwordRules(),
        ];

    }

}
