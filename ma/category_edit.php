<?php 
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
# 6-3
echo "<h2>カテゴリ編集</h2>";

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
if( isset($_GET['err'] ) ){
	echo "<p>同名のカテゴリがあります。</p>";
	echo "<p></p>";
}
#--------------------------------------------------------
$cid = htmlentities($_GET['cid'], ENT_QUOTES, "UTF-8" );
#--------------------------------------------------------
# DB 取得
#$db = new PDO("mysql:dbname=tsukasadb", "root", "root");
#$db->query("SET NAMES utf8;");
$db = db();
#--------------------------------------------------------
# オブジェクト作成
$sql = $db->prepare('SELECT * FROM category WHERE cid=?');
$sql->bindValue(1, $cid);
$sql->execute();
$data = $sql->fetch();
$cname = $data['cname'];

#--------------------------------------------------------
echo "<form method=\"GET\" action=\"category_edit2.php\">";
echo "<input type=\"hidden\" name=\"cid\" value=$cid>";
echo "カテゴリ:<input type=\"text\" name=\"cname\" value=$cname><br>";
echo "<input type=\"submit\" value=\"更新\">";
echo "</form>";
echo "<form method=\"GET\" action=\"category_main.php\">";
echo "<input type=\"submit\" value=\"キャンセル\">";
echo "</form>";
#--------------------------------------------------------

echo "<p></p>";
echo "<td><a href=\"category_main.php\" >カテゴリ操作へ</td>";
?>

<!-- コンテンツ -->

</body>
</html>
