<?php 

use LocalHalPH34\sharereports\classes\middleware\LoginCheck;
use LocalHalPH34\sharereports\classes\controller\LoginController;
use LocalHalPH34\sharereports\classes\controller\ReportController;

$app->setBasePath('/ph34/sharereports/public');
$app->get("/",LoginController::class.":goLogin");
$app->post('/login',LoginController::class.":login");
$app->get('/logout',LoginController::class.":logout");
$app->get('/reports/showList',ReportController::class.":showList")->add(new LoginCheck());
$app->get('/reports/showList/{rpId}',ReportController::class.":pager")->add(new LoginCheck());
$app->post('/reports/showList/goUser',ReportController::class.":goUser")->add(new LoginCheck());
$app->post('/reports/showList/goDate',ReportController::class.":goDate")->add(new LoginCheck());
$app->get('/reports/goAdd',ReportController::class.":goAdd")->add(new LoginCheck());
$app->post('/reports/add',ReportController::class.":add")->add(new LoginCheck());  
$app->get('/reports/detail/{rpId}',ReportController::class.":showDetail")->add(new LoginCheck());
$app->get('/reports/prepareEdit/{rpId}',ReportController::class.":prepareEdit")->add(new LoginCheck());
$app->post('/reports/edit',ReportController::class.":edit")->add(new LoginCheck());
$app->get('/reports/confirmDelete/{rpId}',ReportController::class.":confirmDelete")->add(new LoginCheck());
$app->post('/reports/delete',ReportController::class.":delete")->add(new LoginCheck());
