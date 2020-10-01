<?php

namespace LocalHalPH34\sharereports\classes\entity;

class Report{
    private $id;
    private $rp_date;
    private $rp_time_from;
    private $rp_time_to;
    private $rp_content;
    private $rp_created_at;
    private $reportcate_id;
    private $user_id;
    private $cate_id;
    private $rc_name;
    private $us_name;
    private $us_mail;

    public function getId(): ?int {
        return $this->id;
        }
    public function setId(int $id): void {
    $this->id = $id;
    }
    public function getRp_date():?string{
        return $this->rp_date;
    }
    public function setRp_date(string $rp_date): void{
        $this->rp_date = $rp_date;
    }
    public function getRp_time_from(): ?string{
        return $this->rp_time_from;
    }
    public function setRp_time_from(string $rp_time_from) :void{
        $this->rp_time_from = $rp_time_from;
    }
    public function getRp_time_to(): ?string{
        return $this->rp_time_to;
    }
    public function setRp_time_to(string $rp_time_to):void{
        $this->rp_time_to = $rp_time_to;
    }
    public function getRp_content(): ?string{
        return $this->rp_content;
    }
    public function setRp_content(string $rp_content):void{
        $this->rp_content = $rp_content;
    }
    public function getRp_created_at(): ?string{
        return $this->rp_created_at;
    }
    public function setRp_created_at(string $rp_created_at):void{
        $this->rp_created_at = $rp_created_at;
    }
    public function getReportcate_id(): ?int{
        return $this->reportcate_id;
    }
    public function setReportcate_id(int $reportcate_id):void{
        $this->reportcate_id = $reportcate_id;
    }
    public function getUser_id():int{
        return $this->user_id;
    }
    public function setUser_id(int $user_id):void{
        $this->user_id = $user_id;
    }
    public function getCate_id():int{
        return $this->cate_id;
    }
    public function setCate_id(int $cate_id):void{
        $this->cate_id = $cate_id;
    }
    public function getRc_name():string{
        return $this->rc_name;
    }
    public function setRc_name(string $rc_name):void{
        $this->rc_name = $rc_name;
    }
    public function getUs_name():string{
        return $this->us_name;
    }
    public function setUs_name(string $us_name):void{
        $this->us_name =$us_name;
    }
    public function getUs_mail():string{
        return $this->us_mail;
    }
    public function setUs_mail(string $us_mail):void{
        $this->us_mail=$us_mail;
    }
}