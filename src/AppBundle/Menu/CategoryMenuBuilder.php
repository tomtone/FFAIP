<?php
namespace AppBundle\Menu;

use AppBundle\Http\MagentoResourceGenerator;
use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;

class CategoryMenuBuilder
{
    /**
     * @var FactoryInterface
     */
    private $factory;

    /**
     * @var MagentoResourceGenerator
     */
    private $resourceGenerator;

    /**
     * @param FactoryInterface $factory
     * @param MagentoResourceGenerator $resourceGenerator
     */
    public function __construct(
        FactoryInterface $factory,
        MagentoResourceGenerator $resourceGenerator
    )
    {
        $this->factory = $factory;
        $this->resourceGenerator = $resourceGenerator;
    }

    public function createCategoryMenu(array $options)
    {
        $menu = $this->factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav navbar-nav');

        $categories = $this->resourceGenerator->generate('catalog_category_list');

        foreach ($categories as $category ) {
            $parent = $menu->addChild($category['name'], array('route' => 'catalog_category', 'routeParameters' => ['id' => $category['id']]));
            if(count($category['children_data']) > 0) {
                $parent->setAttribute('dropdown', true);
            }
            $this->appendChildren($category['children_data'], $parent);
        }

        return $menu;
    }

    /**
     * @param array $childCategories
     * @param ItemInterface $parentNode
     */
    private function appendChildren(array $childCategories, ItemInterface $parentNode)
    {
        if(count($childCategories) > 0){
            foreach ($childCategories as $category){
                $childNode = $parentNode->addChild($category['name'], array('route' => 'catalog_category', 'routeParameters' => ['id' => $category['id']]));
                if(isset($category['children_data'])){
                    #$childNode->setAttribute('dropdown', true);
                    $this->appendChildren($category['children_data'], $childNode);
                }
            }
        }
        return $parentNode;
    }
}