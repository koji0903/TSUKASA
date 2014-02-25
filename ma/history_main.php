<?php
	require_once("../common.php");
	// debug
	$_SESSION['UID'] = 2;

	if ( ! isset($_SESSION['UID']) ) {
		header("Location: login.php");
		exit;
	} else 	if ( getGID($_SESSION['UID']) != 0 ) {
		header("Location: top.php");
		exit;
	}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
<meta http-equiv="Content-Style-Type" content="text/css">
<link rel="stylesheet" href="my.css" content="text/css">
</head>
<body>
<h1>TSUKASA　Shop</h1>
<!-- ヘッダー -->

<!-- コンテンツ -->
<h2>購入履歴</h2>
<!-- テーブル表示 -->
<?php
try {
	$db = db();

	$sql = $db->prepare("SELECT * FROM rireki,shouhin,user WHERE shouhin.sid=rireki.sid AND rireki.uid=user.uid ORDER BY hizuke DESC");
	$sql->execute();
	if ( $sql->rowCount() > 0 ) {
		$all = $sql->fetchall();

		echo "<table border=1>\n";
		echo '<thead>';
		// echo '<th>ID(デバッグ)</th>'; // デバッグ
		echo '<th>購入日</th>';
		echo '<th>商品名</th>';
		echo '<th>購入者</th>';
		echo "</thead>\n";
		foreach ($all as $data) {
			echo "<tr>";
			// echo "<td>", $data['rid'], "</td>"; // デバッグ
			echo "<td>", $data['hizuke'], "</td>";
			$sname = (isset($data['sname'])) ? htmlentities(
				$data['sname'],ENT_QUOTES,'UTF-8') : "";
			echo "<td>", $sname, "</td>";
			$uname = (isset($data['uname'])) ? htmlentities(
				$data['uname'],ENT_QUOTES,'UTF-8') : "";
			echo '<td><a href="history_user.php?uid=',
				$data['uid'], '">', $uname, "</a></td>";
			echo "</tr>\n";
		}
		echo "</table>";
		$sql = null; // オブジェクトの解放

	} else {
		echo "購入履歴がありません";
	}
}
catch (PDOException $ex) {
	echo "データベースのエラー";
	echo $ex->getMessage();
	exit(0);
}
?>

</body>
</html>
