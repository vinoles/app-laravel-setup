<?php

namespace App\JsonApi\V1\Talents;

use App\Constants\HandPreference;
use Illuminate\Validation\Rule;
use LaravelJsonApi\Laravel\Http\Requests\ResourceRequest;

class TalentRequest extends ResourceRequest
{
    /**
     * Get the validation rules for the resource.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'hand_preference' => ['required', 'string', Rule::enum(HandPreference::class)],
        ];
    }
}
