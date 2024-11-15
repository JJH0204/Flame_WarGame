DROP DATABASE IF EXISTS `testDB`;
CREATE DATABASE `testDB`;

USE testDB;
DROP TABLE IF EXISTS `ID_info`;
CREATE TABLE `ID_info` (
    `ID` VARCHAR(20) NOT NULL ,
    `PW` VARCHAR(255) NOT NULL ,
    `NICKNAME` VARCHAR(20) NOT NULL,
    `RECOREDE_DATE` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `Score`;
CREATE TABLE IF NOT EXISTS `Score` (
    `ID` VARCHAR(20) NOT NULL,          
    `NICKNAME` VARCHAR(20) NOT NULL,                   
    `SCORE` INT NOT NULL DEFAULT 0,            
    `STRAGE` INT NOT NULL DEFAULT 0,            
    `RECOREDE_DATE` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, 
    UNIQUE KEY unique_user_game (ID, NICKNAME)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- INSERT INTO `ID_info` (`ID`, `PW`, `NICKNAME`) VALUES ('public', 'public', 'public');
-- INSERT INTO `Score` (`ID`, `INCKNAME`) VALUES (`public`, `public`);

CREATE USER `admin`@`localhost` identified by 'flamerootpassword';
GRANT ALL PRIVILEGES ON *.* TO 'admin'@'localhost';
FLUSH PRIVILEGES;