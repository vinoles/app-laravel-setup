<?php

namespace Tests\Feature\Concerns;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Testing\TestResponse;
use Tests\Feature\Requests\Request;

trait SendsRequests
{
    /**
     * Detect the request class name from the test case.
     *
     * @return string
     */
    protected function detectRequestClass(): string
    {
        return Str::of(get_called_class())
            ->replaceLast('Test', 'Request')
            ->replaceLast('Feature\\', 'Feature\Requests\\');
    }

    /**
     * Create a new request instance.
     *
     * @param  mixed  $args
     * @return \Tests\Feature\Requests\Request
     */
    protected function newRequest(...$args): Request
    {
        $request = $this->detectRequestClass();

        if (empty($args)) {
            return resolve($request);
        }

        return $request::make(...$args);
    }

    /**
     * Send a request to the server.
     *
     * @param  mixed  $args
     * @return \Illuminate\Testing\TestResponse
     */
    protected function sendRequest(...$args): TestResponse
    {
        $request = Arr::get($args, 0);

        if (! $request instanceof Request) {
            $request = $this->newRequest(...$args);
        }

        return  $this->json(
            $request->method(),
            $request->endpoint(),
            $request->payload(),
        );
    }

    /**
     * Send a request to the server.
     *
     * @param  mixed  $args
     * @return \Illuminate\Testing\TestResponse
     */
    protected function sendRequestApiGetList(...$args): TestResponse
    {
        $request = Arr::get($args, 0);

        return $this->jsonApi()
            ->expects($request->expects())
            ->query($request->getQuery())
            ->filter($request->getFilters())
            ->get($request->endpoint());
      //  ->withData($request->payload());
    }


    /**
     * Send a request to the server.
     *
     * @param  mixed  $args
     * @return \Illuminate\Testing\TestResponse
     */
    protected function sendRequestApiGetShow(...$args): TestResponse
    {
        $request = Arr::get($args, 0);

        return $this->jsonApi()
            ->get($request->endpoint());
    }
}
