<?php
//	require_once("./common.php");
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

	<p><a href="goods_add.php">新規追加</a></p>
	<p><a href="../maintenance.php">戻る</a></p>


	<?php
	  $db = new PDO("mysql:dbname=tsukasadb","root","root");
	  $db->query('SET NAMES utf8;');
		$sql = $db->prepare('SELECT sid,sname,kakaku,cname FROM shouhin JOIN category ON shouhin.cid=category.cid;');
		$sql->execute();

		$all = $sql->fetchAll();
		$sql = null;

	  echo '<table>';
	  echo '<tr><th>商品名</th><th>カテゴリ</th><th>価格</th><th>編集</th><th>削除</th></tr>';

	  foreach( $all as $data ){
	    echo '<tr>';
	    // 商品名表示
	    echo "<td>{$data['sname']}</td>";
	    // カテゴリ表示
	    if( $data['cname'] == NULL ){
	    	echo "指定なし";
	    }else{
		    echo "<td>{$data['cname']}</td>";
	    }
	    // 価格表示
	    echo "<td>{$data['kakaku']}</td>";
	    // 編集リンク
	    echo '<td><a href="goods_edit.php?sid=' . $data['sid'] . '">';
	    echo '<button>' . '編集' . '</button></td>';
	    //　削除リンク
	    echo '<td><a href="goods_del.php?sid=' . $data['sid'] . '">';
	    echo '<button>' . '削除' . '</button></td>';

	    echo '</tr>';
	  }
	?>

</body>
</html>
