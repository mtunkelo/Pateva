<?php
class Kurssi implements JsonSerializable {
	private $weekday;
	private $date;
	private $start;
	private $end;
	private $course;
	private $trainer;
	private $cap;
	private $description;
	private $id;
	
	//Tehdään lista course-kentän arvoista, jotta voidaan palauttaa vahvistuksessa oikeat arvot
	private $courseList = array(
			"tyo" => "Työturvallisuuskorttikoulutus",
			"hata" => "Hätäensiapukoulutus 8h",
			"eak" => "Ennakoivan ajon koulutus"
	);
	
	private $capList = array(
			"yes" => "Kyllä",
			"no" => "Ei",
	);
	
	// Metodi, mikä muuttaa olion JSON-muotoon
	public function jsonSerialize() {
		return array (
				"weekday" => $this->weekday,
				"date" => $this->date,
				"start" => $this->start,
				"end" => $this->end,
				"course" => $this->course,
				"trainer" => $this->trainer,
				"cap" => $this->cap,
				"description" => $this->description,
				"id" => $this->id
		);
	}
       
	function __construct($weekday = "", $date = "", $start = "", $end = "", $course = "", $trainer = "", $cap ="", $description="", $id=0) {
		$this->weekday = trim ( $weekday);
		$this->date = trim ( $date );
		$this->start = trim ( $start );
		$this->end = trim ( $end );
		$this->course = trim ( $course );
		$this->trainer = trim ( $trainer );
		$this->cap = trim ( $cap );
		$this->description = trim ( $description);
		$this->id = $id;
	}
	
	public function setWeekday($weekday) {
		$this->weekday = trim($weekday);
	}
	public function getWeekday() {
		return $this->weekday;
	}
	public function checkWeekday($required = TRUE) {
		// Jos ei saa olla tyhjä ja on tyhjä
		if ($required == true && strlen ( $this->weekday) == 0) {
			return "Viikonpäivä on pakollinen. Anna lyhenteenä, esim. MA";
		}
		
		if (preg_match("/^(MA|TI|KE|TO|PE|LA|SU)$/", $this->weekday)) {
			return "";
		} else {
			return "Viikonpäivä ei ole oikeanmuotoinen. Anna lyhenteenä, esim. MA";
		}
		
		return "";
	}
	public function setDate($date) {
		$this->date = date("Y-m-d", strtotime($date));
	}
	public function getDate() {
		return $this->date;
	}
	public function checkDate($required = TRUE) {
		// Jos ei saa olla tyhjä ja on tyhjä
		if ($required == true && strlen ( $this->date) == 0) {
			return "Päivämäärä on pakollinen";
		}
		
		$pvmmuoto = "/^([0-3][0-9].[0-2][0-9].[02][0][0-9][0-9])$/"; // Määritellään haluttu muoto
		if (preg_match ($pvmmuoto, $this->date)){ // Tarkastetaanko täsmääkö annettu arvo haluttuun muotoon
			//Jos kaikki ok tarkistetaan onko päivä tulevaisuudessa
			$today=date('d.m.Y');
			$pvm1 = strtotime($today);
			$pvm2 = strtotime($this->date);
			//verrataan nykyistä päivää syötettyyn päivään
			if ($pvm1 < $pvm2){
				$pvm2 = date("Y-m-d", strtotime($this->date));
				return ""; //Kaikki hyvin, päivämäärä tulevaisuudessa.
				
			} else {
				return "Päivämäärä pitää olla tulevaisuudessa tai se on liian kaukana tulevaisuudessa.";
			};
		}
		else {
			return "Päivämäärä ei ole oikeanmuotoinen, ilmoita muodossa pp.kk.vvvv.";
		}
		
		return "";
		
	}
	
	
	public function setStart($start) {
		$this->start= trim($start);
	}
	public function getStart() {
		return $this->start;
	}
	public function checkStart($required = TRUE) {
		// Jos ei saa olla tyhjä ja on tyhjä
		if ($required == true && strlen ( $this->start) == 0) {
			return "Koulutuksen aloitusaika on ilmoitettava, ilmoita muodossa hh:mm";
		}
		$kellonaika = "/^([01][0-9]|2[0-3]):[0-5][0-9]$/"; // Määritellään haluttu muoto
		if (preg_match($kellonaika, $this->start)) {
			return ""; // Kaikki ok
		} else {
			return "Aloitusaika ei ole oikeanmuotoinen, ilmoita muodossa hh:mm.";
		}
		
		return "";
	}
	
	
	public function setEnd($end) {
		$this->end= trim($end);
	}
	public function getEnd() {
		return $this->end;
	}
	public function checkEnd($required = TRUE) {
		if ($required == true && strlen ( $this->end) == 0) {
			return "Koulutuksen päättymisaika on ilmoitettava, ilmoita muodossa hh:mm";
		}
		$kellonaika = "/^([01][0-9]|2[0-3]):[0-5][0-9]$/"; // Määritellään haluttu muoto
		if (preg_match($kellonaika, $this->end)) {
			return ""; // Kaikki ok
		} else {
			return "Päättymisaika ei ole oikeanmuotoinen, ilmoita muodossa hh:mm.";
		}
		return "";
		
	}
	public function setCourse($course) {
		$this->course = trim ( $course );
	}
	public function getCourse() {
		return $this->course;
	}
	public function checkCourse($required = TRUE) {
		
		if($this->course == "0") {
			return "Kurssiaiheen valitseminen on pakollista";
		}
		
		return "";
	}
	
	public function setTrainer($trainer) {
		$this->trainer= trim($trainer);
	}
	
	public function getTrainer() {
		return $this->trainer;
	}
	
	public function checkTrainer($required = true, $min = 1, $max = 50) {
		if ($required == false && strlen ( $this->trainer ) == 0) {
			return "";
		}
		
		if ($required == true && strlen ( $this->trainer) == 0) {
			return "Kouluttajan nimi on pakollinen";
		}
		
		if (strlen ( $this->trainer) < $min) {
			return "Kouluttajan nimi on liian lyhyt";
		}
		
		if (strlen ( $this->trainer) > $max) {
			return "Kouluttajan nimi on liian pitkä";
		}
		

		
		return "";
	}
	
	public function setCap($cap) {
		$this->cap= trim($cap);
	}
	public function getCap() {
		return $this->cap;
	}
	public function checkCap($required = TRUE) {
		
		if($this->cap == "0") {
			return "Ammattipätevyystieto on pakollinen";
		}
		
		return "";
	}
	
	public function setDescription($description) {
		$this->description = trim ( $description );
	}
	
	public function getDescription() {
		return $this->description;
	}
	
	public function checkDescription($required = FALSE, $max = 300) {
		// Jos saa olla tyhjä ja on tyhjä
		if ($required == false && strlen ( $this->description) == 0) {
			return "";
		}
		
		// Jos kommentti on liian pitkä
		if (strlen ( $this->description) > $max) {
			return "Kommentti on liian pitkä";
		}
		
	}
	public function setId($id) {
		$this->id = $id;
	}
	
	public function getId() {
		return $this->id;
	}
}

?>
