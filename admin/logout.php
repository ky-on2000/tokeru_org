<?php
session_start();
$_SESSION = array();
if(isset($_COOKIE[session_name()]) === true) {
    setcookie(session_name(), "", time()-42000, "/");
}
session_destroy();
?>
 
<!DOCTYPE html>
<html lang="ja">
<head>
	<meta name="robots" content="noindex,nofollow">
	<meta charset="utf-8">
	<title>ログアウト</title>
</head>
<body>
	<p>ログアウトしました。</p>
	<a href="admin_login.php">ログイン画面へ</a>
</body>
</html>
