// Vi skapar en variabel som innehåller antalet millisekunder för en dag
ONEDAY = 86400000; // one day in milli seconds

$(function(){ // När sidan laddats kör vi koden nedan

	// Här lägger vi till en datumväljare för fälten där man söker efter lediga rum
	$(".datepicker").datepicker({dateFormat: "yy-mm-dd", minDate: 0});

	// Koden nedan körs när värdet i från-datum ändras
	$("#fromdate").on('change', function(e){
		// Först tömmer vi värdet i till-datum
		$("#todate").val("");

		// Sen skapar vi ett datum-objekt av datumet som finns i från-datum
		var date = new Date(e.target.value);

		// Sen ändrar vi egenskaperna för datumväljaren för till-datum
		// Vi sätter en inställning för den så att man inte kan välja datum tidigare än från-datum + 1 dag
		$("#todate").datepicker(
			'option', 
			'minDate', 
			new Date(date.setTime(date.getTime() + ONEDAY)) // Denna rad räknar ut vilken dag som kommer efter dagen som står i från-datum
		);
	})
});