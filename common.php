<?php 
// データベースの基本処理
function db()
{
	$db = new PDO("mysql:dbname=TSUKADADB", "", "");
	$db->query("SET NAMES utf8;");
	return $db;
}
// GIDの取得関数
function getGID($uid)
{
	$db = db();
	$sql = $db->prepare('SELECT gid FROM user WHERE uid = ?;');
	$sql->bindValue(1,$uid);
	if ( $sql->execute() ){
		$data = $sql->fetch(PDO::FETCH_ASSOC);
		return $data['gid'];
	}
	else
	{
		// データベースアクセス失敗
	}
}
?>
