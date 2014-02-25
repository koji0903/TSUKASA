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
    $db = new PDO("mysql:dbname=tsukasadb","root","root");
    $db->query('SET NAMES utf8;');

    // カテゴリリストの習得
    $sql = $db->prepare('SELECT * FROM category');
    $sql->execute();
    $all = $sql->fetchAll();
    $sql=null;

		// エラーメッセージ出力
	  if( isset( $_GET['err']) ){
	  		$err = $_GET['err'];
	  		if( $err==1 ){
	  			echo '<h3>すでに登録されている商品です。</h3>';
	  		}else if( $err==2 ){
	  			echo '<h3>登録に失敗しました。</h3>';
	  		}
	  	}
	?>

  <p>
    <p>　■　製品情報を選択</p>
    <form action="goods_add2.php" method="post" enctype="multipart/form-data">
      商品名 <input type="text" name="sname"><br>
      価格 <input type="text" name="kakaku"><br>
      カテゴリ <select name="cid">
      <?php
        foreach( $all as $data ){
          echo '<option value="' . $data['cid'] . '">' . $data['cname'] . '</option>';
        }
      ?>
      </select><br>
      説明 <input type="text" name="setsumei"><br>
      <p>　■　画像データ(jpg)</p>
		  <input type="file" name="fname"><br><br>
      <input type="submit" value="登録実行"><br>
    </form>
  </p>


</body>
</html>
