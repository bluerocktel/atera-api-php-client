<?php

namespace BlueRockTEL\AteraClient\Endpoints\Customers;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Illuminate\Support\Arr;
use Saloon\Http\Response;
use Saloon\Contracts\Body\HasBody;
use Saloon\Traits\Body\HasJsonBody;
use BlueRockTEL\AteraClient\Entities\Customer;

class CreateCustomerRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function resolveEndpoint(): string
    {
        return '/v3/customers';
    }

    public function __construct(
        protected Customer $customer,
    ) {
        //
    }

    protected function defaultBody(): array
    {
        return Arr::except(
            $this->customer->toArray(),
            ['CustomerID', 'CreatedOn', 'LastModified']
        );
    }

    public function createDtoFromResponse(Response $response): mixed
    {
        return Customer::fromResponse($response);
    }
}