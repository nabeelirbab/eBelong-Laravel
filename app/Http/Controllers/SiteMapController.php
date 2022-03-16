<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helper;
use Carbon\Carbon;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\SitemapGenerator;
use Spatie\Sitemap\Tags\Url;

class SiteMapController extends Controller
{
    public function index(){
        $path = public_path();
        $file = '/sitemap.xml';
        SitemapGenerator::create(env('APP_URL'))
        ->writeToFile($path.$file);
        return redirect(env('APP_URL')."/sitemap.xml");
    }
}
