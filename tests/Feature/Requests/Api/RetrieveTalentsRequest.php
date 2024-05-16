<?php

namespace Tests\Feature\Requests\Api;

use Tests\Feature\Requests\GetRequest;

class RetrieveTalentsRequest extends GetRequest
{
    /**
     * Retrieve the endpoint of the request.
     *
     * @return string
     */
    public function endpoint(): string
    {
        return route('api.talents.index');
    }

    /**
     * Retrieve the endpoint of the request.
     *
     * @return string
     */
    public function expects(): string
    {
        return 'talents';
    }
}
