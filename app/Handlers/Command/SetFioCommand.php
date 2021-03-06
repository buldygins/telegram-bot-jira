<?php

namespace App\Handlers\Command;

use App\Models\Position;
use App\Models\Subscriber;
use Illuminate\Support\Facades\DB;
use WeStacks\TeleBot\Handlers\CommandHandler;

class SetFioCommand extends BaseCommand
{
    public static $aliases = ['/set_my_name'];
    protected static $description = 'Задать ФИО';

    public function answerFio($text)
    {
        parent::handle();

        $this->sub->fio = trim($text);
        $this->sub->waited_command = null;
        $this->sub->save();

        $this->sendMessage([
            'text' => 'Ваше ФИО записано',
        ]);
    }

    public function handle()
    {
        parent::handle();

        $this->sub->waited_command = get_class($this) . '::answerFio';
        $this->sub->save();

        $this->sendMessage([
            'text' => "Задайте свои ФИО",
            'chat_id' => $this->update->message->chat->id,
        ]);
        return true;
    }
}
