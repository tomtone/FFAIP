<?php
namespace AppBundle\DependencyInjection\Compiler;

use AppBundle\Http\RequestGeneratorInterface;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class RegisterStrategyPass implements CompilerPassInterface
{
    /**
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('app.strategy.generator')) {
            return;
        }

        $appConfig = $container->getExtensionConfig('app');
        $strategy = $appConfig[0]['strategy'];

        $definition = $container->getDefinition('app.strategy.generator');
        foreach ($container->findTaggedServiceIds('strategies') as $id => $attributes) {
        // We must assume that the class value has been correctly filled, even if the service is created by a factory
            if(isset($attributes[0]['type']) && $attributes[0]['type'] == $strategy) {
                #var_dump($id);
                #var_dump($attributes);
                #var_dump($strategy);
            }
        }
    }
}