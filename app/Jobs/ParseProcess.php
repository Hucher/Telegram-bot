<?php

namespace App\Jobs;

use App\Parser;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ParseProcess implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $arr;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($arr)
    {
        $this->arr = $arr;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->arr as $news)
        {
            $parser = Parser::where('title', $news['title'])->firstOrNew([
                'img' => $news['img'],
                'title' => $news['title'],
                'news' => $news['news'],
                'info' => $news['info']
            ]);
            $parser->save();
        }
    }
}
