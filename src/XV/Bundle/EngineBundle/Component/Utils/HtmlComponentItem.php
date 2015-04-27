<?php

namespace XV\Bundle\EngineBundle\Component\Utils;

use JsonSerializable;
use XV\Bundle\EngineBundle\Classes\Component\AbstractComponent;

class HtmlComponentItem implements JsonSerializable {

    /**
     *
     * @var AbstractComponent
     */
    private $component;


    /**
     *
     * @var string
     */
    private $selector = "";

    /**
     * @var bool
     */
    private $replace = false;

    /**
     *
     * @param AbstractComponent $component
     */
    public function __construct($selector , AbstractComponent $component, $replace = false) {
        $this->selector = $selector;
        $this->component = $component;
        $this->replace = $replace;
    }


    /**
     *
     * @return mixed[]
     */
    public function jsonSerialize() {
        return array(
            "component" => $this->component,
            "selector" => $this->selector,
            "replace" => !!$this->replace
        );
    }

}
