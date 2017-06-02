<?php
namespace AppBundle\Http\ResourceStrategy\Fixture;


use AppBundle\Http\MagentoResourceGenerator;
use AppBundle\Http\ResourceStrategy\AbstractResourceStrategy;
use AppBundle\Service\Scope;
use Symfony\Component\HttpKernel\Kernel;

abstract class AbstractFixtureResourceStrategy extends AbstractResourceStrategy
{
    /**
     * @var Kernel
     */
    private $kernel;

    /**
     * AbstractFixtureResourceStrategy constructor.
     * @param Scope $scopeContext
     * @param MagentoResourceGenerator $resourceGenerator
     * @param Kernel $kernel
     */
    public function __construct(Scope $scopeContext, MagentoResourceGenerator $resourceGenerator, Kernel $kernel)
    {
        parent::__construct($scopeContext, $resourceGenerator);
        $this->kernel = $kernel;
    }

    /**
     * @param string $filename
     *
     * @return array
     */
    public function getFileContent($filename = null) : array
    {
        if(is_null($filename)) return [];

        $path = $this->kernel->locateResource('@AppBundle/Resources/fixtures/' . $filename);

        $data = \GuzzleHttp\json_decode(file_get_contents($path), true);

        return $data;
    }
}