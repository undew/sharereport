<?php 

use LocalHalPH34\sharereports\classes\exception\CustomErrorRenderer;

$app->addRoutingMiddleware();
$errorMiddleware = $app->addErrorMiddleware(true,true,true);
$errorHandler = $errorMiddleware->getDefaultErrorHandler();
$errorHandler->registerErrorRenderer('text/html',CustomErrorRenderer::class);