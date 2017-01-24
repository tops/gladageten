<h1>Bildgalleri</h1>
<div id='gallery'>
<?php
	#  Vi öppnar mappen images/gallery/ och använder en if-sats för att bara går vidare om det går
	if ($handle = opendir('./images/gallery/')) {
		# Vi loopar igenom alla filerna som finns i den mappen och får namnet på filen i $entry
	    while (false !== ($entry = readdir($handle))) {
	    	# Om filnamnet inte är . eller .. (vilket är den egna mappen och mappen ovanför)
	        if($entry != '.' && $entry != '..')
	        	# Skriv ut en div med bilden som bakgrund
	        	echo "<div class='image' style='background-image: url(images/gallery/$entry)'></div>";
	    }
	    # Stäng mappen igen när vi är klara
	    closedir($handle);
	}
?>
</div>