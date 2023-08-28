<?php

declare(strict_types=1);

namespace App\Tests\Unit\Infrastructure\Persistence\Doctrine\Repository\Model\Attribute;

use App\Domain\Model\Attribute\AttributeCollection;
use App\Domain\Model\Attribute\Battery;
use App\Infrastructure\Persistence\Doctrine\Repository\Model\Attribute\AttributeBuilder;
use App\Infrastructure\Persistence\Doctrine\Repository\Model\Attribute\Denormalizer\DenormalizerInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\Argument\ServiceLocator;

final class AttributeBuilderTest extends TestCase
{
    private MockObject|DenormalizerInterface $attributeDenormalizer;
    private AttributeBuilder $builder;

    public function setUp(): void
    {
        $this->attributeDenormalizer = $this->createMock(DenormalizerInterface::class);

        /** @var MockObject|ServiceLocator $builderLocator */
        $builderLocator = $this->createMock(ServiceLocator::class);
        $builderLocator->expects(self::any())
            ->method('get')
            ->with(Battery::NAME)
            ->willReturn($this->attributeDenormalizer);

        $this->builder = new AttributeBuilder($builderLocator);
    }

    public function testCreateAttributeCollection(): void
    {
        $references = ['RF3615'];

        $this->attributeDenormalizer->expects(self::once())
            ->method('createAttribute')
            ->with($references)
            ->willReturn(new Battery($references));

        $expectedAttributes = new AttributeCollection([Battery::NAME => new Battery($references)]);

        $result = $this->builder->createAttributeCollection([Battery::NAME => $references]);
        $this->assertEquals($expectedAttributes, $result);
    }
}
