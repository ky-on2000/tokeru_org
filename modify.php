<?php
    try {
	$id = $_GET["id"];
                
	require_once("dbconnect.php");
	$dbh = new pdo($dsn, $user, $password);
	$dbh -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	        
	$sql = "SELECT title, content, date, status FROM blog WHERE id=$id";
	$stmt = $dbh -> prepare($sql);
	$stmt -> execute();
	$rec = $stmt -> fetch(PDO::FETCH_ASSOC);
	
	$sql = "SELECT tag FROM tag WHERE id=$id";
	$stmt = $dbh -> prepare($sql);
 	$stmt -> execute();
 	$tagResults = $stmt -> fetchAll(PDO::FETCH_COLUMN);

    }
    catch(Exception $e) {
        print "異常";
        exit();
    }
?>
<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="utf-8">
	<meta name="robots" content="noindex,nofollow">
	<link rel="stylesheet" href="style.css">
	<script src="https://unpkg.com/turndown/dist/turndown.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js
"></script>
	<script>
		$(document).ready(function(){
			var turndownService = new TurndownService()
			document.getElementById("markdown_input").innerHTML = turndownService.turndown(document.getElementById("content_input").value);
			$("textarea").keyup(function(){
                MDtoHTML();
            });
			$('#HTML2MD').on('click', function() {
				document.getElementById("markdown_input").innerHTML = turndownService.turndown(document.getElementById("content_input").value);
			});
        });
		
		function MDtoHTML(){
			 document.getElementById("content_input").innerHTML =
             marked.parse(document.getElementById("markdown_input").value);
		}
	</script>
</head>
<body>
	<form method="POST" action="update.php?id=<?php print $id;?>">
		<p>タイトル</p>
		<input type="text" name="title" class="title_input" value="<?php print $rec["title"]; ?>">
		<p>本文</p>
		<div class="MD_HTML">
			<div class="MD">
				<h3>Markdown</h3>
				<textarea name="MD" id="markdown_input" rows="50" cols="50"></textarea>
			</div>
		
			<div class="HTML">
				<h3>HTML</h3>
				<button id="HTML2MD" type="button">HTML to Markdown</button>
				<textarea name="content" id="content_input" rows="50" cols="50"><?php print $rec["content"]; ?></textarea>
			</div>
		</div>
		<br><br>
		
		
		<div class="tag_submit">
			<p>タグ　※,で区切ること</p>
			<textarea name="tag" class="tag_input"><?php foreach ($tagResults as $index => $row) {
				if ($index !== 0){
					print ',';
				}
				print $row;
			} ?></textarea>
			<p>
				<input type="radio" name="status" value="0"<?php if($rec["status"] == 0){ print ' checked'; } ?>>下書き
				<input type="radio" name="status" value="1"<?php if($rec["status"] == 1){ print ' checked'; } ?>>公開
			</p>
			<p><input type="submit" value="登録"></p>
		</div>
	</form>

</body>
</html>
