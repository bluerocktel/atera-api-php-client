<?php

namespace BlueRockTEL\AteraClient\Endpoints\Contacts;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Illuminate\Support\Arr;
use Saloon\Http\Response;
use Saloon\Contracts\Body\HasBody;
use Saloon\Traits\Body\HasJsonBody;
use BlueRockTEL\AteraClient\Entities\Contact;

class CreateContactRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function resolveEndpoint(): string
    {
        return '/v3/contacts';
    }

    public function __construct(
        protected Contact $contact,
        protected array $params = [],
    ) {
        //
    }

    protected function defaultQuery(): array
    {
        return [
            ...$this->params,
        ];
    }

    protected function defaultBody(): array
    {
        return Arr::except(
            $this->contact->toArray(),
            ['EndUserID', 'CreatedOn', 'LastModified']
        );
    }

    public function createDtoFromResponse(Response $response): mixed
    {
        return Contact::fromResponse($response);
    }
}