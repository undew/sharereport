<?php

namespace LocalHalPH34\sharereports\classes\controller;

use PDO;
use PDOException;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use LocalHalPH34\sharereports\classes\Conf;
use LocalHalPH34\sharereports\classes\entity\Report;
use LocalHalPH34\sharereports\classes\entity\Paging;
use LocalHalPH34\sharereports\classes\DAO\ReportDAO;
use LocalHalPH34\sharereports\classes\exception\DataAccessException;
use LocalHalPH34\sharereports\classes\controller\ParentController;

class ReportController extends ParentController{
    public function showList(ServerRequestInterface $request,ResponseInterface $response,array $args):ResponseInterface{
        $flashMessage = $this->flash->getFirstMessage("flashMsg");
        if(!isset($flashMessages)){
            $assign["flashMsg"] = $this->flash->getFirstMessage("flashMsg");
        }
        $this->cleanSession();
        try{
            $db = new PDO(Conf::DB_DNS,Conf::DB_USERNAME,Conf::DB_PASSWORD);
            $ReportDAO = new ReportDAO($db);
            $paging = new Paging();
            $row_count = 4;
            
            $ReportList = $ReportDAO->findAll(0,$row_count);
            $assign["ReportList"] = $ReportList;
            $page = $ReportDAO->allSelect();
            $pageList = [];
            for($i = 0;$i<ceil($page/$row_count);$i++){
                $pageList[$i] = $i+1;
            }
            $assign["pageList"] = $pageList;
            $assign["login"] = $_SESSION["name"];
        }
        catch(PDOException $ex){
            $exCode = $ex->getCode();
            throw new DataAccessException("DB接続に失敗しました。",$exCode,$ex);
        }
        finally{
            $db = null;
        }
        $returnResponse = $this->view->render($response,"reports/showList.html",$assign);
        return $returnResponse;
    }

    public function pager(ServerRequestInterface $request,ResponseInterface $response,array $args):ResponseInterface{
        $rpId = $args["rpId"]-1;
        $this->cleanSession();
        try{
            $db = new PDO(Conf::DB_DNS,Conf::DB_USERNAME,Conf::DB_PASSWORD);
            $ReportDAO = new ReportDAO($db);
            $paging = new Paging();
            $row_count = 4;
            $result = $rpId * $row_count;
            $ReportList = $ReportDAO->findAll($result,$row_count);
            $assign["ReportList"] = $ReportList;
            $page = $ReportDAO->allSelect();
            $pageList = [];
            for($i = 0;$i<ceil($page/$row_count);$i++){
                $pageList[$i] = $i+1;
            }
            $assign["pageId"] = $rpId;
            $assign["pageList"] = $pageList;
            $assign["login"] = $_SESSION["name"];
        }
        catch(PDOException $ex){
            $exCode = $ex->getCode();
            throw new DataAccessException("DB接続に失敗しました。",$exCode,$ex);
        }
        finally{
            $db = null;
        }
        $returnResponse = $this->view->render($response,"reports/showList.html",$assign);
        return $returnResponse;
    }

    public function goUser(ServerRequestInterface $request,ResponseInterface $response,array $args):ResponseInterface{
        $name = $_POST["username"];
        try{
            $db = new PDO(Conf::DB_DNS,Conf::DB_USERNAME,Conf::DB_PASSWORD);
            $ReportDAO = new ReportDAO($db);
            $paging = new Paging();
            $row_count = 4;
            $pageList= [];
            $ReportList = $ReportDAO->findGoUser($name);
            $assign["resultMsg"] = $name."　の検索結果：".floor(count($ReportList))."件";
            $assign["pageList"] = $pageList;
            $assign["ReportList"] = $ReportList;
            $assign["pageList"] = $pageList;
            $assign["login"] = $_SESSION["name"];
        }
        catch(PDOException $ex){
            $exCode = $ex->getCode();
            throw new DataAccessException("DB接続に失敗しました。",$exCode,$ex);
        }
        finally{
            $db = null;
        }
        $returnResponse = $this->view->render($response,"reports/showList.html",$assign);
        return $returnResponse;
    }

    public function goDate(ServerRequestInterface $request,ResponseInterface $response,array $args):ResponseInterface{
        $name = $_POST["dateparams"];
        try{
            $db = new PDO(Conf::DB_DNS,Conf::DB_USERNAME,Conf::DB_PASSWORD);
            $ReportDAO = new ReportDAO($db);
            $paging = new Paging();
            $row_count = 4;
            $pageList= [];
            $ReportList = $ReportDAO->findGoDate($name);
            $assign["resultMsg"] = $name."　の検索結果：".floor(count($ReportList))."件";
            $assign["pageList"] = $pageList;
            $assign["ReportList"] = $ReportList;
            $assign["pageList"] = $pageList;
            $assign["login"] = $_SESSION["name"];
        }
        catch(PDOException $ex){
            $exCode = $ex->getCode();
            throw new DataAccessException("DB接続に失敗しました。",$exCode,$ex);
        }
        finally{
            $db = null;
        }
        $returnResponse = $this->view->render($response,"reports/showList.html",$assign);
        return $returnResponse;
    }

    public function showDetail(ServerRequestInterface $request,ResponseInterface $response,array $args):ResponseInterface{
        
        $detailId = $args["rpId"];
        
        $flashMessage = $this->flash->getFirstMessage("flashMsg");
        if(!isset($flashMessages)){
            $assign["flashMsg"] = $this->flash->getFirstMessage("flashMsg");
        }
        $this->cleanSession();
        try{
            $db = new PDO(Conf::DB_DNS,Conf::DB_USERNAME,Conf::DB_PASSWORD);
            $ReportDAO = new ReportDAO($db);
            $ReportList = $ReportDAO->findDetail($detailId);

            $assign["detail"] = $ReportList;
            $assign["rpId"] = $detailId;
            $assign["login"] = $_SESSION["name"];
            
        }
        catch(PDOException $ex){
            $exCode = $ex->getCode();
            throw new DataAccessException("DB接続に失敗しました。",$exCode,$ex);
        }
        finally{
            $db = null;
        }
        $returnResponse = $this->view->render($response,"reports/detail.html",$assign);
        return $returnResponse;
    }

    public function prepareEdit(ServerRequestInterface $request,ResponseInterface $response,array $args):ResponseInterface{
        $templatePath = "reports/edit.html";
        $assign = [];
        $assign["login"] = $_SESSION["name"];
        $editId = $args["rpId"];
        try{
            $db = new PDO(Conf::DB_DNS,Conf::DB_USERNAME,Conf::DB_PASSWORD);
            $ReportDAO = new ReportDAO($db);
            $report = $ReportDAO->findByPk($editId);
            $rc = $ReportDAO->findReportcates($editId);
            if(empty($report)){
                throw new DataAccessException("レポート取得失敗じゃ！");
            }
            else{
                $assign["report"] = $report;
                $assign["rc"] = $rc;
                $assign["login"] = $_SESSION["name"];
            }
        }
        catch(PDOException $ex){
            $exCode = $ex->getCode();
            throw new DataAccessException("DB接続できないねえ。",$exCode,$ex);
        }
        finally{
            $db = null;
        }
        $returnResponse = $this->view->render($response,$templatePath,$assign);
        return $returnResponse;
        }

        public function goAdd(ServerRequestInterface $request,ResponseInterface $response,array $args):ResponseInterface{
            $db = new PDO(Conf::DB_DNS,Conf::DB_USERNAME,Conf::DB_PASSWORD);
            $reportDAO = new ReportDAO($db);
            $rp = $reportDAO->findReportcates();
            $assign["rp"] = $rp;
            $assign["date"] = date("Y-m-d");
            $assign["login"] = $_SESSION["name"];
            $returnResponse = $this->view->render($response,"reports/add.html",$assign);
            return $returnResponse;
        }

        public function add(ServerRequestInterface $request,ResponseInterface $response,array $args):ResponseInterface{
            $templatePath = "reports/add.html";
            $isRedirect = false;
            $assign = [];
            $assign["login"] = $_SESSION["name"];

            $postParams = $request->getParsedBody();
            $addRpDate = $postParams["addRpDate"];
            $addRpTimeFrom = $postParams["addRpTimeFrom"];
            $addRpTimeTo = $postParams["addRpTimeTo"];
            $addRpCreatedAt = date("Y-m-d H:i:s");
            $addRpCate = $postParams["addRpCate"];
            $addRpCon = $postParams["addRpCon"];
            $addUserId = $_SESSION["id"];
            $report = new Report();
            $report->setRp_date($addRpDate);
            $report->setRp_time_from($addRpTimeFrom);
            $report->setRp_time_to($addRpTimeTo);
            $report->setReportcate_id($addRpCate);
            $report->setRp_created_at($addRpCreatedAt);
            $report->setRp_content($addRpCon);
            $report->setUser_id($addUserId);
            $validationMsgs = [];
            try{
                $db = new PDO(Conf::DB_DNS,Conf::DB_USERNAME,Conf::DB_PASSWORD);
                $reportDAO = new ReportDAO($db);
                if(empty($addRpDate) || empty($addRpTimeFrom) || empty($addRpTimeTo) || empty($addRpCon)){
                    $validationMsgs[] = "空欄があるわ、やりなおしてくれ";
                }
                if(explode('-',$addRpTimeFrom) > explode("-",$addRpTimeTo)){
                    $validationMsgs[] = "日付がバグっとるわ、作業終了時間を正しく入力してくれ。";
                }
                if(empty($validationMsgs)){
                    $result = $reportDAO->insert($report);
                    
                    if($result){
                        $isRedirect = true;
                        $this->flash->addMessage("flashMsg","レポートをさっきの情報で登録したで。");
                    }
                    else{
                        throw new DataAccessException("情報更新に失敗しました。もう一度はじめからやり直してください。");
                    }
                }
                else{
                    $assign["report"] = $report;
                    $assign["validationMsgs"] = $validationMsgs;
                    $rp = $reportDAO->findReportcates();
                    $assign["rp"] = $rp;
                    $rpCateId = new Report();
                    $assign["cateId"] = $report->getReportcate_id();
                    $assign["date"] = $report->getRp_date();
                    $assign["login"] = $_SESSION["name"];
                }
            }
            catch(PDOException $ex){
                $exCode=$ex->getCode();
                throw new DataAccessException("DB接続に失敗しました。",$exCode,$ex);
            }
            finally{
                $db = null;
            }
            if($isRedirect){
                $returnResponse = $response->withStatus(302)->withHeader("Location","/ph34/sharereports/public/reports/showList");
            }
            else{
                $returnResponse = $this->view->render($response,$templatePath,$assign);

            }
            return $returnResponse;
        }

        public function edit(ServerRequestInterface $request,ResponseInterface $response,array $args):ResponseInterface{
            $templatePath = "reports/edit.html";
            $isRedirect = false;
            $assign = [];

            $postParams = $request->getParsedBody();
            $editRpId = $postParams["editRpId"];
            $editRpDate = $postParams["editRpDate"];
            $editRpTimeFrom = $postParams["editRpTimeFrom"];
            $editRpTimeTo = $postParams["editRpTimeTo"];
            $editRpCreatedAt = date("Y-m-d H:i:s");
            $editRpCate = $postParams["editRpCate"];
            $editRpCon = $postParams["editRpCon"];
            
            $report = new Report();
            $report->setId($editRpId);
            $report->setRp_date($editRpDate);
            $report->setRp_time_from($editRpTimeFrom);
            $report->setRp_time_to($editRpTimeTo);
            $report->setRp_created_at($editRpCreatedAt);
            $report->setReportcate_id($editRpCate);
            $report->setRp_content($editRpCon);
            $validationMsgs = [];
            try{
                $db = new PDO(Conf::DB_DNS,Conf::DB_USERNAME,Conf::DB_PASSWORD);
                $reportDAO = new ReportDAO($db);
                $rc = $reportDAO->findReportcates($editRpCate);
                if(!empty($reportDB) && $reportDB->getId() != $editRpId){
                    $validationMsgs[] = "そのレポート番号はすでに使われています。別のものを指定してください。";

                }
                if(explode('-',$editRpTimeFrom) > explode("-",$editRpTimeTo)){
                    $validationMsgs[] = "日付がバグっとるわ、作業終了時間を正しく入力してくれ。";
                }
                if(empty($validationMsgs)){
                    $result = $reportDAO->update($report);
                    if($result){
                        $isRedirect = true;
                        $this->flash->addMessage("flashMsg","レポートID【".$editRpId."】で情報更新したで。");       
                    }
                    else{
                        throw new DataAccessException("情報更新に失敗しました。もう一度はじめからやり直してください。");
                    }
                }
                else{
                    $assign["rc"] = $rc;
                    $assign["report"] = $report;
                    $assign["validationMsgs"] = $validationMsgs;
                }
            }
            catch(PDOException $ex){
                $exCode=$ex->getCode();
                throw new DataAccessException("DB接続に失敗しました。",$exCode,$ex);
            }
            finally{
                $db = null;
            }
            if($isRedirect){
                $assign["rpId"] = $editRpId;
                $returnResponse = $response->withStatus(302)->withHeader("Location",$postParams["throwEdit"]);
            }
            else{
                $returnResponse = $this->view->render($response,$templatePath,$assign);

            }
            
            return $returnResponse;
        }
        public function confirmDelete(ServerRequestInterface $request,ResponseInterface $response,array $args):ResponseInterface{
            $templatePath = "reports/confirmDelete.html";
            $assign = [];
            $assign["login"] = $_SESSION["name"];
            $editReportId = $args["rpId"];
            try{
                $db = new PDO(Conf::DB_DNS,Conf::DB_USERNAME,Conf::DB_PASSWORD);
                $reportDAO = new ReportDAO($db);
                $report = $reportDAO->findByPK($editReportId);
                if(empty($report)){
                    throw new DataAccessException("レポートの取得に失敗しました。");
                }
                else{
                    $assign["report"] = $report;
                    $assign["login"] = $_SESSION["name"];
                }
            }
            catch(PDOException $ex){
                $exCode = $ex->getCode();
                throw new DataAccessException("DB接続に失敗しました。",$exCode,$ex);
            }
            finally{
                $db = null;
            }
            $returnResponse = $this->view->render($response,$templatePath,$assign);
            return $returnResponse;
        }
        public function delete(ServerRequestInterface $request,ResponseInterface $response,array $args):ResponseInterface{
            $postParams = $request->getParsedBody();
            $deleteReportId = $postParams["deleteRpId"];
            try{
                $db = new PDO(Conf::DB_DNS,Conf::DB_USERNAME,Conf::DB_PASSWORD);
                $reportDAO = new ReportDAO($db);
                $result = $reportDAO->delete($deleteReportId);
                if($result){
                    $this->flash->addMessage("flashMsg","レポートID【".$deleteReportId."】、消してしもうたわ。");
                }
                else{
                    throw new DataAccessException("情報削除に失敗しました。もう一度はじめからやり直してください。");
                }
            }
            catch(PDOException $ex){
                $exCode = $ex->getCode();
                throw new DataAccessException("DB接続に失敗しました。",$exCode,$ex);
            }   
            finally{
                $db = null;
            }
            $returnResponse = $response->withStatus(302)->withHeader("Location","/ph34/sharereports/public/reports/showList");
            return $returnResponse;
           }
       
}