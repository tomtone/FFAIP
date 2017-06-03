<?php
namespace AppBundle\Http\ResourceStrategy;


interface PostRequestInterface
{
    /**
     * Add body for post request.
     *
     * @param array $args
     *
     * @return mixed
     */
    public function getBody(array $args);
}
