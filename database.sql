-- ============================================
-- DATABASE tour - CLEAN & FIXED
-- ============================================

CREATE DATABASE IF NOT EXISTS `tour` 
DEFAULT CHARACTER SET utf8mb4 
COLLATE utf8mb4_unicode_ci;

USE `tour`;

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ============================================
-- DROP TABLES
-- ============================================
DROP TABLE IF EXISTS `tblitinerary`;
DROP TABLE IF EXISTS `tblwishlist`;
DROP TABLE IF EXISTS `tblbooking`;
DROP TABLE IF EXISTS `tblissues`;
DROP TABLE IF EXISTS `tblenquiry`;
DROP TABLE IF EXISTS `tblpages`;
DROP TABLE IF EXISTS `tbltourpackages`;
DROP TABLE IF EXISTS `tblusers`;
DROP TABLE IF EXISTS `tbladmin`;

-- ============================================
-- TABLES
-- ============================================

CREATE TABLE `tbladmin` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `UserName` VARCHAR(100) NOT NULL,
  `Password` VARCHAR(100) NOT NULL,
  `updationDate` TIMESTAMP DEFAULT CURRENT_TIMESTAMP 
    ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE `tblusers` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `FullName` VARCHAR(100) NOT NULL,
  `MobileNumber` CHAR(10) NOT NULL,
  `EmailId` VARCHAR(70) NOT NULL UNIQUE,
  `Password` VARCHAR(100) NOT NULL,
  `RegDate` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `UpdationDate` TIMESTAMP NULL DEFAULT NULL 
    ON UPDATE CURRENT_TIMESTAMP,
  `Avatar` VARCHAR(255),
  `Address` VARCHAR(255),
  `DateOfBirth` DATE,
  `Gender` VARCHAR(10)
) ENGINE=InnoDB;

CREATE TABLE `tbltourpackages` (
  `PackageId` INT AUTO_INCREMENT PRIMARY KEY,
  `PackageName` VARCHAR(200) NOT NULL,
  `PackageType` VARCHAR(150) NOT NULL,
  `TourDuration` VARCHAR(100) NOT NULL,
  `PackageLocation` VARCHAR(100) NOT NULL,
  `PackagePrice` INT NOT NULL,
  `PackageFetures` VARCHAR(255) NOT NULL,
  `PackageDetails` MEDIUMTEXT NOT NULL,
  `PackageImage` VARCHAR(100) NOT NULL,
  `Creationdate` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `UpdationDate` TIMESTAMP NULL DEFAULT NULL 
    ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE `tblbooking` (
  `BookingId` INT AUTO_INCREMENT PRIMARY KEY,
  `PackageId` INT NOT NULL,
  `UserEmail` VARCHAR(100) NOT NULL,
  `FromDate` DATE NOT NULL,
  `ToDate` DATE NOT NULL,
  `Comment` MEDIUMTEXT,
  `NumberOfPeople` INT NOT NULL,
  `TotalPrice` DECIMAL(10,2) NOT NULL,
  `AdminNotes` MEDIUMTEXT,
  `CancelReason` MEDIUMTEXT,
  `RegDate` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `status` INT NOT NULL,
  `CancelledBy` VARCHAR(5),
  `UpdationDate` TIMESTAMP NULL DEFAULT NULL 
    ON UPDATE CURRENT_TIMESTAMP,
  `CustomerMessage` MEDIUMTEXT
) ENGINE=InnoDB;

CREATE TABLE `tblenquiry` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `FullName` VARCHAR(100) NOT NULL,
  `EmailId` VARCHAR(100) NOT NULL,
  `MobileNumber` CHAR(10) NOT NULL,
  `Subject` VARCHAR(100) NOT NULL,
  `Description` MEDIUMTEXT NOT NULL,
  `PostingDate` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `Status` INT
) ENGINE=InnoDB;

CREATE TABLE `tblissues` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `UserEmail` VARCHAR(100) NOT NULL,
  `Issue` VARCHAR(100) NOT NULL,
  `Description` MEDIUMTEXT NOT NULL,
  `PostingDate` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `AdminRemark` MEDIUMTEXT,
  `AdminremarkDate` TIMESTAMP NULL DEFAULT NULL 
    ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE `tblpages` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `type` VARCHAR(255) NOT NULL,
  `detail` LONGTEXT NOT NULL
) ENGINE=InnoDB;

CREATE TABLE `tblwishlist` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `UserEmail` VARCHAR(70) NOT NULL,
  `PackageId` INT NOT NULL,
  `CreatedAt` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  UNIQUE (`UserEmail`, `PackageId`)
) ENGINE=InnoDB;

CREATE TABLE `tblitinerary` (
  `ItineraryId` INT AUTO_INCREMENT PRIMARY KEY,
  `PackageId` INT NOT NULL,
  `TimeLabel` VARCHAR(255) NOT NULL,
  `Activity` TEXT NOT NULL,
  `SortOrder` INT DEFAULT 0,
  `CreatedAt` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ============================================
-- FOREIGN KEYS
-- ============================================

ALTER TABLE `tblbooking`
ADD CONSTRAINT `fk_booking_package` 
FOREIGN KEY (`PackageId`) REFERENCES `tbltourpackages`(`PackageId`) 
ON DELETE CASCADE,
ADD CONSTRAINT `fk_booking_user` 
FOREIGN KEY (`UserEmail`) REFERENCES `tblusers`(`EmailId`) 
ON DELETE CASCADE;

ALTER TABLE `tblwishlist`
ADD CONSTRAINT `fk_wishlist_package` 
FOREIGN KEY (`PackageId`) REFERENCES `tbltourpackages`(`PackageId`) 
ON DELETE CASCADE,
ADD CONSTRAINT `fk_wishlist_user` 
FOREIGN KEY (`UserEmail`) REFERENCES `tblusers`(`EmailId`) 
ON DELETE CASCADE;

ALTER TABLE `tblitinerary`
ADD CONSTRAINT `fk_itinerary_package` 
FOREIGN KEY (`PackageId`) REFERENCES `tbltourpackages`(`PackageId`) 
ON DELETE CASCADE;

SET FOREIGN_KEY_CHECKS = 1;

-- ============================================
-- SEED DATA
-- ============================================

INSERT INTO `tbladmin` VALUES
(1, 'admin', 'f925916e2754e5e03f75dd58a5733251', '2017-05-13 11:18:49');

INSERT INTO `tblusers` VALUES
(12, 'Le Van Uy', '0763165881', 'leuy26011@gmail.com', '17b9cdbb06619ebae36bfeb59dd89449', '2025-11-20 04:20:33', NULL, NULL, NULL, NULL, NULL),
(13, 'Le Van Uy', '0389378485', 'leuy260105@gmail.com', '258d88e5ebfa52d32ad49bf932146263', '2025-11-21 03:14:09', NULL, NULL, NULL, NULL, NULL);

-- (giữ nguyên các INSERT khác của bạn nếu cần)
