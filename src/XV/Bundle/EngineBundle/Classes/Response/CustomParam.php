<?php

namespace XV\Bundle\EngineBundle\Classes\Response;


use XV\Bundle\EngineBundle\Classes\Component\AbstractComponent;

class CustomParam {

    private $path;

    /**
     * 
     * @param string $path
     */
    public function __construct($path) {
        $this->path = $path;
    }
    
    
    /**
     * 
     * @param type $path
     * @return \self
     */
    public static function get($path){
        if($path instanceof AbstractComponent){
            $path = $path->getId();
        }
        return new self($path);
    }

    /**
     * 
     * @param string $funcname
     * @param mixed[] $args
     * @return array
     */
    function __call($funcname, $args = array()) {
        return array(
            "__custom" => "custom",
            "path" => $this->path,
            "method" => $funcname,
            "arguments" => $args
        );
    }

}
