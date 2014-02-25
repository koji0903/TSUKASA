<?php 
	session_start();
	setcookie(session_name(), session_id(), time()+60*5);
	require_once("./common.php");
	// セッションチェック（まだ未実装）
	// ログイン選択
	$_SESSION['uid'] = 1;
	if ( isset($_SESSION['uid']) ){
		$uid = $_SESSION['uid'];
	}else{
		$uid = 0;		
	}
	$uid =1 ;

	// セッション更新
	if ( isset($_GET['buy']) ){
		echo "<p>カートに追加</p>";
		if ( isset($aaa['buy']) ){
			echo "<p>bbb</p>";			
			$ary = $aaa['buy'];
			print_r ($ary);
		}else{
			$ary = array();
		}
		$aaa['buy'] = $ary;
		print_r( $ary );
		foreach ( $aaa as $key => $value ){
		  echo "$key -> $value";
		  if ( $key == 'buy' ){
			  	echo "<p>aaa</p>";
			  foreach( $value as $sid ){
			  	echo "$sid";
			  }		  	
		  }
		}
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
<?php
	$db = db();


	// カテゴリ選択
	if ( isset($_GET['category']) ){
		$selected_category = $_GET['category']; // 初期値
	}else{
		$selected_category = "all"; // 初期値
	}

	$sql = $db->prepare('SELECT cid, cname FROM category');
	if ( $sql->execute() ){
		$all = $sql->fetchAll(PDO::FETCH_ASSOC);
		echo "<form method=\"GET\" action=\"./top.php\">";
		echo "<p>カテゴリー選択";
		echo "<select name=\"category\">";
		if ( $selected_category == "all" ){
			echo "<option value=\"all\" selected>全部</option>";
		}else{
			echo "<option value=\"all\">全部</option>";
		}
		foreach ( $all as $data ){
			if ( $data['cid'] == $selected_category ){
				echo "<option value=\"{$data['cid']}\" selected>{$data['cname']}</option>";
			}else{
				echo "<option value=\"{$data['cid']}\">{$data['cname']}</option>";				
			}
		}
		echo "</select>";
		echo "<input type=\"submit\" value=\"更新\">";
		echo "</form>";
		echo "</p>";
	}
	$sql = null;

	// 一覧表示
	if ( $selected_category == "all" ){
		// 全部表示
		$sql = $db->prepare('SELECT sid, sname, category.cname as cname, kakaku, setsumei FROM shouhin, category WHERE shouhin.cid = category.cid');
	}else{
		// 選択されたカテゴリのみを表示
		$sql = $db->prepare('SELECT sid, sname, category.cname as cname, kakaku, setsumei FROM shouhin, category WHERE shouhin.cid = category.cid AND shouhin.cid = ?');
		$sql->bindValue(1, $selected_category);
	}
	if ( $sql->execute() ){
		// "shouhin"テーブルからデータを取得
		echo "<table>";
		$all = $sql->fetchAll(PDO::FETCH_ASSOC);
		echo "<tr><th>商品名</th><th>カテゴリ</th><th>価格</th><th>説明</th><th>画像</th>";
		if ( $uid != 0 ){
			echo "<th>カートへ追加</th>";
		}
		echo "</tr>";
		foreach ( $all as $data ){
			echo "<tr>";
			echo "<td>{$data['sname']}</td>";
			echo "<td>{$data['cname']}</td>";
			echo "<td>{$data['kakaku']}円</td>";
			echo "<td class=\"setsumei\">{$data['setsumei']}円</td>";
			// 画像ファイルチェックを行って出力
			$img = "img/" . $data['sid'] . ".jpg" ;
			if ( file_exists($img) ){
				echo "<td><img src=\"${img}\" height=\"150\" width=\"200\"></td>";
			}else{
				echo "<td>no picture</td>";
			}

			// ログイン時には、"カートへ追加"のリンク出力。クリック時にはsid情報を持ってリダイレクト
			if ( $uid != 0 ){
				echo "<td>";
				if ( $selected_category == "all" ){
					echo "<a href=\"./top.php?category=all&buy={$data['sid']}\"><button>カートへ追加</button></a>";
				}else{
					echo "<a href=\"./top.php?category={$selected_category}&buy={$data['sid']}\"><button>カートへ追加</button></a>";
				}
				echo "</td>";
			}
			echo "</tr>";
		}
		echo "</table>";
	}
	else
	{
		echo "<p>DBアクセスエラー</p>";
	}

?>
	</table>
</body>
</html>
