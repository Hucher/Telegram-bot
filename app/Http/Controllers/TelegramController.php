<?php

namespace App\Http\Controllers;

use App\Anecdote;
use App\Information;
use App\Parser;
use App\Picture;
use App\TelegramUser;
use App\User;
use function GuzzleHttp\Promise\all;
use Illuminate\Http\Request;
use Telegram\Bot\Laravel\Facades\Telegram;
use Symfony\Component\DomCrawler\Crawler;
use Clue\React\Buzz\Browser;
use React\EventLoop\Factory;


class TelegramController extends Controller
{
    public function index(Request $request)
    {
        $data = $request->all();

        if ($data['message']['text'] == '/start') {
            $this->createUser($data);
        }
        if ($data['message']['text'] == '/send') {
            $this->sendMessage($data);
        }
        if ($data['message']['text'] == '/delete') {
            $this->delete($data);
        }
        if ($data['message']['text'] == '/help') {
            Telegram::commandsHandler(true);
        }

//        if ($data['message']['text'] == '/test') {
//            logger(Telegram::getWebhookUpdates()['update_id']);
//        }
        if ($data['message']['text'] == 'Gif') {
            $this->getGif($data);
        }
        if ($data['message']['text'] == 'MMA') {
            $this->getNewsMMA($data);
        }
        if ($data['message']['text'] == 'Football') {
            $this->getNewsFootball($data);
        }
    }

    public function createUser($data)
    {
        Telegram::commandsHandler(true);
        $user = TelegramUser::where('chat_id', $data['message']['chat']['id'])->firstOrCreate([
            'chat_id' => $data['message']['chat']['id'],
            'is_bot' => $data['message']['from']['is_bot'],
            'first_name' => $data['message']['from']['first_name'],
            'last_name' => $data['message']['from']['last_name'],
            'user_name' => '',
            'language_code' => $data['message']['from']['language_code']
        ]);
        $user->messages()->create([
            'text' => $data['message']['text']
        ]);

    }

    public function sendMessage($data)
    {
        $user = TelegramUser::where('chat_id', $data['message']['from']['id'])->first();

        $messages = $user->messages()->get();

        $text = '';
        foreach ($messages as $message) {
            $response = Telegram::sendMessage([
                'chat_id' => $data['message']['from']['id'],
                'text' => 'You messages: ' . $message->text,
            ]);
        }

    }

    public function webhook()
    {
        $updates = Telegram::getWebhookUpdates()['message'];
//        logger($updates);
        if (!TelegramUser::find($updates['from']['id'])) {
            TelegramUser::create(json_decode($updates['from'], true));
        }
        Telegram::commandsHandler(true);
    }

    public function delete($data)
    {
        $user = TelegramUser::where('chat_id', $data['message']['from']['id'])->first();
        $messages = $user->messages();

        $response = Telegram::sendMessage([
            'chat_id' => $data['message']['from']['id'],
            'text' => 'Deletes ' . $messages->count() . ' messages'
        ]);

        $messages->delete();
    }

    public function getGif($data)
    {
        $gifs = Picture::all();
        foreach ($gifs as $gif) {
            $response = Telegram:: sendVideo([
                'chat_id' => $data['message']['from']['id'],
                'video' => $gif->url
            ]);
        }
    }

    public function getNewsFootball($data)
    {
        $articles = Information::all();
        foreach ($articles as $article) {
            $response = Telegram:: sendMessage([
                'chat_id' => $data['message']['from']['id'],
                'text' => $article->img . "\n" . $article->title . "\n" . $article->news . "\n" . 'Подробнее:'.$article->info
            ]);
        }
    }

    public function getNewsMMA($data)
    {
        $informations = Parser::all();
        foreach ($informations as $information) {
//            $photo = Telegram :: sendPhoto ([
//                'chat_id' => $data['message']['from']['id'],
//                'photo' => $information->img,
//            ]);
            $response = Telegram:: sendMessage([
                'chat_id' => $data['message']['from']['id'],
                'text' => $information->img . "\n" . $information->title . "\n" . $information->news . "\n" . 'Подробнее:'.$information->info
            ]);
        }
    }
}

