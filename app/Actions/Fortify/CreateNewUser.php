<?php

namespace App\Actions\Fortify;

use App\Constants\UserRole;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        $attributes = Validator::make($input, $this->rules())->validate();

        return User::create(
            array_merge(
                ['uuid' => Str::uuid()],
                $attributes
            )
        );
    }

    public function rules(): array
    {
        $allowedBirthdate = now()
            ->subYears(config('dogme.minimum_age'))->format('Y-m-d');

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
            'city' => ['required', 'string', 'max:50'],
            'country' => ['required', 'string', 'max:50'],
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
