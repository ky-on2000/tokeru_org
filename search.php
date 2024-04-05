<!DOCTYPE html>
<html lang="ja">
	<head>
		<title>トップページ - とけろぐ</title>
		<meta charset="utf-8">
		<link rel="stylesheet" href="style.css">
	</head>
	<body>
	<header><a href="index.php" class="title"><h1>とけろぐ</h1></a></header>
	<section class="outer">
		<h2>検索結果</h2>
		<section class="inner">
			<ul class='inner'>
<?php
// 直接アクセスされたらリダイレクト

if(!isset($_POST['word'])){
	header('Location:https://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'/');
	exit();
}

// $_POST['word']で入力値を取得 文字前後の空白除去&エスケープ処理
$word = htmlspecialchars($_POST['word'],ENT_QUOTES);
$word = trim(mb_convert_kana($word, 's', 'UTF-8'));
$splitWord = explode(' ',$word,200);
// 対象文字列が何もなかったらキーワード指定なしとする
if($splitWord === ""){
	print "キーワード指定なし";
} else {
	$condition_title = [];
	$condition_content = [];
	foreach ($splitWord as $keyword){
		$condition_title[] = "(title LIKE '%".$keyword."%')";
		$condition_content[] = "(content LIKE '%".$keyword."%')";
	}
	$conditions_title = implode(' AND ',$condition_title);
	$conditions_content = implode(' AND ',$condition_content);
}
try{
	require_once("dbconnect.php");
	$dbh = new PDO($dsn, $user, $password);
	
	$dbh -> setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
	$sql = "SELECT id, title, content, date, status FROM blog WHERE ($conditions_title) OR ($conditions_content)";
	
	$stmt = $dbh -> prepare($sql); 
	$stmt -> execute();
		$exist = false;
		while ($rec = $stmt -> fetch(PDO::FETCH_ASSOC)) {
			$title = $rec["title"];
			$content = $rec["content"];
			$id = $rec["id"];
			$date = $rec["date"];
			$status = $rec["status"];
			
			if ($status == 1){
				$exist = true;
				print "<li class='top'>";
				print "<p class='top_content_up'><time>";
				print $date."</time></p>";
				print "<p class='top_content_down'><a class'top_link' href='page.php?id=".$rec['id']."'>";

				print strip_tags($title);
				print "</a></p></li>";
			}
		}
		if ($exist === false){
			print "<p>該当の記事がありません</p>";
		}
		
}catch(Exception $e){
	print "error";
}
?>
				</ul>
			</section>
		</section>
	</body>
</html>