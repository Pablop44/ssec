-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------

DROP SCHEMA IF EXISTS `mydb` ;

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `mydb` DEFAULT CHARACTER SET utf8 ;
USE `mydb` ;


-- -----------------------------------------------------
-- Table `mydb`.`user`
-- -----------------------------------------------------

DROP TABLE IF EXISTS `mydb`.`user` ;

CREATE TABLE IF NOT EXISTS `mydb`.`user` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `dni` VARCHAR(255) NOT NULL UNIQUE,
  `username` VARCHAR(255) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `nombre` VARCHAR(45) NOT NULL,
  `apellidos` VARCHAR(45) NOT NULL,
  `telefono` VARCHAR(45) NOT NULL,
  `poblacion` VARCHAR(45) NOT NULL,
  `colegiado` INT(9) NULL,
  `cargo` VARCHAR(45) NULL,
  `especialidad` VARCHAR(45) NULL,
  `genero` VARCHAR(45) NULL,
  `nacimiento` DATETIME NULL,
  PRIMARY KEY (`id`));
  


-- -----------------------------------------------------
-- Table `mydb`.`cuenta`
-- -----------------------------------------------------

DROP TABLE IF EXISTS `mydb`.`cuenta` ;

CREATE TABLE IF NOT EXISTS `mydb`.`cuenta` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `rol` ENUM("administrador", "paciente", "medico") NOT NULL,
  `estado` ENUM("activada", "desactivada", "autorizada") NOT NULL,
  `user` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fkCuenta_idx` (`user` ASC),
  CONSTRAINT `fkUser`
    FOREIGN KEY (`user`)
    REFERENCES `mydb`.`user` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE);



-- -----------------------------------------------------
-- Table `mydb`.`consejo`
-- -----------------------------------------------------

DROP TABLE IF EXISTS `mydb`.`consejo` ;

CREATE TABLE IF NOT EXISTS `mydb`.`consejo` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `recomendacion` VARCHAR(511) NOT NULL,
  `paciente` INT NOT NULL,
  `medico` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fkPaciente_idx` (`paciente` ASC),
  INDEX `fkMedico_idx` (`medico` ASC),
  CONSTRAINT `fkPacienteConsejo`
    FOREIGN KEY (`paciente`)
    REFERENCES `mydb`.`user` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fkMedicoConsejo`
    FOREIGN KEY (`medico`)
    REFERENCES `mydb`.`user` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE);


-- -----------------------------------------------------
-- Table `mydb`.`ficha`
-- -----------------------------------------------------

DROP TABLE IF EXISTS `mydb`.`ficha` ;

CREATE TABLE IF NOT EXISTS `mydb`.`ficha` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `fechaCreacion` DATETIME NOT NULL,
  `paciente` INT NOT NULL,
  `medico` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fkPaciente_idx` (`paciente` ASC),
  INDEX `fkMedico_idx` (`medico` ASC),
  CONSTRAINT `fkPacienteFicha`
    FOREIGN KEY (`paciente`)
    REFERENCES `mydb`.`user` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fkMedicoFicha`
    FOREIGN KEY (`medico`)
    REFERENCES `mydb`.`user` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE);


-- -----------------------------------------------------
-- Table `mydb`.`consulta`
-- -----------------------------------------------------

DROP TABLE IF EXISTS `mydb`.`consulta` ;

CREATE TABLE IF NOT EXISTS `mydb`.`consulta` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `lugar` VARCHAR(50) NOT NULL,
  `motivo` VARCHAR(255) NOT NULL,
  `fecha` DATETIME NOT NULL,
  `diagnostico` VARCHAR(511),
  `observaciones` VARCHAR(511),
  `medico` INT NOT NULL,
  `paciente` INT NOT NULL,
  `ficha` INT NOT NULL,
  `estado` ENUM('aplazada', 'realizada', 'cancelada', 'en tiempo') NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fkPaciente_idx` (`paciente` ASC),
  INDEX `fkMedico_idx` (`medico` ASC),
  INDEX `fkFicha_idx` (`ficha` ASC),
  CONSTRAINT `fkPacienteConsulta1`
    FOREIGN KEY (`paciente`)
    REFERENCES `mydb`.`user` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fkMedicoConsulta1`
    FOREIGN KEY (`medico`)
    REFERENCES `mydb`.`user` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fkFichaConsulta1`
    FOREIGN KEY (`ficha`)
    REFERENCES `mydb`.`ficha` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE);


-- -----------------------------------------------------
-- Table `mydb`.`plantilla`
-- -----------------------------------------------------

DROP TABLE IF EXISTS `mydb`.`plantilla` ;

CREATE TABLE IF NOT EXISTS `mydb`.`plantilla` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `observaciones` VARCHAR(255) NOT NULL,
  `estado` VARCHAR(255) NOT NULL,
  `medico` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fkMedico_idx` (`medico` ASC),
  CONSTRAINT `fkMedicoPlantilla`
    FOREIGN KEY (`medico`)
    REFERENCES `mydb`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);


-- -----------------------------------------------------
-- Table `mydb`.`informe`
-- -----------------------------------------------------

DROP TABLE IF EXISTS `mydb`.`informe` ;

CREATE TABLE IF NOT EXISTS `mydb`.`informe` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `fecha` DATE NOT NULL,
  `plantilla` INT NOT NULL,
  `ficha` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fkPlantilla_idx` (`plantilla` ASC),
  INDEX `fkFicha_idx` (`ficha` ASC),
  CONSTRAINT `fkPlantillaInforme`
    FOREIGN KEY (`plantilla`)
    REFERENCES `mydb`.`plantilla` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fkFichaInforme`
    FOREIGN KEY (`ficha`)
    REFERENCES `mydb`.`ficha` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);


-- -----------------------------------------------------
-- Table `mydb`.`enfermedad`
-- -----------------------------------------------------

DROP TABLE IF EXISTS `mydb`.`enfermedad` ;

CREATE TABLE IF NOT EXISTS `mydb`.`enfermedad` (
  `nombre`VARCHAR(255) NOT NULL,
  PRIMARY KEY (`nombre`));


-- -----------------------------------------------------
-- Table `mydb`.`tratamiento`
-- -----------------------------------------------------

DROP TABLE IF EXISTS `mydb`.`tratamiento` ;

CREATE TABLE IF NOT EXISTS `mydb`.`tratamiento` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `posologia` VARCHAR(255) NOT NULL,
  `fechaInicio` DATE NOT NULL,
  `fechaFin` DATE NOT NULL,
  `horario` DATE NOT NULL,
  `enfermedad` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fkEnfermedad_idx` (`enfermedad` ASC),
  CONSTRAINT `fkEnfermedadTratamiento`
    FOREIGN KEY (`enfermedad`)
    REFERENCES `mydb`.`enfermedad` (`nombre`)
    ON DELETE CASCADE
    ON UPDATE CASCADE);


-- -----------------------------------------------------
-- Table `mydb`.`marca`
-- -----------------------------------------------------

DROP TABLE IF EXISTS `mydb`.`marca` ;

CREATE TABLE IF NOT EXISTS `mydb`.`marca` (
  `nombre` VARCHAR(50) NOT NULL,
  `pais` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`nombre`));


-- -----------------------------------------------------
-- Table `mydb`.`medicamento`
-- -----------------------------------------------------

DROP TABLE IF EXISTS `mydb`.`medicamento` ;

CREATE TABLE IF NOT EXISTS `mydb`.`medicamento` (
  `nombre` VARCHAR(50) NOT NULL,
  `viaAdministracion` ENUM("oral", "sublingual", "parental", "intravenosa", "intraarterial", "intramuscular", "subcutanea", "otro") NOT NULL,
  `marca` VARCHAR(50) NOT NULL,
  `dosis` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`nombre`),
  INDEX `fkMarca_idx` (`marca` ASC),
  CONSTRAINT `fkMarcaMedicamento`
    FOREIGN KEY (`marca`)
    REFERENCES `mydb`.`marca` (`nombre`)
    ON DELETE CASCADE
    ON UPDATE CASCADE);


-- -----------------------------------------------------
-- Table `mydb`.`ficha_enfermedad`
-- -----------------------------------------------------

DROP TABLE IF EXISTS `mydb`.`ficha_enfermedad` ;

CREATE TABLE IF NOT EXISTS `mydb`.`ficha_enfermedad` (
  `ficha` INT NOT NULL,
  `enfermedad` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`ficha`, `enfermedad`),
  INDEX `fkEnfermedad_idx` (`enfermedad` ASC),
  CONSTRAINT `fkFicha`
    FOREIGN KEY (`ficha`)
    REFERENCES `mydb`.`ficha` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fkEnfermedad`
    FOREIGN KEY (`enfermedad`)
    REFERENCES `mydb`.`enfermedad` (`nombre`)
    ON DELETE CASCADE
    ON UPDATE CASCADE);


-- -----------------------------------------------------
-- Table `mydb`.`tratamiento_medicamento`
-- -----------------------------------------------------

DROP TABLE IF EXISTS `mydb`.`tratamiento_medicamento` ;

CREATE TABLE IF NOT EXISTS `mydb`.`tratamiento_medicamento` (
  `medicamento` VARCHAR(50) NOT NULL,
  `tratamiento` INT NOT NULL,
  PRIMARY KEY (`medicamento`, `tratamiento`),
  INDEX `fkTratamiento_idx` (`tratamiento` ASC),
  CONSTRAINT `fkMedicamento`
    FOREIGN KEY (`medicamento`)
    REFERENCES `mydb`.`medicamento` (`nombre`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fkTratamiento`
    FOREIGN KEY (`tratamiento`)
    REFERENCES `mydb`.`tratamiento` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE);


-- -----------------------------------------------------
-- Table `mydb`.`nota`
-- -----------------------------------------------------

DROP TABLE IF EXISTS `mydb`.`nota` ;

CREATE TABLE IF NOT EXISTS `mydb`.`nota` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `fecha` DATE NOT NULL,
  `datos` VARCHAR(511) NOT NULL,
  `paciente` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fkPaciente_idx` (`paciente` ASC),
  CONSTRAINT `fkPacienteNota`
    FOREIGN KEY (`paciente`)
    REFERENCES `mydb`.`user` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE);


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;


INSERT INTO `user`(`id`, `dni`, `username`, `password`, `email`, `nombre`, `apellidos`, `telefono`, `poblacion`, `colegiado`, `cargo`, `especialidad`, `genero`, `nacimiento`) VALUES (null, '11111111A', 'admin',  'admin', 'admin@admin.com', 'admin', 'admin', '111111111', 'vigo', null, 'administrador', '', 'Male', '');
insert into USER (id, dni, username, password, email, nombre, apellidos, telefono, poblacion, colegiado, cargo, especialidad, genero, nacimiento) values (2, '53857525h', 'rhune1', 'NuZPTuTnJ0t', 'rhune1@weibo.com', 'Raymond', 'Hune', '6813029148', 'San Vicente', '44164292', 'medico', 'migranas', 'Male', '2010-05-07 04:56:32');
insert into USER (id, dni, username, password, email, nombre, apellidos, telefono, poblacion, colegiado, cargo, especialidad, genero, nacimiento) values (3, '25057904x', 'adomone2', 'BIhrVS1P', 'adomone2@shareasale.com', 'Alexine', 'Domone', '9186514509', 'Corinto', '24192239', 'medico', 'migranas', 'Female', '1999-06-26 07:50:02');
insert into USER (id, dni, username, password, email, nombre, apellidos, telefono, poblacion, colegiado, cargo, especialidad, genero, nacimiento) values (4, '20656928o', 'gwalkington3', 'xLsmq8Pzmmda', 'gwalkington3@ucsd.edu', 'Gabby', 'Walkington', '3929262178', 'Oytal', '16349402', 'medico', 'migranas', 'Male', '1956-05-30 09:27:37');
insert into USER (id, dni, username, password, email, nombre, apellidos, telefono, poblacion, colegiado, cargo, especialidad, genero, nacimiento) values (5, '78286619D', 'acammoile4', 't3kDkcDSMM', 'acammoile4@list-manage.com', 'Aloysius', 'Cammoile', '8518414499', 'Shuangmiao', '86929147', 'medico', 'migranas', 'Male', '2014-04-26 06:30:12');
insert into USER (id, dni, username, password, email, nombre, apellidos, telefono, poblacion, colegiado, cargo, especialidad, genero, nacimiento) values (6, '30516357q', 'ahendriks5', 'f13i5I', 'ahendriks5@senate.gov', 'Antony', 'Hendriks', '4436125447', 'Junyang', '31783927', 'medico', 'migranas', 'Male', '2013-09-14 17:40:34');
insert into USER (id, dni, username, password, email, nombre, apellidos, telefono, poblacion, colegiado, cargo, especialidad, genero, nacimiento) values (7, '86797706E', 'cmessenbird6', 'F6DSdv', 'cmessenbird6@tumblr.com', 'Chris', 'Messenbird', '8415045078', 'Ban Thaen', '78120449', 'medico', 'migranas', 'Male', '2004-12-13 09:11:39');
insert into USER (id, dni, username, password, email, nombre, apellidos, telefono, poblacion, colegiado, cargo, especialidad, genero, nacimiento) values (8, '69971711O', 'vfalkous7', 'axef80ktvAvI', 'vfalkous7@jugem.jp', 'Veda', 'Falkous', '8371631900', 'Banes', '60128202', 'medico', 'migranas', 'Female', '1958-06-30 18:57:44');
insert into USER (id, dni, username, password, email, nombre, apellidos, telefono, poblacion, colegiado, cargo, especialidad, genero, nacimiento) values (9, '49800092l', 'tflux8', 'DmAZEcfYx', 'tflux8@furl.net', 'Tiphanie', 'Flux', '8041029705', 'Songshan', '06027462', 'medico', 'migranas', 'Female', '2009-08-03 08:04:15');
insert into USER (id, dni, username, password, email, nombre, apellidos, telefono, poblacion, colegiado, cargo, especialidad, genero, nacimiento) values (10, '22382253Z', 'lpeasnone9', 'igphJ5kYX', 'lpeasnone9@netscape.com', 'Lexis', 'Peasnone', '5034567373', 'Frankfurt am Main', '21511355', 'medico', 'migranas', 'Female', '1990-10-22 08:55:53');
insert into USER (id, dni, username, password, email, nombre, apellidos, telefono, poblacion, colegiado, cargo, especialidad, genero, nacimiento) values (11, '65194491G', 'tivashova', 'JWdBhATb5o', 'tivashova@nature.com', 'Tandy', 'Ivashov', '1166302017', 'Huayan', '51085452', 'medico', 'migranas', 'Female', '1983-01-13 02:11:35');
insert into USER (id, dni, username, password, email, nombre, apellidos, telefono, poblacion, colegiado, cargo, especialidad, genero, nacimiento) values (12, '80449880a', 'lpellewb', 'gbROIAhrR', 'lpellewb@economist.com', 'Laverna', 'Pellew', '8165794461', 'Lees Summit', '82967425', 'medico', 'migranas', 'Female', '2013-07-29 11:02:29');
insert into USER (id, dni, username, password, email, nombre, apellidos, telefono, poblacion, colegiado, cargo, especialidad, genero, nacimiento) values (13, '26945708E', 'lmarrowsc', 'ELohpySrJF', 'lmarrowsc@instagram.com', 'Lissy', 'Marrows', '5782588264', 'Fucheng', '85575842', 'medico', 'migranas', 'Female', '1963-02-27 04:40:43');
insert into USER (id, dni, username, password, email, nombre, apellidos, telefono, poblacion, colegiado, cargo, especialidad, genero, nacimiento) values (14, '53306244G', 'rbowcherd', 'HRtbbyNqn', 'rbowcherd@zdnet.com', 'Richmond', 'Bowcher', '1354693777', 'Garcia Hernandez', '45281518', 'medico', 'migranas', 'Male', '1950-10-16 09:39:14');
insert into USER (id, dni, username, password, email, nombre, apellidos, telefono, poblacion, colegiado, cargo, especialidad, genero, nacimiento) values (15, '96393703P', 'cwaddinghame', 'hmEXdgimtUPU', 'cwaddinghame@biglobe.ne.jp', 'Catlin', 'Waddingham', '7552204534', 'Perpignan', '92620967', 'medico', 'migranas', 'Female', '2010-08-24 05:15:54');
insert into USER (id, dni, username, password, email, nombre, apellidos, telefono, poblacion, colegiado, cargo, especialidad, genero, nacimiento) values (16, '05038320T', 'estaddenf', 'UyRoNV', 'estaddenf@soundcloud.com', 'Emilia', 'Stadden', '4316735344', 'Évry', '90745902', 'medico', 'migranas', 'Female', '2013-10-25 18:09:32');
insert into USER (id, dni, username, password, email, nombre, apellidos, telefono, poblacion, colegiado, cargo, especialidad, genero, nacimiento) values (17, '74550209T', 'mwellsg', 'xZeOzN8Cjqj', 'mwellsg@so-net.ne.jp', 'Modestine', 'Wells', '1352190044', 'Baardheere', '21790148', 'medico', 'migranas', 'Female', '1997-09-02 19:28:06');
insert into USER (id, dni, username, password, email, nombre, apellidos, telefono, poblacion, colegiado, cargo, especialidad, genero, nacimiento) values (18, '99666550U', 'wdarnbroughh', 'p1GWNMB9', 'wdarnbroughh@ebay.co.uk', 'Wash', 'Darnbrough', '1566505063', 'Yangirabot', '25686770', 'medico', 'migranas', 'Male', '1954-07-21 10:17:55');
insert into USER (id, dni, username, password, email, nombre, apellidos, telefono, poblacion, colegiado, cargo, especialidad, genero, nacimiento) values (19, '85975370d', 'clecontei', 'snZdek5N', 'clecontei@google.com', 'Caye', 'Le Conte', '5061938047', 'Oropéndolas', '76448077', 'medico', 'migranas', 'Female', '2003-11-02 08:55:28');
insert into USER (id, dni, username, password, email, nombre, apellidos, telefono, poblacion, colegiado, cargo, especialidad, genero, nacimiento) values (20, '45103592F', 'fdonovinj', 'iEdpf2', 'fdonovinj@netvibes.com', 'Florentia', 'Donovin', '3874668775', 'Kobelyaky', '32519274', 'medico', 'migranas', 'Female', '1978-04-20 19:52:26');
insert into USER (id, dni, username, password, email, nombre, apellidos, telefono, poblacion, colegiado, cargo, especialidad, genero, nacimiento) values (21, '38068217Q', 'opoulsenk', 'sjjDLRfaUn', 'opoulsenk@e-recht24.de', 'Oralle', 'Poulsen', '6043551281', 'Saraqinishtë', '69730199', 'medico', 'migranas', 'Female', '2007-11-27 18:57:24');
insert into USER (id, dni, username, password, email, nombre, apellidos, telefono, poblacion, colegiado, cargo, especialidad, genero, nacimiento) values (22, '79867521J', 'ncaesmansl', 'Q4x69LluA', 'ncaesmansl@digg.com', 'Northrop', 'Caesmans', '6248038332', 'Barrouallie', '68266886', 'medico', 'migranas', 'Male', '1955-10-09 23:10:20');
insert into USER (id, dni, username, password, email, nombre, apellidos, telefono, poblacion, colegiado, cargo, especialidad, genero, nacimiento) values (23, '90735249i', 'lmarcamm', 'i7uGBaUFxu', 'lmarcamm@mysql.com', 'Laurie', 'Marcam', '9676285983', 'Caluire-et-Cuire', '71986637', 'medico', 'migranas', 'Female', '2018-02-02 00:26:46');
insert into USER (id, dni, username, password, email, nombre, apellidos, telefono, poblacion, colegiado, cargo, especialidad, genero, nacimiento) values (24, '36171920d', 'kvalentin', 'LZq8CwmO', 'kvalentin@google.it', 'Kenon', 'Valenti', '7187559093', 'Noyemberyan', '69695971', 'medico', 'migranas', 'Male', '2016-01-18 01:31:23');
insert into USER (id, dni, username, password, email, nombre, apellidos, telefono, poblacion, colegiado, cargo, especialidad, genero, nacimiento) values (25, '85379599l', 'nburlinghamo', 'W5r1fEiEW', 'nburlinghamo@abc.net.au', 'Nelie', 'Burlingham', '6679923093', 'Borås', '09070654', 'medico', 'migranas', 'Female', '1984-09-15 11:44:43');
insert into USER (id, dni, username, password, email, nombre, apellidos, telefono, poblacion, colegiado, cargo, especialidad, genero, nacimiento) values (26, '56131283I', 'dcurlep', 'MLi7nrFIkv', 'dcurlep@upenn.edu', 'Dennie', 'Curle', '4667275515', 'Alangilanan', '00777716', 'medico', 'migranas', 'Male', '1998-07-14 06:11:04');
insert into USER (id, dni, username, password, email, nombre, apellidos, telefono, poblacion, colegiado, cargo, especialidad, genero, nacimiento) values (27, '42053082H', 'ijebbq', 'AH3jySouiO6', 'ijebbq@ucoz.ru', 'Idelle', 'Jebb', '5403082800', 'Krebetkrajan', '76738408', 'medico', 'migranas', 'Female', '1995-05-19 14:43:16');
insert into USER (id, dni, username, password, email, nombre, apellidos, telefono, poblacion, colegiado, cargo, especialidad, genero, nacimiento) values (28, '21967859W', 'mtessymanr', 'I9xKCzUOZzKL', 'mtessymanr@ibm.com', 'Martica', 'Tessyman', '7442778258', 'Makrochóri', '74872571', 'medico', 'migranas', 'Female', '1961-01-11 22:59:22');
insert into USER (id, dni, username, password, email, nombre, apellidos, telefono, poblacion, colegiado, cargo, especialidad, genero, nacimiento) values (29, '96745270M', 'sisitts', 'rpow055', 'sisitts@discovery.com', 'Symon', 'Isitt', '7572714109', 'Béziers', '88473464', 'medico', 'migranas', 'Male', '1999-04-08 20:04:02');
insert into USER (id, dni, username, password, email, nombre, apellidos, telefono, poblacion, colegiado, cargo, especialidad, genero, nacimiento) values (30, '76330102C', 'dangelinit', 'c8Nd0Q4WCb', 'dangelinit@toplist.cz', 'Desi', 'Angelini', '8844288153', 'Bromma', '12055840', 'medico', 'migranas', 'Male', '1951-09-11 09:29:50');
insert into USER (id, dni, username, password, email, nombre, apellidos, telefono, poblacion, colegiado, cargo, especialidad, genero, nacimiento) values (31, '13172998I', 'ncrandonu', 'MiTa5C', 'ncrandonu@indiegogo.com', 'Nicolas', 'Crandon', '8744913994', 'Bishan', '36978371', 'medico', 'migranas', 'Male', '2001-12-27 07:35:51');
insert into USER (id, dni, username, password, email, nombre, apellidos, telefono, poblacion, colegiado, cargo, especialidad, genero, nacimiento) values (32, '72578699S', 'dcollierv', 'MKEqSiWI', 'dcollierv@prlog.org', 'Dorie', 'Collier', '5311125657', 'Stockholm', '78131626', 'medico', 'migranas', 'Female', '1981-01-01 17:15:32');
insert into USER (id, dni, username, password, email, nombre, apellidos, telefono, poblacion, colegiado, cargo, especialidad, genero, nacimiento) values (33, '67963331r', 'areayw', '2NDu7ZSEB', 'areayw@google.com.hk', 'Angelika', 'Reay', '3525740175', 'Polonne', '88852088', 'medico', 'migranas', 'Female', '1998-08-10 15:56:26');
insert into USER (id, dni, username, password, email, nombre, apellidos, telefono, poblacion, colegiado, cargo, especialidad, genero, nacimiento) values (34, '15022062n', 'fwhyex', 'OSAWGmYu', 'fwhyex@sun.com', 'Frederique', 'Whye', '1189993775', 'Eshan', '88177918', 'medico', 'migranas', 'Female', '1993-12-31 21:50:51');
insert into USER (id, dni, username, password, email, nombre, apellidos, telefono, poblacion, colegiado, cargo, especialidad, genero, nacimiento) values (35, '48340496r', 'jturleyy', 'CLBZQn5', 'jturleyy@wunderground.com', 'Jennifer', 'Turley', '5979681114', 'Bizerte', '57059318', 'medico', 'migranas', 'Female', '1998-05-23 16:04:48');
insert into USER (id, dni, username, password, email, nombre, apellidos, telefono, poblacion, colegiado, cargo, especialidad, genero, nacimiento) values (36, '55496983a', 'ecrosez', 'g5TQaNPp', 'ecrosez@ask.com', 'Etan', 'Crose', '5865206491', 'Cendagah', '74840739', 'medico', 'migranas', 'Male', '1990-03-20 20:48:52');
insert into USER (id, dni, username, password, email, nombre, apellidos, telefono, poblacion, colegiado, cargo, especialidad, genero, nacimiento) values (37, '18800784J', 'sluker10', 'Qs0WlDSP', 'sluker10@businessinsider.com', 'Steven', 'Luker', '6214676591', 'Botigues', '71870149', 'medico', 'migranas', 'Male', '1957-03-31 21:52:46');
insert into USER (id, dni, username, password, email, nombre, apellidos, telefono, poblacion, colegiado, cargo, especialidad, genero, nacimiento) values (38, '51755535z', 'dwitherbed11', '3Hh1iqdmDrF', 'dwitherbed11@bizjournals.com', 'Demetria', 'Witherbed', '4744982648', 'Reshetnikovo', '31130402', 'medico', 'migranas', 'Female', '1958-09-19 01:06:43');
insert into USER (id, dni, username, password, email, nombre, apellidos, telefono, poblacion, colegiado, cargo, especialidad, genero, nacimiento) values (39, '01156175q', 'dcapaldo12', 'k4vdFoxr6R', 'dcapaldo12@geocities.com', 'Dasha', 'Capaldo', '9081935792', 'Andilamena', '24120169', 'medico', 'migranas', 'Female', '1965-06-06 07:01:39');
insert into USER (id, dni, username, password, email, nombre, apellidos, telefono, poblacion, colegiado, cargo, especialidad, genero, nacimiento) values (40, '55965905S', 'ofranssen13', 'lmTE1l2CPOdU', 'ofranssen13@acquirethisname.com', 'Onfre', 'Franssen', '4945050624', 'Stamboliyski', '22469029', 'medico', 'migranas', 'Male', '1999-09-22 05:08:00');
insert into USER (id, dni, username, password, email, nombre, apellidos, telefono, poblacion, colegiado, cargo, especialidad, genero, nacimiento) values (41, '72604576R', 'wthreader14', 'QQnxXO', 'wthreader14@comcast.net', 'Wren', 'Threader', '5328019380', 'Peachland', '61071585', 'medico', 'migranas', 'Female', '1974-03-02 18:52:56');
insert into USER (id, dni, username, password, email, nombre, apellidos, telefono, poblacion, colegiado, cargo, especialidad, genero, nacimiento) values (42, '68309388Q', 'mcodlin15', 'qJWfowk606', 'mcodlin15@cnet.com', 'Mohammed', 'Codlin', '7703277337', 'Qulai', '45503654', 'medico', 'migranas', 'Male', '1965-12-06 03:34:44');
insert into USER (id, dni, username, password, email, nombre, apellidos, telefono, poblacion, colegiado, cargo, especialidad, genero, nacimiento) values (43, '52998951x', 'eteffrey16', 'OOKSwpwdTY', 'eteffrey16@vistaprint.com', 'Eugenio', 'Teffrey', '7756285774', 'Dipayal', '80714784', 'medico', 'migranas', 'Male', '2004-08-29 22:51:43');
insert into USER (id, dni, username, password, email, nombre, apellidos, telefono, poblacion, colegiado, cargo, especialidad, genero, nacimiento) values (44, '82429323n', 'afaill17', 'dR18oKV0SCy', 'afaill17@nydailynews.com', 'Adolph', 'Faill', '3363400954', 'Sirre', '49169727', 'medico', 'migranas', 'Male', '1965-05-30 15:15:52');
insert into USER (id, dni, username, password, email, nombre, apellidos, telefono, poblacion, colegiado, cargo, especialidad, genero, nacimiento) values (45, '96710394p', 'gbenson18', 'GCLxwk', 'gbenson18@discovery.com', 'Giff', 'Benson', '1481468273', 'Zīrakī', '82315456', 'medico', 'migranas', 'Male', '1956-04-16 05:59:21');
insert into USER (id, dni, username, password, email, nombre, apellidos, telefono, poblacion, colegiado, cargo, especialidad, genero, nacimiento) values (46, '68728592b', 'pmcneachtain19', '4DGXgNOgRmDa', 'pmcneachtain19@typepad.com', 'Prinz', 'McNeachtain', '6332441773', 'Mora', '91669532', 'medico', 'migranas', 'Male', '1969-11-16 10:08:13');
insert into USER (id, dni, username, password, email, nombre, apellidos, telefono, poblacion, colegiado, cargo, especialidad, genero, nacimiento) values (47, '73479332H', 'mpergens1a', 'EleC5sp3vN', 'mpergens1a@wunderground.com', 'Marris', 'Pergens', '8678680878', 'Ratchasan', '12413649', 'medico', 'migranas', 'Female', '1962-07-07 14:33:40');
insert into USER (id, dni, username, password, email, nombre, apellidos, telefono, poblacion, colegiado, cargo, especialidad, genero, nacimiento) values (48, '88837547C', 'lloughead1b', '9hJ7VCsqQcA', 'lloughead1b@who.int', 'Laurie', 'Loughead', '1856277313', 'Bengubelan', '72044071', 'medico', 'migranas', 'Male', '1976-12-02 17:31:18');
insert into USER (id, dni, username, password, email, nombre, apellidos, telefono, poblacion, colegiado, cargo, especialidad, genero, nacimiento) values (49, '01937429v', 'mcammacke1c', 'VjaD7OX71', 'mcammacke1c@friendfeed.com', 'Manfred', 'Cammacke', '3047075502', 'Timashëvsk', '97341874', 'medico', 'migranas', 'Male', '1998-02-21 12:32:30');
insert into USER (id, dni, username, password, email, nombre, apellidos, telefono, poblacion, colegiado, cargo, especialidad, genero, nacimiento) values (50, '43500569A', 'mbrogioni1d', 'Hoj6VxgPKI', 'mbrogioni1d@ox.ac.uk', 'Maxie', 'Brogioni', '5804204350', 'Xushuguan', '22977516', 'medico', 'migranas', 'Female', '1999-11-22 16:28:28');
insert into USER (id, dni, username, password, email, nombre, apellidos, telefono, poblacion, colegiado, cargo, especialidad, genero, nacimiento) values (51, '60643857k', 'msaltsberg1e', 'UZQrHTVblB', 'msaltsberg1e@wufoo.com', 'Maris', 'Saltsberg', '8453500863', 'Campo Largo', '89327445', 'medico', 'migranas', 'Female', '1999-11-27 13:34:07');
insert into USER (id, dni, username, password, email, nombre, apellidos, telefono, poblacion, colegiado, cargo, especialidad, genero, nacimiento) values (52, '26410424I', 'vbotcherby1f', 'JKnXG5v3RM', 'vbotcherby1f@nhs.uk', 'Vergil', 'Botcherby', '1905705925', 'Myasnikyan', '52791519', 'medico', 'migranas', 'Male', '2003-01-04 14:27:01');
insert into USER (id, dni, username, password, email, nombre, apellidos, telefono, poblacion, colegiado, cargo, especialidad, genero, nacimiento) values (53, '02858825O', 'rmadine1g', 'B15Ewg', 'rmadine1g@kickstarter.com', 'Reube', 'Madine', '4604132875', 'Banjar Beratan', '50762303', 'medico', 'migranas', 'Male', '1951-05-24 20:30:09');
insert into USER (id, dni, username, password, email, nombre, apellidos, telefono, poblacion, colegiado, cargo, especialidad, genero, nacimiento) values (54, '03925493K', 'sdegogay1h', 'fR77jnAQgj2a', 'sdegogay1h@unesco.org', 'Sib', 'De Gogay', '3977785555', 'Oskarshamn', '96035064', 'medico', 'migranas', 'Female', '2001-02-14 00:18:26');
insert into USER (id, dni, username, password, email, nombre, apellidos, telefono, poblacion, colegiado, cargo, especialidad, genero, nacimiento) values (55, '64942173e', 'kbolus1i', 'HZC76faZPO', 'kbolus1i@jimdo.com', 'Keenan', 'Bolus', '5954882982', 'San Agustin', '89173334', 'medico', 'migranas', 'Male', '1959-04-27 18:54:54');
insert into USER (id, dni, username, password, email, nombre, apellidos, telefono, poblacion, colegiado, cargo, especialidad, genero, nacimiento) values (56, '27148988A', 'gbalasini1j', 'xZjWeuJIjRDt', 'gbalasini1j@google.ru', 'Gypsy', 'Balasini', '9579349225', 'Xigaoshan', '14930122', 'medico', 'migranas', 'Female', '2011-12-02 11:18:14');
insert into USER (id, dni, username, password, email, nombre, apellidos, telefono, poblacion, colegiado, cargo, especialidad, genero, nacimiento) values (57, '37092439N', 'mlapenna1k', 'P0DJk54sSI', 'mlapenna1k@feedburner.com', 'Marlo', 'Lapenna', '9637113396', 'Jardia', '27532153', 'medico', 'migranas', 'Female', '1970-10-28 11:20:16');
insert into USER (id, dni, username, password, email, nombre, apellidos, telefono, poblacion, colegiado, cargo, especialidad, genero, nacimiento) values (58, '36011711C', 'asmalcombe1l', 'V3d3DXqm', 'asmalcombe1l@nasa.gov', 'Aurilia', 'Smalcombe', '5259864940', 'Rancabelut', '75977422', 'medico', 'migranas', 'Female', '1989-09-03 15:33:03');
insert into USER (id, dni, username, password, email, nombre, apellidos, telefono, poblacion, colegiado, cargo, especialidad, genero, nacimiento) values (59, '14961916h', 'bdefrancesco1m', 'IRLU1U21W', 'bdefrancesco1m@newsvine.com', 'Babbette', 'De Francesco', '8826378920', 'Al Bahlūlīyah', '36939003', 'medico', 'migranas', 'Female', '2014-04-28 13:51:47');
insert into USER (id, dni, username, password, email, nombre, apellidos, telefono, poblacion, colegiado, cargo, especialidad, genero, nacimiento) values (60, '66405099J', 'bdonaghie1n', '0JDFHPiE', 'bdonaghie1n@comsenz.com', 'Brigida', 'Donaghie', '1271898986', 'Ponta Porã', '87919068', 'medico', 'migranas', 'Female', '1952-05-18 10:41:51');
insert into USER (id, dni, username, password, email, nombre, apellidos, telefono, poblacion, colegiado, cargo, especialidad, genero, nacimiento) values (61, '36401360T', 'wbavister1o', 'xvHtW5tHN4', 'wbavister1o@latimes.com', 'Wilfred', 'Bavister', '6428101874', 'Kota Kinabalu', '93495492', 'medico', 'migranas', 'Male', '2014-02-06 00:05:43');
insert into USER (id, dni, username, password, email, nombre, apellidos, telefono, poblacion, colegiado, cargo, especialidad, genero, nacimiento) values (62, '73517320G', 'jwildbore1p', 'Fp9SMlOwN', 'jwildbore1p@ovh.net', 'Jill', 'Wildbore', '4231216846', 'Yilan', '74942655', 'medico', 'migranas', 'Female', '1957-04-13 04:35:49');
insert into USER (id, dni, username, password, email, nombre, apellidos, telefono, poblacion, colegiado, cargo, especialidad, genero, nacimiento) values (63, '94419543N', 'cedwick1q', 'C60121AM5F', 'cedwick1q@cloudflare.com', 'Chryste', 'Edwick', '4958972416', 'Berëzovka', '90396673', 'medico', 'migranas', 'Female', '1962-09-15 13:17:36');
insert into USER (id, dni, username, password, email, nombre, apellidos, telefono, poblacion, colegiado, cargo, especialidad, genero, nacimiento) values (64, '69324470E', 'yrodolphe1r', 'g9csOhb8', 'yrodolphe1r@51.la', 'Yolande', 'Rodolphe', '7579915325', 'Miaoli', '43786385', 'medico', 'migranas', 'Female', '1960-12-16 11:08:06');
insert into USER (id, dni, username, password, email, nombre, apellidos, telefono, poblacion, colegiado, cargo, especialidad, genero, nacimiento) values (65, '60217467X', 'sskilbeck1s', 'HyByCS0', 'sskilbeck1s@umich.edu', 'Stavros', 'Skilbeck', '3693277930', 'Jianling', '52179966', 'medico', 'migranas', 'Male', '1956-03-23 00:15:25');
insert into USER (id, dni, username, password, email, nombre, apellidos, telefono, poblacion, colegiado, cargo, especialidad, genero, nacimiento) values (66, '73486549Y', 'votson1t', 'Uyx1YRqCP7', 'votson1t@moonfruit.com', 'Vivie', 'Otson', '5876379265', 'Al Lubban al Gharbī', '64990523', 'medico', 'migranas', 'Female', '1977-03-18 10:19:20');
insert into USER (id, dni, username, password, email, nombre, apellidos, telefono, poblacion, colegiado, cargo, especialidad, genero, nacimiento) values (67, '48443277m', 'lpidgin1u', 'oTvl8bGB8f7Q', 'lpidgin1u@cafepress.com', 'Laurence', 'Pidgin', '6793047553', 'Mujiangping', '57578377', 'medico', 'migranas', 'Male', '1955-12-29 03:12:06');
insert into USER (id, dni, username, password, email, nombre, apellidos, telefono, poblacion, colegiado, cargo, especialidad, genero, nacimiento) values (68, '89538019C', 'ebottrill1v', '5WKaLKG8', 'ebottrill1v@time.com', 'Edith', 'Bottrill', '5623438234', 'Dublje', '83135728', 'medico', 'migranas', 'Female', '1951-10-15 08:56:53');
insert into USER (id, dni, username, password, email, nombre, apellidos, telefono, poblacion, colegiado, cargo, especialidad, genero, nacimiento) values (69, '03004603T', 'dtomadoni1w', 'IurQvRLz', 'dtomadoni1w@sciencedirect.com', 'Darlene', 'Tomadoni', '8086859452', 'Guijalo', '58622531', 'medico', 'migranas', 'Female', '1956-09-20 11:57:38');
insert into USER (id, dni, username, password, email, nombre, apellidos, telefono, poblacion, colegiado, cargo, especialidad, genero, nacimiento) values (70, '85417015M', 'bclacey1x', 'lW6d0z8HJ9', 'bclacey1x@tinypic.com', 'Berkley', 'Clacey', '3289176239', 'Tambac', '02656837', 'medico', 'migranas', 'Male', '1950-10-31 09:52:39');
insert into USER (id, dni, username, password, email, nombre, apellidos, telefono, poblacion, colegiado, cargo, especialidad, genero, nacimiento) values (71, '86639136W', 'ceilers1y', 'XHPUnY3', 'ceilers1y@tinyurl.com', 'Clara', 'Eilers', '7421192853', 'Cikabuyutan Barat', '24176826', 'medico', 'migranas', 'Female', '1976-05-21 15:44:10');
insert into USER (id, dni, username, password, email, nombre, apellidos, telefono, poblacion, colegiado, cargo, especialidad, genero, nacimiento) values (72, '86025441u', 'aruddiman1z', 'aCRUKKqc0K', 'aruddiman1z@state.gov', 'Arthur', 'Ruddiman', '4696532927', 'Anolaima', '80694859', 'medico', 'migranas', 'Male', '2019-04-20 14:37:56');
insert into USER (id, dni, username, password, email, nombre, apellidos, telefono, poblacion, colegiado, cargo, especialidad, genero, nacimiento) values (73, '61636374H', 'ecatterill20', 'XMMbL9syIRD3', 'ecatterill20@pcworld.com', 'Emmett', 'Catterill', '5796316411', 'Shunling', '29057062', 'medico', 'migranas', 'Male', '1962-06-10 03:37:38');
insert into USER (id, dni, username, password, email, nombre, apellidos, telefono, poblacion, colegiado, cargo, especialidad, genero, nacimiento) values (74, '73714593W', 'ghalegarth21', '9vTUrM5lU', 'ghalegarth21@epa.gov', 'Gherardo', 'Halegarth', '6454675933', 'Siak Sri Indrapura', '16963316', 'medico', 'migranas', 'Male', '1990-04-17 20:24:00');
insert into USER (id, dni, username, password, email, nombre, apellidos, telefono, poblacion, colegiado, cargo, especialidad, genero, nacimiento) values (75, '60854315R', 'lrabbet22', 'uEwhvXeM8d', 'lrabbet22@dailymotion.com', 'Lucita', 'Rabbet', '1311954856', 'Laidian', '48080695', 'medico', 'migranas', 'Female', '2005-07-04 21:43:54');
insert into USER (id, dni, username, password, email, nombre, apellidos, telefono, poblacion, colegiado, cargo, especialidad, genero, nacimiento) values (76, '91257311u', 'lhoworth23', 'uBWRoxRnxJ', 'lhoworth23@vinaora.com', 'Lilah', 'Howorth', '9314533743', 'Magang', '36310342', 'medico', 'migranas', 'Female', '1960-11-15 17:12:02');
insert into USER (id, dni, username, password, email, nombre, apellidos, telefono, poblacion, colegiado, cargo, especialidad, genero, nacimiento) values (77, '02456771C', 'clorentzen24', '9tOPRT5gG', 'clorentzen24@canalblog.com', 'Christa', 'Lorentzen', '8274601829', 'Kunri', '37332788', 'medico', 'migranas', 'Female', '2006-09-26 05:42:18');
insert into USER (id, dni, username, password, email, nombre, apellidos, telefono, poblacion, colegiado, cargo, especialidad, genero, nacimiento) values (78, '99577783o', 'amcneice25', 'PGj3rmBnhiHv', 'amcneice25@earthlink.net', 'Amitie', 'McNeice', '1897544123', 'Cherga', '46991094', 'medico', 'migranas', 'Female', '1958-07-28 03:18:43');
insert into USER (id, dni, username, password, email, nombre, apellidos, telefono, poblacion, colegiado, cargo, especialidad, genero, nacimiento) values (79, '44466418C', 'sjado26', 'Is3HnM', 'sjado26@xrea.com', 'Shea', 'Jado', '8056680245', 'Hudong', '39113415', 'medico', 'migranas', 'Male', '1977-12-06 16:42:07');
insert into USER (id, dni, username, password, email, nombre, apellidos, telefono, poblacion, colegiado, cargo, especialidad, genero, nacimiento) values (80, '13829474V', 'gpatifield27', '83uacBZ', 'gpatifield27@engadget.com', 'Griffin', 'Patifield', '3972051927', 'Nedakonice', '97597025', 'medico', 'migranas', 'Male', '2002-08-07 18:20:31');
insert into USER (id, dni, username, password, email, nombre, apellidos, telefono, poblacion, colegiado, cargo, especialidad, genero, nacimiento) values (81, '77391965X', 'gplante28', 'hUCNypmQ', 'gplante28@cbc.ca', 'Gertrudis', 'Plante', '9042478398', 'Nové Město pod Smrkem', '93273684', 'medico', 'migranas', 'Female', '1950-05-16 09:58:54');
insert into USER (id, dni, username, password, email, nombre, apellidos, telefono, poblacion, colegiado, cargo, especialidad, genero, nacimiento) values (82, '37440610T', 'dgreenard29', 'AxzaFrn9', 'dgreenard29@irs.gov', 'Damara', 'Greenard', '6192995357', 'Sarandi', '97260981', 'medico', 'migranas', 'Female', '2017-01-23 11:54:48');
insert into USER (id, dni, username, password, email, nombre, apellidos, telefono, poblacion, colegiado, cargo, especialidad, genero, nacimiento) values (83, '87818454U', 'nryman2a', '1wZvbhHKr', 'nryman2a@usnews.com', 'Nap', 'Ryman', '6096379676', 'Bhakkar', '03771345', 'medico', 'migranas', 'Male', '1999-08-26 07:38:20');
insert into USER (id, dni, username, password, email, nombre, apellidos, telefono, poblacion, colegiado, cargo, especialidad, genero, nacimiento) values (84, '25503119f', 'aborleace2b', 'FayvBPD', 'aborleace2b@youku.com', 'Alison', 'Borleace', '8494254295', 'Pangian', '26297972', 'medico', 'migranas', 'Female', '1969-09-29 16:41:38');
insert into USER (id, dni, username, password, email, nombre, apellidos, telefono, poblacion, colegiado, cargo, especialidad, genero, nacimiento) values (85, '07544565q', 'dkynsey2c', '8LKbSrnBiPP', 'dkynsey2c@dot.gov', 'Dix', 'Kynsey', '8093929935', 'Krajan Menggare', '87873663', 'medico', 'migranas', 'Female', '1987-10-06 10:27:26');
insert into USER (id, dni, username, password, email, nombre, apellidos, telefono, poblacion, colegiado, cargo, especialidad, genero, nacimiento) values (86, '33306348R', 'shurburt2d', 'SMG6vgI6', 'shurburt2d@sina.com.cn', 'Shelden', 'Hurburt', '4087713186', 'Saint-Maurice-l''Exil', '73884368', 'medico', 'migranas', 'Male', '1983-04-13 15:51:05');
insert into USER (id, dni, username, password, email, nombre, apellidos, telefono, poblacion, colegiado, cargo, especialidad, genero, nacimiento) values (87, '23839964X', 'smaypes2e', 'iZ9hcasy', 'smaypes2e@people.com.cn', 'Stoddard', 'Maypes', '2898471967', 'Muikamachi', '73661550', 'medico', 'migranas', 'Female', '2016-07-21 12:15:25');
insert into USER (id, dni, username, password, email, nombre, apellidos, telefono, poblacion, colegiado, cargo, especialidad, genero, nacimiento) values (88, '64644551n', 'grizzardini2f', 'SyyhPDrh9cJ', 'grizzardini2f@simplemachines.org', 'Garwin', 'Rizzardini', '5087992730', 'Bārah', '60750621', 'medico', 'migranas', 'Male', '1962-10-30 06:19:41');
insert into USER (id, dni, username, password, email, nombre, apellidos, telefono, poblacion, colegiado, cargo, especialidad, genero, nacimiento) values (89, '56213152v', 'etefft2g', 'AOWhWJ', 'etefft2g@mac.com', 'Elena', 'Tefft', '7766258475', 'Porkhov', '34918084', 'medico', 'migranas', 'Female', '1995-02-03 03:23:27');
insert into USER (id, dni, username, password, email, nombre, apellidos, telefono, poblacion, colegiado, cargo, especialidad, genero, nacimiento) values (90, '17719512L', 'bbrymner2h', 'fAyXlyDX7G', 'bbrymner2h@123-reg.co.uk', 'Bail', 'Brymner', '9279599593', 'Peterhof', '71748485', 'medico', 'migranas', 'Male', '1958-11-26 19:17:21');
insert into USER (id, dni, username, password, email, nombre, apellidos, telefono, poblacion, colegiado, cargo, especialidad, genero, nacimiento) values (91, '57994867t', 'ecarleton2i', 'OArday', 'ecarleton2i@xinhuanet.com', 'Elysia', 'Carleton', '6966112740', 'Yeghegnut', '33983061', 'medico', 'migranas', 'Female', '2012-09-16 18:49:51');
insert into USER (id, dni, username, password, email, nombre, apellidos, telefono, poblacion, colegiado, cargo, especialidad, genero, nacimiento) values (92, '34950184s', 'rbradley2j', 'tYBgglKP7FWt', 'rbradley2j@salon.com', 'Rosaline', 'Bradley', '5096242838', 'Xiangyang', '84440975', 'medico', 'migranas', 'Female', '1958-04-06 14:59:41');
insert into USER (id, dni, username, password, email, nombre, apellidos, telefono, poblacion, colegiado, cargo, especialidad, genero, nacimiento) values (93, '87195905N', 'twasiel2k', 'OkpgQ8WHsYN', 'twasiel2k@timesonline.co.uk', 'Tabby', 'Wasiel', '4358298023', 'Kovdor', '03745325', 'medico', 'migranas', 'Female', '1966-10-10 15:29:35');
insert into USER (id, dni, username, password, email, nombre, apellidos, telefono, poblacion, colegiado, cargo, especialidad, genero, nacimiento) values (94, '04302081m', 'bemmanuele2l', '5C9ooiKrx', 'bemmanuele2l@baidu.com', 'Bartholomeo', 'Emmanuele', '4594836584', 'Zabierzów', '40682827', 'medico', 'migranas', 'Male', '1965-03-16 00:18:45');
insert into USER (id, dni, username, password, email, nombre, apellidos, telefono, poblacion, colegiado, cargo, especialidad, genero, nacimiento) values (95, '67159627k', 'jsoftley2m', 'Q4O8iYvC', 'jsoftley2m@ow.ly', 'Jeffry', 'Softley', '6379770461', 'Cerinza', '66957127', 'medico', 'migranas', 'Male', '1987-08-25 19:48:57');
insert into USER (id, dni, username, password, email, nombre, apellidos, telefono, poblacion, colegiado, cargo, especialidad, genero, nacimiento) values (96, '82225248P', 'hbentke2n', 'EgFLKQIt7UB', 'hbentke2n@webmd.com', 'Hughie', 'Bentke', '5312937711', 'Varberg', '35962513', 'medico', 'migranas', 'Male', '2011-08-23 18:30:31');
insert into USER (id, dni, username, password, email, nombre, apellidos, telefono, poblacion, colegiado, cargo, especialidad, genero, nacimiento) values (97, '54004430j', 'kbelfelt2o', 'z7FAq8uXCay', 'kbelfelt2o@deviantart.com', 'Kristien', 'Belfelt', '4398348491', 'Caluire-et-Cuire', '04391939', 'medico', 'migranas', 'Female', '2006-12-27 07:18:58');
insert into USER (id, dni, username, password, email, nombre, apellidos, telefono, poblacion, colegiado, cargo, especialidad, genero, nacimiento) values (98, '92589248j', 'pjuste2p', 'OrRA8SV', 'pjuste2p@dagondesign.com', 'Paloma', 'Juste', '5113640301', 'Montpellier', '78969789', 'medico', 'migranas', 'Female', '1952-05-18 21:05:17');
insert into USER (id, dni, username, password, email, nombre, apellidos, telefono, poblacion, colegiado, cargo, especialidad, genero, nacimiento) values (99, '60605337e', 'ojose2q', 'KtjygyO', 'ojose2q@typepad.com', 'Obadias', 'Jose', '6302047870', 'Longhe', '29068788', 'medico', 'migranas', 'Male', '1977-07-20 10:58:14');
insert into USER (id, dni, username, password, email, nombre, apellidos, telefono, poblacion, colegiado, cargo, especialidad, genero, nacimiento) values (100, '39826254X', 'wmeeking2r', 'yR4flH', 'wmeeking2r@bloglines.com', 'Wade', 'Meeking', '8042245308', 'Saint-Priest', '17548321', 'medico', 'migranas', 'Male', '2006-04-26 02:26:51');


INSERT INTO `cuenta`(`id`, `rol`, `estado`, `user`) VALUES (null, 'administrador', 'autorizada', '1');
insert into CUENTA (id, rol, estado, user) values (2, 'paciente', 'desactivada', 2);
insert into CUENTA (id, rol, estado, user) values (3, 'paciente', 'activada', 3);
insert into CUENTA (id, rol, estado, user) values (4, 'paciente', 'desactivada', 4);
insert into CUENTA (id, rol, estado, user) values (5, 'medico', 'autorizada', 5);
insert into CUENTA (id, rol, estado, user) values (6, 'paciente', 'activada', 6);
insert into CUENTA (id, rol, estado, user) values (7, 'medico', 'autorizada', 7);
insert into CUENTA (id, rol, estado, user) values (8, 'paciente', 'autorizada', 8);
insert into CUENTA (id, rol, estado, user) values (9, 'paciente', 'desactivada', 9);
insert into CUENTA (id, rol, estado, user) values (10, 'medico', 'desactivada', 10);
insert into CUENTA (id, rol, estado, user) values (11, 'paciente', 'activada', 11);
insert into CUENTA (id, rol, estado, user) values (12, 'medico', 'desactivada', 12);
insert into CUENTA (id, rol, estado, user) values (13, 'paciente', 'activada', 13);
insert into CUENTA (id, rol, estado, user) values (14, 'paciente', 'desactivada', 14);
insert into CUENTA (id, rol, estado, user) values (15, 'medico', 'desactivada', 15);
insert into CUENTA (id, rol, estado, user) values (16, 'paciente', 'desactivada', 16);
insert into CUENTA (id, rol, estado, user) values (17, 'paciente', 'autorizada', 17);
insert into CUENTA (id, rol, estado, user) values (18, 'medico', 'autorizada', 18);
insert into CUENTA (id, rol, estado, user) values (19, 'medico', 'autorizada', 19);
insert into CUENTA (id, rol, estado, user) values (20, 'medico', 'desactivada', 20);
insert into CUENTA (id, rol, estado, user) values (21, 'medico', 'desactivada', 21);
insert into CUENTA (id, rol, estado, user) values (22, 'medico', 'autorizada', 22);
insert into CUENTA (id, rol, estado, user) values (23, 'medico', 'desactivada', 23);
insert into CUENTA (id, rol, estado, user) values (24, 'medico', 'activada', 24);
insert into CUENTA (id, rol, estado, user) values (25, 'paciente', 'autorizada', 25);
insert into CUENTA (id, rol, estado, user) values (26, 'medico', 'desactivada', 26);
insert into CUENTA (id, rol, estado, user) values (27, 'medico', 'autorizada', 27);
insert into CUENTA (id, rol, estado, user) values (28, 'medico', 'autorizada', 28);
insert into CUENTA (id, rol, estado, user) values (29, 'paciente', 'desactivada', 29);
insert into CUENTA (id, rol, estado, user) values (30, 'paciente', 'activada', 30);
insert into CUENTA (id, rol, estado, user) values (31, 'paciente', 'activada', 31);
insert into CUENTA (id, rol, estado, user) values (32, 'paciente', 'desactivada', 32);
insert into CUENTA (id, rol, estado, user) values (33, 'medico', 'desactivada', 33);
insert into CUENTA (id, rol, estado, user) values (34, 'medico', 'autorizada', 34);
insert into CUENTA (id, rol, estado, user) values (35, 'medico', 'autorizada', 35);
insert into CUENTA (id, rol, estado, user) values (36, 'paciente', 'activada', 36);
insert into CUENTA (id, rol, estado, user) values (37, 'medico', 'desactivada', 37);
insert into CUENTA (id, rol, estado, user) values (38, 'paciente', 'autorizada', 38);
insert into CUENTA (id, rol, estado, user) values (39, 'medico', 'desactivada', 39);
insert into CUENTA (id, rol, estado, user) values (40, 'medico', 'activada', 40);
insert into CUENTA (id, rol, estado, user) values (41, 'paciente', 'activada', 41);
insert into CUENTA (id, rol, estado, user) values (42, 'paciente', 'activada', 42);
insert into CUENTA (id, rol, estado, user) values (43, 'paciente', 'desactivada', 43);
insert into CUENTA (id, rol, estado, user) values (44, 'paciente', 'activada', 44);
insert into CUENTA (id, rol, estado, user) values (45, 'paciente', 'desactivada', 45);
insert into CUENTA (id, rol, estado, user) values (46, 'paciente', 'autorizada', 46);
insert into CUENTA (id, rol, estado, user) values (47, 'paciente', 'autorizada', 47);
insert into CUENTA (id, rol, estado, user) values (48, 'paciente', 'autorizada', 48);
insert into CUENTA (id, rol, estado, user) values (49, 'medico', 'activada', 49);
insert into CUENTA (id, rol, estado, user) values (50, 'medico', 'autorizada', 50);
insert into CUENTA (id, rol, estado, user) values (51, 'paciente', 'autorizada', 51);
insert into CUENTA (id, rol, estado, user) values (52, 'paciente', 'activada', 52);
insert into CUENTA (id, rol, estado, user) values (53, 'paciente', 'activada', 53);
insert into CUENTA (id, rol, estado, user) values (54, 'medico', 'desactivada', 54);
insert into CUENTA (id, rol, estado, user) values (55, 'medico', 'desactivada', 55);
insert into CUENTA (id, rol, estado, user) values (56, 'medico', 'desactivada', 56);
insert into CUENTA (id, rol, estado, user) values (57, 'medico', 'activada', 57);
insert into CUENTA (id, rol, estado, user) values (58, 'paciente', 'activada', 58);
insert into CUENTA (id, rol, estado, user) values (59, 'paciente', 'activada', 59);
insert into CUENTA (id, rol, estado, user) values (60, 'medico', 'activada', 60);
insert into CUENTA (id, rol, estado, user) values (61, 'medico', 'desactivada', 61);
insert into CUENTA (id, rol, estado, user) values (62, 'paciente', 'desactivada', 62);
insert into CUENTA (id, rol, estado, user) values (63, 'paciente', 'activada', 63);
insert into CUENTA (id, rol, estado, user) values (64, 'paciente', 'activada', 64);
insert into CUENTA (id, rol, estado, user) values (65, 'paciente', 'activada', 65);
insert into CUENTA (id, rol, estado, user) values (66, 'paciente', 'autorizada', 66);
insert into CUENTA (id, rol, estado, user) values (67, 'medico', 'autorizada', 67);
insert into CUENTA (id, rol, estado, user) values (68, 'paciente', 'desactivada', 68);
insert into CUENTA (id, rol, estado, user) values (69, 'medico', 'autorizada', 69);
insert into CUENTA (id, rol, estado, user) values (70, 'medico', 'activada', 70);
insert into CUENTA (id, rol, estado, user) values (71, 'paciente', 'autorizada', 71);
insert into CUENTA (id, rol, estado, user) values (72, 'paciente', 'activada', 72);
insert into CUENTA (id, rol, estado, user) values (73, 'paciente', 'activada', 73);
insert into CUENTA (id, rol, estado, user) values (74, 'paciente', 'autorizada', 74);
insert into CUENTA (id, rol, estado, user) values (75, 'paciente', 'autorizada', 75);
insert into CUENTA (id, rol, estado, user) values (76, 'paciente', 'desactivada', 76);
insert into CUENTA (id, rol, estado, user) values (77, 'medico', 'desactivada', 77);
insert into CUENTA (id, rol, estado, user) values (78, 'medico', 'autorizada', 78);
insert into CUENTA (id, rol, estado, user) values (79, 'paciente', 'desactivada', 79);
insert into CUENTA (id, rol, estado, user) values (80, 'paciente', 'desactivada', 80);
insert into CUENTA (id, rol, estado, user) values (81, 'medico', 'desactivada', 81);
insert into CUENTA (id, rol, estado, user) values (82, 'paciente', 'activada', 82);
insert into CUENTA (id, rol, estado, user) values (83, 'medico', 'desactivada', 83);
insert into CUENTA (id, rol, estado, user) values (84, 'paciente', 'desactivada', 84);
insert into CUENTA (id, rol, estado, user) values (85, 'medico', 'autorizada', 85);
insert into CUENTA (id, rol, estado, user) values (86, 'paciente', 'autorizada', 86);
insert into CUENTA (id, rol, estado, user) values (87, 'paciente', 'activada', 87);
insert into CUENTA (id, rol, estado, user) values (88, 'paciente', 'desactivada', 88);
insert into CUENTA (id, rol, estado, user) values (89, 'medico', 'autorizada', 89);
insert into CUENTA (id, rol, estado, user) values (90, 'paciente', 'activada', 90);
insert into CUENTA (id, rol, estado, user) values (91, 'medico', 'desactivada', 91);
insert into CUENTA (id, rol, estado, user) values (92, 'medico', 'autorizada', 92);
insert into CUENTA (id, rol, estado, user) values (93, 'medico', 'activada', 93);
insert into CUENTA (id, rol, estado, user) values (94, 'medico', 'activada', 94);
insert into CUENTA (id, rol, estado, user) values (95, 'medico', 'desactivada', 95);
insert into CUENTA (id, rol, estado, user) values (96, 'paciente', 'desactivada', 96);
insert into CUENTA (id, rol, estado, user) values (97, 'paciente', 'desactivada', 97);
insert into CUENTA (id, rol, estado, user) values (98, 'paciente', 'autorizada', 98);
insert into CUENTA (id, rol, estado, user) values (99, 'medico', 'desactivada', 99);
insert into CUENTA (id, rol, estado, user) values (100, 'medico', 'autorizada', 100);




INSERT INTO `ficha`(`id`, `fechaCreacion`, `paciente`, `medico`) VALUES (null,'1000-01-01 00:00:00',2,5);

INSERT INTO `consulta`(`id`, `lugar`, `motivo`, `fecha`, `diagnostico`, `observaciones`, `medico`, `paciente`, `ficha`, `estado`) VALUES (null,'ourense','el paciente se encontraba mal','2020-02-24 09:00:00',null, null,5,2, 1, 'realizada');
INSERT INTO `consulta`(`id`, `lugar`, `motivo`, `fecha`, `diagnostico`, `observaciones`, `medico`, `paciente`, `ficha`, `estado`) VALUES (null,'ourense','el paciente se encontraba mal','1000-01-01',null, null,5,2, 1, 'cancelada');
INSERT INTO `consulta`(`id`, `lugar`, `motivo`, `fecha`, `diagnostico`, `observaciones`, `medico`, `paciente`, `ficha`, `estado`) VALUES (null,'ourense','el paciente se encontraba mal','1000-01-01',null, null,5,2, 1, 'realizada');
INSERT INTO `consulta`(`id`, `lugar`, `motivo`, `fecha`, `diagnostico`, `observaciones`, `medico`, `paciente`, `ficha`, `estado`) VALUES (null,'ourense','el paciente se encontraba mal','1000-01-01',null, null,5,2, 1, 'en tiempo');
INSERT INTO `consulta`(`id`, `lugar`, `motivo`, `fecha`, `diagnostico`, `observaciones`, `medico`, `paciente`, `ficha`, `estado`) VALUES (null,'ourense','el paciente se encontraba mal','1000-01-01',null, null,5,2, 1, 'aplazada');
INSERT INTO `consulta`(`id`, `lugar`, `motivo`, `fecha`, `diagnostico`, `observaciones`, `medico`, `paciente`, `ficha`, `estado`) VALUES (null,'ourense','el paciente se encontraba mal','1000-01-01 14:00:00',null, null,5,2, 1, 'aplazada');
INSERT INTO `consulta`(`id`, `lugar`, `motivo`, `fecha`, `diagnostico`, `observaciones`, `medico`, `paciente`, `ficha`, `estado`) VALUES (null,'ourense','el paciente se encontraba mal','1000-01-01',null, null,5,2, 1, 'realizada');
INSERT INTO `consulta`(`id`, `lugar`, `motivo`, `fecha`, `diagnostico`, `observaciones`, `medico`, `paciente`, `ficha`, `estado`) VALUES (null,'ourense','el paciente se encontraba mal','1000-01-01',null, null,5,2, 1, 'aplazada');
INSERT INTO `consulta`(`id`, `lugar`, `motivo`, `fecha`, `diagnostico`, `observaciones`, `medico`, `paciente`, `ficha`, `estado`) VALUES (null,'ourense','el paciente se encontraba mal','1000-01-01',null, null,5,2, 1, 'realizada');
INSERT INTO `consulta`(`id`, `lugar`, `motivo`, `fecha`, `diagnostico`, `observaciones`, `medico`, `paciente`, `ficha`, `estado`) VALUES (null,'ourense','el paciente se encontraba mal','1000-01-01',null, null,5,2, 1, 'en tiempo');
INSERT INTO `consulta`(`id`, `lugar`, `motivo`, `fecha`, `diagnostico`, `observaciones`, `medico`, `paciente`, `ficha`, `estado`) VALUES (null,'ourense','el paciente se encontraba mal','1000-01-01',null, null,5,2, 1, 'realizada');
INSERT INTO `consulta`(`id`, `lugar`, `motivo`, `fecha`, `diagnostico`, `observaciones`, `medico`, `paciente`, `ficha`, `estado`) VALUES (null,'ourense','el paciente se encontraba mal','1000-01-01',null, null,5,2, 1, 'cancelada');
INSERT INTO `consulta`(`id`, `lugar`, `motivo`, `fecha`, `diagnostico`, `observaciones`, `medico`, `paciente`, `ficha`, `estado`) VALUES (null,'ourense','el paciente se encontraba mal','1000-01-01',null, null,5,2, 1, 'en tiempo');
INSERT INTO `consulta`(`id`, `lugar`, `motivo`, `fecha`, `diagnostico`, `observaciones`, `medico`, `paciente`, `ficha`, `estado`) VALUES (null,'ourense','el paciente se encontraba mal','1000-01-01',null, null,5,2, 1, 'realizada');
INSERT INTO `consulta`(`id`, `lugar`, `motivo`, `fecha`, `diagnostico`, `observaciones`, `medico`, `paciente`, `ficha`, `estado`) VALUES (null,'ourense','el paciente se encontraba mal','1000-01-01',null, null,5,2, 1, 'cancelada');
INSERT INTO `consulta`(`id`, `lugar`, `motivo`, `fecha`, `diagnostico`, `observaciones`, `medico`, `paciente`, `ficha`, `estado`) VALUES (null,'ourense','el paciente se encontraba mal','1000-01-01',null, null,5,2, 1, 'aplazada');

INSERT INTO `enfermedad`(`nombre`) VALUES ('diabetes');
INSERT INTO `enfermedad`(`nombre`) VALUES ('asma');
INSERT INTO `enfermedad`(`nombre`) VALUES ('migranas');

insert into FICHA (id, fechaCreacion, paciente, medico) values (null, '2019-03-20 15:53:33', 51, 5);
insert into FICHA (id, fechaCreacion, paciente, medico) values (null, '2019-03-20 15:53:33', 3, 5);
insert into FICHA (id, fechaCreacion, paciente, medico) values (null, '2019-07-23 09:59:16', 4, 5);
insert into FICHA (id, fechaCreacion, paciente, medico) values (null, '2019-04-15 16:04:06', 6, 15);
insert into FICHA (id, fechaCreacion, paciente, medico) values (null, '2019-05-01 03:21:29', 8, 18);
insert into FICHA (id, fechaCreacion, paciente, medico) values (null, '2019-08-23 09:34:45', 9, 19);
insert into FICHA (id, fechaCreacion, paciente, medico) values (null, '2019-07-24 09:57:58', 11, 20);
insert into FICHA (id, fechaCreacion, paciente, medico) values (null, '2020-02-11 10:55:13', 13, 21);
insert into FICHA (id, fechaCreacion, paciente, medico) values (null, '2019-04-29 13:52:35', 14, 22);
insert into FICHA (id, fechaCreacion, paciente, medico) values (null, '2019-08-15 19:57:46', 16, 5);
insert into FICHA (id, fechaCreacion, paciente, medico) values (null, '2020-01-05 07:02:21', 17, 24);
insert into FICHA (id, fechaCreacion, paciente, medico) values (null, '2019-11-22 03:02:24', 25, 26);
insert into FICHA (id, fechaCreacion, paciente, medico) values (null, '2019-05-23 08:25:59', 29, 5);
insert into FICHA (id, fechaCreacion, paciente, medico) values (null, '2019-09-04 22:09:05', 30, 28);
insert into FICHA (id, fechaCreacion, paciente, medico) values (null, '2019-11-10 01:26:20', 31, 33);
insert into FICHA (id, fechaCreacion, paciente, medico) values (null, '2019-08-28 12:17:28', 32, 34);
insert into FICHA (id, fechaCreacion, paciente, medico) values (null, '2019-03-28 22:53:26', 36, 35);
insert into FICHA (id, fechaCreacion, paciente, medico) values (null, '2019-08-31 09:45:44', 38, 5);
insert into FICHA (id, fechaCreacion, paciente, medico) values (null, '2019-12-05 17:06:34', 41, 37);
insert into FICHA (id, fechaCreacion, paciente, medico) values (null, '2019-09-23 02:57:12', 42, 37);
insert into FICHA (id, fechaCreacion, paciente, medico) values (null, '2019-04-16 17:34:24', 43, 37);
insert into FICHA (id, fechaCreacion, paciente, medico) values (null, '2019-06-15 02:46:09', 44, 37);


insert into FICHA_ENFERMEDAD (ficha, enfermedad) values (1, 'migranas');
insert into FICHA_ENFERMEDAD (ficha, enfermedad) values (2, 'migranas');
insert into FICHA_ENFERMEDAD (ficha, enfermedad) values (3, 'diabetes');
insert into FICHA_ENFERMEDAD (ficha, enfermedad) values (4, 'migranas');
insert into FICHA_ENFERMEDAD (ficha, enfermedad) values (5, 'asma');
insert into FICHA_ENFERMEDAD (ficha, enfermedad) values (6, 'diabetes');
insert into FICHA_ENFERMEDAD (ficha, enfermedad) values (7, 'asma');
insert into FICHA_ENFERMEDAD (ficha, enfermedad) values (8, 'asma');
insert into FICHA_ENFERMEDAD (ficha, enfermedad) values (9, 'diabetes');
insert into FICHA_ENFERMEDAD (ficha, enfermedad) values (10, 'diabetes');
insert into FICHA_ENFERMEDAD (ficha, enfermedad) values (11, 'diabetes');
insert into FICHA_ENFERMEDAD (ficha, enfermedad) values (12, 'diabetes');
insert into FICHA_ENFERMEDAD (ficha, enfermedad) values (13, 'diabetes');
insert into FICHA_ENFERMEDAD (ficha, enfermedad) values (14, 'migranas');
insert into FICHA_ENFERMEDAD (ficha, enfermedad) values (15, 'asma');
insert into FICHA_ENFERMEDAD (ficha, enfermedad) values (16, 'migranas');
insert into FICHA_ENFERMEDAD (ficha, enfermedad) values (17, 'migranas');
insert into FICHA_ENFERMEDAD (ficha, enfermedad) values (18, 'asma');
insert into FICHA_ENFERMEDAD (ficha, enfermedad) values (19, 'asma');
insert into FICHA_ENFERMEDAD (ficha, enfermedad) values (20, 'migranas');
insert into FICHA_ENFERMEDAD (ficha, enfermedad) values (21, 'asma');
insert into FICHA_ENFERMEDAD (ficha, enfermedad) values (22, 'diabetes');
insert into FICHA_ENFERMEDAD (ficha, enfermedad) values (23, 'diabetes');
insert into FICHA_ENFERMEDAD (ficha, enfermedad) values (1, 'diabetes');
insert into FICHA_ENFERMEDAD (ficha, enfermedad) values (1, 'asma');

insert into marca (nombre, pais) values ('Cardene', 'Lesotho');
insert into marca (nombre, pais) values ('Potassium Chloride in Dextrose and Sodium Chloride', 'Poland');
insert into marca (nombre, pais) values ('Citroma', 'Indonesia');
insert into marca (nombre, pais) values ('Sensodyne', 'Moldova');
insert into marca (nombre, pais) values ('Clean N Fresh Instant Hand Sanitizer', 'South Korea');
insert into marca (nombre, pais) values ('PHENYTOIN SODIUM', 'China');
insert into marca (nombre, pais) values ('ACD Blood-Pack Units (PL 146 Plastic)', 'Brazil');
insert into marca (nombre, pais) values ('NEOSPORIN', 'Russia');
insert into marca (nombre, pais) values ('AMILORIDE HYDROCHLORIDE', 'United Arab Emirates');
insert into marca (nombre, pais) values ('YES to coconut', 'Indonesia');


insert into medicamento (nombre, viaAdministracion, marca, dosis) values ('Naphazoline Hydrochloride and Hypromellose', 'otro', 'Sensodyne', 470);
insert into medicamento (nombre, viaAdministracion, marca, dosis) values ('Adenosine 0.04%', 'parental', 'ACD Blood-Pack Units (PL 146 Plastic)', 217);
insert into medicamento (nombre, viaAdministracion, marca, dosis) values ('methylprednisolone acetate', 'intraarterial', 'ACD Blood-Pack Units (PL 146 Plastic)', 390);
insert into medicamento (nombre, viaAdministracion, marca, dosis) values ('Eucalyptol, menthol, methyl salicylate, thymol', 'subcutanea', 'Citroma', 14);
insert into medicamento (nombre, viaAdministracion, marca, dosis) values ('Iodine Bush', 'intraarterial', 'NEOSPORIN', 10);
insert into medicamento (nombre, viaAdministracion, marca, dosis) values ('Pecan Pollen', 'intravenosa', 'Sensodyne', 584);
insert into medicamento (nombre, viaAdministracion, marca, dosis) values ('Benzocaine', 'subcutanea', 'Sensodyne', 530);
insert into medicamento (nombre, viaAdministracion, marca, dosis) values ('German Cockroach', 'intravenosa', 'PHENYTOIN SODIUM', 386);
insert into medicamento (nombre, viaAdministracion, marca, dosis) values ('chlorpheniramine maleate, dextromethorphan hyrdrobromide', 'otro', 'NEOSPORIN', 505);
insert into medicamento (nombre, viaAdministracion, marca, dosis) values ('Acetaminophen, Dextromethorphan HBr, Doxylamine succinate', 'parental', 'Citroma', 390);
insert into medicamento (nombre, viaAdministracion, marca, dosis) values ('ALUMINUM ZIRCONIUM OCTACHLOROHYDREX GLY', 'otro', 'Sensodyne', 363);
insert into medicamento (nombre, viaAdministracion, marca, dosis) values ('Zafirlukast', 'oral', 'Citroma', 544);
insert into medicamento (nombre, viaAdministracion, marca, dosis) values ('Oxygen', 'subcutanea', 'Sensodyne', 582);
insert into medicamento (nombre, viaAdministracion, marca, dosis) values ('temazepam', 'intravenosa', 'Sensodyne', 406);
insert into medicamento (nombre, viaAdministracion, marca, dosis) values ('sennosides', 'subcutanea', 'Cardene', 157);
insert into medicamento (nombre, viaAdministracion, marca, dosis) values ('Ethambutol Hydrochloride', 'intravenosa', 'NEOSPORIN', 511);
insert into medicamento (nombre, viaAdministracion, marca, dosis) values ('Lidocaine Hydrochloride', 'intraarterial', 'ACD Blood-Pack Units (PL 146 Plastic)', 518);
insert into medicamento (nombre, viaAdministracion, marca, dosis) values ('acetic acid', 'subcutanea', 'YES to coconut', 245);
insert into medicamento (nombre, viaAdministracion, marca, dosis) values ('Glyburide and Metformin', 'otro', 'YES to coconut', 578);
insert into medicamento (nombre, viaAdministracion, marca, dosis) values ('OCTINOXATE, TITANIUM DIOXIDE', 'otro', 'YES to coconut', 37);
insert into medicamento (nombre, viaAdministracion, marca, dosis) values ('CIMETIDINE', 'intramuscular', 'PHENYTOIN SODIUM', 382);
insert into medicamento (nombre, viaAdministracion, marca, dosis) values ('ETHYL ALCOHOL', 'parental', 'AMILORIDE HYDROCHLORIDE', 95);
insert into medicamento (nombre, viaAdministracion, marca, dosis) values ('benztropine mesylate', 'intraarterial', 'Cardene', 404);
insert into medicamento (nombre, viaAdministracion, marca, dosis) values ('Octinoxate', 'subcutanea', 'ACD Blood-Pack Units (PL 146 Plastic)', 553);
insert into medicamento (nombre, viaAdministracion, marca, dosis) values ('PETROLATUM', 'otro', 'AMILORIDE HYDROCHLORIDE', 52);
insert into medicamento (nombre, viaAdministracion, marca, dosis) values ('Losartan potassium', 'parental', 'YES to coconut', 172);
insert into medicamento (nombre, viaAdministracion, marca, dosis) values ('ETHYLHEXYL METHOXYCINNAMATE', 'sublingual', 'PHENYTOIN SODIUM', 428);
insert into medicamento (nombre, viaAdministracion, marca, dosis) values ('Clopidogrel Bisulfate', 'intraarterial', 'PHENYTOIN SODIUM', 382);
insert into medicamento (nombre, viaAdministracion, marca, dosis) values ('Aluminum Zirconium Tetrachlorohydrex GLY', 'intramuscular', 'AMILORIDE HYDROCHLORIDE', 227);

