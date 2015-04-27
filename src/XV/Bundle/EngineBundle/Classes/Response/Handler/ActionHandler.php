<?php

namespace XV\Bundle\EngineBundle\Classes\Response\Handler;

use InvalidArgumentException;
use XV\Bundle\EngineBundle\Classes\Component\AbstractComponent;
use XV\Bundle\EngineBundle\Classes\Response\Handler\AbstractHandler;




class ActionHandler extends AbstractHandler {

    /**
     * 
     * @var string
     */
    public $name = "action";

    
    /**
     *
     * @var string
     */
    public $componentID;

    
    /**
     *
     * @var string[]
     */
    public $call = [];

    /**
     *
     * @var mixed[string]
     */
    public $options;


    /**
     * @var bool
     */
    public $ignoreNotFound = false;
 
    /**
     * 
     * @param string|AbstractComponent $componentID
     */
    public function __construct($componentID) {
        if($componentID instanceof AbstractComponent){
            $this->setComponentID($componentID->getId());
        }else{
            $this->setComponentID($componentID);
        }
    }
    
    
    /**
     * 
     * @param string $id
     * @return ActionHandler
     */
    public function setComponentID($id){
        $this->componentID = $id;
        return $this;
    }
    
    
    
    /**
     * 
     * @param string $name
     * @param mixed[] $arguments
     * @return ActionHandler
     * @throws InvalidArgumentException
     */
    public function __call($name, $arguments)
    {
        if(!is_string($name)){
            throw new InvalidArgumentException('Function name must be a string!');
        }
 
        $this->call[] = array(
            "method" => $name,
            "arguments" => $arguments
        );
        
        return $this;
    }
    
    
    public function on($eventName, callable $handler, $obj = null){
        if($obj){
            $handler->bindTo($obj);
        }
        
        $this->call[] = array(
            "method" => "on",
            "arguments" => [
                $eventName,
                $handler()
            ]
        );
        return $this;
    }
    
    
    /**
     * 
     * @param string $key
     * @param mixed $value
     * @return \XV\Bundle\EngineBundle\Classes\Response\Handler\ActionHandler
     */
    public function setOption($key, $value){
        $this->options[$key] = $value;
        return $this;
    }
    
    /**
     * 
     * @param string $options
     * @return \XV\Bundle\EngineBundle\Classes\Response\Handler\ActionHandler
     */
    public function setOptions($options){
        $this->options = $options;
        return $this;
    }
    
    /**
     * 
     * @return mixed[]
     */
    public function jsonSerialize()
    {
        return array(
            "name" => $this->name,
            "call" => $this->call,
            "component" => $this->componentID,
            "options" => $this->options,
            "ignoreNotFound" => !!$this->ignoreNotFound
        );
    }

}
