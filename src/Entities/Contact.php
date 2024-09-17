<?php

namespace BlueRockTEL\AteraClient\Entities;

use Carbon\Carbon;
use BlueRockTEL\AteraClient\Entities\Entity;

class Contact extends Entity
{
    public function __construct(
        readonly public ?int $EndUserID = null,
        readonly public ?int $CustomerID = null,
        readonly public ?string $Email = null,
        readonly public ?string $CustomerName = null,
        readonly public ?string $Firstname = null,
        readonly public ?string $Lastname = null,
        readonly public ?string $JobTitle = null,
        readonly public ?string $Phone = null,
        readonly public ?string $MobilePhone = null,
        readonly public ?bool $IsContactPerson = null,
        readonly public ?bool $InIgnoreMode = null,
        readonly public ?Carbon $CreatedOn = null,
        readonly public ?Carbon $LastModified = null,
    ) {
        //
    }
}