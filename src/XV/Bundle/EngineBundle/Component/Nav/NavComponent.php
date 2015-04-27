<?php

namespace XV\Bundle\EngineBundle\Component\Nav;


use XV\Bundle\EngineBundle\Classes\Component\AbstractComponent;

class NavComponent extends AbstractComponent
{

    protected $items = [];
    public function init()
    {
        $this->setComponentName('nav.navComponent');
        $this->setParamByRef("items", $this->items);
    }

    /**
     * Add new item to menu
     * @param NavComponentItem $item
     * @return $this
     */
    public function addItem(NavComponentItem $item){
        $this->items[] = $item;

        return $this;
    }

    /**
     * @param string $id
     * @return $this
     */
    public function setActive($id){
        return $this->setParam("active", $id);
    }

}
