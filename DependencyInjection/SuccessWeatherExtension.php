<?php

namespace Success\WeatherBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class SuccessWeatherExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        $container->setParameter('weather_underground.apikey', $config['apikey']);
        $container->setParameter('weather_underground.format', $config['format']);
        $container->setParameter('weather_underground.host_data_features', $config['host_data_features']);
        $container->setParameter('weather_underground.host_autocomlete', $config['host_autocomlete']);
        $container->setParameter('weather_underground.cache_enabled', $config['cache_enabled']);
        $container->setParameter('weather_underground.cache_dir', $config['cache_dir']);
        $container->setParameter('weather_underground.cache_duration', $config['cache_duration']);        
        
    }
}
