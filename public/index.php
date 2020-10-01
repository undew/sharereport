<?php 

use Slim\Factory\AppFactory;
require_once($_SERVER["DOCUMENT_ROOT"]."/ph34/sharereports/vendor/autoload.php");
$app = AppFactory::create();
require_once($_SERVER["DOCUMENT_ROOT"]."/ph34/sharereports/classes/exception/bootstrappers.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/ph34/sharereports/routes.php");

$app->run();