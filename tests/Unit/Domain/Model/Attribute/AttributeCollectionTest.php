<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\Model\Attribute;

use App\Domain\Model\Attribute\AttributeCollection;
use App\Domain\Model\Attribute\Battery;
use PHPUnit\Framework\TestCase;

final class AttributeCollectionTest extends TestCase
{
    public function testGetters(): void
    {
        $references = ['1234'];

        $batteryAttribute = new Battery($references);

        $attributeCollection = new AttributeCollection([
            Battery::NAME => $batteryAttribute,
        ]);

        $this->assertTrue($attributeCollection->has(Battery::NAME));
        $this->assertFalse($attributeCollection->has('undefined'));
        $this->assertSame($attributeCollection->get(Battery::NAME), $batteryAttribute);
    }

    public function testSetters(): void
    {
        $references = ['1234'];

        $batteryAttribute = new Battery($references);

        $attributeCollection = new AttributeCollection();

        $this->assertFalse($attributeCollection->has(Battery::NAME));
        $attributeCollection->set(Battery::NAME, $batteryAttribute);
        $this->assertSame($attributeCollection->get(Battery::NAME), $batteryAttribute);
    }
}
