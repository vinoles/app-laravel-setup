<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Constants\UserRole;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Jobs\CreateTalentAfterRegister;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use LaravelJsonApi\Core\Responses\DataResponse;

class RegisterController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  RegisterRequest  $request
     * @return DataResponse
     */
    public function __invoke(RegisterRequest $request): DataResponse
    {
        $attributes = $request->validated();

        $role = Arr::pull($attributes, 'role');

        $user = User::create(
            array_merge(
                ['uuid' => Str::uuid()],
                $attributes
            )
        )->assignRole($role);

        if ($role === UserRole::TALENT->value) {
            CreateTalentAfterRegister::dispatch($user);
        }

        $token = $user->createToken('Device')->plainTextToken;

        return DataResponse::make($user)
            ->withMeta(['token' => $token]);
    }
}
