<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Logos;


class LogosSeender extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Logos::truncate();
        DB::table('logos')->insert(
            [
                [
                    'skill' => 'Magento',
                    'logo'  => 'https://creativetech-solutions.com/wp-content/uploads/2013/11/magento-logo.png',
                ],
                [
                    'skill' => 'Api',
                    'logo'  => 'https://img.icons8.com/ios/452/api-settings.png',
                ],
                [
                    'skill' => 'Css',
                    'logo'  => 'https://e7.pngegg.com/pngimages/239/228/png-clipart-html-css3-cascading-style-sheets-logo-markup-language-digital-agency-miscellaneous-blue-thumbnail.png',
                ],
                [
                    'skill' => 'Salesforce',
                    'logo'  => 'https://www.seraphscience.com/wp-content/uploads/2018/06/logo-salesforce-png-454.png',
                ],
                [
                    'skill' => 'Html5',
                    'logo'  => 'https://seeklogo.com/images/H/html5-without-wordmark-color-logo-14D252D878-seeklogo.com.png',
                ],
                [
                    'skill' => 'JavaScript',
                    'logo'  => 'https://p1.hiclipart.com/preview/951/574/485/react-logo-javascript-redux-vuejs-angular-angularjs-expressjs-front-and-back-ends-png-clipart.jpg',
                ],
                [
                    'skill' => 'Php',
                    'logo'  => 'https://pngimg.com/uploads/php/php_PNG12.png',
                ],
                [
                    'skill' => 'Mysql',
                    'logo'  => 'https://i0.wp.com/www.elearningworld.org/wp-content/uploads/2019/04/MySQL.svg.png',
                ],
                [
                    'skill' => 'Mongodb',
                    'logo'  => 'https://1000logos.net/wp-content/uploads/2020/08/MongoDB-Logo.png',
                ],
                [
                    'skill' => 'Seo',
                    'logo'  => 'https://w7.pngwing.com/pngs/3/293/png-transparent-seo-logo-search-engine-optimization-computer-icons-web-search-engine-website-seo-icon-miscellaneous-web-design-text.png',
                ],
                [
                    'skill' => 'Wordpress',
                    'logo'  => 'https://e7.pngegg.com/pngimages/451/423/png-clipart-wordpress-wordpress-emblem-trademark.png',
                ],
                [
                    'skill' => 'Laravel',
                    'logo'  => 'https://upload.wikimedia.org/wikipedia/commons/thumb/9/9a/Laravel.svg/1200px-Laravel.svg.png',
                ],
            ]
        );
    }
}
