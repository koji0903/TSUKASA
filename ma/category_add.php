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
<h1>TSUKASA Shop カテゴリ追加</h1>
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
if( isset($_GET['err'] ) ){
	echo "<p>同名のカテゴリがあります。</p>";
	echo "<p></p>";
}
#--------------------------------------------------------
if( isset($_GET['category']) ){
	$cate = $_GET['category'];

#--------------------------------------------------------
# DB 取得
	#$db = db();
	$db = new PDO("mysql:dbname=tsukasadb", "root", "root");
	$db->query("SET NAMES utf8;");
#--------------------------------------------------------
# オブジェクト作成
	$sql = $db->prepare('SELECT * FROM category WHERE=?');
	$sql->bindValue(1, $cate);
	$sql->execute();
	if( $sql->fetch() ) {
		# 該当する商品がある場合は何も表示しない
		echo "<td></td>";
	}
	else {
		# 該当する商品がない場合は 削除 を表示
		echo "<td><a href=\"category_del.php?cid=$cid\" >削除</td>";
	}
	$sql->execute();
$all = $sql->fetchAll();
$sql = null; #オブジェクト解放

}


#--------------------------------------------------------
echo "<form method=\"GET\" action=\"category_add2.php\">";
echo "カテゴリ:<input type=\"text\" name=\"cate\"><br>";
echo "<input type=\"submit\" value=\"追加\">";
echo "</form>";
#--------------------------------------------------------

echo "<p></p>";
echo "<td><a href=\"category_main.php\" >カテゴリ操作へ</td>";
?>

<!-- コンテンツ -->
</body>
</html>
