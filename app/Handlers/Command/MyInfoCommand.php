<?php

namespace App\Handlers\Command;

use App\Models\Subscriber;
use WeStacks\TeleBot\Handlers\CommandHandler;

class MyInfoCommand extends BaseCommand
{
    protected static $aliases = [ '/myInfo'];
    protected static $description = 'Инфо обо мне';

    public function handle()
    {
        parent::handle();

        $this->sendMessage([
            'text' => 'ФИО: '.$this->sub->fio."\r\n".
                'Команда: '.$this->sub->team->first()->name."\r\n".
                'Должность: '.$this->sub->position->first()->name."\r\n".
                'Проекты: '.implode(',',$this->sub->team->project)."\r\n"
        ]);
        return true;
    }
}
