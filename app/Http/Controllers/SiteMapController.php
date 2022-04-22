<?php

namespace App\Http\Controllers;

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

class SiteMapController extends Controller
{
    public function index(){
        $path = public_path();
        $file = '/sitemap.xml';
        $sitemap = Sitemap::create();
        Category::all()->each(function (Category $Item) use ($sitemap) {
            $sitemap->add(Url::create("/hire/{$Item->slug}"));
        });
        Skill::all()->each(function (Skill $Item) use ($sitemap) {
            $sitemap->add(Url::create("/hire/{$Item->slug}"));
        });
        User::all()->each(function (User $Item) use ($sitemap) {
            $sitemap->add(Url::create("/profile/{$Item->slug}"));
        });
        Category::all()->each(function (Category $Item) use ($sitemap) {
            $sitemap->add(Url::create("/services/{$Item->slug}"));
        });
        Skill::all()->each(function (Skill $Item) use ($sitemap) {
            $sitemap->add(Url::create("/services/{$Item->slug}"));
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
            $sitemap->add(Url::create("/jobs/{$Item->slug}"));
        });
        Category::all()->each(function (Category $Item) use ($sitemap) {
            $sitemap->add(Url::create("/courses/{$Item->slug}"));
        });
        Skill::all()->each(function (Skill $Item) use ($sitemap) {
            $sitemap->add(Url::create("/courses/{$Item->slug}"));
        });
        Cource::all()->each(function (Cource $Item) use ($sitemap) {
            $sitemap->add(Url::create("/course/{$Item->slug}"));
        });
        Category::all()->each(function (Category $Item) use ($sitemap) {
            $sitemap->add(Url::create("/blogs/{$Item->slug}"));
        });
        Skill::all()->each(function (Skill $Item) use ($sitemap) {
            $sitemap->add(Url::create("/blogs/{$Item->slug}"));
        });
        Blog::all()->each(function (Blog $Item) use ($sitemap) {
            $sitemap->add(Url::create("/blog/{$Item->slug}"));
        });
        
        $sitemap->add(Url::create("page/about-us"));
        $sitemap->add(Url::create("page/privacy-policy"));
        $sitemap->add(Url::create("/"));
        // $sitemap->add(Url::create('/hire'));
        // $sitemap->shouldCrawl(function (Url $url) {
        //     $result = substr($url->segment(1), 0, 13);
        // if ($result === 'search-results') {
        //     return;
        // }
        // Location::all()->each(function (Location $Item) use ($sitemap) {
        //     if ($url->segment(1) === "/hire/{$Item->slug}") {
        //         return;
        //     }
        // });
        // });

        $sitemap->writeToFile($path.$file);
        return redirect(env('APP_URL')."/sitemap.xml");
    }
}

