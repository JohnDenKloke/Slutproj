<!DOCTYPE html>
<html>
<head>
	<link type="text/css" rel="stylesheet" href="new_summary.css"/>
	<title>New summary!</title>
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
	<nav id="container">
		<ul>
			<li id="explore"><a href=""><img src="Summarys-start-explore.png"/></a></li>
			<li id="publish"><a href=""><img src="Summarys-start-publish.png"/></a></li>
		</ul>
	</nav>
		<form action="new_summary.php" method="post">
			<p>
				<label for="title" class="formtext">Titel:</label>
				<input type="text" name="title" id="title"/>
			</P>
			<p>
				<textarea name="text" placeholder="brödtext här"></textarea>
			</p>
				<label for="author" class="formtext2">Skribent:</label>
				<input type="text" name="author"/>
				
				<label for="subject" class="formtext2">Ämne:</label>
				<input type="text" name="subject"></input>
				
				<label for="class_id" class="formtext2">Klasstillhörelse:</label>
				<select name="class_id">
					<?php
						foreach($pdo->query("select * from classes order by class") as $row){
							echo "<option value=\"{$row['id']}\">{$row['class']}</option>";							}
					?>
				</select>
				<label for="request" class="formtext2">Är detta en begäran av sammanfattning?</label>
				<input type="radio" name="request">Ja!</input>
				<input type="radio" name="request">Nej!</input>
				<p>
					<input type="submit" value="Spara"></input>	
				</p>
			</form>
			<?php
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
				
				$statement = $pdo->prepare("insert into posts (title, text, subject, date, author, request, class_id) values (:title, :text, :subject, NOW(), :author, :request, :class_id)");
				$statement->bindparam(":request", $request);
				$statement->bindparam(":author", $author);
				$statement->bindparam(":subject", $subject);
				$statement->bindparam(":text", $text);
				$statement->bindparam(":title", $title);
				$statement->bindparam(":class_id", $class_id);
				if($statement->execute())
					echo "fungerar";
				else
					print_r($statement->errorInfo());
			}
			else
			{
				// användaren har inte skickat formuläret, vad ska visa då?
			}
	} else{
		print_r($statement->errorInfo());
	}
?>
</body>
</html>     