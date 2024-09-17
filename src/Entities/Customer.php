<?php

namespace BlueRockTEL\AteraClient\Entities;

use Carbon\Carbon;
use BlueRockTEL\AteraClient\Entities\Entity;

class Customer extends Entity
{
    public function __construct(
        readonly public ?int $CustomerID = null,
        readonly public ?string $CustomerName = null,
        readonly public ?string $BusinessNumber = null,
        readonly public ?string $Domain = null,
        readonly public ?string $Address = null,
        readonly public ?string $City = null,
        readonly public ?string $State = null,
        readonly public ?string $Country = null,
        readonly public ?string $Phone = null,
        readonly public ?string $Fax = null,
        readonly public ?string $Notes = null,
        readonly public ?string $Logo = null,
        readonly public ?string $Links = null,
        readonly public ?float $Longitude = null,
        readonly public ?float $Latitude = null,
        readonly public ?string $ZipCodeStr = null,
        readonly public ?Carbon $CreatedOn = null,
        readonly public ?Carbon $LastModified = null,
    ) {
        //
    }
}