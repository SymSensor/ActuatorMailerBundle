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

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('sym_sensor_actuator_mailer');

        $rootNode = $treeBuilder->getRootNode();

        $rootNode // @phpstan-ignore-line
            ->canBeDisabled()
            ->children()
                ->arrayNode('transports')
                    ->useAttributeAsKey('name')
                    ->defaultValue(['default' => ['service' => 'mailer.default_transport']])
                    ->arrayPrototype()
                        ->children()
                            ->scalarNode('service')->isRequired()->end()
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
