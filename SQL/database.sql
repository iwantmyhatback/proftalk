CREATE DATABASE proftalk;
USE proftalk;

CREATE TABLE `account` (
	`accountID` INT(11) NOT NULL AUTO_INCREMENT,
	`studentID` INT(11) NULL DEFAULT NULL,
	`professorID` INT(11) NULL DEFAULT NULL
);

CREATE TABLE `administers` (
	`administerID` INT(11) NOT NULL AUTO_INCREMENT,
	`professorID` INT(11) NOT NULL,
	`classID` INT(11) NOT NULL
);

CREATE TABLE `appointment` (
	`appointmentID` INT(11) NOT NULL AUTO_INCREMENT,
	`studentID` TINYTEXT NULL DEFAULT NULL,
	`prof_ID` TINYTEXT NULL DEFAULT NULL,
	`classID` TINYTEXT NULL DEFAULT NULL,
	`start_time` INT(11) NOT NULL DEFAULT 0,
	`end_time` INT(11) NOT NULL DEFAULT 0,
	`room` TEXT NOT NULL DEFAULT ''
);

CREATE TABLE `class` (
	`classID` INT(11) NOT NULL AUTO_INCREMENT,
	`classNum` INT(4) NOT NULL DEFAULT 0,
	`prof_ID` TINYTEXT NOT NULL DEFAULT '',
	`email` TINYTEXT NOT NULL,
	`subject` TINYTEXT NOT NULL,
	`section` TINYTEXT NOT NULL,
	`phone` TINYTEXT NOT NULL,
	`start_time` INT(11) NOT NULL DEFAULT 0,
	`end_time` INT(11) NOT NULL DEFAULT 0,
	`max_seats` INT(11) NOT NULL,
	`used_seats` INT(11) NOT NULL DEFAULT 0,
	`password` TINYTEXT NOT NULL
);

CREATE TABLE `enrolled` (
	`enrolledID` INT(11) NOT NULL AUTO_INCREMENT,
	`studentID` TEXT NOT NULL DEFAULT '',
	`classID` TEXT NOT NULL DEFAULT ''
);

CREATE TABLE `professor` (
	`professorID` INT(11) NOT NULL AUTO_INCREMENT,
	`uName` TINYTEXT NOT NULL,
	`password` LONGTEXT NOT NULL,
	`fName` TINYTEXT NOT NULL,
	`lName` TINYTEXT NOT NULL,
	`email` TINYTEXT NOT NULL,
	`phone` INT(10) NOT NULL,
	`empl` INT(8) NOT NULL
);

CREATE TABLE `student` (
	`studentID` INT(11) NOT NULL AUTO_INCREMENT,
	`password` LONGTEXT NOT NULL,
	`fName` TINYTEXT NOT NULL,
	`lName` TINYTEXT NOT NULL,
	`email` TINYTEXT NOT NULL,
	`phone` INT(10) NOT NULL,
	`empl` INT(8) NOT NULL,
	`uName` TINYTEXT NOT NULL
);