#!/usr/bin/env php
<?php

require_once __DIR__ . '/vendor/autoload.php';

define('DATA_DIR', __DIR__ . '/data');

use Symfony\Component\Console\Application;
use Cars\Command\CarsCommand;

$app = new Application();
$app->add(new CarsCommand());
$app->run();
