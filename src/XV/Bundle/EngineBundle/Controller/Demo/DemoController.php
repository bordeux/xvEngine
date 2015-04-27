<?php

namespace XV\Bundle\EngineBundle\Controller\Demo;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use XV\Bundle\EngineBundle\Classes\Controller\Controller;
use XV\Bundle\EngineBundle\Classes\Response\Handler\PageHandler;
use XV\Bundle\EngineBundle\Classes\Response\Handler\RequestHandler;

use XV\Bundle\EngineBundle\Component\Nav\NavComponent;
use XV\Bundle\EngineBundle\Component\Nav\NavComponentItem;
use XV\Bundle\EngineBundle\Component\Utils\HtmlComponent;
use XV\Bundle\EngineBundle\Component\Utils\HtmlComponentItem;

class DemoController extends Controller
{
    /**
     * @Route("/demo/")
     */
    public function indexAction(Request $request)
    {

        /**
         * Setting view
         */
        $this->response->addHandler(function() {
            $page = new PageHandler("main-page");
            $page->setAnimationType(PageHandler::SLIDE_NONE);
            $page->setComponent($this->getView());
            return $page;
        }, $this);

        /**
         * Set page name
         */
        $this->setPageName("demo-bundle");


        /**
         * Autoload events page
         */
        $this->response->addHandler(function(){
            $request = new RequestHandler('/demo/events/');
            $request->setId("auto-loader");
            return $request;
        });

        return $this->response;
    }


    /**
     * @return HtmlComponent
     */
    public function getView(){
        $view = new HtmlComponent("main-view");
        $view->setHTML(
            $this->get("twig")
            ->render('@XVEngine/Demo/index.html.twig')
        );

        $view->addItem(new HtmlComponentItem("navigation", $this->getNavigationView(), true));
        return $view;
    }

    public function getNavigationView(){
        $view = new NavComponent("header-menu");
        $view->addItem(new NavComponentItem("events", "/demo/events/", "Demo 1"));
        $view->addItem(new NavComponentItem("dialog", "/demo/dialog/", "Demo 2"));
        return $view;
    }
}