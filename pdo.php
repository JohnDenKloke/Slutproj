<!DOCTYPE html>
<html>
<head>
	<link type="text/css" rel="stylesheet" href="submitsummary.css"/>
	<title>Submit summary</title>
	<meta charset="utf-8"/>
</head>
<body>
	<form>
		<input type="text" name="title"/>
		<textarea name="text"></textarea>
		
	</form>
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
			if(!empty($_POST))
			{
				$_POST = null;
				$author = filter_input(INPUT_POST, 'author', FILTER_VALIDATE_STRING );
				$title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS, FILTER_FLAG_STRIP_LOW );
				$text = filter_input(INPUT_POST, 'text', FILTER_SANITIZE_SPECIAL_CHARS, FILTER_FLAG_STRIP_LOW );
				//$date = filter_input(INPUT_POST, 'date', );
				
				$statement = $pdo->prepare("insert into post (title, text, course, date, author) values (:title, :text, :course, NOW(), :author,)");
				$statement->bindparam(":author", $author);
				$statement->bindparam(":text", $text);
				$statement->bindparam(":title", $title);
				$statement->execute();
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