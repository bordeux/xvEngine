<?php

namespace XV\Bundle\EngineBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class BootstrapController extends Controller
{
    /**
     *
     * Bootstrap layout
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $params = array(
            'bootstrapConfig' => $this->getBootstrapConfig(),
            'js' => $this->getJavasScripts(),
            'css' => $this->getCSS()
        );

        $response = $this->render('@XVEngine/Default/index.html.twig', $params);



        $response->setPrivate();
        $response->setMaxAge(0);
        $response->setSharedMaxAge(0);
        $response->headers->addCacheControlDirective('no-cache', true);
        $response->headers->addCacheControlDirective('max-age', 0);
        $response->headers->addCacheControlDirective('must-revalidate', true);
        $response->headers->addCacheControlDirective('no-store', true);

        return $response;
    }


    /**
     *
     * @param string $file
     * @return string
     */
    public function getStaticFileURL($file){
        $webRoot = $this->get('kernel')->getRootDir().'/../web';
        return $file.'?_='.(filemtime($webRoot.$file));
    }

    /**
     *
     * @return string[]
     */
    public function getJavasScripts(){
        $result = [];
        $result[] = $this->getStaticFileURL('/js/vendor.js');
        $result[] = $this->getStaticFileURL('/js/application.js');

        /* @var $request Request */
        $request = $this->container->get('request');
        $result[] = "http://localhost:35729/livereload.js";
        $result[] = "http://localhost:8080/target/target-script-min.js#anonymous";
        $result[] = "//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js";
        return $result;
    }


    /**
     * Bootstrap config
     * @return string[]
     */
    public function getBootstrapConfig(){
        $config = [];
        $config['services'] = $this->getServicesBootstrap();
        return $config;
    }

    /**
     * Configurations for services
     * @return array
     */
    public function getServicesBootstrap(){
        $result = [];
        //$result['server']['uploader']['setRequestURL'] = ["/file/upload/"];
        //$result['unity']['player']['setUnityObjectUrl'] = ["/unity/unity.unity3d"];
        return $result;
    }

    /**
     * Css to load in bootstrap
     * @return string[]
     */
    public function getCSS(){
        $result = [];
        $result[] = '//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css';
        $result[] = $this->getStaticFileURL('/css/style.css');
        return $result;
    }
}
