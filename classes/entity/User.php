<?php 

namespace LocalHalPH34\sharereports\classes\entity;

/**
 * ユーザエンティティクラス。
 */

 class User{
     private $id;
     private $login;
     private $passwd;
     private $name;
     private $mail;

     public function getId(): ?int{
         return $this->id;
     }
     public function setId(int $id):void {
         $this->id = $id;

     }
     public function getLogin(): ?string{
         return $this->login;
     }
     public function setLogin(string $login):void{
         $this->login = $login;
     }
     public function getPasswd(): ?string{
         return $this->passwd;
     }
     public function setPasswd(string $passwd): void{
         $this->passwd = $passwd;
     }
     public function getName():?string{
         return $this->name;
     }
     public function setName(string $name):void{
         $this->name = $name;
     }
     public function getMail():?string{
         return $this->mail;
     }
     public function setMail(string $mail): void{
         $this->mail = $mail;
     }
 }