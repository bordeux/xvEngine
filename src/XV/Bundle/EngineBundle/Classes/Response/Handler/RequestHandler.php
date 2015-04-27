<?php

namespace XV\Bundle\EngineBundle\Classes\Response\Handler;

use XV\Bundle\EngineBundle\Classes\Response\Handler\AbstractHandler;




class RequestHandler extends AbstractHandler {

    /**
     * 
     * @var string
     */
    public $name = "request";

    
    /**
     *
     * @var string 
     */
    private $url;
    
    /**
     *
     * @var mixed[string] 
     */
    private $post = [];
    
    /**
     *
     * @var mixed[string]
     */
    private $get = [];
    
    
    /**
     *
     * @var mixed[string] 
     */
    private $headers = [];
    
    /**
     *
     * @var mixed[string] 
     */
    private $file = [];
    
    
    /**
     *
     * @var mixed[] 
     */
    private $options = [];


    private $params = [];


    /**
     * 
     * @param string $url
     */
    public function __construct($url = "") {
        $this->setURL($url);
    }
    
    
    /**
     * 
     * @param string $url
     * @return RequestHandler
     */
    public function setURL($url){
        $this->url = $url;
        return $this;
    }
    
    
    /**
     * 
     * @param string $key
     * @param mixed $value
     * @return boolean
     */
    public function addPost($key, $value){
        $this->post[$key] = $value;
        
        return true;
    }

    /**
     *
     * @param string $key
     * @param mixed $value
     * @return boolean
     */
    public function addParam($key, $value){
        $this->params[$key] = $value;

        return true;
    }
    
    
    /**
     * 
     * @param string $key
     * @param mixed $value
     * @return RequestHandler
     */
    public function addGet($key, $value){
        $this->get[$key] = $value;
        
        return $this;
    }
    
    
    /**
     * 
     * @param string $key
     * @param mixed $value
     * @return RequestHandler
     */
    public function addFile($key, $value){
        $this->file[$key] = $value;
        return $this;
    }
    
    
    
    /**
     * 
     * @param string $key
     * @param mixed $value
     * @return RequestHandler
     */
    public function addHeader($key, $value){
        $this->headers[$key] = $value;
        return $this;
    }

    
    
    /**
     * 
     * @param string $key
     * @param mixed $value
     */
    public function setOption($key, $value){
        $this->options[$key] = $value;
    }
    
    
    /**
     * 
     * @return mixed[]
     */
    public function jsonSerialize() {
        return array(
            "name" => $this->name,
            "url" => $this->url,
            "post" => $this->post,
            "get" => $this->get,
            "files" => $this->file,
            "params" => $this->params,
            "headers" => $this->headers,
            "options" => $this->options
        );
    }

}
