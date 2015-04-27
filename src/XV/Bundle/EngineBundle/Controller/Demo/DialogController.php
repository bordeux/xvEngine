<?php

namespace XV\Bundle\EngineBundle\Controller\Demo;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use XV\Bundle\EngineBundle\Classes\Controller\Controller;
use XV\Bundle\EngineBundle\Classes\Response\CustomParam;
use XV\Bundle\EngineBundle\Classes\Response\Handler\ActionHandler;
use XV\Bundle\EngineBundle\Classes\Response\Handler\HistoryHandler;
use XV\Bundle\EngineBundle\Classes\Response\Handler\RequestHandler;
use XV\Bundle\EngineBundle\Classes\Response\Handler\WhenHandler;
use XV\Bundle\EngineBundle\Component\Button\ButtonComponent;
use XV\Bundle\EngineBundle\Component\Form\Input\TextInputComponent;
use XV\Bundle\EngineBundle\Component\Utils\HtmlComponent;
use XV\Bundle\EngineBundle\Component\Utils\HtmlComponentItem;

class DialogController extends Controller
{
    /**
     * @Route("/demo/dialog/")
     */
    public function indexAction(Request $request)
    {

        if(!$this->tools()->isFromPage("demo-bundle")){
            $this->response->joinResponse($this->forward("XVEngineBundle:Demo/Demo:index", [
                "request" => $request
            ]));
            $this->response->removeHandler("auto-loader");
        } //load parent page for document structure


        !$this->tools()->isFirstRequest() && $this->response->addHandler(function() use($request){
            $history = new HistoryHandler();
            $history->push("xvEngine: Dialog", $request->getRequestUri());
            return $history;
        }, $this);


        $this->response->addHandler(function(){//setting content of page
            $action = new ActionHandler("main-view");
            $action->addItem(new HtmlComponentItem(".xv-content", $this->getView()));
            return $action;
        });

        $this->response->addHandler(function(){//set active menu position
            $action = new ActionHandler("header-menu");
            $action->setActive("dialog");
            return $action;
        });

        return $this->response;
    }


    /**
     * @return HtmlComponent
     */
    public function getView(){
        $view = new HtmlComponent("simple-html-view");
        $view->setHTML("
                Dialog simple
        ");


        return $view;
    }

}