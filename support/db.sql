SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

CREATE SCHEMA IF NOT EXISTS `tfscdb` ;
USE `tfscdb` ;

-- -----------------------------------------------------
-- Table `tfscdb`.`Event`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `tfscdb`.`Event` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(50) NOT NULL ,
  `date` DATE NOT NULL ,
  `location` VARCHAR(50) NOT NULL ,
  `event_type` VARCHAR(50) NOT NULL ,
  `description` VARCHAR(500) NOT NULL ,
  `start_time` TIME NOT NULL ,
  `end_time` TIME NOT NULL ,
  `contact_name` VARCHAR(50) NULL ,
  `contact_email` VARCHAR(50) NULL ,
  `contact_phone` VARCHAR(50) NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `tfscdb`.`Question`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `tfscdb`.`Question` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `description` VARCHAR(250) NOT NULL ,
  `event_type` VARCHAR(50) NOT NULL ,
  `question_flag` CHAR(1) NOT NULL ,
  `order` INT NOT NULL ,
  `group` VARCHAR(50) NULL ,
  `number_of_choices` INT NULL ,
  `group_description` VARCHAR(500) NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `tfscdb`.`session`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `tfscdb`.`session` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `event_id` INT NOT NULL ,
  `title` VARCHAR(500) NOT NULL ,
  `group_name` VARCHAR(500) NULL ,
  `order` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_Session_Event1` (`event_id` ASC) ,
  CONSTRAINT `fk_Session_Event1`
    FOREIGN KEY (`event_id` )
    REFERENCES `tfscdb`.`Event` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `tfscdb`.`Evaluation`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `tfscdb`.`Evaluation` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `question_id` INT NOT NULL ,
  `event_id` INT NOT NULL ,
  `session_id` INT NULL ,
  `user_rating` INT NULL ,
  `user_comment` VARCHAR(1000) NULL ,
  INDEX `fk_Evaluation_Question_Event` (`event_id` ASC) ,
  INDEX `fk_Evaluation_Question_Question1` (`question_id` ASC) ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_Evaluation_Session1` (`session_id` ASC) ,
  CONSTRAINT `fk_Evaluation_Question_Event`
    FOREIGN KEY (`event_id` )
    REFERENCES `tfscdb`.`Event` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Evaluation_Question_Question1`
    FOREIGN KEY (`question_id` )
    REFERENCES `tfscdb`.`Question` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Evaluation_Session1`
    FOREIGN KEY (`session_id` )
    REFERENCES `tfscdb`.`session` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `tfscdb`.`Participant`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `tfscdb`.`Participant` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `first_name` VARCHAR(50) NOT NULL ,
  `last_name` VARCHAR(50) NOT NULL ,
  `email` VARCHAR(50) NOT NULL ,
  `department` VARCHAR(50) NOT NULL ,
  `meal_choice` VARCHAR(50) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `tfscdb`.`speaker`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `tfscdb`.`speaker` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `first_name` VARCHAR(50) NOT NULL ,
  `last_name` VARCHAR(50) NOT NULL ,
  `prefix` VARCHAR(50) NULL ,
  `title` VARCHAR(50) NULL ,
  `department` VARCHAR(50) NULL ,
  `organization` VARCHAR(50) NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `tfscdb`.`Event_Participant`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `tfscdb`.`Event_Participant` (
  `participant_id` INT NOT NULL ,
  `event_id` INT NOT NULL ,
  `show_flag` CHAR(1) NULL ,
  PRIMARY KEY (`participant_id`, `event_id`) ,
  INDEX `fk_Event_Participant_Event1` (`event_id` ASC) ,
  INDEX `fk_Event_Participant_Participant1` (`participant_id` ASC) ,
  CONSTRAINT `fk_Event_Participant_Event1`
    FOREIGN KEY (`event_id` )
    REFERENCES `tfscdb`.`Event` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Event_Participant_Participant1`
    FOREIGN KEY (`participant_id` )
    REFERENCES `tfscdb`.`Participant` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `tfscdb`.`session_speaker`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `tfscdb`.`session_speaker` (
  `speaker_id` INT NOT NULL ,
  `session_id` INT NOT NULL ,
  PRIMARY KEY (`speaker_id`, `session_id`) ,
  INDEX `fk_Session_Speaker_Session1` (`session_id` ASC) ,
  INDEX `fk_Session_Speaker_Speaker1` (`speaker_id` ASC) ,
  CONSTRAINT `fk_Session_Speaker_Session1`
    FOREIGN KEY (`session_id` )
    REFERENCES `tfscdb`.`session` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Session_Speaker_Speaker1`
    FOREIGN KEY (`speaker_id` )
    REFERENCES `tfscdb`.`speaker` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `tfscdb`.`Acc_Chart`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `tfscdb`.`Acc_Chart` (
  `Description` VARCHAR(250) NOT NULL ,
  `Excellent` INT NOT NULL ,
  `Good` INT NOT NULL ,
  `Fair` INT NOT NULL ,
  `Poor` INT NOT NULL )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `tfscdb`.`Acc_Table`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `tfscdb`.`Acc_Table` (
  `Description` VARCHAR(250) NOT NULL ,
  `Excellent` INT NOT NULL ,
  `Good` INT NOT NULL ,
  `Fair` INT NOT NULL ,
  `Poor` INT NOT NULL )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `tfscdb`.`pro_chart_length`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `tfscdb`.`pro_chart_length` (
  `description` VARCHAR(250) NOT NULL ,
  `too_long` INT NOT NULL ,
  `too_short` INT NOT NULL ,
  `about_right` INT NOT NULL )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `tfscdb`.`pro_chart_info`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `tfscdb`.`pro_chart_info` (
  `description` VARCHAR(250) NOT NULL ,
  `yes` INT NOT NULL ,
  `no` INT NOT NULL )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `tfscdb`.`pro_chart_reco`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `tfscdb`.`pro_chart_reco` (
  `description` VARCHAR(250) NOT NULL ,
  `yes` INT NOT NULL ,
  `no` INT NOT NULL )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `tfscdb`.`pro_chart_sched`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `tfscdb`.`pro_chart_sched` (
  `description` VARCHAR(250) NOT NULL ,
  `too_much` INT NOT NULL ,
  `too_little` INT NOT NULL ,
  `about_right` INT NOT NULL )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `tfscdb`.`pro_percent_length`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `tfscdb`.`pro_percent_length` (
  `description` VARCHAR(250) NOT NULL ,
  `too_long` INT NOT NULL ,
  `too_short` INT NOT NULL ,
  `about_right` INT NOT NULL )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `tfscdb`.`pro_percent_info`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `tfscdb`.`pro_percent_info` (
  `description` VARCHAR(250) NOT NULL ,
  `yes` INT NOT NULL ,
  `no` INT NOT NULL )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `tfscdb`.`pro_percent_sched`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `tfscdb`.`pro_percent_sched` (
  `description` VARCHAR(250) NOT NULL ,
  `too_much` INT NOT NULL ,
  `too_little` INT NOT NULL ,
  `about_right` INT NOT NULL )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `tfscdb`.`pro_percent_reco`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `tfscdb`.`pro_percent_reco` (
  `description` VARCHAR(250) NOT NULL ,
  `yes` INT NOT NULL ,
  `no` INT NOT NULL )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `tfscdb`.`ses_chart_req`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `tfscdb`.`ses_chart_req` (
  `title` VARCHAR(500) NOT NULL ,
  `five` INT NOT NULL ,
  `four` INT NOT NULL ,
  `three` INT NOT NULL ,
  `two` INT NOT NULL ,
  `one` INT NULL )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `tfscdb`.`ses_chart_opt`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `tfscdb`.`ses_chart_opt` (
  `title` VARCHAR(500) NOT NULL ,
  `five` INT NOT NULL ,
  `four` INT NOT NULL ,
  `three` INT NOT NULL ,
  `two` INT NOT NULL ,
  `one` INT NULL )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `tfscdb`.`presentation_chart`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `tfscdb`.`presentation_chart` (
  `title` VARCHAR(500) NOT NULL ,
  `five` INT NOT NULL ,
  `four` INT NOT NULL ,
  `three` INT NOT NULL ,
  `two` INT NOT NULL ,
  `one` INT NOT NULL )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `tfscdb`.`yesno_chart`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `tfscdb`.`yesno_chart` (
  `title` VARCHAR(250) NOT NULL ,
  `yes` INT NOT NULL ,
  `no` INT NOT NULL )
ENGINE = InnoDB;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
