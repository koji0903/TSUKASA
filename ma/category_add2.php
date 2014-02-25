<?php 
	require_once("../common.php");
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
<meta http-equiv="Content-Style-Type" content="text/css">
<link rel="stylesheet" href="../my.css" content="text/css">
</head>
<body>
<h1>TSUKASA Shop カテゴリ追加２</h1>
<!-- ヘッダー -->

<?php
# デバッグ
$uid = 1;
$gid = 0;
#--------------------------------------------------------
#session_start();
#if( ! isset($_SESSION['uid']) ) {
if( ! isset($uid) ) {
	echo "uidがありません。ページ１へ";
#	header("Location: localhost/TSUKASA/login.php");
	exit;
}

#$uid = $_SESSION['uid'];
#$gid = getGID($uid);
if( $gid != 0 ) {
	echo "管理者ではありません。ページ８へ";
#	header("Location: localhost/TSUKASA/top.php");
	exit;

}
#--------------------------------------------------------
$cate = $_GET['cate'];
#--------------------------------------------------------
# DB 取得
#$db = db();
$db = new PDO("mysql:dbname=tsukasadb", "root", "root");
$db->query("SET NAMES utf8;");
#--------------------------------------------------------
# オブジェクト作成
$sql = $db->prepare('SELECT * FROM category WHERE cname=?');
$sql->bindValue(1, $cate);
$sql->execute();
#--------------------------------------------------------
# 既にカテゴリ名が存在する場合
if( $sql->fetch() ) {
	# 既にカテゴリ名が存在する場合
	header("Location: category_add.php?err");
	exit;
}
#--------------------------------------------------------
# 該当する商品がない場合はDBに追加する
# オブジェクト作成
$sql = $db->prepare('INSERT INTO category ( cname ) VALUES ( ? )');
$sql->bindValue(1, $cate);
if( ! $sql->execute() ) {
	echo "DBにオブジェクトが追加できませんでした";
}

header("Location: category_main.php");	

?>

<!-- コンテンツ -->

</body>
</html>
