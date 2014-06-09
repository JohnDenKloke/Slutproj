<!DOCTYPE html>
<html>
<head>
	<link type="text/css" rel="stylesheet" href="browsingsummarys.css"/>
	<title>Which summary?</title>
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
?>
	<nav id="container">
		<ul>
			<li id="explore"><a href=""><img src="Summarys-start-explore.png"/></a></li>
			<li id="publish"><a href=""><img src="Summarys-start-publish.png"/></a></li>
		</ul>
	</nav>
<?php
	if($pdo)
	{
		//gör om detta till en lista istället
		echo "<nav id=\"container2\">";
		echo "<ul id=\"summarys\">";
		foreach ($pdo->query("select posts.id, posts.subject, posts.title, posts.date, posts.class_id from posts order by date desc") as $row)
		{
			echo "<li class=\"summarytitles\"><a href=\"summarys.php?id={$row['id']}\"><span class=\"titletext\"><div class=\"time\">{$row['date']}</div>{$row['subject']}: {$row['title']}</span></a></li>";		
		}
		echo "</ul>";
		echo "</nav>";
	}
	else
	{
		print_r($pdo->errorInfo());
	}
?>
</body>
</html>