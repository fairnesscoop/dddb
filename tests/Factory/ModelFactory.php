<?php

namespace App\Tests\Factory;

use App\Domain\Model\Attribute\Battery;
use App\Domain\Model\Model;

class ModelFactory
{
    public const MODEL_UUID = 'e84c9137-ac34-43f4-943f-9565942ef134';

    public static function create(array $attributes = null): Model
    {
        $serie = SerieFactory::create();

        $model = new Model(
            self::MODEL_UUID,
            'F1234G',
            'starlte',
            is_null($attributes) ? [
                Battery::NAME => ['F4BATT-1ZW-WW1', 'BLP613'],
            ] : $attributes,
            $serie,
        );
        $model->setUpdatedAt(\DateTimeImmutable::createFromFormat('!Y-m-d H:i', '2023-12-25 11:12'));

        return $model;
    }
}
