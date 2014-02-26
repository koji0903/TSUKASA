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
<h1>TSUKASA　Shop</h1>
<!-- ヘッダー -->

<?php
# 6-2 ファイル追加
# カテゴリ追加２

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
$cate = htmlentities($_GET['cate'], ENT_QUOTES, "UTF-8" );
#--------------------------------------------------------
# DB 取得
#$db = new PDO("mysql:dbname=tsukasadb", "root", "root");
#$db->query("SET NAMES utf8;");
$db = db();
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
$sql = $db->prepare('INSERT INTO category ( cname ) VALUES ( ? )');
$sql->bindValue(1, $cate);
if( ! $sql->execute() ) {
	echo "<p>DBにオブジェクトが追加できませんでした</p>";
	echo "<p></p>";
	echo "<td><a href=\"category_main.php\" >カテゴリ操作へ</td>";
	exit;
}

header("Location: category_main.php");	
?>

<!-- コンテンツ -->

</body>
</html>
