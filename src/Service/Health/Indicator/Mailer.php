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

namespace SymSensor\ActuatorMailerBundle\Service\Health\Indicator;

use Symfony\Component\Mailer\Transport\TransportInterface;
use SymSensor\ActuatorBundle\Service\Health\Health;
use SymSensor\ActuatorBundle\Service\Health\HealthInterface;
use SymSensor\ActuatorBundle\Service\Health\HealthStack;
use SymSensor\ActuatorBundle\Service\Health\Indicator\HealthIndicator;
use SymSensor\ActuatorMailerBundle\Service\Health\Indicator\MailerTransport\TransportHealthIndicator;

class Mailer implements HealthIndicator
{
    /**
     * @var iterable<TransportHealthIndicator>
     */
    private iterable $mailerTransportHealthIndicators = [];

    /**
     * @var array<string, TransportInterface>
     */
    private array $transports;

    /**
     * @param array<string, TransportInterface>  $transports
     * @param iterable<TransportHealthIndicator> $mailerTransportHealthIndicators
     */
    public function __construct(array $transports, iterable $mailerTransportHealthIndicators)
    {
        $this->transports = $transports;
        $this->mailerTransportHealthIndicators = $mailerTransportHealthIndicators;
    }

    public function name(): string
    {
        return 'mailer';
    }

    public function health(): HealthInterface
    {
        $healthList = [];
        foreach ($this->transports as $name => $transport) {
            $transportChecked = false;
            foreach ($this->mailerTransportHealthIndicators as $transportHealthIndicator) {
                if ($transportChecked) {
                    continue;
                }
                if ($transportHealthIndicator->supports($transport)) {
                    $healthList[$name] = $transportHealthIndicator->health($transport);
                    $transportChecked = true;
                }
            }

            if (!$transportChecked) {
                $healthList[$name] = Health::unknown(
                    \sprintf('No suitable transport health indicator available for class "%s"', $transport::class)
                );
            }
        }

        if (0 === \count($healthList)) {
            return Health::unknown('No transports checked');
        }
        if (1 === \count($healthList)) {
            return \current($healthList);
        }

        return new HealthStack($healthList);
    }
}
