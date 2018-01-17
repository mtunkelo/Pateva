<?php include("navi.php"); ?>
<div class="container">
	<h2>Hae kurssia kouluttajan nimellä</h2>
	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
		<input type="text" name="trainer" id="trainer" value="" placeholder="Kouluttajan nimi"> <input type="button" name="hae"	id="hae" value="Hae">
	</form>
	<br>
	<script type="text/javascript">

	//Muuttaa päiväyksen suomalaiseen muotoon
	function convertYMDDateToFinnishDate(ymdDate) {
		  var parts = ymdDate.split('-').map(function (part) { return parseInt(part, 10); });
		  parts.reverse();
		  return parts.join('.');
		}
	//Muuttaa kurssin nimen pitkään muotoon
	const courselist = {
			 tyo: 'Työturvallisuuskorttikoulutus',
			 eak: 'Ennakoivan ajon koulutus',
			 hata: 'Hätäensiapukoulutus 8h'
			}
	//Muuttaa ammattipätevyyden arvon pitkään muotoon
	const caplist = {
			 yes: 'Kyllä',
			 no: 'Ei'
			}
		
	$(document).on("ready", function() {
		// Kun painiketta id="hae" painetaan
		$("#hae").on("click", function() {
			$.ajax({
				url: "hakuJSON.php",  // PHP-sivu, jota haetaan AJAX:lla
				method: "get",
				data: {trainer: $("#trainer").val()},
				dataType: "json",
				timeout: 5000
			})

			// AJAX haku onnistui
			.done(function(data) {
				// Tyhjennetään elementti, johon vastaus laitetaan
				$("#lista").html("");

				// Käsitellään vastauksena tullut taulukko
				for(var i = 0; i < data.length; i++) {
					// Lisätään attribuutilla id="lista" elementtiin sisältöä
					$("#lista").append("<p><b>Koulutusaihe:</b> " + courselist[data[i].course] +
							"<br><b>Ajankohta:</b>  " + data[i].weekday + " " + convertYMDDateToFinnishDate(data[i].date) + " klo " + data[i].start + " - " + data[i].end + 
							"<br><b>Kouluttaja:</b>  " + data[i].trainer +
							"<br><b>Ammattipätevyysmerkintä:</b>  " + caplist[data[i].cap] +
							"<br><b>Kurssikuvaus:</b>  " + data[i].description + "</p>");
				}
				// Jos vastauksena ei tullut yhtään riviä eli vastaus oli tyhjä taulukko
				if (data.length == 0) {
					$("#lista").append("<p>Kyseiselle kouluttajalle ei löytynyt yhtäkään kurssia.</p>")
				}
			})
			// AJAX haku ei onnistunut
			.fail(function() {
				$("#lista").html("<p>Nyt joku meni pieleen, listausta ei voida tehdä.</p>");
			});
			
		});
	
	});
	
	</script>
	<div id="lista"></div>
</div>

<?php include("footer.php"); ?>
			