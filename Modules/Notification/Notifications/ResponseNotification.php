<?php

namespace Modules\Notification\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ResponseNotification extends Notification
{
    use Queueable;

    private $title;
    private $description;
    private $response;

    /**
     * ResponseNotification constructor.
     * @param $title
     * @param $description
     * @param $response
     */
    public function __construct($title , $description, $response)
    {
        $this->title = $title;
        $this->description = $description;
        $this->response = $response;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'title'       => $this->title,
            'description' => $this->description,
            'type'        => 'response',
            'response_id'        => $this->response->id,
        ];
    }
}
