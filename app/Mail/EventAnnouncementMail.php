<?php

namespace App\Mail;

use App\Models\Event;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EventAnnouncementMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Event $event, public string $message)
    {
    }

    public function build()
    {
        return $this->subject('Announcement — ' . $this->event->title)
            ->view('mail.event-announcement');
    }
}
