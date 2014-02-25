<?php 
	require_once("./../common.php");
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
<?php 
	session_start();
	$uid =1 ;
	
	db();
	$sql = $db->prepare("SELECT * FROM rireki,shouhin WHERE uid =? AND rireki.sid=shouhin.sid ORDER BY hizuke DESC");
	bindVlalue(1,$uid) ;
	$sql->execute();

	$all = $sql->fetchALL();

	echo '<table>';
		echo '<tr>';
			echo '<th>商品名</th>' ;
			echo '<th>金額</th>' ;
			echo '<th>日時</th>' ;
		echo '</tr>' ;
		foreach ($all as $data){
			echo '<tr>';
				echo "<td>htmlentities{$data['sname']}</td>";
				echo "<td>htmlentities{$data['kakaku']}</td>";
				echo "<td>htmlentities{$data['hizuke']}</td>";
			echo '</tr>';
		}
	echo '</table>';

?>

　<a href="sh/mypage_show.php"登録情報変更</a>


</body>
</html>
