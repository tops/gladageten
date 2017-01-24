<?php
	# Uppkoppling till databasen
	$db = mysqli_connect("localhost","root","root","gladageten");
	mysqli_query($db, "SET NAMES utf8");

	# Sätter från och tilldatum i bokningen till blankt eller vill det vi får från formuläret
	$fromdate = "";
	$todate = "";
	if(isset($_POST['fromdate']))
		$fromdate = $_POST['fromdate'];
	if(isset($_POST['todate']))
		$todate = $_POST['todate'];
?>

<h1>Sök efter lediga rum</h1>

<form method='post' action='' id='roomsearch'>
	<label for='fromdate'>Från datum</label>
		<input type='text' id='fromdate' name='fromdate' class='datepicker' value='<?=$fromdate?>'>
	<label for='todate'>Till datum</label>
		<input type='text' id='todate' name='todate' class='datepicker' value='<?=$todate?>'>
	<input type='submit' value='Sök efter rum' name='searchroom'>
</form>

<?php
# Om formuläret för att boka ett rum skickats
if(isset($_POST['bookroom'])){

	foreach($_POST as $k => $v){
		$clean[$k] = mysqli_real_escape_string($db, $v);
	}

	$query = "
		INSERT INTO bookings
		(room_id, fromdate, todate, fullname, phonenumber, email)
		VALUES
		({$clean['room_id']}, 
		'{$clean['fromdate']}', 
		'{$clean['todate']}', 
		'{$clean['fullname']}', 
		'{$clean['phonenumber']}',
		'{$clean['email']}')
	";

	if(mysqli_query($db, $query)){
		echo "Bokat!";
	}else{
		echo "Något gick fel, försök igen!";
	}

# Om formuläret för att söka efter rum under en period skickats
}elseif(isset($_POST['searchroom'])){
	# Om vi fått från- och tilldatum skickade
	if($fromdate && $todate)
		getAvailableRooms($fromdate, $todate, $db);
	# Om vi int fått båda datumen
	else
		echo "<p>Du måste välja både från- och tilldatum.</p>";
}

# Funktion som hämtar alla lediga rum under peioden och skriver ut bokningsformulär
function getAvailableRooms($fromdate, $todate, $db){

	# Tvätta datumen så de inte går att göra SQL-injection
	$fromdate 	= mysqli_real_escape_string($db, $fromdate);
	$todate 	= mysqli_real_escape_string($db, $todate);

	# Skapa vår query som kollar vilka rum som är lediga baserat på datumen
	$query = "
		SELECT *
		FROM rooms
		WHERE id NOT IN (
			SELECT room_id 
			FROM bookings
			WHERE 
				( fromdate >= '$fromdate' AND fromdate < '$todate' )
			OR  ( todate > '$fromdate' AND todate <= '$todate' )
			OR  ( fromdate < '$fromdate' AND todate > '$todate' )
		)
	";	

	# Skicka frågan till databasen
	$result = mysqli_query($db, $query);

	# Sätt räknaren för antal lediga rum till 0
	$count = 0;
	# Sätt HTML-utskriften för rummen till tomt
	$rooms_html = "";

	# Loopar igenom alla rummen som är lediga och lägger till dem till utskriften
	while($room = mysqli_fetch_assoc($result)){

		# Utöver informationen om rummet finns även en radio-button där man kan välja rummet så vi får med id för rummet i formuläret så man bokar rätt rum
		$rooms_html .= "
			<div class='room'>
				<input type='radio' name='room_id' value='{$room['id']}'>
				<h2>{$room['name']} [{$room['type']}]</h2>
				<p>{$room['description']}</p>
			</div>
		";

		# Ökar räknaren med lediga rum med 1 för varje ledigt rum
		$count++;
	}

	# Om det inte finns några lediga rum
	if($count == 0){
		echo "<p>Inga lediga rum under perioden du valt tyvärr.</p>";

	# Om det finns lediga rum skriver vi ut bokningsformuläret
	}else{

		echo "<form method='post' action=''>";

		# Här skrivs alla rummen ut från den variabel vi lagt all HTML för rummen i
		echo $rooms_html;

		# Skriv ut fälten för namn, telefonnnummer och e-post samt dolda fält med datumen så de också kommer med
		echo "
		<div id='personal_info'>
			<label for='fullname'>Ditt namn</label>
				<input type='text' id='fullname' name='fullname'>
			<label for='phonenumber'>Ditt telefonnnummer</label>
				<input type='text' id='phonenumber' name='phonenumber'>
			<label for='email'>Ditt E-post</label>
				<input type='text' id='email' name='email'>
			<input type='hidden' name='fromdate' value='$fromdate'>
			<input type='hidden' name='todate' value='$todate'>
			<input type='submit' name='bookroom' value='Boka!'>
		</div>
		";

		echo "</form>";
	}
}
