<?php

namespace XV\Bundle\EngineBundle\Classes\Response\Handler;

use InvalidArgumentException;
use XV\Bundle\EngineBundle\Classes\Response\Handler\AbstractHandler;




class MultiHandler extends AbstractHandler {

    /**
     * 
     * @var string
     */
    public $name = "multi";

    
    /**
     *
     * @var int
     */
    public $handlers = [];


    /**
     *
     * @var string 
     */
    public $id;


    /**
     * @param callable $call
     * @param null     $obj
     *
     * @return MultiHandler
     */
    public function addHandler(callable $call, $obj = null){
        if($obj){
            $call->bindTo($obj);
        }

        return $this->addRawHandler($call());
    }

    /**
     * @param AbstractHandler $handler
     *
     * @return $this
     */
    public function addRawHandler(AbstractHandler $handler){
        $this->handlers[] = $handler;
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
            'id' => $this->id
        );
    }

}
