<?php
namespace AppBundle\Http\RequestResources;


interface ResourceStrategyInterface
{
    /**
     * @return string
     */
    public function request() : string;
    
    /**
     * @return bool checks for resource support for given request
     */
    public function supports() : bool;
}