<?php

namespace App\Mail;

use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TestMailWithData extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    public $post;
    // tutte le proprietà pubbliche del mailable sono visibili alla view

    /**
     * Create a new message instance.
     */
    public function __construct($data, Post $post)
    {
        $this->data = $data;
        $this->post = $post;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Test Mail With Data',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
//        $post = Post::orderBy('id', 'desc')->first();
// Posso passare alla vista dati aggiuntivi usando il parametro 'with'
        return new Content(
            view: 'mail.test-with-data',
            text: 'mail.test-with-data-text',
//            with: ['post' => $post]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
