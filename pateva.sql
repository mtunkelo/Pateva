CREATE DATABASE a1602454;
USE a1602454;

CREATE table `pateva` (
    `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
    `weekday` VARCHAR(2) NOT NULL,
    `date` DATE NOT NULL,
    `start` VARCHAR(5) NOT NULL,
    `end` VARCHAR(5) NOT NULL,
    `course` VARCHAR(100) NOT NULL,
    `trainer` VARCHAR(50) NOT NULL,
    `cap` VARCHAR(10) NOT NULL,
    `description` VARCHAR(300),
  PRIMARY KEY (`id`)  
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


INSERT INTO `pateva` (`weekday`, `date`, `start`, `end`, `course`, `trainer`, `cap`, `description`) VALUES ('MA', '2018-11-02', '08:00', '16:00', 'tyo', 'Pasi Nurmi', 'no', 'Työturvallisuuskorttikoulutus antaa työntekijälle perustiedot työympäristön vaaroista ja työsuojelusta.');
INSERT INTO `pateva` (`weekday`, `date`, `start`, `end`, `course`, `trainer`, `cap`, `description`) VALUES ('TI', '2018-10-02', '08:00', '16:00', 'hata', 'Pekka Pouta', 'no', '');
INSERT INTO `pateva` (`weekday`, `date`, `start`, `end`, `course`, `trainer`, `cap`, `description`) VALUES ('KE', '2018-09-02', '08:00', '15:00', 'eak', 'Janne Niska', 'yes', 'Ennakoivan ajon tavoitteena on, että kuljettaja osaa tunnistaa riskejä, ennakoida ja välttää vaaratilanteita.');