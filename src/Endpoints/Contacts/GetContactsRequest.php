<?php

namespace BlueRockTEL\AteraClient\Endpoints\Contacts;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use BlueRockTEL\AteraClient\Entities\Contact;
use BlueRockTEL\AteraClient\EntityCollection;

class GetContactsRequest extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/v3/contacts';
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
        return EntityCollection::fromResponse($response, Contact::class, 'items');
    }
}