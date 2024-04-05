<!DOCTYPE html>
<html lang="ja">
	<head>
		<title>トップページ - とけろぐ</title>
		<meta charset="utf-8">
		<link rel="stylesheet" href="style.css">
		<link rel="icon" href="/images/favicon.ico">
	</head>
	<body>
		<header><a href="index.php" class="title"><h1>とけろぐ</h1></a></header>
		<section class="outer">
			<h2>トップ</h2>
			<section class="inner">
				<form method="post" action="search.php">
					<input type="text" name="word" value="" placeholder="検索" required>
					<input type="submit" name="submit" value="検索">
				</form>
				<ul class='inner'>
<?php
try {

	if(empty($_GET["page"]) === true) {
		$page = 1; 
	} else {
		$get = htmlspecialchars($_GET, ENT_QUOTES);
		$page = htmlspecialchars($get["page"], ENT_QUOTES);
	}

	$now = $page -1;
	$card_max = 500;
	
	require_once("dbconnect.php");
	$dbh = new PDO($dsn, $user, $password);
	$dbh -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	$sql = "SELECT title FROM blog WHERE 1";
	$stmt = $dbh -> prepare($sql);
	$stmt -> execute();

	while(true) {
		$rec = $stmt -> fetch(PDO::FETCH_ASSOC);
		if(empty($rec["title"]) === true) {
			break;
		}
		$title[] = $rec["title"];
	}

	if(isset($title) === true) {

		$card_all = count($title);
		$page_max = ceil($card_all / $card_max);

		if($page === 1) {
			$sql = "SELECT id, title, content, date, status FROM blog ORDER BY id DESC LIMIT $now, $card_max";
			$stmt = $dbh -> prepare($sql);
			$stmt -> execute();
		} else {
			$now = $now * $card_max;
			$sql = "SELECT id, title, content, date, status FROM blog ORDER BY id DESC LIMIT $now, $card_max";
			$stmt = $dbh -> prepare($sql);
			$stmt -> execute();
		}

		while(true) {
			$rec = $stmt -> fetch(PDO::FETCH_ASSOC);
			if(empty($rec["title"]) === true) {
				break;
			}
			if($rec["status"] == 1){
				print "<li class='top'>";
				print "<p class='top_content_up'><time>";
				print $rec["date"]."</time></p>";
				print "<p class='top_content_down'><a class'top_link' href='page.php?id=".$rec['id']."'>";

				print strip_tags($rec["title"]);
				print "</a></p></li>";
			}
			
		}

		print "<div>";
		for($i = 1; $i <= $page_max; $i++) {
			if($i == $page) {
				print "<div>".$page."</div>";
			} else {
				print "<div><a href='index.php?id=".$i."'>";
				print $i."</a></div>";
			}
		}
		print "</div>";
	} else {
		print "<br><br>";
		print "記事はありません。";
	}

	$dbh = null;

}
catch(Exception $e) {
	print "異常";
	exit();
}

?>
				</ul>
			</section>
		</section>
	</body>
</html>
