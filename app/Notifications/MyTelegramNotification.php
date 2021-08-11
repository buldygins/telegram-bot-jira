<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use WeStacks\TeleBot\Laravel\TelegramNotification;

class MyTelegramNotification extends Notification
{
    public function via($notifiable)
    {
        return ['telegram'];
    }

    public function toTelegram($notifiable)
    {
        $notifiable->telegram_chat_id=env('TELEGRAM_DEFAULT_CHAT_ID');
        return (new TelegramNotification)->bot('bot')
            ->sendMessage([
                'chat_id' => $notifiable->telegram_chat_id,
                'text'    => $notifiable->issue_url."\r\n".$notifiable->webhookEvent."\r\n".$notifiable->summary,
            ]);
    }
}
