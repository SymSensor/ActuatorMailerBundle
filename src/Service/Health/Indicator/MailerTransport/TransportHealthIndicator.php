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
use SymSensor\ActuatorBundle\Service\Health\HealthInterface;

interface TransportHealthIndicator
{
    public function supports(TransportInterface $transport): bool;

    public function health(TransportInterface $transport): HealthInterface;
}
