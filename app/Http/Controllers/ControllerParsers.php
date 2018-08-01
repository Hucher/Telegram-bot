<?php

namespace App\Http\Controllers;
use App\Jobs;
use Illuminate\Http\Request;
use Symfony\Component\DomCrawler\Crawler;

class ControllerParsers extends Controller
{
//    public function getContent()
//    {
//        $html = file_get_contents('http://allboxing.ru/mma-news.html');
//        $crawler = new Crawler($html);
//        $allNews = $crawler->filter( '#block-system-main > div > div > div.view-content.red-border-block.news-list-view > div > ul > li')->each(function (Crawler $node) {
//            return $node;
//        });
//        $arr = [];
//        $i = 0;
//        foreach ($allNews as $news) {
//            $img = $news->filter('section > div > div.teaser-img > div > div > div > a > img')->attr('src');
//            $title = $news->filter('h2 > a')->text();
//            $text = $news->filter('section > div > div.teaser-content > div.field.field-name-body.field-type-text-with-summary.field-label-hidden > div > div > div > div > div > p')->text();
//            $arr[$i]['img'] = $img;
//            $arr[$i]['title'] = $title;
//            $arr[$i]['news'] = $text;
//            $i++;
//        }
//        Jobs\ParseProcess::dispatch($arr);
//    }
}