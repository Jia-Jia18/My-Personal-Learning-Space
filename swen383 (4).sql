-- -----------------------------------------------------
-- Table `user`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `user` ;

CREATE TABLE IF NOT EXISTS `user` (
  `userid` INT NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(100) NOT NULL,
  `fname` VARCHAR(100) NOT NULL,
  `lname` VARCHAR(100) NOT NULL,
  `password` VARCHAR(100) NOT NULL,
  `role` INT NULL,
  `active` VARCHAR(1) NULL,
  `confirmation` VARCHAR(5) NULL,
  UNIQUE (email),
  PRIMARY KEY (`userid`),
  INDEX `role_idx` (`role` ASC))
ENGINE = MyISAM;

-- -----------------------------------------------------
-- Table `course`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `course` ;

CREATE TABLE IF NOT EXISTS `course` (
  `courseid` INT NOT NULL AUTO_INCREMENT,
  `courseName` VARCHAR(100) NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci,
  `preRequire` VARCHAR(500) NOT NULL,
  `userid` INT NOT NULL,
   PRIMARY KEY (`courseid`),
   INDEX `userid_fk_idx` (`userid` ASC))
ENGINE = MyISAM;

-- -----------------------------------------------------
-- Table `lecture`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `lecture` ;

CREATE TABLE IF NOT EXISTS `lecture` (
  `lectureid` INT NOT NULL AUTO_INCREMENT,
  `lectureName` VARCHAR(100) NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci,
 `filename` varchar(255),
  `courseid` INT NOT NULL,
  `availabledate` datetime,
  PRIMARY KEY (`lectureid`),
  INDEX `courseid_fk_idx` (`courseid` ASC))
ENGINE = MyISAM;

-- -----------------------------------------------------
-- Table `discussion`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `discussion` ;

CREATE TABLE IF NOT EXISTS `discussion` (
  `discussionid` INT NOT NULL AUTO_INCREMENT,
  `type` VARCHAR(10) NOT NULL,
  `dName` VARCHAR(100) NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci,
  `createdate` DATE NOT NULL,
  `userid` INT NOT NULL,
  PRIMARY KEY (`discussionid`),
  INDEX `userid_fk_idx` (`userid` ASC))
ENGINE = MyISAM;

-- -----------------------------------------------------
-- Table `attend_discussion`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `attend_discussion` ;

CREATE TABLE IF NOT EXISTS `attend_discussion` (
-- discussion id
  `discussionid` INT NOT NULL,
-- userid
  `userid` INT NOT NULL,
  PRIMARY KEY (`discussionid`, `userid`),
  INDEX `userid_fk_idx` (`userid` ASC),
  INDEX `discussionid_fk_idx` (`discussionid` ASC))
ENGINE = MyISAM;


-- -----------------------------------------------------
-- Table `rating table`
-- -----------------------------------------------------

DROP TABLE IF EXISTS `rating` ;
CREATE TABLE IF NOT EXISTS `rating` (
  `rateid` INT NOT NULL AUTO_INCREMENT,
  `type` VARCHAR(15) NOT NULL, 
  `name` VARCHAR(100) NOT NULL, 
  `rating` INT NOT NULL,
  `comment` VARCHAR(1000),
  PRIMARY KEY (`rateid`))
ENGINE = MyISAM;
 
 select * from rating;


 -- -----------------------------------------------------
-- Table `student_course`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `student_course` ;

CREATE TABLE IF NOT EXISTS `student_course` (
-- course id
  `courseid` INT NOT NULL,
-- userid
  `userid` INT NOT NULL,
  PRIMARY KEY (`userid`, `courseid`),
  INDEX `userid_fk_idx` (`userid` ASC),
  INDEX `courseid_fk_idx` (`courseid` ASC))
ENGINE = MyISAM;

 -- -----------------------------------------------------
-- Table `professor_course`
-- -----------------------------------------------------

DROP TABLE IF EXISTS `professor_course` ;

CREATE TABLE IF NOT EXISTS `professor_course` (
-- course id
  `courseid` INT NOT NULL,
-- userid
  `userid` INT NOT NULL,
  PRIMARY KEY (`userid`, `courseid`),
  INDEX `userid_fk_idx` (`userid` ASC),
  INDEX `courseid_fk_idx` (`courseid` ASC))
ENGINE = MyISAM;


 -- -----------------------------------------------------
-- Table `discussion_content`
-- -----------------------------------------------------

DROP TABLE IF EXISTS `discussion_content` ;

CREATE TABLE IF NOT EXISTS `discussion_content` (
-- request
	`contentid` INT NOT NULL AUTO_INCREMENT,
	
-- discussion id
  `discussionid` INT NOT NULL,
-- userid
  `userid` INT NOT NULL,
  
  `title` VARCHAR(100) NOT NULL,
-- date
  `currentdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
-- Comment
   `comment` longtext COLLATE utf8_unicode_ci,
  PRIMARY KEY (`contentid`),
  INDEX `userid_fk_idx` (`userid` ASC),
  INDEX `discussionid_fk_idx` (`discussionid` ASC))
ENGINE = MyISAM;


-- -----------------------------------------------------
-- Table `request`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `request` ;

CREATE TABLE IF NOT EXISTS `request` (
-- request
	`requestid` INT NOT NULL AUTO_INCREMENT,
-- discussion id
  `discussionid` INT NOT NULL,
-- userid
  `userid` INT NOT NULL,
  
  `action` VARCHAR(7) NOT NULL,
  PRIMARY KEY (`requestid`),
  INDEX `userid_fk_idx` (`userid` ASC),
  INDEX `discussionid_fk_idx` (`discussionid` ASC))
ENGINE = MyISAM;


-- -----------------------------------------------------
-- Table `invite`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `invite` ;

CREATE TABLE IF NOT EXISTS `invite` (
-- request
	`inviteid` INT NOT NULL AUTO_INCREMENT,
-- discussion id
  `discussionid` INT NOT NULL,
-- userid
  `userid` INT NOT NULL,
  
  -- who send the invite
  `senderid` INT NOT NULL,
  
  `action` VARCHAR(7) NOT NULL,
  PRIMARY KEY (`inviteid`),
  
  INDEX `userid_fk_idx` (`userid` ASC),
  INDEX `senderid_fk_idx` (`senderid` ASC),
  INDEX `discussionid_fk_idx` (`discussionid` ASC))
ENGINE = MyISAM;


-- -----------------------------------------------------
-- Table `quiz`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `quiz` ;

CREATE TABLE IF NOT EXISTS `quiz` (
-- id
	`quizid` INT NOT NULL AUTO_INCREMENT,
-- course id
  `courseid` INT NOT NULL,

-- name
  `quizname` VARCHAR(100) NOT NULL,
  
  `description` longtext COLLATE utf8_unicode_ci,
  
  `timelimit` INT NOT NULL,
  
  `availabledate` datetime NOT NULL,
  
  `enddate` datetime NOT NULL,
  
  PRIMARY KEY (`quizid`),
  
  INDEX `courseid_fk_idx` (`courseid` ASC))
ENGINE = MyISAM;


-- -----------------------------------------------------
-- Table `quiz_question`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `quiz_question` ;

CREATE TABLE IF NOT EXISTS `quiz_question` (
-- id
	`questionid` INT NOT NULL AUTO_INCREMENT,
-- quiz id
  `quizid` INT NOT NULL,

  
  `question` longtext COLLATE utf8_unicode_ci,
  
  `selectionA` longtext COLLATE utf8_unicode_ci,
  
  `selectionB` longtext COLLATE utf8_unicode_ci,
  
  `selectionC` longtext COLLATE utf8_unicode_ci,
  
  `selectionD` longtext COLLATE utf8_unicode_ci,
  
  `answer` VARCHAR(5) NOT NULL,
  
  
  PRIMARY KEY (`questionid`),
  
  INDEX `quizid_fk_idx` (`quizid` ASC))
ENGINE = MyISAM;




-- -----------------------------------------------------
-- Table `quiz_take`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `quiz_take` ;

CREATE TABLE IF NOT EXISTS `quiz_take` (
-- id
	`quiztakeid` INT NOT NULL AUTO_INCREMENT,
-- quiz id
  `quizid` INT NOT NULL,
  
  `userid` INT NOT NULL,
  
  
  `studentchose`  VARCHAR(100),
  
  
  `take`  VARCHAR(3) NOT NULL,

  
  `answer` VARCHAR(100),
  
  
  `grade` FLOAT NOT NULL,
  PRIMARY KEY (`quiztakeid`),
  
  INDEX `userid_fk_idx` (`userid` ASC),
  
  INDEX `quizid_fk_idx` (`quizid` ASC))
ENGINE = MyISAM;




