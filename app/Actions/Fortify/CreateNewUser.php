<?php

namespace App\Actions\Fortify;

use App\Constants\UserRole;
use App\Jobs\CreateTalentAfterRegister;
use App\Models\User;
use Illuminate\Support\Arr;
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

        $role = Arr::pull($attributes, 'role');

        $user =  User::create(
            array_merge(
                ['uuid' => Str::uuid()],
                $attributes
            )
        )->assignRole($role);

        if($role === UserRole::TALENT->value) {
            CreateTalentAfterRegister::dispatch($user);
        }

        return $user;


    }

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
