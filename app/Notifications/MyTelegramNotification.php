<?php

namespace App\Notifications;

use App\Models\JiraIssue;
use Illuminate\Notifications\Notification;
use WeStacks\TeleBot\Laravel\TelegramNotification;

class MyTelegramNotification extends Notification
{

    /**
     * @var JiraIssue
     */
    private $issue;
    /**
     * @var string
     */
    private $message_body;
    /**
     * @var string
     */
    private $message_header;

    public function __construct(JiraIssue $issue, string $message_header = '', string $message_body = '')
    {
        $this->issue = $issue;
        $this->message_header = $message_header;
        $this->message_body = $message_body;
    }

    public function via($notifiable)
    {
        return ['telegram'];
    }

    private function getInlineKeyBoard($data)
    {
        $inlineKeyboard = array(
            "inline_keyboard" => $data,
        );
        return json_encode($inlineKeyboard);
    }

    private function getKeyBoard($data)
    {
        $keyboard = array(
            "keyboard" => $data,
            "one_time_keyboard" => false,
            "resize_keyboard" => true
        );
        return json_encode($keyboard);
    }

    public function toTelegram($notifiable)
    {
        if (!$notifiable->chat_id) {
            $notifiable->chat_id = env('TELEGRAM_DEFAULT_CHAT_ID');
        }
        // $this->issue->update(['event_processed'=>$this->issue->event_created]);
        JiraIssue::query()->where('id', '=', $this->issue->id)->update([
            'event_processed' => $this->issue->event_created
        ]);

        $keyboard = array(
            array(
                array('text' => ':like:', 'callback_data' => '{"action":"like","count":0,"text":":like:"}'),
                array('text' => ':joy:', 'callback_data' => '{"action":"joy","count":0,"text":":joy:"}'),
                array('text' => ':hushed:', 'callback_data' => '{"action":"hushed","count":0,"text":":hushed:"}'),
                array('text' => ':cry:', 'callback_data' => '{"action":"cry","count":0,"text":":cry:"}'),
                array('text' => ':rage:', 'callback_data' => '{"action":"rage","count":0,"text":":rage:"}')
            )
        );

        return (new TelegramNotification)->bot('bot')
            ->sendMessage([
                'parse_mode' => 'HTML',
                'disable_web_page_preview' => true,
                //'reply_markup' => json_encode(array('inline_keyboard' => $keyboard)),
                'chat_id' => $notifiable->chat_id,
                'text' => view('telegram.notification', [
                    'issue' => $this->issue,
                    'message_header' => $this->message_header,
                    'message_body' => $this->message_body
                ])->render()]);
    }
}
