<?php include("navi.php"); ?>
<div class="container">

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

  <div class="row">
    <div class="col-md-6">


      <form method="post"	action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <label for="weekday" class="control-label">Viikonpäivä: *</label>
              <input type="text" class="form-control" name="weekday" value="<?php echo $kurssi->getWeekday(); ?>">
              <!-- Tehdään error näkyväksi vain, jos kentässä virheitä -->
              <?php if($weekdayErr != ""): ?>
                <span class="error"><?php echo $weekdayErr;?></span><br>
              <?php endif; ?>
            </div>
          </div>
          <div class="col-md-8">
            <div class="form-group">
              <label for="date" class="control-label">Päivämäärä: *</label>
              <input type="text" class="form-control" name="date" value="<?php echo $kurssi->getDate();?>">
              <!-- Tehdään error näkyväksi vain, jos kentässä virheitä -->
              <?php if($dateErr!= ""): ?>
                <span class="error"><?php echo $dateErr;?></span><br>
              <?php endif; ?>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="start" class="control-label">Alkuaika: *</label>
              <input type="text" class="form-control" name="start" value="<?php echo $kurssi->getStart();?>">
              <?php if($startErr!= ""): ?>
                <span class="error"><?php echo $startErr;?></span><br>
              <?php endif; ?>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="end" class="control-label">Päättymisaika: *</label>
              <input type="text" class="form-control" name="end" value="<?php echo $kurssi->getEnd();?>">
              <!-- Tehdään error näkyväksi vain, jos kentässä virheitä -->
              <?php if($endErr!= ""): ?>
                <span class="error"><?php echo $endErr;?></span><br>
              <?php endif; ?>
            </div>

          </div>
        </div>
        <div class="form-group">
          <label for="state_id" class="control-label">Koulutusaihe: *</label>
          <select class="form-control" name="course">
            <option value="0">Valitse kurssi</option>
            <option value="tyo" <?php if($kurssi->getCourse() == 'tyo') { echo 'selected="selected"'; } ?>>Työturvallisuuskorttikoulutus</option>
            <option value="hata" <?php if($kurssi->getCourse() == 'hata') { echo 'selected="selected"'; } ?>>Hätäensiapukoulutus 8h</option>
            <option value="eak" <?php if($kurssi->getCourse() == 'eak') { echo 'selected="selected"'; } ?>>Ennakoivan ajon koulutus</option>
          </select>
          <!-- Tehdään error näkyväksi vain, jos kentässä virheitä -->
          <?php if($courseErr!= ""): ?>
            <span class="error"><?php echo $courseErr;?></span><br>
          <?php endif; ?>
        </div>
        <div class="form-group">
          <label for="trainer" class="control-label">Kouluttaja: *</label>
          <input type="text" class="form-control" name="trainer" value="<?php echo $kurssi->getTrainer();?>">
          <!-- Tehdään error näkyväksi vain, jos kentässä virheitä -->
          <?php if($trainerErr!= ""): ?>
            <span class="error"><?php echo $trainerErr;?></span><br>
          <?php endif; ?>
        </div>
        <div class="form-group">
          <label for="cap" class="control-label">Ammattipätevyyspäivä:*</label>
          <select class="form-control" name="cap">
            <option value="0">Valitse</option>
            <option value="yes" <?php if($kurssi->getCap() == 'yes') { echo 'selected="selected"'; } ?>>Kyllä</option>
            <option value="no" <?php if($kurssi->getCap() == 'no') { echo 'selected="selected"'; } ?>>Ei</option>
          </select>
          <!-- Tehdään error näkyväksi vain, jos kentässä virheitä -->
          <?php if($capErr!= ""): ?>
            <span class="error"><?php echo $capErr;?></span><br>
          <?php endif; ?>
        </div>
        <div class="form-group">
          <label class="control-label " for="description">Kurssikuvaus:</label>
          <textarea class="form-control" cols="40" name="description" rows="5"><?php echo $kurssi->getDescription();?></textarea>
          <!-- Tehdään error näkyväksi vain, jos kentässä virheitä -->
          <?php if($descriptionErr!= ""): ?>
            <span class="error"><?php echo $descriptionErr;?></span><br>
          <?php endif; ?>
        </div>
        <div class="form-group">
          <button type="submit" name="submit" class="btn btn-primary">Lisää kurssi</button>
          <button type="reset" name="cancel" class="btn btn-default">Tyhjennä</button>
        </div>
      </form>

    </div>
  </div>


  <?php include("footer.php"); ?>
