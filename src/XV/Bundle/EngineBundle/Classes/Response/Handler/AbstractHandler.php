<?php

namespace XV\Bundle\EngineBundle\Classes\Response\Handler;

use JsonSerializable;

abstract class AbstractHandler implements JsonSerializable {
    
    /**
     * Handler name
     * @var string
     */
    public $name = "";
    
    
    /**
     *
     * @var string
     */
    public $id =  null;

    
    /**
     * 
     * @return string
     */
    public function getHandlerName(){
        return $this->name;
    }
    

    /**
     * 
     * @param type $id
     * @return HandlerAbstract
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
    
    
    public function jsonSerialize() {
        return array();
    }

}
