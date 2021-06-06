<?php

namespace App\Listeners;

use App\Events\MessageCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Http\Controllers\NodeJSController;


class MessageCreatedListener
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
     * @param  MessageCreated  $event
     * @return void
     */
    public function handle(MessageCreated $event)
    {
    
        if($event->message->type == 'mu') NodeJSController::post('message_mu',['report_message'=>$event->message->ToArray()]);
        if($event->message->type == 'ma') NodeJSController::post('message_am',['report_message'=>$event->message->ToArray()]);
           
    }
}
