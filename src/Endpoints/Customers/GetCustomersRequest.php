<?php

namespace BlueRockTEL\AteraClient\Endpoints\Customers;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use BlueRockTEL\AteraClient\EntityCollection;
use BlueRockTEL\AteraClient\Entities\Customer;
use Saloon\PaginationPlugin\Contracts\Paginatable;

class GetCustomersRequest extends Request implements Paginatable
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/v3/customers';
    }

    public function __construct(
        protected int $page = 1,
        protected int $perPage = 20,
        protected array $params = [],
    ) {
        //
    }

    protected function defaultQuery(): array
    {
        return [
            'page' => $this->page,
            'itemsInPage' => $this->perPage,
            ...$this->params,
        ];
    }

    public function createDtoFromResponse(Response $response): EntityCollection
    {
        return EntityCollection::fromResponse($response, Customer::class, 'items');
    }
}