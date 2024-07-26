<?php

namespace Tests\Feature\Requests\Api;

use Tests\Feature\Requests\GetRequest;

class RetrieveTalentsRequest extends GetRequest
{

    /**
     * Create a new instance of the request.
     *
     * @param  array  $query
     * @param  array  $filters
     */
    public function __construct(protected array $query = [], protected array $filters = [])
    {
    }

    /**
     * Retrieve the endpoint of the request.
     *
     * @return string
     */
    public function endpoint(): string
    {
        return route('v1.api.talents.index');
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

    /**
     * Retrieve the query for request.
     *
     * @return string
     */
    public function getQuery(): array
    {
        return $this->query;
    }

    /**
     * Retrieve the query for request.
     *
     * @return string
     */
    public function getFilters(): array
    {
        return $this->filters;
    }
}
