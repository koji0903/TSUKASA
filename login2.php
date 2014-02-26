<?php 
	session_start();
	setcookie(session_name(), session_id(), time() + 60*60);

	require_once("./common.php");
	
	if(!(isset($_GET['mail']) && isset($_GET['password']))){
		header("Location: ./login.php");
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
<?php
	disp_header();
?>
<!-- コンテンツ -->
	<?php
		$mail    = $_GET[ 'mail' ];
		$password = $_GET['password'];
		
		$db = db();
		
		$sql = $db->prepare('SELECT * FROM user WHERE mail = :mail AND password = :password');
		
		$sql->bindValue(':mail',$mail);
		$sql->bindValue(':password',md5($password));
		//SQLの実行
		$sql->execute();
		$data = $sql->fetch();
	
		if($data){
			$_SESSION['uid'] = $data['uid']; 
			$gid = getGID($data['uid']);
			if($gid == 1){ //ユーザ権限
				echo "<h1>ユーザー権限でログインしました</h1><br>";
				echo '<a href="./top.php">トップへ</a>';
			}
			else{ //管理者権限
				echo "<h1>管理者権限でログインしました</h1><br>";
				echo '<a href="./maintenance.php">トップへ</a>';
			}
		}
		else{
			echo "<h1>ユーザー名またはパスワードが違います。</h1>";
			echo '<a href="./login.php">ログインページへ</a>';
		}
	?>
	
</body>
</html>
