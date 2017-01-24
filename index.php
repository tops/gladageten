<!--

Det här är filen som hela sidan utgår från.
Alla sidor som besökaren eller admin använder hämtas in genom denna sida genom olika värdern i ?page=

-->
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="style.css">
	<link href="https://fonts.googleapis.com/css?family=Merriweather:300,400|Parisienne" rel="stylesheet">
	<script src='http://code.jquery.com/jquery-latest.min.js'></script>
	<script src='https://code.jquery.com/ui/1.12.1/jquery-ui.min.js'></script>
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<script src='script.js'></script>
</head>
<body>

<div id='content'>
	<div id='header'><p>Den Glada Geten</p></div>
	<nav>
	<ul>
		<li><a href='?page=start'>Startsida</a></li>
		<li><a href='?page=gallery'>Bildgalleri</a></li>
		<li><a href='?page=activities'>Aktiviteter</a></li>
		<li><a href='?page=booking'>Boka rum</a></li>
		<li><a href='?page=contact'>Kontakt</a></li>
	</ul>
	</nav>
	<div class='text'>
		<?php
			# Beroende på vad vi får för värde i ?page= i URLen gör vi olika saker
			switch($_GET['page']){
				case 'gallery':
					include "gallery.php";
					break;
				case 'booking':
					include "booking.php";
					break;
				case 'admin':
					include "admin.php";
					break;
				default:
					load_page($_GET['page']);
			}
		?>
	</div>
</div>
	
</body>
</html>

<?php
# Den här funktionen laddar in de sidor som bara ligger i databasen
function load_page($page){
	$db = mysqli_connect("localhost","root","root","gladageten");
	mysqli_query($db, "SET NAMES utf8");

	$page = mysqli_real_escape_string($db, $page);

	if($page == "") $page = 'start';

	$query = "SELECT * FROM pages WHERE name = '$page'";
	$result = mysqli_query($db, $query);
	if($page = mysqli_fetch_assoc($result)){
		echo $page['content'];
	}else{
		echo "<h1>Sidan finns inte</h1>";
	}					
}