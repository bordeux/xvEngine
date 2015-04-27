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

class EventsController extends Controller
{
    /**
     * @Route("/demo/events/")
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
            $history->push("xvEngine: Events", $request->getRequestUri());
            return $history;
        }, $this);


        $this->response->addHandler(function(){//setting content of page
            $action = new ActionHandler("main-view");
            $action->addItem(new HtmlComponentItem(".xv-content", $this->getView()));
            return $action;
        });

        $this->response->addHandler(function(){//set active menu position
            $action = new ActionHandler("header-menu");
            $action->setActive("events");
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

            <h3>Demo 1. Simple form interaction</h3>
            <text-input></text-input>

            <button></button>

            <div class='message'></div>
        ");

        $view->addItem(new HtmlComponentItem("text-input", $this->getTextInputView(), true));
        $view->addItem(new HtmlComponentItem("button", $this->getButtonView(), true));
        return $view;
    }

    /**
     * @return TextInputComponent
     */
    public function getTextInputView(){
        $view = new TextInputComponent("simple-input");
        $view->setLabel("Write something here (min 5 chars):");
        $view->setRequired(true);
        $view->setMinLength(5);

        $view->on("input", function() use($view){

            $when  = new WhenHandler();
            $when->when(function($case) use($view){
                $case->isPositive(CustomParam::get($view)->isValidated());//when input is validated
            }, $this)
                ->then(function(){
                    $action = new ActionHandler("simple-button");
                    $action->disable(false);
                    $action->setText("OK. You now can click here!");
                    $action->addClass("btn-success");
                    $action->removeClass("btn-danger");
                    return $action;
                }, $this)
                ->fail(function(){
                    $action = new ActionHandler("simple-button");
                    $action->disable(true);
                    $action->addClass("btn-danger");
                    $action->removeClass("btn-success");
                    $action->setText("Invalidated");
                    return $action;
                }, $this);

            return $when;
        }, $this);

        return $view;
    }

    /**
     * @return ButtonComponent
     */
    public function getButtonView(){
        $view = new ButtonComponent("simple-button");
        $view->setText("Invalidated");
        $view->addClass("btn-danger");
        $view->disable(true);

        $view->on("click", function(){
            $request = new RequestHandler("/demo/events/echo/");
            $request->addPost("message", CustomParam::get("simple-input")->getValue());
            return $request;
        }, $this);

        return $view;
    }

    /**
     * @Route("/demo/events/echo/")
     * @Method("POST")
     */
    public function echoAction(Request $request)
    {

        $message = $request->get("message");
        $view = $this->getResponseView($message);

        /**
         * Display message
         */
        $this->response->addHandler(function() use($view){
            $action = new ActionHandler("simple-html-view");
            $action->addItem(new HtmlComponentItem(".message", $view));
            return $action;
        });

        /**
         * And change label of input
         */
        $this->response->addHandler(function() use($view){
            $action = new ActionHandler("simple-button");
            $action->setText("Successfull send!");
            $action->disable(true);
            return $action;
        });



        return $this->response;
    }

    public function getResponseView($message){
        $message = htmlspecialchars($message);
        $view = new HtmlComponent();
        $view->setHTML("<div class='alert alert-success mt10px' >
            <strong>Well done!</strong> You send me <strong>{$message}</strong>
        </div>");
        return $view;
    }
}