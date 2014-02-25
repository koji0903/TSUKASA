<?php
	require_once("../common.php");
		// debug
	$_SESSION['UID'] = 2;

	if ( ! isset($_SESSION['UID']) ) {
		header("Location: ../login.php");
		exit;
	} else 	if ( getGID($_SESSION['UID']) != 0 ) {
		header("Location: ../top.php");
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
<h2>購入者情報</h2>
<!-- テーブル表示 -->
<?php
	// GET取得(nullの場合は存在しないIDにしておく)
	$uid = (isset($_GET['uid'])) ? $_GET['uid'] : 0;

	try {
		$db = db();

		$sql = $db->prepare("SELECT * FROM user WHERE uid=:uid");
		$sql->bindValue(":uid", $uid);
		$sql->execute();
		if ( $sql->rowCount() > 0 ) {
			$data = $sql->fetch();
			echo "<table border=1>\n";
			echo '<thead>';
			// echo '<th>ID(デバッグ)</th>'; // デバッグ
			echo '<th>購入者</th>';
			echo '<th>住所</th>';
			echo '<th>メールアドレス</th>';
			echo "</thead>\n";
			echo "<tr>";
			// echo "<td>", $data['uid'], "</td>"; // デバッグ
			// 購入者
			$uname = (isset($data['uname'])) ? htmlentities(
				$data['uname'],ENT_QUOTES,'UTF-8') : "";
			echo "<td>", $uname, "</td>";
			// 住所
			$address = (isset($data['address'])) ? htmlentities(
				$data['address'],ENT_QUOTES,'UTF-8') : "";
			echo "<td>", $address, "</td>";
			// メールアドレス
			$mail = (isset($data['mail'])) ? htmlentities(
				$data['mail'],ENT_QUOTES,'UTF-8') : "";
			echo "<td>", $mail, "</td>";
			echo "</tr>\n";
			echo "</table>";
		} else {
			echo "該当のユーザは存在しません<br>";
		}
		$sql = null; // オブジェクトの解放
	}
	catch (PDOException $ex) {
		echo "データベースのエラー";
		echo $ex->getMessage();
		exit(0);
	}

?>

<!-- 履歴へ戻るリンク -->
<a href="history_main.php">履歴へ戻る</a>

</body>
</html>
