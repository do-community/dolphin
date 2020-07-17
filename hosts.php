#!/usr/bin/env php
<?php

if (php_sapi_name() !== 'cli') {
    exit;
}

require __DIR__ . '/vendor/autoload.php';

use Minicli\App;
use App\Service\DigitalOceanService;
use Minicli\Minicache\FileCache;

$app = new App(require __DIR__ . '/config.php');
$cache = new FileCache(__DIR__ . '/var/cache');

$app->addService('digitalocean', new DigitalOceanService($cache));
$app->runCommand([ 'dolphin', 'inventory', 'json', '--force-update' ]);