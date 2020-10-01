<?php

namespace LocalHALPH34\sharereports\classes\DAO;

use PDO;
use LocalHalPH34\sharereports\classes\entity\User;
/**
* usersテーブルへのデータ操作クラス。
*/
class UserDAO {
/**
* @var PDO DB接続オブジェクト
*/
private $db;

/**
* コンストラクタ
*
* @param PDO $db DB接続オブジェクト
*/
public function __construct(PDO $db) {
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
$this->db = $db;
}

/**
* ログインIDによる検索。
*
* @param string $loginId ログインID。
* @return User 該当するUserオブジェクト。ただし、該当データがない場合はnull。
*/
public function findByLoginid(string $loginId): ?User {
$sql = "SELECT * FROM users WHERE us_mail = :us_mail";
$stmt = $this->db->prepare($sql);
$stmt->bindValue(":us_mail", $loginId, PDO::PARAM_STR);
$result = $stmt->execute();
$user = null;
if($result && $row = $stmt->fetch(PDO::FETCH_ASSOC)) {
$id = $row["id"];
$us_name = $row["us_name"];
$passwd = $row["us_password"];
$mail = $row["us_mail"];

$user = new User();
$user->setId($id);
$user->setName($us_name);
$user->setPasswd($passwd);
$user->setMail($mail);
}
return $user;
}
}