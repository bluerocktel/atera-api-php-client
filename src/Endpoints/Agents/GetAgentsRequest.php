<?php

namespace BlueRockTEL\AteraClient\Endpoints\Agents;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use BlueRockTEL\AteraClient\Entities\Agent;
use BlueRockTEL\AteraClient\EntityCollection;

class GetAgentsRequest extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/v3/agents';
    }

    public function __construct(
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

    public function createDtoFromResponse(Response $response): EntityCollection
    {
        return EntityCollection::fromResponse($response, Agent::class, 'items');
    }
}