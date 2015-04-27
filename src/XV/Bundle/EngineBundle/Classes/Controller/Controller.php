<?php

namespace XV\Bundle\EngineBundle\Classes\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller as ControllerAbstract;
use XV\Bundle\EngineBundle\Classes\Response\AjaxResponse;
use XV\Bundle\EngineBundle\Classes\Response\Handler\ServiceHandler;
use XV\Bundle\EngineBundle\Service\Tools;


class Controller extends ControllerAbstract
{
    
    /**
     *
     * @var AjaxResponse 
     */
    public $response;


    /**
     * Constructor
     */
    public function __construct() {
        $this->response = new AjaxResponse();
    }





    /**
     * @return Tools
     */
    public function tools(){
        return $this->get('xv.tools');
    }


    /**
     * Setting page name
     * @param string$pageName
     * @return $this
     */
    public function setPageName($pageName){
        $this->response->addHandler(function() use($pageName){
            $service = new ServiceHandler("request");
            $service->setHeader("X-XV-Page", $pageName);
            return $service;
        }, $this);
        return $this;
    }

}
