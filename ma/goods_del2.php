<?php
//	require_once("./common.php");
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
		$sid = $_GET['sid'];
    // 共通
	  $db = new PDO("mysql:dbname=tsukasadb","root","root");
	  $db->query('SET NAMES utf8;');

		$sql = $db->prepare( 'DELETE FROM shouhin WHERE sid=:sid');
		$sql->bindValue(':sid',$sid);
    if( $sql->execute() ){
      echo '削除しました。<br>';
    }else{
      echo '削除に失敗しました。<br>';
    }
    $sql = null;
  ?>

  <p><a href="goods_main.php">商品管理画面へ</a></p>

</body>
</html>
