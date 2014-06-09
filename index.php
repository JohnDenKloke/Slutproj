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
			<li id="explore"><a href="index.php?page=1"><img src="Summarys-start-explore.png" alt="Explore"/></a></li>
			<li id="publish"><a href="index.php?page=2"><img src="Summarys-start-publish.png" alt="publish"/></a></li>
		</ul>
	</nav>
<?php
	if($pdo)
	{
		if(!empty($_GET))
		{
			$_GET = null;
			// hämta ut från GET på id
			$page_id = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT);
			if($page_id == 1)
			{
				echo "<audio controls loop autoplay>
				<source src=\"The%20Victory%20(%201988%20Seoul%20Olympic%20theme%20song%20).mp3\" type=\"audio/ogg\">
				<source src=\"The%20Victory%20(%201988%20Seoul%20Olympic%20theme%20song%20).mp3\" type=\"audio/mpeg\">
				</audio>";
				echo "<nav id=\"container2\">";
				echo "<ul id=\"summarys\">";
				foreach ($pdo->query("select posts.id, posts.subject, posts.title, posts.date, posts.class_id from posts order by date desc") as $row)
				{
					echo "<li class=\"summarytitles\"><a href=\"summary.php?id={$row['id']}\"><span class=\"titletext\"><div class=\"time\">{$row['date']}</div>{$row['subject']}: {$row['title']}</span></a></li>";		
				}
				echo "</ul>";
				echo "</nav>";

			} else
			{
				echo "<audio controls loop autoplay>
				<source src=\"MaidwiththeFlaxenHair.mp3\" type=\"audio/ogg\">
				<source src=\"MaidwiththeFlaxenHair.mp3\" type=\"audio/mpeg\">
				</audio>";
					echo "<nav id=\"container2\">";
					?>		
					<form action="index.php?page=2" method="post">
				<p id="mastertitle">
					<label for="title" class="formtext">Titel:</label>
					<input type="text" name="title" id="title"/>
				</P>
				<p>
					<textarea name="text" placeholder="brödtext här" id="mastertext"></textarea>
				</p>
				<p id="masterrest">
					<label for="author" class="formtext2">Skribent:</label>
					<input id="author type="text" name="author"/>
					
					<label for="subject" class="formtext2">Ämne:</label>
					<input id="subject" type="text" name="subject"/>
					
					<label for="class_id" class="formtext2">Klasstillhörelse:</label>
					<select name="class_id" id="class_id">
						<?php
							foreach($pdo->query("select * from classes order by class") as $row){
								echo "<option value=\"{$row['id']}\">{$row['class']}</option>";							}
						?>
					</select>
					<p>
						<input type="submit" value="Spara"/>
					</p>
				</p>
				</form>	<?php
				if(!empty($_POST))
				{
					$_POST = null;
					$request = filter_input(INPUT_POST, 'request', FILTER_VALIDATE_INT );
					$author = filter_input(INPUT_POST, 'author' );
					$subject = filter_input(INPUT_POST, 'subject' );
					$title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS, FILTER_FLAG_STRIP_LOW );
					$text = filter_input(INPUT_POST, 'text', FILTER_SANITIZE_SPECIAL_CHARS, FILTER_FLAG_STRIP_LOW );
					$class_id = filter_input(INPUT_POST, 'class_id' );
					//$date = filter_input(INPUT_POST, 'date', );
					
					$statement = $pdo->prepare("insert into posts (title, text, subject, date, author, class_id) values (:title, :text, :subject, NOW(), :author, :class_id)");
					$statement->bindparam(":author", $author);
					$statement->bindparam(":subject", $subject);
					$statement->bindparam(":text", $text);
					$statement->bindparam(":title", $title);
					$statement->bindparam(":class_id", $class_id);
					if($statement->execute())
						echo "<span id=\"thanks\">Tack för ditt bidrag</span>";
					else
						print_r($statement->errorInfo());
				}
				echo "</nav>";
			}
		} else
		{
			echo "<audio controls loop autoplay>
			<source src=\"The%20Victory%20(%201988%20Seoul%20Olympic%20theme%20song%20).mp3\" type=\"audio/ogg\">
			<source src=\"The%20Victory%20(%201988%20Seoul%20Olympic%20theme%20song%20).mp3\" type=\"audio/mpeg\">
			</audio>";
			echo "<nav id=\"container2\">";
			echo "<ul id=\"summarys\">";
			foreach ($pdo->query("select posts.id, posts.subject, posts.title, posts.date, posts.class_id from posts order by date desc") as $row)
			{
				echo "<li class=\"summarytitles\"><a href=\"summary.php?id={$row['id']}\"><span class=\"titletext\"><div class=\"time\">{$row['date']}</div>{$row['subject']}: {$row['title']}</span></a></li>";		
			}
			echo "</ul>";
			echo "</nav>";
		}
	}
	else
	{
		print_r($pdo->errorInfo());
	}
?>
	<img id="scientist" alt="scientist" src="imageedit_2_8280370067.gif"/>
</body>
</html>