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
        $file = 'sitemap.xml';
        SitemapGenerator::create('https://ebelong.com')
        ->writeToFile($path.$file);
        return redirect("http://127.0.0.1:8000/sitemap.xml");
    }
}
