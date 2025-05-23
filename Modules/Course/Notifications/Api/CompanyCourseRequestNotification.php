<?php

namespace Modules\Course\Notifications\Api;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class CompanyCourseRequestNotification extends Notification
{
    use Queueable;


    public $request;
    public $courseUser;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($request,$courseUser)
    {
        $this->request = $request;
        $this->courseUser = $courseUser;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
               ->subject(__('course::api.new_request.mail.subject'))
               ->markdown('course::api.emails.course-request', [ 'request' => $this->request , 'courseUser' => $this->courseUser]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
