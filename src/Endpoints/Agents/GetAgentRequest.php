<?php

namespace BlueRockTEL\AteraClient\Endpoints\Agents;

use BlueRockTEL\AteraClient\Entities\Agent;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetAgentRequest extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/v3/agents/' . $this->id;
    }

    public function __construct(
        protected int $id,
    ) {
        //
    }

    public function createDtoFromResponse(Response $response): mixed
    {
        return Agent::fromResponse($response);
    }
}