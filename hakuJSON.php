<?php
try {
	require_once "patevaPDO.php";
	
	// Luodaan tietokanta-luokan olio
	$kantakasittely = new patevaPDO();
	
	if (isset($_GET["trainer"])) {
		// Tehdään kantahaku
		$tulos = $kantakasittely->haeKurssi($_GET["trainer"] );
		
		// Palautetaan vastaus JSON-tekstina
		echo (json_encode( $tulos )) ;
	}

} catch ( Exception $error ) {
}
?>

