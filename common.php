<?php 
// データベースの基本処理
function db()
{
	$db = new PDO("mysql:dbname=TSUKADADB", "", "");
	$db->query("SET NAMES utf8;");
	return $db;
}
// GIDの取得関数
function getGID()
{
	$db = db();
}
?>
