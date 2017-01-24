<?php session_start(); // Startar SESSION så vi kan jobba med den ?>

<h1>Adminpanel</h1>

<?php
# Om lösenordet skickats kollar vi det och är det rätt sätts vår SESSION till true
if(isset($_POST['password']) && $_POST['password'] == "ledsenget"){
	$_SESSION['admin'] = true;
}

# Om vi inte har en SESSION som är true får man formuläret för att skriva in lösenord
if(!isset($_SESSION['admin']) || !$_SESSION['admin']){
	echo "
		<form action='' method='post'>
		Lösenord: <input type='password' name='password'>
		<input type='submit' value='Logga in'>
		</form>
	";

# Annars, om vi har en SESSION som är true, kör vi funktionen rum_admin() som skriver ut vårt admin
}else{
	run_admin();
}

# Funktionen som skriver ut admin-sidan
function run_admin(){
	
	# Här skriver vi ut navigationen för adminet
	echo "
	<nav>
		<ul>
			<li><a href='?page=admin&adminpage=text'>Textadmin</a></li>
			<li><a href='?page=admin&adminpage=image'>Bildadmin</a></li>
			<li><a href='?page=admin&adminpage=booking'>Bokningsadmin</a></li>
		</ul>
	</nav>
	";

	# Om vi inte fått någon adminpage som GET-parameter sätts den till tomt, annars tar vi värdet
	if(!isset($_GET['adminpage'])) $adminpage = "";
	else $adminpage = $_GET['adminpage'];

	# Baserat på vilken adminpage vi fått via GET kör vi olika funktioner
	switch($adminpage){
		case 'text':
			run_text_admin();
			break;
		case 'image':
			run_image_admin();
			break;
		case 'booking':
			run_booking_admin();
			break;
		default:
			echo "Välj något att administrera.";
	}
}

# Funktionen som skriver ut och hanterar administration av texter
function run_text_admin(){
	$db = mysqli_connect("localhost","root","root","gladageten");
	mysqli_query($db, "SET NAMES utf8");

	foreach($_POST as $k => $v){
		$clean[$k] = mysqli_real_escape_string($db, $v);
	}

	if(isset($_POST['savepage'])){
		$query = "
			UPDATE pages
			SET content = '{$clean['content']}'
			WHERE id = {$clean['id']}

		";
		if(mysqli_query($db, $query)){
			echo "Ändringarna sparades.";
		}else{
			echo "Något gick fel.";
		}
	}


	$query = "SELECT * FROM pages";
	$result = mysqli_query($db, $query);
	while($page = mysqli_fetch_assoc($result)){
		echo "
			<form action='' method='post'>
				<h1>{$page['name']}</h1>
				<textarea name='content' class='pagecontent'>{$page['content']}</textarea>
				<input type='hidden' name='id' value='{$page['id']}'>
				<input type='submit' value='Spara ändringar' name='savepage'>
			</form>
		";
	}
}

# Funktionen som skriver ut och hanterar administration av bilder
function run_image_admin(){

	# Om formuläret för att ta bort en bild skickats tar vi bort filen
	if(isset($_POST['removeimage'])){
		unlink("./images/gallery/".$_POST['image']);
	}

	# Om formuläret för att ladda upp en bild skickats sparar vi bilden i galleri-mappen
	if(isset($_POST['uploadfile'])){
		$uploaddir = './images/gallery/';
		$uploadfile = $uploaddir . basename($_FILES['userfile']['name']);

		if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
		    echo "Bilden uppladdad.\n";
		} else {
		    echo "Något gick fel!\n";
		}
	}

	# Här skriver vi ut alla bilderna i galleriet med samma kod som vi gör för besökarna
	echo "<div id='gallery'>";
	if ($handle = opendir('./images/gallery/')) {
	    while (false !== ($entry = readdir($handle))) {
	        if($entry != '.' && $entry != '..')
	        	echo "
	        	<div class='image' style='background-image: url(images/gallery/$entry)'>
	        		<form method='post'>
	        		<input type='hidden' value='$entry' name='image'>
	        		<input type='submit' value='Ta bort' name='removeimage'>
	        		</form>
	        	</div>
	        	";
	    }
	    closedir($handle);
	}
	echo "</div>";

	# Här skriver bi ut formuläret för att ladda upp en ny bild till galleriet
	echo '
		<form enctype="multipart/form-data" action="" method="POST">
		    <input type="hidden" name="MAX_FILE_SIZE" value="30000" />
		    Välj en fil: <input name="userfile" type="file" />
		    <input type="submit" value="Ladda upp" name="uploadfile" />
		</form>
	';


}

# Funktionen som skriver ut och hanterar administration av bokningar
function run_booking_admin(){
	# Uppkoppling till databasen
	$db = mysqli_connect("localhost","root","root","gladageten");
	mysqli_query($db, "SET NAMES utf8");

	# Hämta dagens datum som en sträng i stil med 2017-01-24
	$today = date("Y-m-d");

	# Skapa en query för att hämta alla bokningar som inte checkat ut ännu
	$query = "
		SELECT * 
		FROM bookings, rooms
		WHERE todate >= '$today'
		AND bookings.room_id = rooms.id
		ORDER BY fromdate ASC
	";

	# Skicka SQL-frågan till databasen
	$result = mysqli_query($db, $query);

	# Här skriver vi ut början på tabellen med rubrikerna för varje kolumn
	echo "<table>";
	echo "
		<tr class='tablehead'>
			<td>Rum</td>
			<td>Från</td>
			<td>Till</td>
			<td>Namn</td>
			<td>Telefon</td>
			<td>E-post</td>
		</tr>
	";

	# Vi loopar igenom alla bokningarna vi fick från databasen och skriver ut en tabellrad för varje bokning med informationen för den bokningen
	while($booking = mysqli_fetch_assoc($result)){
		echo "
			<tr>
				<td>{$booking['name']}</td>
				<td>{$booking['fromdate']}</td>
				<td>{$booking['todate']}</td>
				<td>{$booking['fullname']}</td>
				<td>{$booking['phonenumber']}</td>
				<td>{$booking['email']}</td>
			</tr>
		";
	}

	# Här stänger vi tabellen
	echo "</table>";
}