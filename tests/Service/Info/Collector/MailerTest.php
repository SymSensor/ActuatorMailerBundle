<?php

declare(strict_types=1);

/*
 * This file is part of the symsensor/actuator-mailer-bundle package.
 *
 * (c) Kevin Studer <kreemer@me.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymSensor\ActuatorMailerBundle\Tests\Service\Info\Collector;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Mailer\Transport\TransportInterface;
use SymSensor\ActuatorMailerBundle\Service\Info\Collector\Mailer;

class MailerTest extends TestCase
{
    /**
     * @test
     */
    public function willDisplayDSNString(): void
    {
        // given
        $transport = self::createMock(TransportInterface::class);
        $transport->expects(self::once())
            ->method('__toString')
            ->willReturn('dsnIdentifier');

        $mailer = $this->build(['name' => $transport]);

        // when
        $info = $mailer->collect();

        // then
        self::assertFalse($info->isEmpty());
        self::assertEquals('mailer', $info->name());
        $infoArray = $info->jsonSerialize();
        self::assertArrayHasKey('transport', $infoArray);

        self::assertIsArray($infoArray['transport']);
        self::assertArrayHasKey('name', $infoArray['transport']);

        self::assertIsArray($infoArray['transport']['name']);
        self::assertArrayHasKey('class', $infoArray['transport']['name']);
        self::assertArrayHasKey('dsn', $infoArray['transport']['name']);

        self::assertEquals($transport::class, $infoArray['transport']['name']['class']);
        self::assertEquals('dsnIdentifier', $infoArray['transport']['name']['dsn']);
    }

    /**
     * @test
     */
    public function emptyWithoutTransports(): void
    {
        // given
        $mailer = $this->build();

        // when
        $info = $mailer->collect();

        // then
        self::assertTrue($info->isEmpty());
    }

    /**
     * @param array<string, TransportInterface> $transports
     */
    protected function build(array $transports = []): Mailer
    {
        return new Mailer($transports);
    }
}
