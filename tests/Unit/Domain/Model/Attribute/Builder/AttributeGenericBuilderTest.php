<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\Model\Attribute\Builder;

use App\Domain\Model\Attribute\AttributeCollection;
use App\Domain\Model\Attribute\Battery;
use App\Application\Attribute\Builder\AttributeGenericBuilder;
use App\Application\Attribute\Builder\BuilderInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\Argument\ServiceLocator;

final class AttributeGenericBuilderTest extends TestCase
{
    private MockObject|BuilderInterface $specificBuilder;
    private AttributeGenericBuilder $genericBuilder;

    public function setUp(): void
    {
        $this->specificBuilder = $this->createMock(BuilderInterface::class);

        /** @var MockObject|ServiceLocator $builderLocator */
        $builderLocator = $this->createMock(ServiceLocator::class);
        $builderLocator->expects(self::any())
            ->method('get')
            ->with(Battery::NAME)
            ->willReturn($this->specificBuilder);

        $this->genericBuilder = new AttributeGenericBuilder($builderLocator);
    }

    public function testCreateAttributeCollection(): void
    {
        $references = ['RF3615'];

        $this->specificBuilder->expects(self::once())
            ->method('createAttribute')
            ->with($references)
            ->willReturn(new Battery($references));

        $expectedAttributes = new AttributeCollection([Battery::NAME => new Battery($references)]);

        $result = $this->genericBuilder->createAttributeCollection([Battery::NAME => $references]);
        $this->assertEquals($expectedAttributes, $result);
    }

    function testGetAllAttributeNames(): void
    {
        $this->assertContains(Battery::NAME, $this->genericBuilder->getAllAttributeNames());
    }
}
