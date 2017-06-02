<?php
namespace AppBundle\Http;


use AppBundle\Http\ResourceStrategy\ResourceStrategyInterface;

interface RequestGeneratorInterface
{
    /**
     * @param ResourceStrategyInterface $strategy
     * 
     * @return void
     */
    public function addStrategy(ResourceStrategyInterface $strategy);

    /**
     * @param $resource
     * @param array ...$args
     * @return mixed
     */
    public function generate($resource, ...$args);
}