<?php

namespace App\Notifications\Confirmation;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use NotificationChannels\Twilio\TwilioChannel;
use NotificationChannels\Twilio\TwilioSmsMessage;

class SMSNotification extends Notification
{
    use Queueable;

    protected string $code;

    /**
     * Create a new notification instance.
     */
    public function __construct($code)
    {
        $this->code = $code;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return [TwilioChannel::class];
    }

    /**
     * Get the sms representation of the notification.
     */
    public function toTwilio($notifiable): TwilioSmsMessage|\NotificationChannels\Twilio\TwilioMessage
    {
        return (new TwilioSmsMessage())->content("Your confirmation code is: {$this->code}");
    }

}
