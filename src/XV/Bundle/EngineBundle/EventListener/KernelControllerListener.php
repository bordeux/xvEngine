<?php

namespace XV\Bundle\EngineBundle\EventListener;

use JMS\DiExtraBundle\Annotation\Inject;
use JMS\DiExtraBundle\Annotation\InjectParams;
use JMS\DiExtraBundle\Annotation\Observe;
use JMS\DiExtraBundle\Annotation\Service;
use Symfony\Component\HttpKernel\Controller\ControllerResolverInterface;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * @Service
 */
class KernelControllerListener {

    /**
     * @var ControllerResolverInterface
     */
    private $controllerResolver;
    
    /**
     * 
     * @param ControllerResolverInterface $controllerResolver
     *  @InjectParams({
     *     "em" = @Inject("controller_resolver")
     * })
     */
    public function __construct( ControllerResolverInterface $controllerResolver) {
       $this->controllerResolver = $controllerResolver;
    }

    public function startsWith($haystack, $needle) {
        // search backwards starting from haystack length characters from the end
        return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== FALSE;
    }


    /**
     * @param FilterControllerEvent $event
     * @Observe(KernelEvents::CONTROLLER)
     */
    public function onKernelController(FilterControllerEvent $event) {
        $request = $event->getRequest();
        $isXVRequest = (int) $request->headers->get('X-XV-Request', 0);


        if ($isXVRequest) {
            return;
        }
        
        $routeName =  $request->get('_route');



        if(!$this->startsWith($routeName, "xv")){
            return;
        }


        if($request->get('rawResponse')){
            return;
        }
      
    
        $request->attributes->set( '_controller', 'XV\Bundle\EngineBundle\Controller\BootstrapController::indexAction' );
        $event->setController($this->controllerResolver->getController( $request ));
    }

}
