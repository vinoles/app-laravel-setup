<?php

namespace Tests\Feature\Requests\Api;

use App\Models\Talent;
use Tests\Feature\Requests\GetRequest;

class RetrieveTalentRequest extends GetRequest
{

    /**
     * Create a new instance of the request.
     *
     * @param  Talent|null  $talent
     */
    public function __construct(protected  Talent|null $talent = null)
    {
        if($talent === null) {
            $this->talent = $talent = Talent::factory()->create();
        }
    }


    /**
     * Retrieve the endpoint of the request.
     *
     * @return string
     */
    public function endpoint(): string
    {
        return route('v1.api.talents.show', ['talent' => $this->talent]);
    }

}
