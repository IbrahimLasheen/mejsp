<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResearchDelete extends Notification
{
    use Queueable;
    private $requestData;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($requestData)
    {
        $this->requestData = $requestData;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
   

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'id' => $this->requestData['id'],
            'user_id' => $this->requestData['user_id'],
            'user_name' => $this->requestData['user_name'],
            'type' => $this->requestData['type'],
            'body' => $this->requestData['body'],
        ];
    }
    public function toDatabase($notifiable)     //The function to database. As mentioned in the via method.
    {
        return [
            'id' => $this->requestData['id'],
            'user_id' => $this->requestData['user_id'],
            'user_name' => $this->requestData['user_name'],
            'type' => $this->requestData['type'],
            'body' => $this->requestData['body'],
        ];
    }
}