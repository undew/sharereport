<?php 

namespace LocalHALPH34\sharereports\classes\DAO;

use PDO;
use LocalHalPH34\sharereports\classes\entity\Report;

class ReportDAO {
    private $db;

    public function __construct(PDO $db){
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        $this->db = $db;
    }
    public function allSelect(){
        $sql = "SELECT * FROM reports";
        $stmt = $this->db->prepare($sql);
        $result = $stmt->execute();
        $count = 0;
        while($row = $stmt->fetch()){
            $count++;
        }
        return $count;
    }
    public function findAll(int $start,int $end){
        $sql = "SELECT reports.id as reportId,reports.rp_date,reports.rp_content,reports.user_id,users.id,users.us_name FROM reports left outer join users on reports.user_id = users.id ORDER BY reportId DESC LIMIT :start,:end";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":start", $start, PDO::PARAM_INT);
        $stmt->bindValue(":end", $end, PDO::PARAM_INT);
        $result = $stmt->execute();
        $ReportList = [];
        while($row = $stmt->fetch()) {
        $id = $row["reportId"];
        $rp_date = $row["rp_date"];
        $rp_content = $row["rp_content"];
        $us_name = $row["us_name"];
        $report = new Report();
        $report->setId($id);
        $report->setRp_date($rp_date);
        $report->setRp_content($rp_content);
        $report->setRc_name($us_name);
        $ReportList[$id] = $report;
        }
        return $ReportList;
    }

    public function findGoUser(string $name){
        $sql = "SELECT reports.id as reportId,reports.rp_date,reports.rp_content,reports.user_id,users.id,users.us_name FROM reports left outer join users on reports.user_id = users.id WHERE users.us_name = :name";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":name", $name, PDO::PARAM_STR);
        $result = $stmt->execute();
        $ReportList = [];
        while($row = $stmt->fetch()) {
        $id = $row["reportId"];
        $rp_date = $row["rp_date"];
        $rp_content = $row["rp_content"];
        $us_name = $row["us_name"];
        $report = new Report();
        $report->setId($id);
        $report->setRp_date($rp_date);
        $report->setRp_content($rp_content);
        $report->setRc_name($us_name);
        $ReportList[$id] = $report;
        }
        return $ReportList;
    }

    public function findGoDate(string $name){
        $sql = "SELECT reports.id as reportId,reports.rp_date,reports.rp_content,reports.user_id,users.id,users.us_name FROM reports left outer join users on reports.user_id = users.id WHERE reports.rp_date = :name";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":name", $name, PDO::PARAM_STR);
        $result = $stmt->execute();
        $ReportList = [];
        while($row = $stmt->fetch()) {
        $id = $row["reportId"];
        $rp_date = $row["rp_date"];
        $rp_content = $row["rp_content"];
        $us_name = $row["us_name"];
        $report = new Report();
        $report->setId($id);
        $report->setRp_date($rp_date);
        $report->setRp_content($rp_content);
        $report->setRc_name($us_name);
        $ReportList[$id] = $report;
        }
        return $ReportList;
    }

    public function findReportcates(){
        $sql = "SELECT * FROM reportcates ORDER BY id";
        $stmt = $this->db->prepare($sql);
        $result = $stmt->execute();
        $ReportList = [];
        while($row = $stmt->fetch()) {
        $cate_id = $row["id"];
        $rc_name = $row["rc_name"];
        
        $report = new Report();
        $report->setCate_id($cate_id);
        $report->setRc_name($rc_name);
        $ReportList[$cate_id] = $report;
        }
        return $ReportList;
    }

    public function findDetail(int $rpId): ?Report {
        $sql = "SELECT reports.id as reportId, reports.rp_date,reports.rp_time_from,reports.rp_time_to,reports.rp_content,reports.rp_created_at,reports.reportcate_id,reports.user_id,users.us_name,users.us_mail ,reportcates.rc_name FROM reports left outer join users on reports.user_id = users.id left outer join reportcates on reports.reportcate_id = reportcates.id WHERE reports.id = :id";
        $stmt = $this->db->prepare($sql);
        
        $stmt->bindValue(":id", $rpId, PDO::PARAM_INT);
        $result = $stmt->execute();
        $report = null;
        while($result && $row = $stmt->fetch()) {
        $id = $row["reportId"];
        $rp_date = $row["rp_date"];
        $rp_time_from = $row["rp_time_from"];
        $rp_time_to = $row["rp_time_to"];
        $rp_content = $row["rp_content"];
        $rp_created_at = $row["rp_created_at"];
        $reportcate_id = $row["reportcate_id"];
        $us_name = $row["us_name"];
        $rc_name=$row["rc_name"];
        $us_mail = $row["us_mail"];
        
        $report = new Report();
        $report->setId($id);
        $report->setRp_date($rp_date);
        $report->setRp_time_from($rp_time_from);
        $report->setRp_time_to($rp_time_to);
        $report->setRp_content($rp_content);
        $report->setRp_created_at($rp_created_at);
        $report->setReportcate_id($reportcate_id);
        $report->setUs_name($us_name);
        $report->setRc_name($rc_name);
        $report->setUs_mail($us_mail);

        }
        return $report;
        }
    public function findByPK(int $rpId): ?Report {
        $sql = "SELECT * FROM reports WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":id", $rpId, PDO::PARAM_INT);
        $result = $stmt->execute();
        $report = null;
        if($result && $row = $stmt->fetch()) {
            
            $id = $row["id"];
            $rp_date = $row["rp_date"];
            $rp_time_from = $row["rp_time_from"];
            $rp_time_to = $row["rp_time_to"];
            $rp_content = $row["rp_content"];
            $reportcate_id = $row["reportcate_id"];
        
            $report = new Report();
            $report->setId($id);
            $report->setRp_date($rp_date);
            $report->setRp_time_from($rp_time_from);
            $report->setRp_time_to($rp_time_to);
            $report->setRp_content($rp_content);
            $report->setReportcate_id($reportcate_id);
        }
        return $report;
        }
        public function update(Report $report): bool {
            $sqlUpdate = "UPDATE reports SET rp_date = :rp_date, rp_time_from = :rp_time_from, rp_time_to = :rp_time_to , rp_content = :rp_content, rp_created_at = :rp_created_at ,reportcate_id = :reportcate_id WHERE id = :id";
            $stmt = $this->db->prepare($sqlUpdate);
            $stmt->bindValue(":rp_date", $report->getRp_date(), PDO::PARAM_INT);
            $stmt->bindValue(":rp_time_from", $report->getRp_time_from(), PDO::PARAM_STR);
            $stmt->bindValue(":rp_time_to", $report->getRp_time_to(), PDO::PARAM_STR);
            $stmt->bindValue(":rp_content", $report->getRp_content(), PDO::PARAM_STR);
            $stmt->bindValue(":rp_created_at", $report->getRp_created_at(), PDO::PARAM_STR);
            $stmt->bindValue(":reportcate_id", $report->getReportcate_id(), PDO::PARAM_STR);
            $stmt->bindValue(":id", $report->getId(), PDO::PARAM_INT);
            $result = $stmt->execute();
            return $result;
            }
        public function insert(Report $report): bool {
            $sqlUpdate = "INSERT INTO reports (rp_date,rp_time_from,rp_time_to,rp_content,rp_created_at,reportcate_id,user_id)value(:rp_date,:rp_time_from,:rp_time_to,:rp_content,:rp_created_at,:reportcate_id,:user_id)";
            $stmt = $this->db->prepare($sqlUpdate);
            $stmt->bindValue(":rp_date", $report->getRp_date(), PDO::PARAM_INT);
            $stmt->bindValue(":rp_time_from", $report->getRp_time_from(), PDO::PARAM_STR);
            $stmt->bindValue(":rp_time_to", $report->getRp_time_to(), PDO::PARAM_STR);
            $stmt->bindValue(":rp_content", $report->getRp_content(), PDO::PARAM_STR);
            $stmt->bindValue(":rp_created_at", $report->getRp_created_at(), PDO::PARAM_STR);
            $stmt->bindValue(":reportcate_id", $report->getReportcate_id(), PDO::PARAM_STR);
            $stmt->bindValue(":user_id", $report->getUser_id(), PDO::PARAM_INT);
            $result = $stmt->execute();
            if($result) {
                $rpId = $this->db->lastInsertId();
                }
                else {
                $rpId = -1;
                }
                return $rpId;
            }
        public function delete(int $id): bool {
            $sql = "DELETE FROM reports WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(":id", $id, PDO::PARAM_INT);
            $result = $stmt->execute();
            return $result;
            }
}