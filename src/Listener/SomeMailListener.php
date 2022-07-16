<?php

namespace Elfcms\Basic\Listeners;

use Elfcms\Basic\Models\EmailEvent;
use Elfcms\Basic\Events\SomeMailEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SomeMailListener
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
     * @param  \App\Events\SomeMailEvent  $event
     * @return void
     */
    public function handle(SomeMailEvent $event)
    {
        Log::info('SomeMailEvent: ' . $event->eventCode);

        $emailEvent = EmailEvent ::where('code',$event->eventCode)->first();

        if (!empty($event->eventProps['text'])) {
            $emailEvent->text = $event->eventProps['text'];
        }

        if (!empty($event->eventProps['subject'])) {
            $emailEvent->subject = $event->eventProps['subject'];
        }

        if (!empty($event->eventProps['attach'])) {
            $emailEvent->attach = $event->eventProps['attach'];
        }

        if (!empty($event->eventProps['params'])) {
            $emailEvent->params = $event->eventProps['params'];
        }

        Mail::send(new \Elfcms\Basic\Mail\EmailEventSend($emailEvent));
    }
}
