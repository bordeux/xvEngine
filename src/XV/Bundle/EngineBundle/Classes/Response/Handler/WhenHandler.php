<?php

namespace XV\Bundle\EngineBundle\Classes\Response\Handler;

use XV\Bundle\EngineBundle\Classes\Response\Handler\AbstractHandler;
use XV\Bundle\EngineBundle\Classes\Response\Handler\WhenHandler\When;


/**
 * $caseHandler = new WhenHandler();
 * <code>
 * $caseHandler->when(function($case){
 *      $case.isEqual($case.getParam("loremIpsum", "dupa"), "5325");
 *      $case.isEqual($case.getParam("loremIpsum", "dupa"), "5325");
 * 
 * }).then(function(){
 *      $handler new Handler();
 *      return $handler;
 * }).fail(function(){
 *      $handler new Handler();
 *      return $handler;
 * });
 * </code>
 */
class WhenHandler extends AbstractHandler {

    /**
     * 
     * @var string
     */
    public $name = "when";

    /**
     *
     * @var When[] 
     */
    public $when = [];

    /**
     * 
     * @param string $serviceName
     */
    public function __construct() {
    }


    public function when(callable $function, $obj = null) {
        $when = new When($function, $obj);
        $this->when[] = $when;
        return $when;
    }

    /**
     * 
     * @return mixed[]
     */
    public function jsonSerialize() {
        return array(
            "name" => $this->name,
            "when" => $this->when
        );
    }

}
