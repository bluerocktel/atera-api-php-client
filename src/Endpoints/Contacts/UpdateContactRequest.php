<?php

namespace BlueRockTEL\AteraClient\Endpoints\Contacts;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Illuminate\Support\Arr;
use Saloon\Http\Response;
use BlueRockTEL\AteraClient\Entities\Contact;
use Saloon\Contracts\Body\HasBody;
use Saloon\Traits\Body\HasJsonBody;
use BlueRockTEL\AteraClient\Exceptions\EntityIdMissingException;

class UpdateContactRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::PUT;

    public function resolveEndpoint(): string
    {
        return '/v3/contacts/' . $this->contact->EndUserID;
    }

    public function __construct(
        protected Contact $contact,
    ) {
        if (!$this->contact->EndUserID) {
            throw new EntityIdMissingException('Entity must have an ID to be updated.');
        }
    }

    protected function defaultBody(): array
    {
        return Arr::except(
            $this->contact->toArray(filter: true),
            ['EndUserID', 'CreatedOn', 'LastModified']
        );
    }

    public function createDtoFromResponse(Response $response): mixed
    {
        return Contact::fromResponse($response);
    }
}