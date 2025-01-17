<?php

namespace BlueRockTEL\AteraClient\Entities;

use Saloon\Http\Response;
use Saloon\Traits\Responses\HasResponse;
use Saloon\Contracts\DataObjects\WithResponse;
use BlueRockTEL\AteraClient\Entities\Concerns\CastArrayValues;
use BlueRockTEL\AteraClient\Contracts\Entity as EntityContract;
use BlueRockTEL\AteraClient\Entities\Concerns\CreatesFromArray;
use Illuminate\Support\Collection;

abstract class Entity implements EntityContract, WithResponse
{
    use HasResponse;
    use CreatesFromArray;
    use CastArrayValues;

    public static function fromResponse(Response $response, null|string|int $path = null): static
    {
        return static::fromArray(
            (array) $response->json($path)
        );
    }

    public static function fromArray(array $data): static
    {
        static::castArrayValues($data, static::getCastAttributes());

        return static::createFromArray($data);
    }

    public function toArray(bool $filter = false): array
    {
        $data = get_object_vars($this);

        return $filter
            ? array_filter($data, fn ($i) => $i !== null)
            : $data;
    }

    public function toCollection(bool $filter = false): Collection
    {
        return new Collection(
            $this->toArray($filter)
        );
    }
}