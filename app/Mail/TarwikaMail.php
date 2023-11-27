<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;

class TarwikaMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function envelope()
    {
        // from, to, cc, bcc, replyTo, subject, tags, metadata, using
        return new Envelope(
            new Address($this->data['address'], $this->data['name']),
            $this->data['to'],
            null,
            null,
            null,
            $this->data['subject']
        );
    }

    public function content()
    {
        return new Content(
            null,
            null,
            null,
            'emails.tarwikaMail',
            [
                'content' => $this->data['content'],
            ]
        );
    }

    public function attachments()
    {
        return [];
    }
}
