<?php include("navi.php"); ?>
<div class="container">
    <div class="col-sm-2"></div>

  <div class="col-sm-6">          
		<h2>Kurssin tiedot</h2>
<?php
require_once "patevaPDO.php";
session_start(); //käynnistetään sessio

if (isset ( $_SESSION ["naytaKoulutus"] )) {
	$tulos = $_SESSION ["naytaKoulutus"];
		
}
if (isset ( $_POST ["back"] )) {
	header("location:listaaKurssit.php");
	exit();
}
	
	//Tehdään lista course-kentän arvoista, jotta voidaan palauttaa vahvistuksessa oikeat arvot
	$courseList = array(
	"tyo" => "Työturvallisuuskorttikoulutus",
	"hata" => "Hätäensiapukoulutus 8h",
	"eak" => "Ennakoivan ajon koulutus"
			);
	// Tehdään lista cap-kentän arvoista, jotta voidaan palauttaa vahvistuksessa oikeat arvot
	$capList = array (
	"yes" => "Kyllä",
	"no" => "Ei"
			);
	
?>	

          <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"><b>Koulutusaihe:</b> <?php echo $courseList[$tulos->getCourse()]; ?><br>
          <b>Ajankohta:</b> <?php echo ($tulos->getWeekday()); ?> <?php echo date("d.m.Y", strtotime($tulos->getDate())); ?> klo <?php echo $tulos->getStart(); ?> - <?php echo $tulos->getEnd(); ?><br>
          <b>Kouluttaja:</b> <?php echo $tulos->getTrainer(); ?><br> <b>Ammattipätevyysmerkintä:</b> <?php echo $capList[$tulos->getCap()]; ?><br>
          <b>Kurssikuvaus:</b> <?php echo $tulos->getDescription(); ?>	<br> 
		  <input type="submit" name="back" value="Takaisin"> 
		  </form>
</div>
	</div>
<?php include("footer.php"); ?>
			