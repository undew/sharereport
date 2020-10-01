<?php 

namespace LocalHalPH34\sharereports\classes\exception;

use Throwable;
use Psr\Http\Message\ServerRequestInterface;
use psr\Http\Message\ResponseInterface;
use Slim\Error\Renderers\HtmlErrorRenderer;
use Slim\Views\Twig;
use LocalHalPH34\sharereports\classes\exception\NoLoginException;
use LocalHalPH34\sharereports\classes\exception\DataAccessException;

class CustomErrorRenderer{
    /**
     * 実行メソッド
     * NoLogionExceptionとDataAccessExceptionの例外処理を行っている。
     * 
     * それ以外の例外が発生した場合は、デフォルトのHTMLエラーレンダラクラス（HtmlErrorRenderer)に処理を移管している。
     * 
     * @param throwable $exception 発生した例外。
     * @param boolk $displayErrorDetails エラーの詳細を発生させるかどうかのフラグ。
     * @return string レスポンスとして返す文字列　ここでは生成されたHTML文字列。
     */
    public function __invoke(throwable $exception , bool $displayErrorDetails):string{
        $view=Twig::create($_SERVER["DOCUMENT_ROOT"]."/ph34/sharereports/templates");
        if($exception instanceof NoLoginException){
            $validationMsgs[]="ログインしていないか、前回ログインしてから一定時間が経過しています。もう一度ログインしなおしてください。";
            $assign["validationMsgs"]=$validationMsgs;
            $returnHtml = $view->fetch('login.html',$assign);
        }
        elseif($exception instanceof DataAccessException){
            $assign["errorMsg"] = $exception->getMessage();
            $returnHtml = $view->fetch("error.html",$assign);
        }
        else{
            $htmlErrorRenderer = new HtmlErrorRenderer();
            $returnHtml = $htmlErrorRenderer($exception,$displayErrorDetails);
        }
        return $returnHtml;
    }
}