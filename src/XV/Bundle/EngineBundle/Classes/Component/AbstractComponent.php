<?php

namespace XV\Bundle\EngineBundle\Classes\Component;

use JsonSerializable;
use XV\Bundle\EngineBundle\Classes\Response\Handler\AbstractHandler;

class AbstractComponent implements JsonSerializable {

    /**
     *
     * @var mixed[] 
     */
    public $params = array();

    /**
     *
     * @var int 
     */
    public $id;

    /**
     *
     * @var string 
     */
    public $componentName = "";

    
    /**
     *
     * @var type 
     */
    public $eventHandlers = [];

    /**
     *
     * @var mixed[] 
     */
    public $attrs = [];
    
    /**
     * 
     * @param type $id
     */
    public function __construct($id = null) {
        $this->id = null;
        if (!is_null($id)) {
            $this->setID($id);
        }

        $this->setParamByRef("attrs", $this->attrs);
        $this->init();
    }

    /**
     * 
     * @param string $id
     */
    public function setID($id) {
        $this->id = $id;
    }

    
    
    /**
     * 
     * @return string
     */
    public function getPath(){
        return "component://{$this->id}";
    }
    
    /**
     * 
     * @return string
     */
    public function getId() {
        return $this->id;
    }
 

    /**
     * 
     * @return array
     */
    public function getParams() {
        return $this->params;
    }

    /**
     * @param string $key
     * @return array
     */
    public function getParam($key) {
        if (!isset($this->params[$key])) {
            return null;
        }
        return $this->params[$key];
    }

    
    /**
     * 
     * @param string $key
     * @param mixed $value
     * @return $this
     */
    public function setParam($key, $value) {
        $this->params[$key] = $value;
        return $this;
    }
    
    
    /**
     * 
     * @param string $key
     * @param mixed $value
     * @return $this
     */
    public function setParamByRef($key, &$value) {
        $this->params[$key] = &$value;
        return $this;
    }

    /**
     * 
     * @return string
     */
    public function getComponentName() {
        return $this->componentName;
    }

    /**
     * 
     * @param string $name
     * @return $this
     */
    protected function setComponentName($name) {
        $this->componentName = $name;
        return $this;
    }

    /**
     * 
     */
    public function init() {
        
    }



    /**
     * 
     * @param string $eventName
     * @param callable|AbstractHandler $handler
     * @param mixed $obj
     * @return $this
     */
    public function on($eventName, $handler, $obj = null){
        if(is_callable($handler)){
            if($obj){
                $handler->bindTo($obj);
            }
            $handler = $handler();
        }
        
        if (!isset($this->eventHandlers[$eventName])) {
            $this->eventHandlers[$eventName] = [];
        }
        $this->eventHandlers[$eventName][] = $handler;
        return $this;
    }
    
    
    /**
     * 
     * @param string $eventName
     * @return $this
     */
    public function off($eventName){
        if(isset($this->eventHandlers[$eventName])){
            unset($this->eventHandlers[$eventName]);
        }
        return $this;
    }
    
    /**
     * 
     * @return AbstractHandler[]
     */
    public function getEvents(){
        return $this->eventHandlers;
    }
    
    
    
    /**
     * 
     * @param string $classes
     */
    public function addClass($classes){
        if(is_array($classes)){
            $classes = implode(" " , $classes);
        }
        
        $classeExsist = $this->getParam('classes');
        if(!$classeExsist){
            $classeExsist = "";
        }
        $classes = $classeExsist.' '.$classes;
        $this->setParam('classes', $classes);
        return $this;
    }

    /**
     * 
     * @return mixed[]
     */
    public function jsonSerialize() {
        return array(
            "id" => $this->getId(),
            "component" => $this->getComponentName(),
            "params" => $this->getParams(),
            "events" => $this->getEvents()
        );
    }
    
 
    /**
     * 
     * @param string $key
     * @param string $value
     * @return $this
     */
    public function setAttr($key, $value){
        $this->attrs[$key] = $value;
        return $this;
    }

}
