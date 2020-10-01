<?php 

namespace LocalHalPH34\sharereports\classes\controller;

use Slim\Views\Twig;
use Slim\Flash\Messages;

class ParentController{
    protected $view;
    protected $flash;
    public function __construct(){
        $this->view = Twig::create($_SERVER["DOCUMENT_ROOT"]."/ph34/sharereports/templates");
        $this->flash = new Messages();
    }

    protected function cleanSession(): void{
        $loginFlg = $_SESSION["loginFlg"];
        $id = $_SESSION["id"];
        $name = $_SESSION["name"];
        $auth = $_SESSION["auth"];

        session_unset();

        $_SESSION["loginFlg"] = $loginFlg;
        $_SESSION["id"] = $id;
        $_SESSION["name"] = $name;
        $_SESSION["auth"] = $auth;
    }
}