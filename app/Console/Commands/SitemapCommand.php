<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Http\Request;
use App\Helper;
use Carbon\Carbon;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\SitemapGenerator;
use Spatie\Sitemap\Tags\Url;
use App\Category;
use App\Skill;
use App\Blog;
use App\User;
use App\Service;
use App\Cource;
use App\Job;

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
        $sitemap = Sitemap::create(); 
        $sitemap->add(Url::create("/hire"));
        $sitemap->add(Url::create("/blogs"));
        $sitemap->add(Url::create("/courses"));
        $sitemap->add(Url::create("/"));
        $sitemap->add(Url::create("/jobs"));
        $sitemap->add(Url::create("/services"));
        Category::all()->each(function (Category $Item) use ($sitemap) {
            $sitemap->add(Url::create("/hire/{$Item->slug}"));
        });
        Skill::all()->each(function (Skill $Item) use ($sitemap) {
            if($Item->title=='E-Commerce'||$Item->title=='Cloud Computing'||$Item->title=='Data Science'||
            $Item->title=='Graphic Designing'||$Item->title=='Artificial Intelligence'||$Item->title=='Growth Hacking'){
                
            }
            else{
            $sitemap->add(Url::create("/hire/{$Item->slug}"));
            }
        });
        User::all()->each(function (User $Item) use ($sitemap) {
            $sitemap->add(Url::create("/profile/{$Item->slug}"));
        });
        Category::all()->each(function (Category $Item) use ($sitemap) {
            $sitemap->add(Url::create("/services/{$Item->slug}"));
        });
        Skill::all()->each(function (Skill $Item) use ($sitemap) {
            if($Item->title=='E-Commerce'||$Item->title=='Cloud Computing'||$Item->title=='Data Science'||
            $Item->title=='Graphic Designing'||$Item->title=='Artificial Intelligence'||$Item->title=='Growth Hacking'){
                
            }
            else{
            $sitemap->add(Url::create("/services/{$Item->slug}"));
            }
        });
        Service::all()->each(function (Service $Item) use ($sitemap) {
            $sitemap->add(Url::create("/service/{$Item->slug}"));
        });
        Category::all()->each(function (Category $Item) use ($sitemap) {
            $sitemap->add(Url::create("/jobs/{$Item->slug}"));
        });
        Job::all()->each(function (Job $Item) use ($sitemap) {
            $sitemap->add(Url::create("/job/{$Item->slug}"));
        });
        Skill::all()->each(function (Skill $Item) use ($sitemap) {
            if($Item->title=='E-Commerce'||$Item->title=='Cloud Computing'||$Item->title=='Data Science'||
            $Item->title=='Graphic Designing'||$Item->title=='Artificial Intelligence'||$Item->title=='Growth Hacking'){
                
            }
            else{
            $sitemap->add(Url::create("/jobs/{$Item->slug}"));
            }
        });
        Category::all()->each(function (Category $Item) use ($sitemap) {
            $sitemap->add(Url::create("/courses/{$Item->slug}"));
        });
        Skill::all()->each(function (Skill $Item) use ($sitemap) {
            if($Item->title=='E-Commerce'||$Item->title=='Cloud Computing'||$Item->title=='Data Science'||
            $Item->title=='Graphic Designing'||$Item->title=='Artificial Intelligence'||$Item->title=='Growth Hacking'){
                
            }
            else{
            $sitemap->add(Url::create("/courses/{$Item->slug}"));
            }
        });
        Cource::all()->each(function (Cource $Item) use ($sitemap) {
            $sitemap->add(Url::create("/course/{$Item->slug}"));
        });
        Blog::all()->each(function (Blog $Item) use ($sitemap) {
            $sitemap->add(Url::create("/blog/{$Item->slug}"));
        });
        
        $sitemap->add(Url::create("page/about-us"));
        $sitemap->add(Url::create("page/privacy-policy"));
        $sitemap->add(Url::create("/"));

        $sitemap->writeToFile($path.$file);
        
    }
}
