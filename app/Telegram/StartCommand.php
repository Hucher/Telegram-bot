<?php
/**
 * Created by PhpStorm.
 * User: PHP
 * Date: 09.07.2018
 * Time: 18:48
 */

namespace App\Telegram;

use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;
use Telegram\Bot\Laravel\Facades\Telegram;

class StartCommand extends Command
{
    protected $name = 'start';
    protected $description = 'start command';
    public function handle($arguments)
    {
        $this->replyWithChatAction(['action' => Actions::TYPING]);
        $telegram_user = Telegram::getWebhookUpdates()['message'];
        $text = sprintf('%s - %s' . PHP_EOL, 'Ваш номер чата' , $telegram_user['from']['id']);

        $keyboard = [
            ['Football'],
            ['MMA'],
            ['Gif']];

        $reply_markup = Telegram::replyKeyboardMarkup([
            'keyboard' => $keyboard,
            'resize_keyboard' => true,
            'one_time_keyboard' => true
        ]);

        $response = Telegram::sendMessage([
            'chat_id' => $telegram_user['from']['id'],
            'text' => 'Hello World',
            'reply_markup' => $reply_markup
        ]);
    }
}