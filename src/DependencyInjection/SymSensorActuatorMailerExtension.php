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

namespace SymSensor\ActuatorMailerBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\Mailer\Transport\Transports;
use SymSensor\ActuatorMailerBundle\Service\Health\Indicator as HealthIndicator;
use SymSensor\ActuatorMailerBundle\Service\Info\Collector as InfoCollector;

final class SymSensorActuatorMailerExtension extends Extension
{
    /**
     * @param mixed[] $configs
     */
    public function load(array $configs, ContainerBuilder $container): void
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        if (
            $container->willBeAvailable('symfony/mailer', Transports::class, [])
            && $this->isConfigEnabled($container, $config)
        ) {
            $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../../config'));
            $loader->load('services.yaml');
            if (isset($config['transports']) && \is_array($config['transports'])) {
                $transportReferences = [];
                foreach ($config['transports'] as $name => $currentTransportConfig) {
                    $transportReferences[$name] = new Reference($currentTransportConfig['service']);
                }
                $definition = $container->getDefinition(HealthIndicator\Mailer::class);
                $definition->replaceArgument('$transports', $transportReferences);

                $infoDefinition = $container->getDefinition(InfoCollector\Mailer::class);
                $infoDefinition->replaceArgument(0, $transportReferences);
            }
        }
    }
}
