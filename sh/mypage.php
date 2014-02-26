<?php 
	require_once("./../common.php");
	session_start();   		//for debug
	$_SESSION['UID'] = 1 ; 	//for debug
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

<!-- コンテンツ -->
<?php 
//	session_start();		

	if(isset($_SESSION['UID'])){
		$uid = $_SESSION['UID']  ;
		$gid=getGID($uid);
		if (!$gid){
			header("location:http:../maintenance.php") ;
		}
		
	}else{
		header("location:http:../login.php");
	}
	
	$db = db();
	$sql = $db->prepare("SELECT * FROM rireki LEFT JOIN shouhin ON rireki.sid=shouhin.sid WHERE uid=? ORDER BY hizuke DESC");
	$sql->bindValue(1,$uid) ;
	$sql->execute();

	$all = $sql->fetchALL();

	echo '<table>';
	echo '<caption>購入履歴一覧</caption>' ;
		echo '<tr>';
			echo '<th>商品名</th>' ;
			echo '<th>金額</th>' ;
			echo '<th>日時</th>' ;
		echo '</tr>' ;
		foreach ($all as $data){
			echo '<tr>';
				$sname2=htmlentities($data['sname'],ENT_QUOTES,'UTF-8') ;
				echo "<td>$sname2</td>";
				$kakaku2=htmlentities($data['kakaku'],ENT_QUOTES,'UTF-8') ;
				echo "<td>$kakaku2</td>";
				$hizuke2=htmlentities($data['hizuke'],ENT_QUOTES,'UTF-8') ;
				echo "<td>$hizuke2</td>";
			echo '</tr>';
		}
	echo '</table>';
	$sql=null ;
?>

<br>
<br>
　<a href="mypage_show.php" >登録情報表示</a>


</body>
</html>
