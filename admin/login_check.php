<?php
try{
	//ホントはサニタイズ
	$post = $_POST;
	$name = $post["name"];
	$pass = $post["pass"];

	if(empty($name) === true or empty($pass) === true) {
		print "ログイン情報が間違っています。<br><br>";
		print "<form>";
		print "<a href='admin_login.php'>戻る</a>";
		print "</form>";
		exit();
	}

	require_once("../dbconnect.php");

	$dbh = new PDO($dsn, $user, $password);
	$dbh -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	$sql = "SELECT * FROM login WHERE name = :name";
	$stmt = $dbh -> prepare($sql);
	$stmt -> execute(array(':name' => $name));
	$rec = $stmt->fetch(PDO::FETCH_ASSOC);
	if(password_verify($pass, $rec['password'])){
		echo "ログイン認証に成功しました";
		session_start();
		$_SESSION["login"] = 1;
		$_SESSION["name"] = $rec["name"];
		header("Location:admin_top.php");
	}else{
		echo "ログイン認証に失敗しました";
		print "ログイン情報が間違っています。<br><br>";
		print "<form>";
		print "<a href='admin_login.php'>戻る</a>";
		print "</form>";
		exit();
	}
}

catch(Exception $e) {
	print "只今障害が発生しております。<br><br>";
	print "<a href='admin_login.php'>戻る</a>";
}
?>
