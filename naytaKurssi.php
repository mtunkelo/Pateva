<?php include("navi.php"); ?>
<div id="about" class="container-fluid">
  <div class="row">
    
    <div class="col-sm-2"></div>
	    <div class="col-sm-6">
	      <h2>VAHVISTUS KURSSIN LISÄÄMISESTÄ</h2>
	      
	      <p>
	        <?php
	        require_once "kurssi.php";
	        session_start ();
	       
	        if (isset ( $_SESSION ["koulutus"] )) {
	          $kurssi = $_SESSION ["koulutus"];
	        } else {
	          $kurssi = new Kurssi ();
	        }
	        
	        if (isset ( $_POST ["save"] )) {
	        	try {
	        		require_once 'patevaPDO.php';
	        		$kantakasittely = new patevaPDO();
	        		$id = $kantakasittely->lisaaKurssi ($kurssi);
	        		// Muutetaan istunnossa olevan olion id lisäykseltä saaduksi id:ksi
	        		$_SESSION ["koulutus"]->setId ( $id );
	        		
	        	} catch ( Exception $error ) {
	        		session_write_close ();
	        		header ( "location: virhe.php?sivu=" . urlencode ( "lisäys" ) . "&virhe=" . $error->getMessage () );
	        		exit ();
	        	}
	        	// Tyhjennetään istuntomuuttujat palvelimelta
	          $_SESSION = array ();
	          
	          if (isset ( $_COOKIE [session_name ()] )) {
	            // Poistetaan istunnon tunniste käyttäjän koneelta
	            setcookie ( session_name (), '', time () - 100, '/' );
	          }
	          // Tuhotaan istunto
	          session_destroy ();
	          
	          header ( "location: tallennettu.php" );
	          exit ();
	        } 
	        elseif (isset ( $_POST ["modify"] )) {
	          session_write_close ();
	          header ( "location: lisaaKurssi.php" );
	          exit ();
	        } elseif (isset ( $_POST ["cancel"] )) {
	          // Jos poistetaan vain lomake istunnosta
	          unset ( $_SESSION ["koulutus"] );
	     
	          header ( "location: index.php" );
	          exit ();
	        }
	        
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
	        ?>
	        
	        <!-- Näytetään vahvistus vain, jos erroreita ei tule -->
	        
	        
	        <form method="post"
	        action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	        <div id="vahvistus">
	          <b>Koulutusaihe:</b> <?php echo $courseList[$kurssi->getCourse()]; ?><br>
	          <b>Ajankohta:</b> <?php echo (strtoupper($kurssi->getWeekday())); ?> <?php echo date("d.m.Y", strtotime($kurssi->getDate())); ?> klo <?php echo $kurssi->getStart(); ?> - <?php echo $kurssi->getEnd(); ?><br>
	          <b>Kouluttaja:</b> <?php echo $kurssi->getTrainer(); ?><br> <b>Ammattipätevyysmerkintä:</b> <?php echo $capList[$kurssi->getCap()]; ?><br>
	          <b>Kurssikuvaus:</b> <?php echo $kurssi->getDescription(); ?>	<br> <br>
	          
	          <input type="submit" name="modify" value="Korjaa"> 
	          <input type="submit" name="save" value="Tallenna"> 
	        </div>
	      </form>
	      
	      
	    </div>
 	 </div>
</div>


<?php include("footer.php"); ?>

