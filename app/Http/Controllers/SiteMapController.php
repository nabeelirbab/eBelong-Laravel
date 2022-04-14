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

class SiteMapController extends Controller
{
    public function index(){
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
        return redirect(env('APP_URL')."/sitemap.xml");
    }
}

