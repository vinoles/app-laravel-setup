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
            'talental_code' => $this->talental_code,
            'birthdate' => $this->birthdate,
            'hand_preference' => $this->hand_preference,
        ];
    }

    /**
     * @return array
     */
    public function deleteRules(): array
    {
        return [
            'meta.no_posts' => 'accepted',
        ];
    }

    /**
     * @return array
     */
    public function deleteMessages(): array
    {
        return [
            'meta.no_posts.accepted' =>
              'You cannot delete a talent with posts.',
        ];
    }

    /**
     * @param Talent $talent
     * @return array
     */
    public function metaForDelete(Talent $talent): array
    {
        return [
            'no_posts' => $talent->posts()->doesntExist(),
        ];
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
            $this->relation('posts'),
        ];
    }
}
