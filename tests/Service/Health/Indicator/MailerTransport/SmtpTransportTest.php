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

namespace SymSensor\ActuatorMailerBundle\Tests\Service\Health\Indicator\MailerTransport;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Mailer\Exception\TransportException;
use Symfony\Component\Mailer\Transport\Smtp\SmtpTransport;
use Symfony\Component\Mailer\Transport\Smtp\Stream\AbstractStream;
use SymSensor\ActuatorBundle\Service\Health\HealthState;
use SymSensor\ActuatorMailerBundle\Service\Health\Indicator\MailerTransport\SmtpTransport as SmtpTransportIndicator;

class SmtpTransportTest extends TestCase
{
    private SmtpTransportIndicator $smtpTransportIndicator;

    /**
     * @var SmtpTransport&MockObject
     */
    private SmtpTransport $smtpTransport;

    protected function setUp(): void
    {
        parent::setUp();

        $this->smtpTransportIndicator = new SmtpTransportIndicator();
        $this->smtpTransport = self::createMock(SmtpTransport::class);
    }

    /**
     * @test
     */
    public function supportsSmtpTransport(): void
    {
        self::assertTrue($this->smtpTransportIndicator->supports($this->smtpTransport));
    }

    /**
     * @test
     */
    public function supportsSubClassOfSmtpTransport(): void
    {
        $subClass = new class() extends SmtpTransport {};

        self::assertTrue($this->smtpTransportIndicator->supports($subClass));
    }

    /**
     * @test
     */
    public function upIfConnectionCanBeEstablished(): void
    {
        // given
        $stream = self::createMock(AbstractStream::class);

        $this->smtpTransport->expects(self::once())
            ->method('getStream')
            ->willReturn($stream);

        $stream->expects(self::once())
            ->method('initialize');

        $stream->expects(self::once())
            ->method('terminate');

        // when
        $health = $this->smtpTransportIndicator->health($this->smtpTransport);

        // then
        self::assertTrue($health->isUp());
        self::assertEquals(HealthState::UP, $health->getStatus());
    }

    /**
     * @test
     */
    public function downIfConnectionThrowsException(): void
    {
        // given
        $stream = self::createMock(AbstractStream::class);

        $this->smtpTransport->expects(self::once())
            ->method('getStream')
            ->willReturn($stream);

        $stream->expects(self::once())
            ->method('initialize')
            ->willThrowException(new TransportException());

        $stream->expects(self::once())
            ->method('terminate');

        // when
        $health = $this->smtpTransportIndicator->health($this->smtpTransport);

        // then
        self::assertFalse($health->isUp());
        self::assertEquals(HealthState::DOWN, $health->getStatus());
    }
}
