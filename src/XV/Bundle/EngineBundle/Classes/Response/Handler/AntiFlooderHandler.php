<?php

namespace XV\Bundle\EngineBundle\Classes\Response\Handler;

use InvalidArgumentException;
use XV\Bundle\EngineBundle\Classes\Response\Handler\AbstractHandler;




class AntiFlooderHandler extends AbstractHandler {

    /**
     * 
     * @var string
     */
    public $name = "antiFlooder";

    
    /**
     *
     * @var int
     */
    public $timeout;

    
    /**
     *
     * @var AbstractHandler
     */
    public $handlers = [];
    

    /**
     *
     * @var string 
     */
    public $id;
  
    
    
    /**
     * 
     * @param type $ms
     */
    public function __construct($ms = 10) {
        $this->setTimeout($ms);
        $this->setID(uniqid());
    }
    
    
    /**
     * 
     * @param int $ms
     * @return AntiFlooderHandler
     */
    public function setTimeout($ms){
        $this->timeout = (int) $ms;
        return $this;
    }
    
    /**
     * 
     * @param int $timeout
     * @return AntiFlooderHandler
     */
    public function addHandler($handler, $obj = null){
        if(is_callable($handler)){
            $handler->bindTo($obj);
            $handler = $handler();
        }
        if( ! ($handler instanceof AbstractHandler)){
            throw new InvalidArgumentException("Should be handler here!");
        }
        
        
        $this->handlers[] = $handler;
        return $this;
    }
    
    
    /**
     * 
     * @param string $id
     * @return AntiFlooderHandler
     */
    public function setID($id){
        $this->id = $id;
        return $this;
    }
    
    

    /**
     * 
     * @return mixed[]
     */
    public function jsonSerialize() {
        return array(
            "name" => $this->name,
            'handlers' => $this->handlers,
            'timeout' => $this->timeout,
            'id' => $this->id
        );
    }

}
