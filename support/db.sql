set @old_unique_checks=@@unique_checks, unique_checks=0;
set @old_foreign_key_checks=@@foreign_key_checks, foreign_key_checks=0;
set @old_sql_mode=@@sql_mode, sql_mode='traditional';

create schema if not exists `tfsc` ;
use `tfsc` ;

-- -----------------------------------------------------
-- table `tfsc`.`event`
-- -----------------------------------------------------
create  table if not exists `tfsc`.`event` (
  `id` int not null auto_increment ,
  `name` varchar(50) not null ,
  `date` date not null ,
  `location` varchar(50) not null ,
  `event_type` varchar(50) not null ,
  `description` varchar(500) not null ,
  `start_time` time not null ,
  `end_time` time not null ,
  `contact_name` varchar(50) null ,
  `contact_email` varchar(50) null ,
  `contact_phone` varchar(50) null ,
  primary key (`id`) )
engine = innodb;


-- -----------------------------------------------------
-- table `tfsc`.`question`
-- -----------------------------------------------------
create  table if not exists `tfsc`.`question` (
  `id` int not null auto_increment ,
  `description` varchar(250) not null ,
  `event_type` varchar(50) not null ,
  `question_flag` char(1) not null ,
  `order` int not null ,
  `group` varchar(50) null ,
  `number_of_choices` int null ,
  `group_description` varchar(500) null ,
  primary key (`id`) )
engine = innodb;


-- -----------------------------------------------------
-- table `tfsc`.`session`
-- -----------------------------------------------------
create  table if not exists `tfsc`.`session` (
  `id` int not null auto_increment ,
  `event_id` int not null ,
  `title` varchar(500) not null ,
  `group_name` varchar(500) null ,
  `order` int not null ,
  primary key (`id`) ,
  index `fk_session_event1` (`event_id` asc) ,
  constraint `fk_session_event1`
    foreign key (`event_id` )
    references `tfsc`.`event` (`id` )
    on delete no action
    on update no action)
engine = innodb;


-- -----------------------------------------------------
-- table `tfsc`.`evaluation`
-- -----------------------------------------------------
create  table if not exists `tfsc`.`evaluation` (
  `id` int not null auto_increment ,
  `question_id` int not null ,
  `event_id` int not null ,
  `session_id` int null ,
  `user_rating` int null ,
  `user_comment` varchar(1000) null ,
  index `fk_evaluation_question_event` (`event_id` asc) ,
  index `fk_evaluation_question_question1` (`question_id` asc) ,
  primary key (`id`) ,
  index `fk_evaluation_session1` (`session_id` asc) ,
  constraint `fk_evaluation_question_event`
    foreign key (`event_id` )
    references `tfsc`.`event` (`id` )
    on delete no action
    on update no action,
  constraint `fk_evaluation_question_question1`
    foreign key (`question_id` )
    references `tfsc`.`question` (`id` )
    on delete no action
    on update no action,
  constraint `fk_evaluation_session1`
    foreign key (`session_id` )
    references `tfsc`.`session` (`id` )
    on delete no action
    on update no action)
engine = innodb;


-- -----------------------------------------------------
-- table `tfsc`.`participant`
-- -----------------------------------------------------
create  table if not exists `tfsc`.`participant` (
  `id` int not null auto_increment ,
  `first_name` varchar(50) not null ,
  `last_name` varchar(50) not null ,
  `email` varchar(50) not null ,
  `department` varchar(50) not null ,
  `meal_choice` varchar(50) not null ,
  primary key (`id`) )
engine = innodb;


-- -----------------------------------------------------
-- table `tfsc`.`speaker`
-- -----------------------------------------------------
create  table if not exists `tfsc`.`speaker` (
  `id` int not null auto_increment ,
  `first_name` varchar(50) not null ,
  `last_name` varchar(50) not null ,
  `prefix` varchar(50) null ,
  `title` varchar(50) null ,
  `department` varchar(50) null ,
  `organization` varchar(50) null ,
  primary key (`id`) )
engine = innodb;


-- -----------------------------------------------------
-- table `tfsc`.`event_participant`
-- -----------------------------------------------------
create  table if not exists `tfsc`.`event_participant` (
  `participant_id` int not null ,
  `event_id` int not null ,
  `show_flag` char(1) null ,
  primary key (`participant_id`, `event_id`) ,
  index `fk_event_participant_event1` (`event_id` asc) ,
  index `fk_event_participant_participant1` (`participant_id` asc) ,
  constraint `fk_event_participant_event1`
    foreign key (`event_id` )
    references `tfsc`.`event` (`id` )
    on delete no action
    on update no action,
  constraint `fk_event_participant_participant1`
    foreign key (`participant_id` )
    references `tfsc`.`participant` (`id` )
    on delete no action
    on update no action)
engine = innodb;


-- -----------------------------------------------------
-- table `tfsc`.`session_speaker`
-- -----------------------------------------------------
create  table if not exists `tfsc`.`session_speaker` (
  `speaker_id` int not null ,
  `session_id` int not null ,
  primary key (`speaker_id`, `session_id`) ,
  index `fk_session_speaker_session1` (`session_id` asc) ,
  index `fk_session_speaker_speaker1` (`speaker_id` asc) ,
  constraint `fk_session_speaker_session1`
    foreign key (`session_id` )
    references `tfsc`.`session` (`id` )
    on delete no action
    on update no action,
  constraint `fk_session_speaker_speaker1`
    foreign key (`speaker_id` )
    references `tfsc`.`speaker` (`id` )
    on delete no action
    on update no action)
engine = innodb;


-- -----------------------------------------------------
-- table `tfsc`.`acc_chart`
-- -----------------------------------------------------
create  table if not exists `tfsc`.`acc_chart` (
  `description` varchar(250) not null ,
  `excellent` int not null ,
  `good` int not null ,
  `fair` int not null ,
  `poor` int not null )
engine = innodb;


-- -----------------------------------------------------
-- table `tfsc`.`acc_table`
-- -----------------------------------------------------
create  table if not exists `tfsc`.`acc_table` (
  `description` varchar(250) not null ,
  `excellent` int not null ,
  `good` int not null ,
  `fair` int not null ,
  `poor` int not null )
engine = innodb;



set sql_mode=@old_sql_mode;
set foreign_key_checks=@old_foreign_key_checks;
set unique_checks=@old_unique_checks;
