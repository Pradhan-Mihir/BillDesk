-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 09, 2021 at 12:37 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tryon_project`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `deleteCategory` (IN `CAT_ID` BIGINT(20))  BEGIN
  DELETE FROM tbl_category WHERE category_id = CAT_ID;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `deleteCompany` (IN `CID` BIGINT(20))  BEGIN
  DELETE FROM tbl_company WHERE company_id = CID;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `deleteManageUser` (IN `UID` BIGINT(20))  BEGIN
	DELETE FROM manage_user_tbl WHERE user_id = UID;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `fetchCategory` (IN `CAT_ID` BIGINT(20))  BEGIN
  SELECT * FROM tbl_category WHERE category_id = CAT_ID;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `fetchcompany` (IN `CID` BIGINT(20))  BEGIN
  SELECT * FROM tbl_company WHERE company_id = CID;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `fetchManageUser` (IN `UID` BIGINT(20))  BEGIN
	SELECT * FROM manage_user_tbl WHERE user_id = UID;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insertCategory` (IN `CAT_CODE` VARCHAR(100), IN `CAT_NAME` VARCHAR(100))  BEGIN
	INSERT INTO  tbl_category (category_code,category_name) values (CAT_CODE,CAT_NAME );	
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insertCompany` (IN `CNAME` VARCHAR(100), IN `MOBILE` BIGINT(20), IN `ALT_MOBILE` BIGINT(10), IN `EMAIL` VARCHAR(100), IN `ADDRESS` VARCHAR(500), IN `CITY` VARCHAR(50), IN `STATE` VARCHAR(50), IN `PINCODE` BIGINT(6), IN `GST` VARCHAR(20), IN `BANKNAME` VARCHAR(100), IN `ACNO` BIGINT(20), IN `IFSC` VARCHAR(20), IN `PAN` VARCHAR(20), IN `TIN` VARCHAR(20), IN `CST` VARCHAR(20), IN `STAX` VARCHAR(20), IN `LIC` VARCHAR(20), IN `LOGO` VARCHAR(2000))  BEGIN
INSERT INTO  tbl_company ( company_name , mobile_no , alter_mobile_no , email , address , city , state , pincode , gst_in_no , bank_name , ac_no , ifsc , pan_no , tin_no , cst_no , stax_no , general_lic_no , company_logo )
 values (CNAME , MOBILE , ALT_MOBILE , EMAIL , ADDRESS , CITY , STATE , PINCODE , GST , BANKNAME , ACNO , IFSC , PAN , TIN , CST , STAX , LIC , LOGO );
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insertManageUser` (IN `UNAME` VARCHAR(100), IN `FNAME` VARCHAR(100), IN `EMAIL` VARCHAR(100), IN `MOBILE` BIGINT(10), IN `PWD` VARCHAR(20), IN `UIMG` VARCHAR(2000))  BEGIN
  INSERT INTO  manage_user_tbl (username, full_name, email, mobile, passward, user_image) values (UNAME, FNAME, EMAIL , MOBILE , PWD , UIMG );
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `updateCategory` (IN `CAT_ID` BIGINT(20), IN `CAT_CODE` VARCHAR(100), IN `CAT_NAME` VARCHAR(100))  BEGIN
  UPDATE tbl_category SET category_code = CAT_CODE , category_name = CAT_NAME WHERE category_id = CAT_ID;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `updateCompany` (IN `CID` BIGINT(20), IN `CNAME` VARCHAR(100), IN `MOBILE` BIGINT(20), IN `ALT_MOBILE` BIGINT(10), IN `EMAIL` VARCHAR(100), IN `ADDRESS` VARCHAR(500), IN `CITY` VARCHAR(50), IN `STATE` VARCHAR(50), IN `PINCODE` BIGINT(6), IN `GST` VARCHAR(20), IN `BANKNAME` VARCHAR(100), IN `ACNO` BIGINT(20), IN `IFSC` VARCHAR(20), IN `PAN` VARCHAR(20), IN `TIN` VARCHAR(20), IN `CST` VARCHAR(20), IN `STAX` VARCHAR(20), IN `LIC` VARCHAR(20), IN `LOGO` VARCHAR(2000))  BEGIN
  UPDATE tbl_company SET company_name= CNAME , mobile_no= MOBILE , alter_mobile_no= ALT_MOBILE , email= EMAIL , address= ADDRESS , city= CITY , state=STATE  , pincode=PINCODE  , gst_in_no=GST  , bank_name=BANKNAME ,ac_no=ACNO  ,ifsc=IFSC ,pan_no=PAN ,tin_no=TIN ,cst_no=CST ,stax_no=STAX ,general_lic_no=LIC ,company_logo=LOGO  WHERE company_id= CID;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `updateManageUser` (IN `UID` BIGINT(20), IN `UNAME` VARCHAR(100), IN `FNAME` VARCHAR(100), IN `EMAIL` VARCHAR(100), IN `MOBILE` BIGINT(10), IN `PWD` VARCHAR(20), IN `UIMG` VARCHAR(2000))  BEGIN
  UPDATE manage_user_tbl SET username = UNAME, full_name = FNAME , email = EMAIL , mobile = MOBILE , passward = PWD , user_image = UIMG WHERE user_id = UID;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `updateUserPassword` (IN `UID` BIGINT(20), IN `PWD` VARCHAR(20))  BEGIN
  UPDATE manage_user_tbl SET passward = PWD WHERE user_id = UID;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `updateUserProfile` (IN `UID` BIGINT(20), IN `FNAME` VARCHAR(100), IN `EMAIL` VARCHAR(100), IN `MOBILE` BIGINT(10), IN `UIMG` VARCHAR(2000))  BEGIN
  UPDATE manage_user_tbl SET  full_name = FNAME , email = EMAIL , mobile = MOBILE , user_image = UIMG WHERE user_id = UID;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `viewCategory` ()  BEGIN
  SELECT * FROM tbl_category;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `viewCompany` ()  BEGIN
  SELECT * FROM tbl_company;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `viewLogin` (IN `UNAME` VARCHAR(25), IN `PWD` VARCHAR(25))  BEGIN
	SELECT * FROM manage_user_tbl WHERE username = UNAME AND passward = PWD;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `viewManageUser` ()  BEGIN
  SELECT * FROM manage_user_tbl;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `manage_user_tbl`
--

CREATE TABLE `manage_user_tbl` (
  `user_id` bigint(20) NOT NULL,
  `username` varchar(100) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mobile` bigint(10) NOT NULL,
  `passward` varchar(20) NOT NULL,
  `user_image` varchar(2000) NOT NULL,
  `is_admin` bit(1) NOT NULL DEFAULT b'0',
  `added_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `manage_user_tbl`
--

INSERT INTO `manage_user_tbl` (`user_id`, `username`, `full_name`, `email`, `mobile`, `passward`, `user_image`, `is_admin`, `added_date`) VALUES
(1, 'admin', 'admin', 'admin@gmail.com', 9638527410, '123', 'default.png', b'1', '2021-12-06 08:55:43'),
(4, 'mihir', 'Pradhan Mihir', 'mihirhpradhan@gmail.com', 9876543210, '123', 'IMG_4456666538.PNG', b'0', '2021-12-06 10:44:50'),
(5, 'bhautik', 'Patel Bhautik Pravinbhai', 'bhautikpatel1201@gmail.com', 9328659886, '1201', 'photo_2021-12-07_16-12-40757331.jpg', b'0', '2021-12-07 10:42:56'),
(7, 'vjj', '', '', 0, '123', '', b'0', '2021-12-09 09:22:51');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_category`
--

CREATE TABLE `tbl_category` (
  `category_id` bigint(20) NOT NULL,
  `category_code` varchar(100) NOT NULL,
  `category_name` varchar(100) NOT NULL,
  `category_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_category`
--

INSERT INTO `tbl_category` (`category_id`, `category_code`, `category_name`, `category_date`) VALUES
(1, 'C101', 'netbanking', '2021-12-09 11:35:29');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_company`
--

CREATE TABLE `tbl_company` (
  `company_id` bigint(20) NOT NULL,
  `company_name` varchar(100) NOT NULL,
  `mobile_no` bigint(20) NOT NULL,
  `alter_mobile_no` bigint(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `address` varchar(500) NOT NULL,
  `city` varchar(50) NOT NULL,
  `state` varchar(50) NOT NULL,
  `pincode` bigint(20) NOT NULL,
  `gst_in_no` varchar(20) NOT NULL,
  `bank_name` varchar(100) NOT NULL,
  `ac_no` bigint(20) NOT NULL,
  `ifsc` varchar(20) NOT NULL,
  `pan_no` varchar(20) NOT NULL,
  `tin_no` varchar(20) NOT NULL,
  `cst_no` varchar(20) NOT NULL,
  `stax_no` varchar(20) NOT NULL,
  `general_lic_no` varchar(20) NOT NULL,
  `company_logo` varchar(2000) NOT NULL,
  `is_default` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_company`
--

INSERT INTO `tbl_company` (`company_id`, `company_name`, `mobile_no`, `alter_mobile_no`, `email`, `address`, `city`, `state`, `pincode`, `gst_in_no`, `bank_name`, `ac_no`, `ifsc`, `pan_no`, `tin_no`, `cst_no`, `stax_no`, `general_lic_no`, `company_logo`, `is_default`) VALUES
(8, 'bhautik', 9328659886, 9090909090, 'bhautikpatel1201@gmail.com', 'althan', 'surat', 'Gujarat', 395017, '21345', 'sbi', 12345780, '1251bvi', '215463', '659649', '165432', '3134', 'a5513a38', 'photo_2021-12-07_16-12-40686798.jpg', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `manage_user_tbl`
--
ALTER TABLE `manage_user_tbl`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `tbl_category`
--
ALTER TABLE `tbl_category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `tbl_company`
--
ALTER TABLE `tbl_company`
  ADD PRIMARY KEY (`company_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `manage_user_tbl`
--
ALTER TABLE `manage_user_tbl`
  MODIFY `user_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_category`
--
ALTER TABLE `tbl_category`
  MODIFY `category_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_company`
--
ALTER TABLE `tbl_company`
  MODIFY `company_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
