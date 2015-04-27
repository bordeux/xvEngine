<?php

namespace XV\Bundle\EngineBundle\Classes\Response\Handler;

use XV\Bundle\EngineBundle\Classes\Component\AbstractComponent;
use XV\Bundle\EngineBundle\Classes\Response\Handler\AbstractHandler;




class PageHandler extends AbstractHandler {

    /**
     * 
     * @var string
     */
    public $name = "page";

    /**
     *
     * @var AbstractComponent 
     */
    protected $component = null;

    protected $slideType;

    
    
    CONST SLIDE_UP = "up";
    CONST SLIDE_DOWN = "down";
    CONST SLIDE_LEFT = "left";
    CONST SLIDE_RIGHT = "right";
    CONST SLIDE_PREVIOUS= "previous";
    CONST SLIDE_NONE = "none";
    
    
    /**
     * 
     * @param string $id
     */
    public function __construct($id = null) {
        $this->setId($id);
        $this->setAnimationType(self::SLIDE_UP);
    }

    /**
     * 
     * @param AbstractComponent $component
     * @return PageHandler
     */
    public function setComponent(AbstractComponent $component) {
        $this->component = $component;
        return $this;
    }
    
    
   
    /**
     * 
     * @param string $id
     * @return PageHandler
     */
    public function setId($id){
        $this->id = $id;
        return $this;
    }
    
    /**
     * 
     * @return string
     */
    public function getId(){
        return $this->id;
    }
    
    
    /**
     * 
     * @param string $slideType
     * @return PageHandler
     */
    public function setAnimationType($slideType){
        $this->slideType = $slideType;
        return $this;
    }

    /**
     * 
     * @return mixed[]
     */
    public function jsonSerialize() {
        return array(
            "name" => $this->name,
            "component" => $this->component,
            'slideType' => $this->slideType,
            "id" => $this->getId()
        );
    }

}
