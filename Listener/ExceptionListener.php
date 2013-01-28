<?php

/**
 * This file is part of the desarrolla2 proyect.
 * 
 * Copyright (c)
 * Daniel González Cerviño <daniel.gonzalez@ideup.com> 
 * 
 * This source file is subject to the MIT license that is bundled
 * with this package in the file LICENSE.
 */

namespace Desarrolla2\Bundle\BlogBundle\Listener;

use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Bundle\FrameworkBundle\HttpKernel;
use Swift_Mailer;

/**
 * 
 * Description of ErrorListener
 *
 * @author : Daniel González Cerviño <daniel.gonzalez@ideup.com> 
 * @file : ErrorListener.php , UTF-8
 * @date : Oct 16, 2012 , 5:58:31 PM
 */
class ExceptionListener
{

    protected $mailer;

    protected $from;

    protected $to;

    protected $subject;

    public function __construct(Swift_Mailer $mailer, $from, $to, $subject)
    {
        $this->mailer = $mailer;
        $this->from = $from;
        $this->to = $to;
        $this->subject = $subject;
    }

    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        if (HttpKernel::MASTER_REQUEST != $event->getRequestType()) {
            return;
        }
        $exception = $event->getException();
        if (get_class($exception) != 'Symfony\Component\HttpKernel\Exception\NotFoundHttpException') {
            $message =
                    'route : http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . PHP_EOL .
                    'message        : ' . $exception->getMessage() . PHP_EOL .
                    'code           : ' . $exception->getCode() . PHP_EOL .
                    'trace          : ' . $exception->getTraceAsString() . PHP_EOL .
                    'previous       : ' . $exception->getPrevious() . PHP_EOL .
                    'file           : ' . $exception->getFile() . PHP_EOL .
                    'line           : ' . $exception->getLine() . PHP_EOL .
                    'GET            : ' . PHP_EOL . print_r($_GET, true) . PHP_EOL .
                    'POST           : ' . PHP_EOL . print_r($_POST, true) . PHP_EOL .
                    'SERVER         : ' . PHP_EOL . print_r($_SERVER, true) . PHP_EOL;

            $message = \Swift_Message::newInstance()
                    ->setSubject($this->subject . ' ' . $exception->getMessage())
                    ->setFrom($this->from)
                    ->setTo($this->to)
                    ->setBody($message)
            ;
            $this->mailer->send($message);
        }
    }

}
