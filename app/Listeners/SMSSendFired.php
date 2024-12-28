<?php

namespace App\Listeners;

use App\Events\SMSSendEvent;
use App\Libraries\SMSIR;

class SMSSendFired
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  SMSSendEvent  $event
     *
     * @return void
     */
    public function handle(SMSSendEvent $event)
    {
//        TODO get from config or env
        $templateId = 136895;

        SMSIR::send($event->phone, $event->otp);
    }
}
