<?php

namespace BlueRockTEL\AteraClient;

use Saloon\Http\Request;
use Saloon\Http\Connector;
use Saloon\Http\Response;
use Saloon\RateLimitPlugin\Limit;
use Saloon\RateLimitPlugin\Stores\MemoryStore;
use Saloon\RateLimitPlugin\Traits\HasRateLimits;
use Saloon\RateLimitPlugin\Contracts\RateLimitStore;
use Saloon\PaginationPlugin\PagedPaginator;
use Saloon\PaginationPlugin\Contracts\HasPagination;

class AteraConnector extends Connector implements HasPagination
{
    use HasRateLimits;

    public function __construct(
        #[\SensitiveParameter]
        protected string $apiToken,
        protected string $apiUrl = 'https://app.atera.com/api',
    ) {
    }

    public function resolveBaseUrl(): string
    {
        return $this->apiUrl;
    }

    protected function defaultHeaders(): array
    {
        return [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'X-API-KEY' => $this->apiToken,
        ];
    }

    protected function defaultQuery(): array
    {
        return [];
    }

    public function defaultConfig(): array
    {
        return [
            'timeout' => 60,
        ];
    }

    protected function resolveLimits(): array
    {
        return [
            Limit::allow(requests: 2000, threshold: 0.9)->everyMinute()->sleep(),
        ];
    }

    protected function resolveRateLimitStore(): RateLimitStore
    {
        return new MemoryStore;
    }

    public function paginate(Request $request): PagedPaginator
    {
        return new class(connector: $this, request: $request) extends PagedPaginator
        {
            protected ?int $perPageLimit = 20;

            protected function isLastPage(Response $response): bool
            {
                return $response->json('totalPages')
                    && $response->json('totalPages') === $response->json('page');
            }

            protected function getPageItems(Response $response, Request $request): array
            {
                return $request->createDtoFromResponse($response->json('items'));
            }
        };
    }

    public function agent(): Resources\AgentResource
    {
        return new Resources\AgentResource($this);
    }

    public function customer(): Resources\CustomerResource
    {
        return new Resources\CustomerResource($this);
    }

    public function contact(): Resources\ContactResource
    {
        return new Resources\ContactResource($this);
    }
}