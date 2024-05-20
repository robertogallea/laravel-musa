<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TestMailWithAttachment extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Test Mail With Attachment',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.test-with-attachment',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [
            // fromPath legge l'allegato da un percorso assoluto
            Attachment::fromPath('C:\Users\Roberto Gallea\Downloads\test.txt')
                ->as('allegato.txt')->withMime('text/plain'),
            // fromStorage legge l'allegato da un percorso relativo rispetto allo storage predefinito
            Attachment::fromStorage('public/test.txt')
                ->as('allegato2.txt'),
            // fromStorage legge l'allegato da un percorso relativo rispetto allo storage specificato (es. s3)
//            Attachment::fromStorageDisk('s3', '/path/file.txt')
        ];
    }
}
