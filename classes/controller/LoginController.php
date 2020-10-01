<?php 

namespace LocalHalPH34\sharereports\classes\controller;

use PDO;
use PDOException;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use LocalHalPH34\sharereports\classes\Conf;
use LocalHalPH34\sharereports\classes\exception\DataAccessException;
use LocalHalPH34\sharereports\classes\DAO\UserDAO;
use LocalHalPH34\sharereports\classes\Entity\User;
use LocalHalPH34\sharereports\classes\controller\ParentController;

class LoginController extends ParentController{

    public function goLogin(ServerRequestInterface $request , ResponseInterface $response,array $args):ResponseInterface{
        $returnResponse = $this->view->render($response,"login.html");
        return $returnResponse;
    }
    public function login(ServerRequestInterface $request , ResponseInterface $response,array $args):ResponseInterface{
        $isRedirect = false;
        $templatePath = "login.html";
        $assign = [];

        $postParams = $request->getParsedBody();
        $loginId = $postParams["loginId"];
        $loginPw = $postParams["loginPw"];

        $loginId = trim($loginId);
        $loginPw = trim($loginPw);

        $validatinoMsgs = ["id","pass"];
        if(empty($validationMsgs)){
            try{
                $db = new PDO(Conf::DB_DNS,Conf::DB_USERNAME,Conf::DB_PASSWORD);
                $userDAO = new UserDAO($db);
                $user = $userDAO->findByLoginId($loginId);
                if($user == null){
                    $validationMsgs["id"] = "存在しないメールです。正しいメールアドレスを入力してください";
                }
                else{
                    $userPw = $user->getPasswd();
                    if(password_verify($loginPw,$userPw)){
                        $id = $user->getId();
                        $name = $user->getName();

                        $_SESSION["loginFlg"] = true;
                        $_SESSION["id"] = $id;
                        $_SESSION["name"] = $name;
                        $_SESSION["auth"] = 1;
                        $isRedirect = true;
                    }
                    else{
                        $validationMsgs["pass"] = "パスワードが違います。正しいパスワードを入力してください。";
                    }
                }
            }
            catch(PDOException $ex){
                $exCode = $ex->getCode();
                throw new DataAccessException('DB接続に失敗しました。',$exCode,$ex);
            }
            finally{
                $db = null;
            }
        }
        if($isRedirect){
            $returnResponse = $response->withStatus(302)->withHeader("Location","/ph34/sharereports/public/reports/showList");
        }
        else{
            if(!empty($validationMsgs)){
                $assign["validationMsgs"] = $validationMsgs;
                $assign["loginId"] = $loginId;
            }
            $returnResponse = $this->view->render($response,$templatePath,$assign);
        }
        return $returnResponse;
    }
    public function logout(ServerRequestInterface $request , ResponseInterface $response,array $args):ResponseInterface{
    session_destroy();
    $returnResponse = $response->withStatus(302)->withHeader("Location","/ph34/sharereports/public");
    return $returnResponse;
    }
}
