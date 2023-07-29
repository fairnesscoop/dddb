<?php

namespace App\Tests\Factory;

use App\Domain\Model\Serie;

class SerieFactory
{
    public const SERIE_UUID = 'a5bdbdc7-7917-4041-88c3-c4fa4621761c';

    public static function create(): Serie
    {
        $manufacturer = ManufacturerFactory::create();

        return new Serie(
            self::SERIE_UUID,
            'Fairphone 4',
            $manufacturer,
        );
    }
}
