<?php
namespace AppBundle\Http\ResourceStrategy;


use AppBundle\Http\MagentoResourceGenerator;
use AppBundle\Service\Scope;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

abstract class AbstractCustomerResourceStrategy extends AbstractResourceStrategy
{
    /**
     * AbstractAdminResourceStrategy constructor.
     *
     * @param Scope $scopeContext
     * @param MagentoResourceGenerator $resourceGenerator
     * @param $adminUser
     * @param $adminPassword
     */
    public function __construct(
        Scope $scopeContext,
        MagentoResourceGenerator $resourceGenerator
    ) {
        parent::__construct($scopeContext,$resourceGenerator);
        $this->setToken();
    }

    private function setToken()
    {
        if (!$this->getScope()->isGuest() && $this->getScope()->getToken()) {
            $this->header['Authorization'] = 'Bearer ' . $this->getScope()->getToken()->getAttribute('bearerToken');
        }
    }
}
