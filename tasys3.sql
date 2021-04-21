-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.4.8-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             11.1.0.6116
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for tasys3
CREATE DATABASE IF NOT EXISTS `tasys3` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
USE `tasys3`;

-- Dumping structure for table tasys3.course
CREATE TABLE IF NOT EXISTS `course` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `course_id` int(11) NOT NULL,
  `course_name` varchar(100) NOT NULL,
  `major_id` int(11) NOT NULL,
  `deleted` tinyint(1) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `major_id` (`major_id`),
  KEY `id` (`id`),
  CONSTRAINT `course_ibfk_1` FOREIGN KEY (`major_id`) REFERENCES `major` (`major_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Data exporting was unselected.

-- Dumping structure for table tasys3.day_work
CREATE TABLE IF NOT EXISTS `day_work` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `day` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- Data exporting was unselected.

-- Dumping structure for table tasys3.major
CREATE TABLE IF NOT EXISTS `major` (
  `major_id` int(7) NOT NULL AUTO_INCREMENT,
  `major_name` varchar(100) NOT NULL,
  PRIMARY KEY (`major_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- Data exporting was unselected.

-- Dumping structure for table tasys3.matching_course
CREATE TABLE IF NOT EXISTS `matching_course` (
  `m_course_id` int(11) NOT NULL AUTO_INCREMENT,
  `sem_id` int(11) NOT NULL,
  `courseID` int(11) unsigned NOT NULL,
  `section` int(4) NOT NULL,
  `t_date` varchar(10) NOT NULL,
  `t_time` varchar(12) NOT NULL,
  `user_id` int(11) NOT NULL COMMENT 'Only lecturerID',
  `language` varchar(25) NOT NULL DEFAULT '' COMMENT 'stuTH=90, stuENG=120, ExTH=200, ExENG=300, Special=450',
  `hr_per_week` int(11) unsigned NOT NULL,
  `m_status` int(11) NOT NULL COMMENT '0=close, 1=open',
  `deleted` int(11) DEFAULT NULL COMMENT '0=non deleted , 1=deleted',
  PRIMARY KEY (`m_course_id`),
  KEY `sem_id` (`sem_id`),
  KEY `user_id` (`user_id`),
  KEY `course_id` (`courseID`) USING BTREE,
  CONSTRAINT `FK_matching_course_course` FOREIGN KEY (`courseID`) REFERENCES `course` (`id`),
  CONSTRAINT `matching_course_ibfk_1` FOREIGN KEY (`sem_id`) REFERENCES `semester` (`sem_id`),
  CONSTRAINT `matching_course_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `user_tbl` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8;

-- Data exporting was unselected.

-- Dumping structure for table tasys3.matching_ta
CREATE TABLE IF NOT EXISTS `matching_ta` (
  `m_ta_id` int(11) NOT NULL AUTO_INCREMENT,
  `request_id` int(11) NOT NULL,
  `register_id` int(11) NOT NULL,
  `m_ta_status` int(11) NOT NULL,
  PRIMARY KEY (`m_ta_id`),
  KEY `request_id` (`request_id`),
  KEY `register_id` (`register_id`),
  CONSTRAINT `matching_ta_ibfk_1` FOREIGN KEY (`request_id`) REFERENCES `ta_request` (`request_id`),
  CONSTRAINT `matching_ta_ibfk_2` FOREIGN KEY (`register_id`) REFERENCES `register` (`register_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.

-- Dumping structure for table tasys3.register
CREATE TABLE IF NOT EXISTS `register` (
  `register_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `m_course_id` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `r_status` tinyint(1) NOT NULL COMMENT '0=unsgined,1=signed,2=approved',
  PRIMARY KEY (`register_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `register_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user_tbl` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;

-- Data exporting was unselected.

-- Dumping structure for table tasys3.semester
CREATE TABLE IF NOT EXISTS `semester` (
  `sem_id` int(5) NOT NULL AUTO_INCREMENT,
  `sem_number` int(1) NOT NULL COMMENT '1 = sem 1 or 2 = sem 2',
  `year` int(5) NOT NULL,
  PRIMARY KEY (`sem_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Data exporting was unselected.

-- Dumping structure for table tasys3.ta_request
CREATE TABLE IF NOT EXISTS `ta_request` (
  `request_id` int(11) NOT NULL AUTO_INCREMENT,
  `m_course_id` int(11) NOT NULL,
  `stu_num` int(11) NOT NULL,
  `ex_num` int(11) NOT NULL,
  `request_note` varchar(200) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `requested_by` int(11) DEFAULT NULL,
  `approved` tinyint(3) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`request_id`),
  KEY `m_course_id` (`m_course_id`),
  CONSTRAINT `ta_request_ibfk_1` FOREIGN KEY (`m_course_id`) REFERENCES `matching_course` (`m_course_id`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8;

-- Data exporting was unselected.

-- Dumping structure for table tasys3.user_tbl
CREATE TABLE IF NOT EXISTS `user_tbl` (
  `user_id` int(4) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `password` varchar(20) NOT NULL,
  `f_name` varchar(30) NOT NULL,
  `l_name` varchar(30) NOT NULL,
  `student_id` int(15) DEFAULT NULL,
  `major` varchar(20) DEFAULT NULL,
  `cmu_mail` varchar(20) DEFAULT NULL,
  `line_id` varchar(20) DEFAULT NULL,
  `facebook_link` varchar(100) DEFAULT NULL,
  `tel` varchar(12) DEFAULT NULL,
  `portfolio_link` varchar(100) DEFAULT NULL,
  `user_type` varchar(20) NOT NULL COMMENT '1=admin, 2=student, 3=external, 4=lecturer',
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

-- Data exporting was unselected.

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
