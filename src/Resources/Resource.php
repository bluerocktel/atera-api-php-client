<?php

namespace BlueRockTEL\AteraClient\Resources;

use BlueRockTEL\AteraClient\AteraConnector;

class Resource
{
    public function __construct(
        protected AteraConnector $connector
    ) {
        //
    }
}