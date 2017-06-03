<?php
namespace AppBundle\Http\ResourceStrategy;


interface PutRequestInterface
{
    /**
     * Add body for put request.
     *
     * @param array $args
     *
     * @return mixed
     */
    public function getBody(array $args);
}
