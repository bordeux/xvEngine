<?php

namespace XV\Bundle\EngineBundle\Classes\Response\Handler;

use XV\Bundle\EngineBundle\Classes\Component\AbstractComponent;
use XV\Bundle\EngineBundle\Classes\Response\Handler\AbstractHandler;




class ReplaceHandler extends AbstractHandler {

    /**
     * 
     * @var string
     */
    public $name = "replace";

    
    public $replaces = [];

    public $replacesHTML = [];

    /**
     * 
     * @param string $componentID
     */
    public function __construct() {

    }
    
    
    /**
     * 
     * @param string $id
     * @return ActionHandler
     */
    public function replace($id, AbstractComponent $component){
        $this->replaces[] = array(
            "id" => $id,
            "component" => $component
        );
        return $this;
    }


    /**
     * @param                   $selector
     * @param AbstractComponent $component
     *
     * @return $this
     */
    public function replaceHTML($selector,  AbstractComponent $component){
        $this->replacesHTML[] = array(
            "selector" => $selector,
            "component" => $component
        );
        return $this;
    }

    
    /**
     * 
     * @return mixed[]
     */
    public function jsonSerialize() {
        return array(
           "name" => $this->name,
           "replaces" => $this->replaces,
           "replacesHTML" => $this->replacesHTML
        );
    }

}
