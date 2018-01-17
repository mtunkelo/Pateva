<?php
require_once 'kurssi.php';

class patevaPDO {
	
	private $db;
	private $lkm;
	
	function __construct($dsn = "mysql:host=localhost;dbname=a1602454", $user = "root", $password = "") {
		// Ota yhteys kantaan
		$this->db = new PDO ( $dsn, $user, $password );
		
		// Virheiden jäljitys kehitysaikana
		$this->db->setAttribute ( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
		
		// MySQL injection estoon (paramerit sidotaan PHP:ssä ennen SQL-palvelimelle lähettämistä)
		$this->db->setAttribute ( PDO::ATTR_EMULATE_PREPARES, false );
		
		// Tulosrivien määrä
		$this->lkm = 0;
	}
	// Metodi palauttaa tulosrivien määrän
	function getLkm() {
		return $this->lkm;
	}
	
	public function kaikkiKurssit() {
		$sql = "SELECT id, weekday, date, start, end, course, trainer, cap, description
		        FROM pateva";
		
		// Valmistellaan lause
		if (! $stmt = $this->db->prepare ( $sql )) {
			$virhe = $this->db->errorInfo ();
			
			throw new PDOException ( $virhe [2], $virhe [1] );
		}
		
		// Ajetaan lauseke
		if (! $stmt->execute ()) {
			$virhe = $stmt->errorInfo ();
			
			throw new PDOException ( $virhe [2], $virhe [1] );
		}
		
		// Käsittellään hakulausekkeen tulos
		$tulos = array ();
		
		// Pyydetään haun tuloksista kukin rivi kerrallaan
		while ( $row = $stmt->fetchObject () ) {
			// Tehdään tietokannasta haetusta rivistä kurssi-luokan olio
			$kurssi = new Kurssi ();
			
			$kurssi->setId ( $row->id );
			$kurssi->setWeekday ( utf8_encode ( $row->weekday ) );
			$kurssi->setDate ( utf8_encode ( $row->date ) );
			$kurssi->setStart ( utf8_encode ( $row->start ) );
			$kurssi->setEnd ( utf8_encode ( $row->end ) );
			$kurssi->setCourse ( utf8_encode ( $row->course ) );
			$kurssi->setTrainer ( utf8_encode ( $row->trainer ) );
			$kurssi->setCap ( utf8_encode ( $row->cap ) );
			$kurssi->setDescription ( utf8_encode ( $row->description) );
			
			// Laitetaan olio tulos taulukkoon (olio-taulukkoon)
			$tulos [] = $kurssi;
		}
		
		$this->lkm = $stmt->rowCount ();
		
		return $tulos;
	}
	public function naytaKurssi($id) {
		$sql = "SELECT id, weekday, date, start, end, course, trainer, cap, description
		        FROM pateva
				WHERE id like :id";
		
		// Valmistellaan lause, prepare on PDO-luokan metodeja
		if (! $stmt = $this->db->prepare ( $sql )) {
			$virhe = $this->db->errorInfo ();
			throw new PDOException ( $virhe [2], $virhe [1] );
		}
		
		// Sidotaan parametrit
		$ni = "%" . utf8_decode ( $id) . "%";
		$stmt->bindValue ( ":id", $ni, PDO::PARAM_INT );
		
		// Ajetaan lauseke
		if (! $stmt->execute ()) {
			$virhe = $stmt->errorInfo ();
			
			if ($virhe [0] == "HY093") {
				$virhe [2] = "Invalid parameter";
			}
			
			throw new PDOException ( $virhe [2], $virhe [1] );
		}
		
		// Käsittellään hakulausekkeen tulos
		
		while ( $row = $stmt->fetchObject () ) {
			$kurssi = new kurssi ();
			
			$kurssi->setId ( $row->id );
			$kurssi->setWeekday ( utf8_encode ( $row->weekday ) );
			$kurssi->setDate ( utf8_encode ( $row->date ) );
			$kurssi->setStart ( $row->start );
			$kurssi->setEnd ( $row->end );
			$kurssi->setCourse ( utf8_encode ( $row->course ) );
			$kurssi->setTrainer ( utf8_encode ( $row->trainer ) );
			$kurssi->setCap ( utf8_encode ( $row->cap ) );
			$kurssi->setDescription ( utf8_encode ( $row->description) );
					}
		
		$this->lkm = $stmt->rowCount ();
		
		return $kurssi;
	}
	
	public function haeKurssi($trainer) {
		$sql = "SELECT id, weekday, date, start, end, course, trainer, cap, description
		        FROM pateva
				WHERE trainer like :trainer";
		
		// Valmistellaan lause, prepare on PDO-luokan metodeja
		if (! $stmt = $this->db->prepare ( $sql )) {
			$virhe = $this->db->errorInfo ();
			throw new PDOException ( $virhe [2], $virhe [1] );
		}
		
		// Sidotaan parametrit
		$ni = "%" . utf8_decode ( $trainer) . "%";
		$stmt->bindValue ( ":trainer", $ni, PDO::PARAM_STR );
		
		// Ajetaan lauseke
		if (! $stmt->execute ()) {
			$virhe = $stmt->errorInfo ();
			
			if ($virhe [0] == "HY093") {
				$virhe [2] = "Invalid parameter";
			}
			
			throw new PDOException ( $virhe [2], $virhe [1] );
		}
		
		// Käsittellään hakulausekkeen tulos
		$tulos = array ();
		
		while ( $row = $stmt->fetchObject () ) {
			$kurssi = new kurssi ();
			
			$kurssi->setId ( $row->id );
			$kurssi->setWeekday ( utf8_encode ( $row->weekday ) );
			$kurssi->setDate ( utf8_encode ( $row->date ) );
			$kurssi->setStart ( $row->start );
			$kurssi->setEnd ( $row->end );
			$kurssi->setCourse ( utf8_encode ( $row->course ) );
			$kurssi->setTrainer ( utf8_encode ( $row->trainer ) );
			$kurssi->setCap ( utf8_encode ( $row->cap ) );
			$kurssi->setDescription ( utf8_encode ( $row->description) );
			
			// Laitetaan olio tulos taulukkoon (olio-taulukkoon)
			$tulos [] = $kurssi;
		}
		
		$this->lkm = $stmt->rowCount ();
		
		return $tulos;
	}
	
	function lisaaKurssi($kurssi) {
		$sql = "INSERT INTO pateva (weekday, date, start, end, course, trainer, cap, description)
		        values (:weekday, :date, :start, :end, :course, :trainer, :cap, :description)";
		
		// Valmistellaan SQL-lause
		if (! $stmt = $this->db->prepare ( $sql )) {
			$virhe = $this->db->errorInfo ();
			throw new PDOException ( $virhe [2], $virhe [1] );
		}
		
		// Parametrien sidonta
		$stmt->bindValue ( ":weekday", utf8_decode ( $kurssi->getWeekday () ), PDO::PARAM_STR );
		$stmt->bindValue ( ":date", utf8_decode (date('Y-m-d H:i:s',strtotime($kurssi->getDate ()))), PDO::PARAM_STR );
		$stmt->bindValue ( ":start", utf8_decode ($kurssi->getStart ()), PDO::PARAM_STR );
		$stmt->bindValue ( ":end", utf8_decode ($kurssi->getEnd ()), PDO::PARAM_STR );
		$stmt->bindValue ( ":course", utf8_decode ( $kurssi->getCourse () ), PDO::PARAM_STR );
		$stmt->bindValue ( ":trainer", utf8_decode ( $kurssi->getTrainer () ), PDO::PARAM_STR );
		$stmt->bindValue ( ":cap", utf8_decode ( $kurssi->getCap () ), PDO::PARAM_STR );
		$stmt->bindValue ( ":description", utf8_decode ( $kurssi->getDescription () ), PDO::PARAM_STR );
		// Jotta id:n saa lisäyksestä, täytyy laittaa tapahtumankäsittely päälle
		$this->db->beginTransaction();
		
		// Suoritetaan SQL-lause (insert)
		if (! $stmt->execute ()) {
			$virhe = $stmt->errorInfo ();
			
			if ($virhe [0] == "HY093") {
				$virhe [2] = "Invalid parameter";
			}
			// Perutaan tapahtuma
			$this->db->rollBack();
			
			throw new PDOException ( $virhe [2], $virhe [1] );
		}
		
		// id täytyy ottaa talteen ennen tapahtuman päättämistä
		$id = $this->db->lastInsertId ();
		
		$this->db->commit();
		
		// Palautetaan lisätyn ilmoituksen id
		return $id;
	}
	
	function poistaKurssi($id) {
		$sql = "DELETE FROM pateva WHERE id =:id";
		
		// Valmistellaan SQL-lause
		if (! $stmt = $this->db->prepare ( $sql )) {
			$virhe = $this->db->errorInfo ();
			throw new PDOException ( $virhe [2], $virhe [1] );
		}
		$stmt->bindValue ( ":id", $id, PDO::PARAM_INT );
		$this->db->beginTransaction();
		
		// Suoritetaan SQL-lause (delete)
		if (! $stmt->execute ()) {
			$virhe = $stmt->errorInfo ();
			
			if ($virhe [0] == "HY093") {
				$virhe [2] = "Invalid parameter";
			}
			// Perutaan tapahtuma
			$this->db->rollBack();
			
			throw new PDOException ( $virhe [2], $virhe [1] );
		}
		
		$this->db->commit();
		
	}
	
}
?>