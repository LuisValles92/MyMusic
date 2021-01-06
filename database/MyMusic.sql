SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

CREATE SCHEMA IF NOT EXISTS `MyMusic` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `MyMusic` ;

-- -----------------------------------------------------
-- Table `MyMusic`.`Usuario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `MyMusic`.`Usuario` (
  `uuid_usuario` VARCHAR(36) NOT NULL,
  `correo_usuario` VARCHAR(320) NOT NULL,
  `nick_usuario` VARCHAR(45) NOT NULL,
  `nombre_usuario` VARCHAR(45) NOT NULL,
  `password_usuario` VARCHAR(45) NOT NULL,
  `pais_usuario` VARCHAR(45) NOT NULL,
  `fecha_alta_usuario` DATETIME NOT NULL,
  `imagen_usuario` VARCHAR(255) NOT NULL,
  `saldo_usuario` FLOAT NOT NULL,
  PRIMARY KEY (`uuid_usuario`),
  UNIQUE INDEX `correo_usuario_UNIQUE` (`correo_usuario` ASC),
  UNIQUE INDEX `nick_usuario_UNIQUE` (`nick_usuario` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `MyMusic`.`Artista`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `MyMusic`.`Artista` (
  `uuid_artista` VARCHAR(36) NOT NULL,
  `correo_artista` VARCHAR(320) NOT NULL,
  `nombre_artistico_artista` VARCHAR(45) NOT NULL,
  `nombre_artista` VARCHAR(45) NOT NULL,
  `password_artista` VARCHAR(45) NOT NULL,
  `pais_artista` VARCHAR(45) NOT NULL,
  `bio_artista` VARCHAR(600) NOT NULL,
  `fecha_alta_artista` DATETIME NOT NULL,
  `imagen_artista` VARCHAR(255) NOT NULL,
  `saldo_artista` FLOAT NOT NULL,
  `estado_artista` TINYINT(1) NOT NULL,
  PRIMARY KEY (`uuid_artista`),
  UNIQUE INDEX `correo_artista_UNIQUE` (`correo_artista` ASC),
  UNIQUE INDEX `nombre_artistico_artista_UNIQUE` (`nombre_artistico_artista` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `MyMusic`.`Tema`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `MyMusic`.`Tema` (
  `uuid_tema` VARCHAR(36) NOT NULL,
  `uuid_artista_tema` VARCHAR(36) NOT NULL,
  `nombre_tema` VARCHAR(45) NOT NULL,
  `completo_tema` VARCHAR(255) NOT NULL,
  `teaser_tema` VARCHAR(255) NOT NULL,
  `categoria_tema` VARCHAR(45) NOT NULL,
  `numero_descargas_tema` INT NOT NULL,
  `nota_tema` VARCHAR(600) NOT NULL,
  `fecha_lanzamiento_tema` DATETIME NOT NULL,
  `imagen_tema` VARCHAR(255) NOT NULL,
  `precio_tema` FLOAT NOT NULL,
  `estado_tema` TINYINT(1) NOT NULL,
  PRIMARY KEY (`uuid_tema`),
  INDEX `uuid_artista_tema_idx` (`uuid_artista_tema` ASC),
  CONSTRAINT `uuid_artista_tema`
    FOREIGN KEY (`uuid_artista_tema`)
    REFERENCES `MyMusic`.`Artista` (`uuid_artista`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `MyMusic`.`Licencia`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `MyMusic`.`Licencia` (
  `uuid_licencia` VARCHAR(36) NOT NULL,
  `uuid_tema_licencia` VARCHAR(36) NOT NULL,
  `uuid_usuario_licencia` VARCHAR(36) NOT NULL,
  `fecha_licencia` DATETIME NOT NULL,
  `precio_licencia` FLOAT NOT NULL,
  PRIMARY KEY (`uuid_licencia`),
  INDEX `uuid_tema_licencia_idx` (`uuid_tema_licencia` ASC),
  INDEX `uuid_usuario_licencia_idx` (`uuid_usuario_licencia` ASC),
  CONSTRAINT `uuid_tema_licencia`
    FOREIGN KEY (`uuid_tema_licencia`)
    REFERENCES `MyMusic`.`Tema` (`uuid_tema`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `uuid_usuario_licencia`
    FOREIGN KEY (`uuid_usuario_licencia`)
    REFERENCES `MyMusic`.`Usuario` (`uuid_usuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
