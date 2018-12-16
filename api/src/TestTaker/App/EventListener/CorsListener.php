<?php

namespace App\TestTaker\App\EventListener;


use Symfony\Component\HttpKernel\Event\FilterResponseEvent;

/**
 * Class CorsListener
 * @package App\TestTaker\App\EventListener
 */
class CorsListener
{
    /**
     * @param FilterResponseEvent $event
     */
    public function onKernelResponse(FilterResponseEvent $event)
    {
        $responseHeaders = $event->getResponse()->headers;
        $responseHeaders->set('Access-Control-Allow-Headers', 'origin, content-type, accept');
        $responseHeaders->set('Access-Control-Allow-Origin', '*');
        $responseHeaders->set('Access-Control-Allow-Methods', 'GET');
    }
}