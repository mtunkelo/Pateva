<?php include("navi.php"); ?>
<div id="about" class="container-fluid">
	<div class="row">
		<div class="col-sm-2"></div>

		<div class="col-sm-6">
			<!-- Tähän evästeestä nimi (cookiename) -->
      <?php
						if (isset ( $_COOKIE ["namecookie"] )) {
							echo ("<h2>Tervetuloa " . $_COOKIE ["namecookie"] . "!</h2>");
						}
						?>
      </div>

	</div>

	<div class="row">
		<div class="col-sm-2"></div>

		<div class="col-sm-3">
			<h3>Lisää uusia koulutuksia</h3>
			<p>
				Voit lisätä uusia koulutuksia <a href="lisaaKurssi.php">tästä</a>.
			</p>
		</div>
		<div class="col-sm-3">
			<h3>Katso kaikki koulutukset</h3>
			<p>
				Näet kaikki koulutukset <a href="listaaKurssit.php">tästä</a>.
			</p>
		</div>
		<div class="col-sm-3">
			<h3>Hae tietty koulutus</h3>
			<p>
				Voit hakea tiettyä koulutusta <a href="haeKurssi.php">tästä</a>.
			</p>
		</div>

	</div>
	<div class="row">
		<div class="col-sm-2"></div>
		<div class="col-sm-5">
			<h3>Henkilökohtaiset asetukset</h3>
			<p>
				Pääset muuttamaan asetuksia <a href="asetukset.php">tästä</a>.
			</p>
		</div>
	</div>
</div>



<?php include("footer.php"); ?>
