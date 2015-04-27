<?php

namespace XV\Bundle\EngineBundle\Classes\Response\Handler;

use XV\Bundle\EngineBundle\Classes\Response\Handler\AbstractHandler;




class ServiceHandler extends AbstractHandler {

    /**
     * 
     * @var string
     */
    public $name = "service";

    
    /**
     *
     * @var string
     */
    public $serviceName;


    
    /**
     *
     * @var mixed[]
     */
    public $calls = [];
    
    
    /**
     * 
     * @param string $serviceName
     */
    public function __construct($serviceName) {
        $this->serviceName = $serviceName;
    }
    
    
    /**
     * 
     * @param string $name
     * @param mixed[] $arguments
     * @return ServiceHandler
     */
    public function __call($name, $arguments) {
        $this->calls[] = array(
            "method"  => $name,
            "arguments" => $arguments
        );
        return $this;
    }


    /**
     * @param $eventName
     * @param callable $callable
     * @param null $obj
     * @return $this
     */
    public function on($eventName, callable $callable, $obj = null){

        if($obj){
            $callable->bindTo($obj);
        }


        $handler = null;
        $this->calls[] = array(
            "method"  => "on",
            "arguments" => [$eventName, $callable()]
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
            "serviceName" => $this->serviceName,
            'call' => $this->calls,
        );
    }

}
