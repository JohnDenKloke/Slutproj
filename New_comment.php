<!DOCTYPE html>
<html>
<head>
	<link type="text/css" rel="stylesheet" href="new_summary.css"/>
	<title>New comment!</title>
	<meta charset="utf-8"/>
</head>
<body>
<?php
	//Den här filen låter folk skapa sammanfattningar och spara dem till databasen.
	$host = "localhost";
	$dbname = "studenthelping";
	$username = "studenthelping";
	$password="123456";
	$dsn = "mysql:host=$host;dbname=$dbname";
	$attr = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC);

	$pdo = new PDO($dsn, $username, $password, $attr);
		if($pdo){
			?>
			<form action="new_comment.php" method="post">
			<p>
				<label for="title">Titel:</label>
				<input type="text" name="title" placeholder="Skriver du någonting av värde?"/>
			</P>
			<p>
				<textarea name="text" placeholder="brödtext här"></textarea>
			</p>
				<label for="author">Skribent:</label>
				<input type="text" name="author"/>
				<p>
					<input type="submit" value="Spara"></input>	
				</p>
			</form>
			<?php
			if(!empty($_POST))
			{
				$_POST = null;
				$author = filter_input(INPUT_POST, 'author' );
				$title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS, FILTER_FLAG_STRIP_LOW );
				$text = filter_input(INPUT_POST, 'text', FILTER_SANITIZE_SPECIAL_CHARS, FILTER_FLAG_STRIP_LOW );
				$class_id = filter_input(INPUT_POST, 'post_id' );
				//$date = filter_input(INPUT_POST, 'date', );
				
				$statement = $pdo->prepare("insert into comments (title, text, author, date) values (:title, :text, :author, NOW())");
				$statement->bindparam(":author", $author);
				$statement->bindparam(":text", $text);
				$statement->bindparam(":title", $title);
				if($statement->execute())
				else
					print_r($statement->errorInfo());
			}
			else
			{
				// användaren har inte skickat formuläret, vad ska visa då?
			}
		}
		else
		{
			echo "<p>pdo didnt run</p>";
		}
?>
</body>
</html>     