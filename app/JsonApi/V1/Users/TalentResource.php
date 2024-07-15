<?php

namespace App\JsonApi\V1\Talents;

use App\Models\Talent;
use Illuminate\Http\Request;
use LaravelJsonApi\Core\Resources\JsonApiResource;

/**
 * @property Talent $resource
 */
class TalentResource extends JsonApiResource
{
    /**
     * Get the resource's attributes.
     *
     * @param Request|null $request
     * @return iterable
     */
    public function attributes($request): iterable
    {
        return [
            'id' => $this->uuid,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'phone' => $this->phone,
            'address' => $this->address,
            'city' => $this->city,
            'province' => $this->province,
            'birthdate' => $this->birthdate,
        ];
    }

    /**
     * @return array
     */
    public function deleteRules(): array
    {
        return [];
    }

    /**
     * @return array
     */
    public function deleteMessages(): array
    {
        return [];
    }

    /**
     * @param Talent $talent
     * @return array
     */
    public function metaForDelete(Talent $talent): array
    {
        return [];
    }

    /**
     * Get the resource's relationships.
     *
     * @param Request|null $request
     * @return iterable
     */
    public function relationships($request): iterable
    {
        return [
            $this->relation('talent'),
        ];
    }
}
