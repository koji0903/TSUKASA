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
<h1>TSUKASA Shop カテゴリ操作</h1>
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
# 追加
echo "<p><a href=\"category_add.php\">カテゴリ追加</a>";
#--------------------------------------------------------
# DB 取得
#$db = db();
$db = new PDO("mysql:dbname=tsukasadb", "root", "root");
$db->query("SET NAMES utf8;");
#--------------------------------------------------------
# オブジェクト作成
$sql = $db->prepare('SELECT * FROM category');
$sql->execute();
$all = $sql->fetchAll();
$sql = null; #オブジェクト解放
#--------------------------------------------------------

echo "<table>";
echo "<tr>";
echo "<th>カテゴリ名</th>";
echo "<th>編集</th>";
echo "<th>削除</th>";
echo "</tr>";
foreach($all as $data) {
	$cid    = $data['cid'];
	$cname  = $data['cname'];

	echo "<tr>";
	echo "<td>$cname</td>";
	echo "<td><a href=\"category_edit.php?cid=$cid\">編集</a></td>";

	# オブジェクト作成
	$sql = $db->prepare('SELECT * FROM shouhin WHERE cid=?');
	$sql->bindValue(1, $cid);
	$sql->execute();
	if( $sql->fetch() ) {
		# 該当する商品がある場合は何も表示しない
		echo "<td></td>";
	}
	else {
		# 該当する商品がない場合は 削除 を表示
		echo "<td><a href=\"category_del.php?cid=$cid\" >削除</td>";
	}
	echo "</tr>";
}
echo "</table>";

echo "<p></p>";
echo "<td><a href=\"../maintenance.php\" >管理画面へ</td>";
?>

<!-- コンテンツ -->

</body>
</html>
