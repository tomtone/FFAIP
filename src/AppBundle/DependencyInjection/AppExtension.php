<?php
namespace AppBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

class AppExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $strategyConfiguration = new StrategyConfiguration();
        $this->processConfiguration($strategyConfiguration, $configs);
        
        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('strategies/magento.yml');
        $loader->load('strategies/fixtures.yml');
        $loader->load('services.yml');
        $loader->load('controller.yml');

        if (isset($configs[0]) && $configs[0]['strategy']) {
            $container->setParameter('app.strategy', $configs[0]['strategy']);
        }
    }
}
