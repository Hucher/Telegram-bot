<?php

namespace App\Console\Commands;

use App\Jobs\ParseFootball;
use App\Jobs\ParseProcess;
use App\Parser;
use Illuminate\Console\Command;
use Symfony\Component\DomCrawler\Crawler;

class ParseNews extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parse:news';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parsing news';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $html = file_get_contents('https://ringside24.com/ru/mma/');
        $crawler = new Crawler(null, $html);
        $crawler->addHtmlContent($html, 'UTF-8');
        $arr = [];
        $articles = $crawler->filter('body > div.site-wrap.site-body > div.container-fluid > div > section > div.post-list-wr > div.post-list')->each(function (Crawler $node)
        {
            return $node;
        });

        foreach ($articles as $key => $news)
        {
            $img = 'https://ringside24.com' . $news->filter('div.post-list__left > a > img')->attr('src');
            $title = $news->filter('div.post-list__right > div.h3 > a')->text();
            $text = $news->filter('div.post-list__right > p')->text();
            $info = 'https://ringside24.com' . $news->filter('div.post-list__right > div.post-list__more > a')->attr('href');
            $arr[$key]['img'] = $img;
            $arr[$key]['title'] = $title;
            $arr[$key]['news'] = $text;
            $arr[$key]['info'] = $info;
        }

        $site = file_get_contents('https://www.sports.ru/football/');
        $crawler = new Crawler(null , $site);
        $crawler->addHtmlContent($site, 'UTF-8');
        $football = [];
        $allNews = $crawler->filter('body > #branding-layout > div.page-layout > div.content-wrapper > div > div > div > main > article')->each(function (Crawler $node)
        {
            return $node;
        });
        foreach ($allNews as $key => $news)
        {

            $img = $news->filter('article > a > img')->attr('data-lazy-normal');
            $title = $news->filter('h2 > a')->text();
            $text = $news->filter('p')->text();
            $info = 'https://sport.ua' . $news->filter('h2 > a')->attr('href');
            $football[$key]['img'] = $img;
            $football[$key]['title'] = $title;
            $football[$key]['news'] = $text;
            $football[$key]['info'] = $info;
        }
        logger($arr);
        ParseProcess::withChain([
            new ParseFootball($football)
        ])->dispatch($arr);

////        ParseProcess::dispatch($arr);
//        ParseFootball::dispatch($football);

    }
}














