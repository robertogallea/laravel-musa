<?php

namespace App\Notifications;

use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TestNotification extends Notification implements ShouldQueue, ShouldBroadcast
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public Post $post)
    {

    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database', 'broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Nuovo post pubblicato')
            ->greeting('Ciao ' . $notifiable->name)
            ->line('E\' stato pubblicato un nuovo post!')
            ->line($this->post->title)
            ->action('Leggi il post', route('posts.show', $this->post))
            ->line('Buona lettura!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
//        il metodo to array viene usato per i canali database e broadcast
//        a meno di non volere differenziare la notifica sui due canali (vedi sotto)
        return [
            'post_id' => $this->id,
            'text' => $this->post->title,
            'url' => route('posts.show', $this->post),
            'metadata' => []
        ];
    }

    public function withDelay(object $notifiable)
    {
        return [
            'mail' => now()->addHour(),
            'database' => now(),
            'slack' => now()->addSeconds(15)
        ];
    }

    // notifica specifica per il canale database
//    public function toDatabase(object $notifiable): array
//    {
//        return [
//            //
//        ];
//    }

    // notifica specifica per il canale broadcast
//    public function toBroadcast(object $notifiable): array
//    {
//        return [
//            //
//        ];
//    }
}
