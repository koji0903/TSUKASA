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
    $sname = $_POST['sname'];
    $kakaku = $_POST['kakaku'];
    $setsumei = $_POST['setsumei'];
    $cid = $_POST['cid'];

    // 共通
	  $db = new PDO("mysql:dbname=tsukasadb","root","root");
	  $db->query('SET NAMES utf8;');

		// すでに登録済みでないか確認
		$sql = $db->prepare('SELECT * FROM shouhin WHERE sname=:sname;');
		$sql->bindValue(':sname',$sname);
		$sql->execute();
		$data = $sql->fetch();
		$sql = null;

		if( !empty($data) ){
			// データがすでに登録済みである場合はエラーフラグを返す。
		  header("Location: goods_add.php?err=1");
		  exit;
		}else{

			if( !empty($setsumei) ){
				$sql = $db->prepare('INSERT INTO shouhin (sname,kakaku,setsumei,cid) VALUES(:sname,:kakaku,:setsumei,:cid);');
				$sql->bindValue(':setsumei',$setsumei);
			}else{
				$sql = $db->prepare('INSERT INTO shouhin (sname,kakaku,cid) VALUES(:sname,:kakaku,:cid);');
			}
			$sql->bindValue(':sname',$sname);
			$sql->bindValue(':kakaku',$kakaku);
			$sql->bindValue(':cid',$cid);

			if( $sql->execute() ){

				//　商品情報が登録されれば画像をアップロード
				$sql = $db->prepare('SELECT * FROM shouhin WHERE sname=:sname;');
				$sql->bindValue(':sname',$sname);
				$sql->execute();
				$data = $sql->fetch();

				echo '<h3>商品を登録しました</h3><br>';
				echo '商品ID：' . $data['sid'] . '<br>';
				echo '商品名：' . htmlentities( $data['sname'], ENT_QUOTES, "UTF-8" ) . '<br>';
				echo '価格：' . $data['kakaku'] . '<br>';

		    $tempfile = $_FILES['fname']['tmp_name'];
		    $filename = "../img/" . $data['sid'] . ".jpg";

			  if (is_uploaded_file($tempfile)) {
			    if ( move_uploaded_file($tempfile , $filename )) {
			      echo '画像：' . $filename . '<br>';
			    }else {
			      echo "ファイルをアップロードできません。" . '<br>';
			    }
			  }else {
		      echo '画像：未登録です' . '<br>';
			  }
			}else{
			  header("Location: goods_add.php?err=2");
			  exit;
			}

			echo '<p><a href="goods_main.php">商品一覧に戻る</a></p>';

		}
	?>

</body>
</html>
