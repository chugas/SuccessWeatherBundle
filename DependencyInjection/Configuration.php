<?php

namespace Success\WeatherBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('success_weather');

        $rootNode
            ->children()
                ->scalarNode('apikey')->isRequired()->cannotBeEmpty()->end()
                ->scalarNode('format')->defaultValue('json')
                    ->validate()
                        ->ifNotInArray(array('json', 'xml'))
                        ->thenInvalid('Invalid {format} for doctype param "%s"')
                    ->end()
                ->end()
                ->scalarNode('host_data_features')
                    ->defaultValue('http://api.wunderground.com')
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode('host_autocomlete')
                    ->defaultValue('http://autocomplete.wunderground.com')
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode('cache_enabled')
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode('cache_dir')
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode('cache_duration')
                    ->cannotBeEmpty()
                ->end()                
            ->end();

        return $treeBuilder;
    }
}
