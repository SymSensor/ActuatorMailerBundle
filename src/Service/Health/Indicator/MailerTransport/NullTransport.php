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

namespace SymSensor\ActuatorMailerBundle\Service\Health\Indicator\MailerTransport;

use Symfony\Component\Mailer\Transport\TransportInterface;
use SymSensor\ActuatorBundle\Service\Health\Health;
use SymSensor\ActuatorBundle\Service\Health\HealthInterface;

class NullTransport implements TransportHealthIndicator
{
    public function supports(TransportInterface $transport): bool
    {
        return $transport instanceof \Symfony\Component\Mailer\Transport\NullTransport;
    }

    public function health(TransportInterface $transport): HealthInterface
    {
        return Health::up();
    }
}
