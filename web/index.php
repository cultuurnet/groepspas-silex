<?php
use CultuurNet\GroepsPas\WebApplication;

require_once __DIR__.'/../vendor/autoload.php';
error_reporting(2147483647);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
$app = new WebApplication();
$app->run();
