<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Models\Posts;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;

class CreateSitemap extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $posts = Posts::active()->get();
        $fh = fopen(public_path('sitemap.xml'), 'w');
        fwrite($fh, view('files.sitemap', compact('posts'))->render());
        fclose($fh);
    }
}