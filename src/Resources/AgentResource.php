<?php

namespace BlueRockTEL\AteraClient\Resources;

use Saloon\Http\Response;
use BlueRockTEL\AteraClient\Entities\Agent;
use BlueRockTEL\AteraClient\Endpoints\Agents as Endpoints;

class AgentResource extends Resource
{
    public function index(
        array $query = [],
    ): Response {
        return $this->connector->send(
            new Endpoints\GetAgentsRequest(
                params: $query,
            )
        );
    }

    public function show(int $id): Response
    {
        return $this->connector->send(
            new Endpoints\GetAgentRequest($id)
        );
    }

    public function delete(int $id): Response
    {
        return $this->connector->send(
            new Endpoints\DeleteAgentRequest($id)
        );
    }
}