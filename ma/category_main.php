<?php
# git test 2014/02/28
session_start();
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
	disp_header2();
?>

<!-- コンテンツ -->
<?php
# 6-1
echo "<h2>カテゴリ操作</h2>";

# デバッグ
#$uid = 1;
#$gid = 0;
#--------------------------------------------------------
#if( ! isset($uid) ) {
if( ! isset($_SESSION['UID']) ) {
#	echo "uidがありません。ページ１へ";
	header("Location: ../login.php");
	exit;
}

$uid = $_SESSION['UID'];
$gid = getGID($uid);
if( $gid != 0 ) {
#	echo "管理者ではありません。ページ８へ";
	header("Location: ../top.php");
	exit;

}
#--------------------------------------------------------
# 追加
echo "<p><a href=\"category_add.php\">カテゴリ追加</a>";
#--------------------------------------------------------
# DB 取得
#$db = new PDO("mysql:dbname=tsukasadb", "root", "root");
#$db->query("SET NAMES utf8;");
$db = db();
#--------------------------------------------------------
# カテゴリのデータ取得
$sql = $db->prepare('SELECT * FROM category');
$sql->execute();
$all = $sql->fetchAll();
$sql = null; #オブジェクト解放
#--------------------------------------------------------
# 一覧表示
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

	# cid に一致するカテゴリデータの取得
	# (cid を取得してから比較から、一致するものを取得で記載している)
	$sql = $db->prepare('SELECT * FROM shouhin WHERE cid=?');
	$sql->bindValue(1, $cid);
	$sql->execute();
	if( $sql->fetch() ) {
		# 該当する商品がある場合は何も表示しない
		echo "<td></td>";
	}
	else {
		# 該当する商品がない場合は「削除」を表示
		echo "<td><a href=\"category_del.php?cid=$cid\" >削除</td>";
	}
	echo "</tr>";
}
echo "</table>";

echo "<p></p>";
echo "<td><a href=\"../maintenance.php\" >管理画面へ</td>";
?>

</body>
</html>
