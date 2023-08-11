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

use PHPUnit\Framework\TestCase;
use Symfony\Component\Mailer\Transport\NullTransport;
use SymSensor\ActuatorBundle\Service\Health\HealthState;
use SymSensor\ActuatorMailerBundle\Service\Health\Indicator\MailerTransport\NullTransport as NullTransportIndicator;

class NullTransportTest extends TestCase
{
    private NullTransportIndicator $nullTransportIndicator;

    private NullTransport $nullTransport;

    protected function setUp(): void
    {
        parent::setUp();

        $this->nullTransportIndicator = new NullTransportIndicator();
        $this->nullTransport = new NullTransport();
    }

    /**
     * @test
     */
    public function supportsNullTransport(): void
    {
        self::assertTrue($this->nullTransportIndicator->supports($this->nullTransport));
    }

    /**
     * @test
     */
    public function isAlwaysUp(): void
    {
        self::assertTrue($this->nullTransportIndicator->health($this->nullTransport)->isUp());
        self::assertEquals(HealthState::UP, $this->nullTransportIndicator->health($this->nullTransport)->getStatus());
    }
}
