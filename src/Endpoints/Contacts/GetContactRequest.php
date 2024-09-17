<?php

namespace BlueRockTEL\AteraClient\Endpoints\Contacts;

use BlueRockTEL\AteraClient\Entities\Contact;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetContactRequest extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/v3/contacts/' . $this->id;
    }

    public function __construct(
        protected int $id,
    ) {
        //
    }

    public function createDtoFromResponse(Response $response): mixed
    {
        return Contact::fromResponse($response);
    }
}