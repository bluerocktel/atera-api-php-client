<?php

namespace BlueRockTEL\AteraClient\Entities;

use Carbon\Carbon;
use BlueRockTEL\AteraClient\Entities\Entity;

class Agent extends Entity
{
    /**
     * The attributes that should be cast when created from an array.
     *
     * @var array
     */
    protected static $arrayCast = [
        'Created' => 'datetime',
        'Modified' => 'datetime',
        'LastPatchManagementReceived' => 'datetime',
        'BiosReleaseDate' => 'datetime',
        'LastRebootTime' => 'datetime',
    ];

    public function __construct(
        readonly public ?int $AgentID = null,
        readonly public ?int $MachineID = null,
        readonly public ?string $DeviceGuid = null,
        readonly public ?int $FolderID = null,
        readonly public ?int $CustomerID = null,
        readonly public ?string $CustomerName = null,
        readonly public ?string $AgentName = null,
        readonly public ?string $SystemName = null,
        readonly public ?string $MachineName = null,
        readonly public ?string $DomainName = null,
        readonly public ?string $CurrentLoggedUsers = null,
        readonly public ?string $ComputerDescription = null,
        readonly public ?bool $Monitored = null,
        readonly public ?Carbon $LastPatchManagementReceived = null,
        readonly public ?string $AgentVersion = null,
        readonly public ?bool $Favorite = null,
        readonly public ?int $ThresholdID = null,
        readonly public ?int $MonitoredAgentID = null,
        readonly public ?bool $Online = null,
        readonly public ?string $ReportedFromIP = null,
        readonly public ?string $AppViewUrl = null,
        readonly public ?string $Motherboard = null,
        readonly public ?string $Processor = null,
        readonly public ?int $Memory = null,
        readonly public ?string $Display = null,
        readonly public ?string $Sound = null,
        readonly public ?int $ProcessorCoresCount = null,
        readonly public ?string $SystemDrive = null,
        readonly public ?string $ProcessorClock = null,
        readonly public ?string $Vendor = null,
        readonly public ?string $VendorSerialNumber = null,
        readonly public ?string $VendorBrandModel = null,
        readonly public ?string $ProductName = null,
        readonly public ?string $BiosManufacturer = null,
        readonly public ?string $BiosVersion = null,
        readonly public ?Carbon $BiosReleaseDate = null,
        readonly public ?array $MacAddresses = null,
        readonly public ?array $IpAddresses = null,
        readonly public ?array $HardwareDisks = null,
        readonly public ?array $BatteryInfo = null,
        readonly public ?string $OS = null,
        readonly public ?string $OSType = null,
        readonly public ?string $WindowsSerialNumber = null,
        readonly public ?string $Office = null,
        readonly public ?string $OfficeSP = null,
        readonly public ?string $OfficeOEM = null,
        readonly public ?string $OfficeSerialNumber = null,
        readonly public null|int|float $OSNum = null,
        readonly public ?Carbon $LastRebootTime = null,
        readonly public ?string $OSVersion = null,
        readonly public ?string $OSBuild = null,
        readonly public ?string $OfficeFullVersion = null,
        readonly public ?string $LastLoginUser = null,
        readonly public ?Carbon $Created = null,
        readonly public ?Carbon $Modified = null,
    ) {
        //
    }
}