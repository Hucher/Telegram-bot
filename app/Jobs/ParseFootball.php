<?php

namespace App\Jobs;

use App\Information;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ParseFootball implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $football;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($football)
    {
        $this->football = $football;
    }
    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->football as $news)
        {
            $parser =  Information::where('title' , $news['title'])->firstOrNew([
                'title' => $news['title'],
                'news' => $news['news'],
                'img' => $news['img'],
                'info' => $news['info']
            ]);
            $parser->save();
        }
    }
}
