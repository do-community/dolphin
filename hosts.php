#!/usr/bin/env php
<?php

if (php_sapi_name() !== 'cli') {
    exit;
}

require __DIR__ . '/vendor/autoload.php';

use Minicli\App;
use App\DigitalOceanService as DigitalOcean;
use Minicli\Util\FileCache;

$app = new App(require __DIR__ . '/config.php');
$cache = new FileCache(__DIR__ . '/var/cache');

$app->addService('digitalocean', new DigitalOcean($cache));
$app->runCommand([ 'dolphin', 'inventory', 'json' ]);