<?php include("navi.php"); ?>
<div class="container">
	<div class="table-responsive">
		<h2>Listaa kaikki kurssit</h2>
		<p>Klikkaamalla otsikkoa voit järjestää tiedot aakkosjärjestykseen.</p>
			<?php
			require_once "patevaPDO.php";
			session_start (); // käynnistetään sessio
			
			if (isset ( $_POST ["nayta"] )) {
				$kantakasittely = new patevaPDO ();
				$_SESSION ["naytaKoulutus"] = $kantakasittely->naytaKurssi($_POST["id"]);
				header ( "location:etsiNayta.php" );
				exit ();
			}
			
			if (isset ( $_POST ["poista"] )) {
				try {
					$kantakasittely = new patevaPDO ();
					$kantakasittely->poistaKurssi ( $_POST ["id"] );
					// print_r($tulos);
					// oliotaulukosta otettu yksittäinen Kurssi-luokan olio
					header ( "location:listaaKurssit.php" );
					exit ();
				} catch ( Exception $error ) {
					// Jos tuli jokin virhe, ohjataan selain virheen näyttösivulle
					header ( "location: virhe.php?sivu=Listaus&virhe=" . $error->getMessage () . $error->getCode () );
					exit ();
				}
			}
			try {
				// Tehdään lista course-kentän arvoista, jotta voidaan palauttaa vahvistuksessa oikeat arvot
				$courseList = array (
						"tyo" => "Työturvallisuuskorttikoulutus",
						"hata" => "Hätäensiapukoulutus 8h",
						"eak" => "Ennakoivan ajon koulutus" 
				);
				// Tehdään lista cap-kentän arvoista, jotta voidaan palauttaa vahvistuksessa oikeat arvot
				$capList = array (
						"yes" => "Kyllä",
						"no" => "Ei" 
				);
				// Tehdään tietokanta-luokan olio
				$kantakasittely = new patevaPDO ();
				
				// Kutsutaan tietokantaluokan metodia, mikä hakee kaikki leffat
				// Metodi palauttaa oliotaulukon
				$rivit = $kantakasittely->kaikkiKurssit ();
				
				// Käydään oliotaulukko läpi
				echo ("<table id='lista' class='table table-borderless table-condensed table-hover'>");
				echo ("<thead>");
				echo ("<tr>");
				echo ("<th onclick='sortTable(0)'></th>");
				echo ("<th onclick='sortTable(1)'>Koulutusaihe</th> ");
				echo ("<th onclick='sortTable(2)'>Ajankohta</th> ");
				echo ("<th onclick='sortTable(3)'>Kouluttaja</th> ");
				echo ("<th></th>");
				echo ("</tr>");
				echo ("</thead>");
				
				foreach ( $rivit as $kurssi ) {
					// oliotaulukosta otettu yksittäinen Kurssi-luokan olio
					echo ("<tbody>");
					echo ("<tr>");
					echo ("<td>" . $kurssi->getId () . "</td>");
					echo ("<td>" . $courseList [$kurssi->getCourse ()] . "</td>");
					echo ("<td>" . $kurssi->getWeekday () . " " . date ( "d.m.Y", strtotime ( $kurssi->getDate () ) ) . " klo " . $kurssi->getStart () . "-" . $kurssi->getEnd () . "</td>");
					echo ("<td>" . $kurssi->getTrainer () . "</td>");
					echo ("<td><form action='".htmlspecialchars($_SERVER["PHP_SELF"])."' method='post'> 
								<input type='hidden' name='id' id='id' value='" . $kurssi->getId () . "'>
								<input type='submit' name='nayta' id='nayta' value='Näytä'>
								<input type='submit' name='poista' value='Poista'>
						</form>" . "</td>");
					echo ("</tr>");
					echo ("</tbody>");
				}
				echo ("</table>");
			} catch ( Exception $error ) {
				// Jos tuli jokin virhe, ohjataan selain virheen näyttösivulle
				header ( "location: virhe.php?sivu=Listaus&virhe=" . $error->getMessage () );
				exit ();
			}
			
			?>	
			
		</div>
	</div>
<script>
	function sortTable(n) {
		  var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
		  table = document.getElementById("lista");
		  switching = true;
		  //Set the sorting direction to ascending:
		  dir = "asc"; 
		  /*Make a loop that will continue until
		  no switching has been done:*/
		  while (switching) {
		    //start by saying: no switching is done:
		    switching = false;
		    rows = table.getElementsByTagName("TR");
		    /*Loop through all table rows (except the
		    first, which contains table headers):*/
		    for (i = 1; i < (rows.length - 1); i++) {
		      //start by saying there should be no switching:
		      shouldSwitch = false;
		      /*Get the two elements you want to compare,
		      one from current row and one from the next:*/
		      x = rows[i].getElementsByTagName("TD")[n];
		      y = rows[i + 1].getElementsByTagName("TD")[n];
		      /*check if the two rows should switch place,
		      based on the direction, asc or desc:*/
		      if (dir == "asc") {
		        if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
		          //if so, mark as a switch and break the loop:
		          shouldSwitch= true;
		          break;
		        }
		      } else if (dir == "desc") {
		        if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
		          //if so, mark as a switch and break the loop:
		          shouldSwitch= true;
		          break;
		        }
		      }
		    }
		    if (shouldSwitch) {
		      /*If a switch has been marked, make the switch
		      and mark that a switch has been done:*/
		      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
		      switching = true;
		      //Each time a switch is done, increase this count by 1:
		      switchcount ++;      
		    } else {
		      /*If no switching has been done AND the direction is "asc",
		      set the direction to "desc" and run the while loop again.*/
		      if (switchcount == 0 && dir == "asc") {
		        dir = "desc";
		        switching = true;
		      }
		    }
		  }
		}

</script>
<?php include("footer.php"); ?>
			