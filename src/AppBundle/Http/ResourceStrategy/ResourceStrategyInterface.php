<?php
namespace AppBundle\Http\ResourceStrategy;


interface ResourceStrategyInterface
{
    /**
     * @param null $args
     * 
     * @return array|string
     */
    public function request($args = null) : array;

    /**
     * @param $resource
     * 
     * @return bool checks for resource support for given request
     */
    public function supports($resource) : bool;
}