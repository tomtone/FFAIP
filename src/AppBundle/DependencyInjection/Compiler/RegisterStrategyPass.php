<?php
namespace AppBundle\DependencyInjection\Compiler;

use AppBundle\Http\RequestGeneratorInterface;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

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
        $strategy = $container->getParameter('app.strategy');

        $definition = $container->getDefinition('app.strategy.generator');
        foreach ($container->findTaggedServiceIds('strategies') as $id => $attributes) {
        // We must assume that the class value has been correctly filled, even if the service is created by a factory
            if(isset($attributes[0]['type']) && $attributes[0]['type'] == $strategy) {
                $name = isset($attributes[0]['id']) ? $attributes[0]['id'] : $id;
                $definition->addMethodCall('addStrategy', array(new Reference($id)));
            }
        }
    }
}