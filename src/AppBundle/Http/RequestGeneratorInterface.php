<?php
namespace AppBundle\Http;


interface RequestGeneratorInterface
{
    public function generate($resource);
}