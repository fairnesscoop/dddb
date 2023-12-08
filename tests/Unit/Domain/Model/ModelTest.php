<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\Model;

use App\Domain\Model\Model;
use App\Domain\Model\Serie;
use PHPUnit\Framework\TestCase;

final class ModelTest extends TestCase
{
    public function testGetters(): void
    {
        $uuid = 'abcde';
        $androidCodeName = 'twolip';
        $attributes = [
            "os" => "os_uuid",
            "battery_reference" => "battery_uuid"
        ];
        $serie = $this->createMock(Serie::class);
        $parentModel = $this->createMock(Model::class);

        $model = new Model(
            $uuid,
            null,
            $androidCodeName,
            $attributes,
            $serie,
            $parentModel
        );

        $this->assertSame($model->getUuid(), $uuid);
        $this->assertNull($model->getReference());
        $this->assertSame($model->getAttributes(), $attributes);
        $this->assertSame($model->getSerie(), $serie);
        $this->assertSame($model->getParentModel(), $parentModel);
    }
}
