<?php

namespace BlueRockTEL\AteraClient\Endpoints\Customers;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Contracts\Body\HasBody;
use Saloon\Traits\Body\HasJsonBody;

class DeleteCustomerRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::DELETE;

    public function resolveEndpoint(): string
    {
        return '/v3/customers/' . $this->id;
    }

    public function __construct(
        protected int $id,
    ) {
        //
    }
}