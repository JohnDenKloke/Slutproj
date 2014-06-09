<!DOCTYPE html>
<html>
<head>
	<link type="text/css" rel="stylesheet" href="summary.css"/>
	<title>Summary!</title>
	<meta charset="utf-8"/>
</head>
<body>
<?php
	$host = "localhost";
	$dbname = "studenthelping";
	$username = "studenthelping";
	$password="123456";
	$dsn = "mysql:host=$host;dbname=$dbname";
	$attr = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC);

	$pdo = new PDO($dsn, $username, $password, $attr);
	
	if($pdo)
	{
		// om GET inte är tom, dvs den innehåller ngt
		if(!empty($_GET))
		{
			$_GET = null;
			// hämta ut från GET på id
			$post_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
			
			// skicka en fråga med id
			$statement = $pdo->prepare("SELECT posts.* FROM posts where id=:post_id");
			$statement->bindParam(":post_id", $post_id);
			if($statement->execute())
			{
				echo "<div id=\"container\">";
				while($row = $statement->fetch())
				{
					echo "<p> <span id=\"date\">Postats: {$row['date']}</span><span id=\"title\">{$row['title']}</span> <span id=\"text\"> {$row['text']}</span> <br/> <span id=\"author\">Skribent: {$row['author']}</span></p>";
				}
				echo "</div>";
			}
			?>
			<form action="?id=<?php echo $post_id ?>" method="post">
			<fieldset>
			<legend>Kommentera</legend>
			<p>
				<div id="titleset">
				<label for="titleinput" id="titlelabel">Titel:</label>
				<input type="text" name="title" placeholder="Skriver du någonting av värde?" id="titleinput"/>
				</div>
			</P>
			<p>
				<textarea name="text" placeholder="brödtext här" id="submittext"></textarea>
			</p>
				<label for="author">Skribent:</label>
				<input type="text" name="author" id="author"/>
				<p>
					<input type="submit" value="Spara" id="submit"></input>	
				</p>
			</fieldset>
			</form>
			<?php
			if(!empty($_POST))
			{
				$_POST = null;
				$author = filter_input(INPUT_POST, 'author' );
				$title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS, FILTER_FLAG_STRIP_LOW );
				$text = filter_input(INPUT_POST, 'text', FILTER_SANITIZE_SPECIAL_CHARS, FILTER_FLAG_STRIP_LOW );
				//$date = filter_input(INPUT_POST, 'date', );
				if(strlen($title) > 5)
				{
					if(strlen($author)>=3 )
					{
						if(strlen($text)>10)
						{
							$statement = $pdo->prepare("insert into comments (title, text, author, date, post_id) values (:title, :text, :author, NOW(), :post_id)");
							$statement->bindparam(":author", $author);
							$statement->bindparam(":text", $text);
							$statement->bindparam(":title", $title);
							$statement->bindparam(":post_id", $post_id);
							if(!$statement->execute())
								print_r($statement->errorInfo());
						}
					}
				}
			}
			echo "<ul id=\"comments\">";
			foreach ($pdo->query("select * from comments where post_id = $post_id order by date desc") as $row)
			{
				echo "<li class=\"comment\">{$row['date']}.<div class=\"commenttitle\">{$row['title']}</div>.<div class=\"commenttext\">{$row['text']}</div>.<div class=\"commentauthor\">Skribent: {$row['author']}</div></li>";		
			}
			echo "</ul>";
		}
	} else
	{
		echo "<p>pdo didnt run</p>";
	}
?>
</body>
</html>