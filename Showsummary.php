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
		echo "";
		foreach ($pdo->query("select posts.subject, posts.title, posts.date, posts.class_id, posts.text, posts.author from posts") as $row)
		{
			echo "<p>{$row['subject']}.{$row['title']}.{$row['date']}.{$row['class_id']}.{$row['text']}.{$row['author']}</p>";		
		}
	}
	else
	{
		print_r($pdo->errorInfo());
	}
?>