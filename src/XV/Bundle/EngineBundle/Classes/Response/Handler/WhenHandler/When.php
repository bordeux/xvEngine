<?php

namespace XV\Bundle\EngineBundle\Classes\Response\Handler\WhenHandler;

use JsonSerializable;
use XV\Bundle\EngineBundle\Classes\Response\Handler\AbstractHandler;

class When implements JsonSerializable {

    
    /**
     *
     * @var AbstractHandler
     */
    public $thenHandler = null;

    /**
     *
     * @var AbstractHandler
     */
    public $failHandler = null;

    /**
     *
     * @var CaseExpresion 
     */
    public $caseExpresion;
    
    
    /**
     * 
     * @param callable $callable
     * @param type $obj
     */
    public function __construct(callable $callable, $obj = null) {
        $this->caseExpresion = new CaseExpresion();
        if($obj){
            $callable->bindTo($obj);
        }
        $result = $callable($this->caseExpresion);
        
        if($result instanceof CaseExpresion){
            $this->caseExpresion = $result;
        }
    }
    
    
    
   
    /**
     * 
     * @param callable $callable
     * @param type $obj
     * @return When
     */
    public function then(callable $callable, $obj = null) {
        $obj && $callable->bindTo($obj);
        $this->thenHandler = $callable();
        return $this;
    }

    
    /**
     * 
     * @param callable $callable
     * @param mixed $obj
     * @return When
     */
    public function fail(callable $callable, $obj = null) {
        $obj && $callable->bindTo($obj);
        $this->failHandler = $callable();
        return $this;
    }

    /**
     * 
     * @return string[]
     */
    public function jsonSerialize() {
        return array(
            "when" => $this->caseExpresion,
            "then" => $this->thenHandler,
            "fail" => $this->failHandler
        );
    }

}
