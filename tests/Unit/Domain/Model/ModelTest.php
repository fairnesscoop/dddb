<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\Model;

use App\Domain\Model\Model;
use App\Domain\Serie\Serie;
use PHPUnit\Framework\TestCase;

final class ModelTest extends TestCase
{
    public function testGetters(): void
    {
        $uuid = 'abcde';
        $codeName = 'Redfin';
        $codeTac = ['0123456'];
        $attributes = [
            "os" => "os_uuid",
            "battery_reference" => "battery_uuid"
        ];
        $serie = $this->createMock(Serie::class);
        $parentModel = $this->createMock(Model::class);

        $model = new Model(
            $uuid,
            $codeName,
            $codeTac,
            $attributes,
            $serie,
            $parentModel
        );

        $this->assertSame($model->getUuid(), $uuid);
        $this->assertSame($model->getCodeName(), $codeName);
        $this->assertSame($model->getCodeTac(), $codeTac);
        $this->assertSame($model->getAttributes(), $attributes);
        $this->assertSame($model->getSerie(), $serie);
        $this->assertSame($model->getParentModel(), $parentModel);
    }
}
