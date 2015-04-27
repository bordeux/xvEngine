<?php

namespace XV\Bundle\EngineBundle\Service;


use JMS\DiExtraBundle\Annotation\Inject;
use JMS\DiExtraBundle\Annotation\Service;
use Symfony\Component\HttpFoundation\RequestStack;


/**
 * @Service("xv.tools", public=true)
 */
class Tools
{
    /**
     * @Inject("request_stack")
     * @var RequestStack
     */
    public $request;


    /**
     * @return bool
     */
    public function isXVRequest(){
        return !!$this->request->headers->get('X-XV-Request', false);
    }


    public function getCurrentRequest(){
        return $this->request->getCurrentRequest();
    }

    /**
     * @return bool
     */
    public function isFirstRequest(){
        return !!$this->getCurrentRequest()->headers->get('X-XV-First-Request', false);
    }


    /**
     * @param $page
     *
     * @return mixed
     */
    public function isFromPage($page){
        return $this->isFromPages([$page]);
    }

    /**
     * @param array $pages
     *
     * @return bool
     */
    public function isFromPages(array $pages){
        $from = $this->getCurrentRequest()->headers->get("X-XV-Page");
        foreach($pages as $page){
            if($from == $page){
                return true;
            }
        }
        return false;
    }


}
