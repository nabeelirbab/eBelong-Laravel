<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\SitemapGenerator;
use Spatie\Sitemap\Tags\Url;
use App\Category;
use App\Skill;

class SitemapCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:sitemap';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generating Sitemap every day';

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
        // log('generating Sitemap');
        $path = public_path();
        $file = '/sitemap.xml';
        $sitemap = SitemapGenerator::create(env('APP_URL'))
        ->getSitemap();
        Category::all()->each(function (Category $Item) use ($sitemap) {
            $sitemap->add(Url::create("/hire/{$Item->slug}"));
        });
        Skill::all()->each(function (Skill $Item) use ($sitemap) {
            $sitemap->add(Url::create("/hire/{$Item->slug}"));
        });
        $sitemap->add(Url::create('/hire'))
        ->writeToFile($path.$file);
        
    }
}
