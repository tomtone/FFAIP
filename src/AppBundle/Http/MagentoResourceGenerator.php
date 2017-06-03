<?php
namespace AppBundle\Http;


use AppBundle\Http\ResourceStrategy\ResourceStrategyInterface;

class MagentoResourceGenerator implements RequestGeneratorInterface
{
    /**
     * @var ResourceStrategyInterface[]
     */
    private $strategies = [];

    /**
     * @param $resource
     * @param array $args
     * @return array|string
     */
    public function generate($resource, ...$args)
    {
        foreach ($this->strategies as $key => $strategy){
            if($strategy->supports($resource) === true){
                return $strategy->request($args);
            }
        }
        throw new \Exception("Requested resource \"" . $resource . "\" does not exist");
    }

    public function addStrategy(ResourceStrategyInterface $strategy)
    {
        $this->strategies[] = $strategy;
    }
}
