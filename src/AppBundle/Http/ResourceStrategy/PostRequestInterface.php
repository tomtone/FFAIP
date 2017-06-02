<?php
namespace AppBundle\Http\ResourceStrategy;


interface PostRequestInterface
{
    /**
     * Add body for post request.
     *
     * @param string $payload
     *
     * @return mixed
     */
    public function setBody(string $payload);
}