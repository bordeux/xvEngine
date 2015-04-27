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
use XV\Bundle\EngineBundle\Classes\Response\Handler\ServiceHandler;
use XV\Bundle\EngineBundle\Classes\Response\Handler\WhenHandler;
use XV\Bundle\EngineBundle\Component\Button\ButtonComponent;
use XV\Bundle\EngineBundle\Component\Dialog\DialogComponent;
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

        if (!$this->tools()->isFromPage("demo-bundle")) {
            $this->response->joinResponse($this->forward("XVEngineBundle:Demo/Demo:index", [
                "request" => $request
            ]));
            $this->response->removeHandler("auto-loader");
        } //load parent page for document structure


        !$this->tools()->isFirstRequest() && $this->response->addHandler(function () use ($request) {
            $history = new HistoryHandler();
            $history->push("xvEngine: Dialog", $request->getRequestUri());
            return $history;
        }, $this);


        $this->response->addHandler(function () {//setting content of page
            $action = new ActionHandler("main-view");
            $action->addItem(new HtmlComponentItem(".xv-content", $this->getView()));
            return $action;
        });

        $this->response->addHandler(function () {//set active menu position
            $action = new ActionHandler("header-menu");
            $action->setActive("dialog");
            return $action;
        });

        return $this->response;
    }


    /**
     * @return HtmlComponent
     */
    public function getView()
    {
        $view = new HtmlComponent("simple-html-view");
        $view->setHTML("
                <button></button>
        ");

        $view->addItem(new HtmlComponentItem("button", $this->getButtonView(), true));

        return $view;
    }


    /**
     * @return ButtonComponent
     */
    public function getButtonView()
    {
        $view = new ButtonComponent();
        $view->setText("Open dialog");
        $view->on("click", function () {
            $service = new ServiceHandler("ui.sharedPlace");
            $service->addComponent($this->getDialogView());
            return $service;
        }, $this);
        return $view;
    }


    public function getDialogView()
    {
        $view = new DialogComponent("simple-dialog-view");
        $view->setHeaderComponent($this->getDialogHeaderView());
        $view->setContentComponent($this->getDialogContentView());
        $view->setFooterComponent($this->getDialogFooterView());
        return $view;
    }

    /**
     * @return HtmlComponent
     */
    public function getDialogHeaderView()
    {
        $view = new HtmlComponent();
        $view->setHTML("<h3> Hello! </h3>");
        return $view;
    }


    /**
     * @return HtmlComponent
     */
    public function getDialogContentView()
    {
        $view = new HtmlComponent();
        $view->setHTML("<p class='mt10px'>Thank you for click!</p>");
        return $view;
    }

    /**
     * @return HtmlComponent
     */
    public function getDialogFooterView()
    {
        $view = new HtmlComponent();
        $view->addClass("mt10px");
        $view->setHTML("<button></button>");
        $view->addItem(new HtmlComponentItem("button", $this->getDialogButtonView(), true));
        return $view;
    }


    /**
     * Button on dialog component
     * @return ButtonComponent
     */
    public function getDialogButtonView(){
        $view = new ButtonComponent();
        $view->setText("Go to demo 1");
        $view->on("click", function(){
            $action = new ActionHandler("simple-dialog-view");
            $action->close(); //close dialog
            return $action;
        }, $this);

        $view->on("click", function(){
            $request = new RequestHandler("/demo/events/");
            return $request;
        }, $this);
        return $view;
    }
}