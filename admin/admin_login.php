<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="utf-8">
	<meta name="robots" content="noindex,nofollow">
	<title>管理画面ログイン</title>
</head>

<body>
	<p>ログイン情報を入力してください。</p>
	<form action="login_check.php" method="post">
		<p>管理者名</p>
		<p><input type="text" name="name"></p>
		<p>パスワード</p>
		<p><input type="password" name="pass"></p>
		<p><input type="submit" value="ログイン"></p>
	</form>
</body>
</html>
