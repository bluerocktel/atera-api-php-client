<?php

namespace BlueRockTEL\AteraClient\Endpoints\Customers;

use BlueRockTEL\AteraClient\Entities\Customer;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetCustomerRequest extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/v3/customers/' . $this->id;
    }

    public function __construct(
        protected int $id,
    ) {
        //
    }

    public function createDtoFromResponse(Response $response): mixed
    {
        return Customer::fromResponse($response);
    }
}