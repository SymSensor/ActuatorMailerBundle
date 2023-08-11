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

namespace SymSensor\ActuatorMailerBundle;

use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;
use SymSensor\ActuatorMailerBundle\DependencyInjection\SymSensorActuatorMailerExtension;

final class SymSensorActuatorMailerBundle extends AbstractBundle
{
    public function getContainerExtension(): ?ExtensionInterface
    {
        return new SymSensorActuatorMailerExtension();
    }
}
