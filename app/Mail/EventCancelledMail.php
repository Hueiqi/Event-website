<?php

namespace App\Mail;

use App\Models\Event;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EventCancelledMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Event $event)
    {
    }

    public function build()
    {
        return $this->subject('Event Cancelled — ' . $this->event->title)
            ->view('mail.event-cancelled');
    }
}
