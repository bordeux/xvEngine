<?php

namespace XV\Bundle\EngineBundle\Component\Utils;

use XV\Bundle\EngineBundle\Classes\Component\AbstractComponent;

class HtmlComponent extends AbstractComponent
{

    /**
     * @var HtmlComponentItem[]
     */
    protected $items = [];

    public function init()
    {
        $this->setComponentName('utils.htmlComponent');
        $this->setParamByRef("items", $this->items);
    }

    /**
     *
     * @param string $html
     * @return $this
     */
    public function setHTML($html)
    {
        $this->setParam("html", $html);
        return $this;
    }


    /**
     * @param                   $selector
     * @param AbstractComponent $component
     *
     * @deprecated
     * @return $this
     */
    public function addComponent(HtmlComponentItem $item)
    {
        return $this->addItem($item);
    }

    /**
     * @param                   $selector
     * @param AbstractComponent $component
     *
     * @return $this
     */
    public function addItem(HtmlComponentItem $item)
    {
        $this->items[] = $item;
        return $this;
    }

}
