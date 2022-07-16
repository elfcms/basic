<?php

namespace Elfcms\Basic\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class EmailEventSend extends Mailable
{
    use Queueable, SerializesModels;

    public  $emailEvent;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($emailEvent)
    {
        $this->emailEvent = $emailEvent;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $fields = $this->emailEvent->fields();

        if(!empty($fields['from']) && !empty($fields['from']->email)) {
            $this->from($fields['from']->email,$fields['from']->name);
        }
        if(!empty($fields['cc']) && !empty($fields['cc']->email)) {
            $this->cc($fields['cc']->email,$fields['cc']->name);
        }
        if(!empty($fields['bcc']) && !empty($fields['bcc']->email)) {
            $this->bcc($fields['bcc']->email,$fields['bcc']->name);
        }
        if(!empty($fields['bcc']) && !empty($fields['bcc']->email)) {
            $this->bcc($fields['bcc']->email,$fields['bcc']->name);
        }
        if(!empty($fields['to']) && !empty($fields['to']->email)) {
            $this->to($fields['to']->email,$fields['to']->name);
        }
        $this->subject($this->emailEvent->subject);
        if(!empty($this->emailEvent->attach) && file_exists($this->emailEvent->attach)) {
            $this->attach($this->emailEvent->attach);
        }
        elseif (!empty($this->emailEvent->attachData) && !empty($this->emailEvent->attachData->data) && !empty($this->emailEvent->attachData->name) && isset($this->emailEvent->attachData->option)) {
            $this->attachData($this->emailEvent->attachData->data,$this->emailEvent->attachData->name,$this->emailEvent->attachData->option);
        }

        return $this->view('basic::emails.events.default',['text'=>$this->emailEvent->text, 'params'=>$this->emailEvent->params]);
    }
}
