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

namespace SymSensor\ActuatorMailerBundle\Service\Info\Collector;

use Symfony\Component\Mailer\Transport\TransportInterface;
use SymSensor\ActuatorBundle\Service\Info\Collector\Collector;
use SymSensor\ActuatorBundle\Service\Info\Info;

class Mailer implements Collector
{
    /**
     * @var array<string, TransportInterface>
     */
    private array $transports;

    /**
     * @param array<string, TransportInterface> $transports
     */
    public function __construct(array $transports)
    {
        $this->transports = $transports;
    }

    public function collect(): Info
    {
        $transportInfo = [];

        foreach ($this->transports as $name => $transport) {
            $transportInfo[$name] = [
                'class' => $transport::class,
                'dsn' => $transport->__toString(),
            ];
        }

        if (0 === \count($transportInfo)) {
            return new Info('mailer', []);
        }

        return new Info('mailer', [
            'transport' => $transportInfo,
        ]);
    }
}
