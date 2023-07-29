<?php

namespace App\Tests\Factory;

use App\Domain\Model\Manufacturer;

class ManufacturerFactory
{
    public const MANUFACTURER_UUID = '9287fba8-2103-44d7-b028-b54f14d5c224';

    public static function create(): Manufacturer
    {
        return new Manufacturer(
            self::MANUFACTURER_UUID,
            'Fairphone',
        );
    }
}
