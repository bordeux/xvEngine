<?php


namespace XV\Bundle\EngineBundle\Classes\Response;

use DateTime;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use XV\Bundle\EngineBundle\Classes\Response\Handler\AbstractHandler;


class AjaxResponse  extends JsonResponse {


    public $handlers = array();
    
    
    /**
     * 
     * @param \callable $handler
     * @param type $obj
     * @return AjaxResponse
     */
    public function addHandler(callable $handler, $obj = null) {
        if ($obj) {
            $handler->bindTo($obj);
        }

        $handler = $handler($this);

        return $this->addRawHandler($handler);
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
     * @return AbstractHandler[]
     */
    public function getHandlers(){
        return $this->handlers;
    }


    /**
     * @param $id
     *
     * @return bool
     */
    public function removeHandler($id){
        foreach($this->handlers as $index =>$handler){
            if($handler->getID() == $id){
                unset($this->handlers[$index]);
            }
        }

        return true;
    }


    /**
     * 
     * @param Request $request
     * @return type
     */
    public function prepare(Request $request) {

        $this->setPrivate();
        $this->setMaxAge(0);
        $this->setSharedMaxAge(0);
        $this->headers->addCacheControlDirective('no-cache', true);
        $this->headers->addCacheControlDirective('max-age', 0);
        $this->headers->addCacheControlDirective('must-revalidate', true);
        $this->headers->addCacheControlDirective('no-store', true);
        $this->headers->set("X-Powered-By" ,"XV-Server v1.0");
    
        $this->setData(array(
            "handlers" => array_values($this->handlers)
        ));
        
        $this->setEtag(uniqid());
        $this->setMaxAge(0);
        $this->setLastModified(new DateTime());
        return parent::prepare($request);
       
    }


    /**
     * @param AjaxResponse $response
     *
     * @return $this
     */
    public function joinResponse( $response){
        if(!($response instanceof AjaxResponse)){
            echo($response->getContent());
            exit;
        }
        foreach($response->getHandlers() as $handler){

            if(!$handler instanceof AbstractHandler){
                exit("wut?! ".$handler);
            }
            $this->addRawHandler($handler);
        }
        return $this;
    }
}
