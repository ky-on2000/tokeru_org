<?php
try {
	require_once("dbconnect.php");
	$PDO = new PDO($dsn, $user, $password); //PDOでMySQLのデータベースに接続
	$PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
	
  	$id = $_GET["id"];
	//modify.phpの値を取得
	$title = $_POST['title'];
	$content = $_POST['content'];
	$status = $_POST['status'];
	$tagAfterUpdate = explode(',',$_POST['tag'],200);

	$sql = "UPDATE blog SET title = :title, content = :content, status = :status WHERE id = :id"; 
	$stmt = $PDO->prepare($sql); //値が空のままSQL文をセット
	$params = array(':title' => $title, ':content' => $content, ':status' => $status, ':id' => $id); // 挿入する値を配列に格納
	$stmt->execute($params); //挿入する値が入った変数をexecuteにセットしてSQLを実行
	
	//タグの設定
	//取得
 	$sql = "SELECT tag FROM tag WHERE id=$id";
	$stmt = $PDO -> prepare($sql);
 	$stmt -> execute();
 	$tagBeforeUpdate = $stmt -> fetchAll(PDO::FETCH_COLUMN);
	
	//消去＆追加
	foreach ($tagAfterUpdate as $row) {
		$exist = 0;
		foreach ($tagBeforeUpdate as $row2) {
			if ($row == $row2){
				$exist = 1;
				break;
			}
		}
		if($exist === 0){
			print "insert".$row;
			$sql = "INSERT INTO tag (id, tag) VALUES (:id, :tag)";
			$stmt = $PDO->prepare($sql); 
			$params2 = array(':id' => $id, ':tag' => $row);
			$stmt->execute($params2);
		}
	}
	foreach($tagBeforeUpdate as $row2){
		$exist = 0;
		foreach ($tagAfterUpdate as $row) {
			if($row2===$row){
				$exist = 1;
				break;
			}
		}
		if ($exist === 0) {
			print "delete".$row2;
			$sql = "DELETE FROM tag WHERE id=:id AND tag=:tag";
			$stmt = $PDO->prepare($sql);
			$params = array(':id' => $id, ':tag' => $row2);
			$stmt->execute($params);
		}
	}
	
	// 登録内容確認・メッセージ
	echo "<p>title: " . $title . "</p>";
	echo "<p>content: " . $content . "</p>";
	echo '<p>上記の内容をデータベースへ登録しました。</p>';
} catch (PDOException $e) {
	exit('データベースに接続できませんでした。' . $e->getMessage());
}
?>
