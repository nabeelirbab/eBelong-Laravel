<?php
return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application. Just store away!
    |
    */

    'default' => env('FILESYSTEM_DRIVER', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Default Cloud Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Many applications store files both locally and in the cloud. For this
    | reason, you may specify a default "cloud" driver here. This driver
    | will be bound as the Cloud disk implementation in the container.
    |
    */

    'cloud' => env('FILESYSTEM_CLOUD', 's3'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "disks" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been setup for each driver as an example of the required options.
    |
    | Supported Drivers: "local", "ftp", "sftp", "s3", "rackspace"
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
        ],

        // live settings
        // 'local_public' => [
        //     'driver' => 'local',
        //     'root'   => '/',
        //     'url' => env('APP_URL').'/public',
        //     'visibility' => 'public',
        // ],

        'local_public' => [
            'driver' => 'local',
            'root'   => public_path() . '/uploads',
            'url' => env('APP_URL') . '/public',
            'visibility' => 'public',
        ],
        'local_public_tinyce' => [
            'driver' => 'local',
            'root'   => public_path() . '/uploads',
            'url' => env('APP_URL') . '/uploads',
            'visibility' => 'public',
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL') . '/storage',
            'visibility' => 'public',
        ],

        's3' => [
            'driver' => 's3',
            'key' => 'AKIA2Z56FJV424WUHJEZ',
            'secret' => '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',
            'region' => 'us-east-1',
            'bucket' => 'ebelong-assets',
            'url' => env('AWS_URL'),
        ],

    ],

];
