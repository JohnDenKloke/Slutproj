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
		foreach ($pdo->query("select comments.date, comments.title, comments.text, comments.author from comments") as $row)
		{
			echo "<p>{$row['date']}.{$row['title']}.{$row['text']}.{$row['author']}</p>";		
		}
	}
	else
	{
		print_r($pdo->errorInfo());
	}
?>