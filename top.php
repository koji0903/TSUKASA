<?php 
	session_start();
	setcookie(session_name(), session_id(), time()+60*5);
	require_once("./common.php");
	// セッションチェック（まだ未実装）
	// デバッグ
	if ( isset($_GET['debug']) ){
		echo "<p>Degug Mode!</p>";
		$_SESSION['UID'] = 1;
		$debug = "debug&";
	}else{
		$debug = "";
	}

	// ログインチェック
	if ( isset($_SESSION['UID']) ){
		$uid = $_SESSION['UID'];
		$gid = getGID($uid);
		if ( $gid != 0 ){
			$login = "true";
		}else{
			$login = "false";
		}
	}else{
		$uid = 0;
		$gid = 1;
		$login = "false";
	}

	// セッション更新
	if ( isset($_GET['buy']) ){
		if ( isset($_SESSION['SID']) ){
			$ary = $_SESSION['SID'];
		}else{
			$ary = array();
		}
		array_push( $ary, $_GET['buy']);
		$ary = array_unique($ary);
		$_SESSION['SID'] = $ary;

		// foreach ( $_SESSION as $key => $value ){
		//   echo "$key -> $value";
		//   if ( $key == 'SID' ){
		// 	  foreach( $value as $sid ){
		// 	  	echo "$sid, ";
		// 	  }		  
		//   }
		// }

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
	$db = db();

	// ログイン状態表示
	if ( $gid == 0 ){
		$group = "管理者";
	}else{
		$group = "ユーザ";
	}
	if ( $login == "true" ){
		echo "<p>ログイン中({$group})</p>";
	}else{
		if ( $gid == 0 ){
			echo "<p>管理者でログイン中</p>";
		}else{
			echo "<p>ログインしていません</p>";
		}
	}

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
			echo "<option value=\"all\" selected>ALL</option>";
		}else{
			echo "<option value=\"all\">ALL</option>";
		}
		foreach ( $all as $data ){
			$cname = htmlentities($data['cname'],ENT_QUOTES, "UTF-8");
			if ( $data['cid'] == $selected_category ){
				echo "<option value=\"{$data['cid']}\" selected>{$cname}</option>";
			}else{
				echo "<option value=\"{$data['cid']}\">{$cname}</option>";				
			}
		}
		echo "</select>";
		if ( isset($_GET['debug']) ){
			echo "<input type=\"hidden\" name=debug value=1>";
		}
		echo "<input type=\"submit\" value=\"更新\">";
		echo "</form>";
		echo "</p>";
	}
	$sql = null;

	// 選択されたカテゴリの数をカウント
	if ( $selected_category == "all" ){
		$count = 100; // 適当な数値
	}else{
		$sql = $db->prepare('SELECT count(*) FROM shouhin WHERE cid = ?');
		$sql->bindValue(1, $selected_category);
		if ( $sql->execute() ){
			$count = $sql->fetchColumn();
		}
		$sql = null;
	}

	// テーブル表示
	if ( $count == 0 ){
		echo "<p>選択されたカテゴリに該当する製品はありません</p>";
	}else{
		// 一覧表示
		if ( $selected_category == "all" ){
			// 全部表示
//			$sql = $db->prepare('SELECT sid, sname, category.cname as cname, kakaku, setsumei FROM shouhin, category WHERE shouhin.cid = category.cid');
			$sql = $db->prepare('SELECT sid, sname, category.cname as cname, kakaku, setsumei FROM shouhin LEFT JOIN category ON shouhin.cid = category.cid');
		}else{
			// 選択されたカテゴリのみを表示
//			$sql = $db->prepare('SELECT sid, sname, category.cname as cname, kakaku, setsumei FROM shouhin, category WHERE shouhin.cid = category.cid AND shouhin.cid = ?');
			$sql = $db->prepare('SELECT sid, sname, category.cname as cname, kakaku, setsumei FROM shouhin LEFT JOIN category ON shouhin.cid = category.cid AND shouhin.cid = ?');
			$sql->bindValue(1, $selected_category);
		}
		if ( $sql->execute() ){
			// "shouhin"テーブルからデータを取得
			echo "<table>";
			$all = $sql->fetchAll(PDO::FETCH_ASSOC);
			echo "<tr><th>商品名</th><th>カテゴリ</th><th>価格</th><th>説明</th><th>画像</th>";
			if ( $login == "true" ){
				echo "<th>カートへ追加</th>";
			}
			echo "</tr>";
			foreach ( $all as $data ){
				// XSS対策
				$sname = htmlentities($data['sname'],ENT_QUOTES, "UTF-8");
				if ( $data['cname'] != null ){
					$cname = htmlentities($data['cname'],ENT_QUOTES, "UTF-8");
				}else{
					$cname = "なし";
				}
				$kakaku = htmlentities($data['kakaku'],ENT_QUOTES, "UTF-8");
				$setsumei = htmlentities($data['setsumei'],ENT_QUOTES, "UTF-8");

				echo "<tr>";
				echo "<td>{$sname}</td>";
				echo "<td>{$cname}</td>";
				echo "<td>{$kakaku}円</td>";
				echo "<td class=\"setsumei\">{$setsumei}</td>";
				// 画像ファイルチェックを行って出力
				$img = "img/" . $data['sid'] . ".jpg" ;
				if ( file_exists($img) ){
					echo "<td><img src=\"${img}\" height=\"150\" width=\"200\"></td>";
				}else{
					echo "<td>no picture</td>";
				}

				// ログイン時には、"カートへ追加"のリンク出力。クリック時にはsid情報を持ってリダイレクト
				if ( $login == "true" ){
					echo "<td>";
					if ( $selected_category == "all" ){
						echo "<a href=\"./top.php?{$debug}category=all&buy={$data['sid']}\"><button>カートへ追加</button></a>";
					}else{
						echo "<a href=\"./top.php?{$debug}category={$selected_category}&buy={$data['sid']}\"><button>カートへ追加</button></a>";
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
	}

?>
	</table>
</body>
</html>
