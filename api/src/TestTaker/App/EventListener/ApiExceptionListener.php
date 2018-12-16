<?php

namespace App\TestTaker\App\EventListener;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\Validator\Exception\ValidatorException;

/**
 * Class ApiExceptionListener
 * @package App\TestTaker\App\EventListener
 */
class ApiExceptionListener
{
    /** @var bool  */
    public $isKernelDebug;

    /**
     * ApiExceptionListener constructor.
     * @param bool $isKernelDebug
     */
    public function __construct(bool $isKernelDebug)
    {
        $this->isKernelDebug = $isKernelDebug;
    }

    /**
     * @param GetResponseForExceptionEvent $event
     */
    public function onKernelException(GetResponseForExceptionEvent $event): void
    {
        $throwedException = $event->getException();

        $errorBody = [
            'code'    => $throwedException->getCode(),
            'message' => $throwedException->getMessage(),
        ];

        if ($throwedException instanceof ValidatorException) {
            $errorBody['message'] = 'Invalid data has been sent';
        }

        if ($this->isKernelDebug) {
            $errorBody['exception'] = [
                'class'   => get_class($throwedException)
            ];
            $errorBody['trace'] = $throwedException->getTrace();
        }

        $event->setResponse(new JsonResponse(['success' => false, 'error' => $errorBody]));
    }
}
