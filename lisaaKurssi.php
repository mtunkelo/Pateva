<?php include("navi.php"); ?>
<div id="about" class="container">
      
      <h2>Lisää uusi kurssi</h2>
      <p>
        <span class="error">* pakollinen kenttä</span>
      </p>
      <?php 
      require_once "kurssi.php";
      session_start(); //käynnistetään sessio		
      
      if (isset ( $_POST ["submit"] )) {
        $kurssi = new Kurssi ( $_POST ["weekday"], $_POST ["date"], $_POST ["start"], $_POST ["end"], $_POST ["course"], $_POST ["trainer"], $_POST ["cap"],$_POST ["description"] );
        // Laitetaan olio sessioon
        $_SESSION ["koulutus"] = $kurssi;
        
        $weekdayErr = $kurssi->checkWeekday();
        $dateErr = $kurssi->checkDate();
        $startErr = $kurssi->checkStart();
        $endErr = $kurssi->checkEnd();
        $courseErr = $kurssi->checkCourse();
        $trainerErr = $kurssi->checkTrainer();
        $capErr = $kurssi->checkCap();
        $descriptionErr = $kurssi->checkDescription (false);
        if($weekdayErr == "" && $dateErr == "" && $startErr == "" && $endErr == "" && $courseErr == "" && $trainerErr == "" && $capErr == "" && $descriptionErr == ""){
			// jos ei virheitä, näytetään kurssin vahvistus
			session_write_close ();
        	header ( "location: naytaKurssi.php" );
        	exit ();
        }
      }
      elseif (isset ( $_POST ["cancel"] )) {
        // Jos poistetaan vain lomake istunnosta
        unset ( $_SESSION ["koulutus"] );
        
        header ( "location: index.php" );
        exit ();
      }
      else {
        // Tutkitaan, onko istunnossa kurssia
        if (isset($_SESSION["koulutus"])) {
          // Otetaan istunnosta olio
          $kurssi = $_SESSION ["koulutus"];
          
          
        } else {
          $kurssi = new Kurssi();
        }
        
        $weekdayErr= "";
        $dateErr= "";
        $startErr= "";
        $endErr= "";
        $courseErr= "";
        $trainerErr= "";
        $capErr= "";
        $descriptionErr= "";
        
      }
      
      
      ?>
      
      
      <form method="post"	action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <div class="form-group">
          <p>
            <label> Viikonpäivä:</label><input type="text" name="weekday" size="4" value="<?php echo $kurssi->getWeekday(); ?>">* 
            <!-- Tehdään error näkyväksi vain, jos kentässä virheitä --> 
            <?php if($weekdayErr != ""): ?>
              <span class="error"><?php echo $weekdayErr;?></span><br>
            <?php endif; ?>
          </p>
          <p>
            <label>Päivämäärä:</label> <input type="text" name="date" size="10" value="<?php echo $kurssi->getDate();?>">*
            <!-- Tehdään error näkyväksi vain, jos kentässä virheitä --> 
            <?php if($dateErr!= ""): ?>
              <span class="error"><?php echo $dateErr;?></span><br>
            <?php endif; ?>
          </p>
          <p>
            <label>Alkuaika:</label> <input type="text" name="start" size="6" value="<?php echo $kurssi->getStart();?>">*
            <!-- Tehdään error näkyväksi vain, jos kentässä virheitä --> 
            <?php if($startErr!= ""): ?>
              <span class="error"><?php echo $startErr;?></span><br>
            <?php endif; ?>					</p>
            <p>
              <label>Päättymisaika:</label> <input type="text" name="end" size="6" value="<?php echo $kurssi->getEnd();?>">*
              <!-- Tehdään error näkyväksi vain, jos kentässä virheitä --> 
              <?php if($endErr!= ""): ?>
                <span class="error"><?php echo $endErr;?></span><br>
              <?php endif; ?>			
            </p>
            <p>
              <label>Koulutusaihe: </label><select name="course">
                <option value="0">Valitse kurssi</option>
                <option value="tyo" <?php if($kurssi->getCourse() == 'tyo') { echo 'selected="selected"'; } ?>>Työturvallisuuskorttikoulutus</option>
                <option value="hata" <?php if($kurssi->getCourse() == 'hata') { echo 'selected="selected"'; } ?>>Hätäensiapukoulutus 8h</option>
                <option value="eak" <?php if($kurssi->getCourse() == 'eak') { echo 'selected="selected"'; } ?>>Ennakoivan ajon koulutus</option>					
              </select> *
              <!-- Tehdään error näkyväksi vain, jos kentässä virheitä --> 
              <?php if($courseErr!= ""): ?>
                <span class="error"><?php echo $courseErr;?></span><br>
              <?php endif; ?>			
            </p>
            <p>
              <label>Kouluttaja:</label> <input type="text" name="trainer" size="30" value="<?php echo $kurssi->getTrainer();?>">*
              <!-- Tehdään error näkyväksi vain, jos kentässä virheitä --> 
              <?php if($trainerErr!= ""): ?>
                <span class="error"><?php echo $trainerErr;?></span><br>
              <?php endif; ?>			
            </p>
            <p>
              
              <label>Ammattipätevyyspäivä:</label> <select name="cap">
                <option value="0">Valitse</option>
                <option value="yes" <?php if($kurssi->getCap() == 'yes') { echo 'selected="selected"'; } ?>>Kyllä</option>
                <option value="no" <?php if($kurssi->getCap() == 'no') { echo 'selected="selected"'; } ?>>Ei</option>
              </select>*
              <!-- Tehdään error näkyväksi vain, jos kentässä virheitä --> 
              <?php if($capErr!= ""): ?>
                <span class="error"><?php echo $capErr;?></span><br>
              <?php endif; ?>	
            </p>
            <p>
              <label>Kurssikuvaus:</label><textarea name="description" rows="5" cols="40"><?php echo $kurssi->getDescription();?></textarea>
              <!-- Tehdään error näkyväksi vain, jos kentässä virheitä --> 
              <?php if($descriptionErr!= ""): ?>
                <span class="error"><?php echo $descriptionErr;?></span><br>
              <?php endif; ?>	
              <br> 
              
              <input type="submit" name="submit" value="Lisää kurssi">
              <input type="submit" name="cancel" value="Peruuta">
            </div>
          </form>
          
          

    </div>
    
    <?php include("footer.php"); ?>
    
