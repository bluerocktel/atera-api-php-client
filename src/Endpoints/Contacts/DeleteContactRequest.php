<?php

namespace BlueRockTEL\AteraClient\Endpoints\Contacts;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Contracts\Body\HasBody;
use Saloon\Traits\Body\HasJsonBody;

class DeleteContactRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::DELETE;

    public function resolveEndpoint(): string
    {
        return '/v3/contacts/' . $this->id;
    }

    public function __construct(
        protected int $id,
    ) {
        //
    }
}