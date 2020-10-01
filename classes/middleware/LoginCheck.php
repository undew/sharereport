<?php 

namespace LocalHalPH34\sharereports\classes\middleware;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface;
use LocalHalPH34\sharereports\classes\exception\NoLoginException;

/**
 * ログインチェックミドルウェアクラス
 */
class LoginCheck{
    public function __invoke(ServerRequestInterface $request,RequestHandlerInterface $handler):ResponseInterface{
    if(!isset($_SESSION["id"]) || !isset($_SESSION["loginFlg"]) || $_SESSION["loginFlg"] == false || !isset($_SESSION["name"]) || !isset($_SESSION["auth"])){
        $result = true;
        throw new NoLoginException();       
        }
        $response = $handler->handle($request);
        return $response;
        }   
}