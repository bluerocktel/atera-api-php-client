<?php

namespace BlueRockTEL\AteraClient\Endpoints\Customers;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Illuminate\Support\Arr;
use Saloon\Http\Response;
use Saloon\Contracts\Body\HasBody;
use Saloon\Traits\Body\HasJsonBody;
use BlueRockTEL\AteraClient\Entities\Customer;
use BlueRockTEL\AteraClient\Exceptions\EntityIdMissingException;

class UpdateCustomerRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::PUT;

    public function resolveEndpoint(): string
    {
        return '/v3/customers/' . $this->customer->CustomerID;
    }

    public function __construct(
        protected Customer $customer,
    ) {
        if (!$this->customer->CustomerID) {
            throw new EntityIdMissingException('Entity must have an ID to be updated.');
        }
    }

    protected function defaultBody(): array
    {
        return Arr::except(
            $this->customer->toArray(filter: true),
            ['CustomerID', 'CreatedOn', 'LastModified']
        );
    }

    public function createDtoFromResponse(Response $response): mixed
    {
        return Customer::fromResponse($response);
    }
}