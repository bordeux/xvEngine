<?php

namespace XV\Bundle\EngineBundle\Classes\Response\Handler\WhenHandler;

use JsonSerializable;

class CaseExpresion  implements JsonSerializable {

    /**
     *
     * @var mixed[] 
     */
    public $cases = [];
    
    /**
     * 
     * @param mixed $param1
     * @param mixed $param2
     */
    public function isEqual($param1, $param2) {
        $this->cases[] = array(
            "type" => __FUNCTION__,
            "param1" => $param1,
            "param2" => $param2,
        );
    }

    /**
     * 
     * @param mixed $param1
     * @param mixed $param2
     */
    public function isNotEqual($param1, $param2) {
        $this->cases[] = array(
            "type" => __FUNCTION__,
            "param1" => $param1,
            "param2" => $param2,
        );
    }
    
    /**
     * 
     * @param mixed $param1
     * @param mixed $param2
     */
    public function isLess($param1, $param2) {
        $this->cases[] = array(
            "type" => __FUNCTION__,
            "param1" => $param1,
            "param2" => $param2,
        );
    }
    
    
    /**
     * 
     * @param mixed $param1
     * @param mixed $param2
     */
    public function isPositive($param1) {
        $this->cases[] = array(
            "type" => __FUNCTION__,
            "param1" => $param1
        );
    }
    
    /**
     * 
     * @param mixed $param1
     * @param mixed $param2
     */
    public function isNegative($param1) {
        $this->cases[] = array(
            "type" => __FUNCTION__,
            "param1" => $param1
        );
    }


    /**
     * 
     * @return array
     */
    public function jsonSerialize() {
        return $this->cases;
    }

}
