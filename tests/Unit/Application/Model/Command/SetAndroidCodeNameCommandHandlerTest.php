<?php

declare(strict_types=1);

namespace App\Tests\Unit\Application\Model\Command;

use App\Application\Model\Command\SetAndroidCodeNameCommand;
use App\Application\Model\Command\SetAndroidCodeNameCommandHandler;
use App\Domain\Model\Model;
use App\Domain\Model\Repository\ModelRepositoryInterface;
use App\Tests\Factory\ModelFactory;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class SetAndroidCodeNameCommandHandlerTest extends TestCase
{
    private MockObject|ModelRepositoryInterface $modelRepository;
    private SetAndroidCodeNameCommandHandler $handler;

    public function setUp(): void
    {
        $this->modelRepository = $this->createMock(ModelRepositoryInterface::class);

        $this->handler = new SetAndroidCodeNameCommandHandler(
            $this->modelRepository,
        );
    }

    public function testSetAndroidCodeName(): void
    {
        $androidCodeName = 'pstar';
        $variant = 1;
        $model = ModelFactory::create();

        $this->modelRepository
            ->expects(self::once())
            ->method('update')
            ->with(self::callback(
                fn (Model $model) => $model->getAndroidCodeName() === $androidCodeName && $model->getVariant() === $variant)
            );

        $command = new SetAndroidCodeNameCommand($model, $androidCodeName, $variant);

        ($this->handler)($command);
    }
}
