<?php

namespace XV\Bundle\EngineBundle\Classes\Response\Handler;

use XV\Bundle\EngineBundle\Classes\Response\Handler\AbstractHandler;

/**
 * 
 *
 * @method self push(string $title, string $path)
 * @method self replace(string $title, string $path)
 * @method self back()
 * @method self setTitle(string $title)
 */
class HistoryHandler extends AbstractHandler {

    /**
     *
     * @var string 
     */
    public $name = "history";
    
    /**
     *
     * @var type 
     */
    private $operations = [];
    

    
    /**
     * 
     * @param string $method
     * @param mixed[] $arguments
     * @return HistoryHandler
     */
    public function __call($method, $arguments) {
        $this->operations[] = array(
            "method" => $method,
            "arguments" => $arguments
        );
        return $this;
    }

    
    public function on($eventName , $handler , $obj = null){
        if(is_callable($handler)){
            if($obj){
                $handler->bindTo($obj);
            }
            $handler = $handler();
        }
        
        $this->operations[] = array(
            "method" => "on",
            "arguments" => [$eventName, $handler]
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
            "operations" => $this->operations
        );
    }

}
