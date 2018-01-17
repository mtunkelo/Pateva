<?php include("navi.php"); ?>
<div class="container">
	<div class="row">
		<div class="col-sm-2"></div>
			<div class="col-sm-6">
				<h2>Virheitä tiedossa</h2>
	
				<?php
				if (isset ( $_GET ["virhe"] )) {
					$virhe = $_GET ["virhe"];
					@$sivu = $_GET ["sivu"];
				} else {
					$virhe = "Tuntematon virhe";
					$sivu = "ei tietoa";
				}
				
				print ("<p><b>$sivu</b>: $virhe</p>") ;
				
				?>
		</div>
	</div>
</div>

<?php include("footer.php"); ?>
			
