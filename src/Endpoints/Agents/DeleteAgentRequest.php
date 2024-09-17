<?php

namespace BlueRockTEL\AteraClient\Endpoints\Agents;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Contracts\Body\HasBody;
use Saloon\Traits\Body\HasJsonBody;

class DeleteAgentRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::DELETE;

    public function resolveEndpoint(): string
    {
        return '/v3/agents/' . $this->id;
    }

    public function __construct(
        protected int $id,
    ) {
        //
    }
}