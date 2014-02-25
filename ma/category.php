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

#echo "uid は $uid です";
#--------------------------------------------------------
# DB 取得
#$db = db();
$db = new PDO("mysql:dbname=tododb", "root", "root");
$db->query("SET NAMES utf8;");
#--------------------------------------------------------
# オブジェクト作成
$sql = $db->prepare('SELECT * FROM category');
$sql->execute();
$all = $sql->fetchAll();

echo '</table>';
echo '<tr>';
echo '<th>カテゴリ名</th>';
echo '<th>編集</th>';
echo '<th>削除</th>';
echo '</tr>';
foreach($all as $data) {
	$tid    = $data['cname'];
	$cid    = $data['cid'];
	$shori  = "処理済み";
	$tcheck = 0; // 未処理
	if($data['tcheck'] == 0) {
		$shori  = "未処理";
		$tcheck = 1; // 処理済み
	}
	echo '<tr>';
	echo "<td><a href=\"todo.php?mode=shori&uid=${uid}&tid=${tid}&tcheck=${tcheck}\">${shori}</a></td>";
	echo "<td><a href=\"updatetodo.php?uid=${uid}&tid=${tid}&cid=${cid}\">${data['title']}</a></td>";
	echo "<td>${data['utime']}</td>";
	echo "<td>${data['cname']}</td>";
	echo '</tr>';
}
echo '</table>';

$sql = null; #オブジェクト解放
?>

<!-- コンテンツ -->
</body>
</html>
