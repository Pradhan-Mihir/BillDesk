-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 15, 2021 at 03:42 PM
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `deleteColor` (IN `CID` BIGINT(20))  BEGIN
	DELETE FROM tbl_color WHERE color_id = CID;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `deleteCompany` (IN `CID` BIGINT(20))  BEGIN
	DELETE FROM tbl_company WHERE company_id = CID;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `deleteExpence` (IN `EID` BIGINT(20))  BEGIN
	DELETE FROM tbl_expence WHERE expence_id = EID;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `deleteExpense_type` (IN `EID` BIGINT(20))  BEGIN
	DELETE FROM tbl_expense_type WHERE expense_id  = EID ;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `deleteGstslab` (IN `GID` BIGINT(20))  BEGIN
	DELETE FROM tbl_gstslab_master WHERE gstslab_id = GID ;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `deleteManageUser` (IN `UID` BIGINT(20))  BEGIN
	DELETE FROM manage_user_tbl WHERE user_id = UID;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `deleteParty_master` (IN `PID` BIGINT(20))  BEGIN
	DELETE FROM tbl_party_master WHERE party_id  = PID ;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `deletePayment_type` (IN `PID` BIGINT(20))  BEGIN
	DELETE FROM tbl_payment_type WHERE payment_type_id  = PID ;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `deleteSize` (IN `SID` BIGINT(20))  BEGIN
	DELETE FROM tbl_size WHERE size_id = SID ;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `deleteUnit` (IN `UID` BIGINT(20))  BEGIN
	DELETE FROM tbl_unit WHERE unit_id = UID ;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `fetchCategory` (IN `CAT_ID` BIGINT(20))  BEGIN
  SELECT * FROM tbl_category WHERE category_id = CAT_ID;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `fetchColor` (IN `CID` BIGINT(20))  BEGIN
	SELECT * FROM tbl_color WHERE color_id = CID;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `fetchCompany` (IN `CID` BIGINT(20))  BEGIN
	SELECT * FROM tbl_company WHERE company_id = CID;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `fetchExpence` (IN `EID` BIGINT(20))  BEGIN
	SELECT * FROM tbl_expence WHERE expence_id = EID;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `fetchExpense_type` (IN `EID` BIGINT(20))  BEGIN
	SELECT * FROM tbl_expense_type WHERE expense_id  = EID ;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `fetchGstslab` (IN `GID` BIGINT(20))  BEGIN
	SELECT * FROM tbl_gstslab_master WHERE gstslab_id = GID ;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `fetchManageUser` (IN `UID` BIGINT(20))  BEGIN
	SELECT * FROM manage_user_tbl WHERE user_id = UID;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `fetchParty_master` (IN `PID` BIGINT(20))  BEGIN
	SELECT * FROM tbl_party_master WHERE party_id  = PID ;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `fetchPayment_type` (IN `PID` BIGINT(20))  BEGIN
	SELECT * FROM tbl_payment_type WHERE payment_type_id  = PID ;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `fetchSize` (IN `SID` BIGINT(20))  BEGIN
	SELECT * FROM tbl_size WHERE size_id = SID;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `fetchUnit` (IN `UID` BIGINT(20))  BEGIN
	SELECT * FROM tbl_unit WHERE unit_id = UID ;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insertCategory` (IN `CAT_CODE` VARCHAR(100), IN `CAT_NAME` VARCHAR(100))  BEGIN
	INSERT INTO  tbl_category (category_code , category_name) values (CAT_CODE,CAT_NAME );	
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insertColor` (IN `CTYPE` VARCHAR(100))  BEGIN
	INSERT INTO tbl_color (color_name) VALUES (CTYPE);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insertCompany` (IN `CNAME` VARCHAR(100), IN `MOBILE` BIGINT(20), IN `ALT_MOBILE` BIGINT(10), IN `EMAIL` VARCHAR(100), IN `ADDRESS` VARCHAR(500), IN `CITY` VARCHAR(50), IN `STATE` VARCHAR(50), IN `PINCODE` BIGINT(6), IN `GST` VARCHAR(20), IN `BANKNAME` VARCHAR(100), IN `ACNO` BIGINT(20), IN `IFSC` VARCHAR(20), IN `PAN` VARCHAR(20), IN `TIN` VARCHAR(20), IN `CST` VARCHAR(20), IN `STAX` VARCHAR(20), IN `LIC` VARCHAR(20), IN `LOGO` VARCHAR(2000))  BEGIN
INSERT INTO  tbl_company ( company_name , mobile_no , alter_mobile_no , email , address , city , state , pincode , gst_in_no , bank_name , ac_no , ifsc , pan_no , tin_no , cst_no , stax_no , general_lic_no , company_logo )
 values ( CNAME , MOBILE , ALT_MOBILE , EMAIL , ADDRESS , CITY , STATE , PINCODE , GST , BANKNAME , ACNO , IFSC , PAN , TIN , CST , STAX , LIC , LOGO );
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insertExpence` (IN `NAME` VARCHAR(100), IN `CATEGORY` BIGINT(20), IN `AMT` BIGINT(20))  BEGIN
	INSERT INTO tbl_expence (expence_name , expense_id , expence_amount ) VALUES (NAME , CATEGORY , AMT);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insertExpense_type` (IN `ENAME` VARCHAR(100))  BEGIN
	INSERT INTO tbl_expense_type (expense_name) VALUES (ENAME);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insertGstslab` (IN `NAME` VARCHAR(100), IN `C_GST` DECIMAL(18,2), IN `S_GST` DECIMAL(18,2), IN `I_GST` DECIMAL(18,2))  BEGIN
	INSERT INTO tbl_gstslab_master ( gstslab_name , cgst , sgst , igst) VALUES ( NAME , C_GST , S_GST , I_GST);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insertManageUser` (IN `UNAME` VARCHAR(100), IN `FNAME` VARCHAR(100), IN `EMAIL` VARCHAR(100), IN `MOBILE` BIGINT(10), IN `PWD` VARCHAR(20), IN `UIMG` VARCHAR(2000))  BEGIN
	INSERT INTO  manage_user_tbl (username, full_name, email, mobile, passward, user_image) values (UNAME, FNAME, EMAIL , MOBILE , PWD , UIMG );
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insertParty_master` (IN `GRP` INT(6), IN `NAME` VARCHAR(100), IN `MOBILE` BIGINT(20), IN `ALT_MOBILE` BIGINT(20), IN `EML` VARCHAR(100), IN `BILL_ADD` VARCHAR(250), IN `SHIP_ADD` VARCHAR(250), IN `GST_TYP` VARCHAR(100), IN `GSTIN` VARCHAR(20), IN `STAT` VARCHAR(50))  BEGIN
	INSERT INTO tbl_party_master (party_group,party_name, mobile_no,alter_mobile_no,email,billing_address,shipping_address, gst_type,gst_in,state) VALUES (GRP,NAME,MOBILE,ALT_MOBILE,EML, BILL_ADD,SHIP_ADD,GST_TYP,GSTIN,STAT);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insertPayment_type` (IN `PTYPE` VARCHAR(100))  BEGIN
	INSERT INTO tbl_payment_type ( payment_type) VALUES (PTYPE);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insertSize` (IN `STYPE` VARCHAR(100))  BEGIN
	INSERT INTO tbl_size (size) VALUES (STYPE);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insertUnit` (IN `UTYPE` VARCHAR(100))  BEGIN
	INSERT INTO tbl_unit (unit_name) VALUES (UTYPE);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `updateCategory` (IN `CAT_ID` BIGINT(20), IN `CAT_CODE` VARCHAR(100), IN `CAT_NAME` VARCHAR(100))  BEGIN
  UPDATE tbl_category SET category_code = CAT_CODE , category_name = CAT_NAME WHERE category_id = CAT_ID;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `updateColor` (IN `CID` BIGINT(20), IN `CTYPE` VARCHAR(100))  BEGIN
	UPDATE tbl_color SET color_name = CTYPE WHERE color_id = CID; 
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `updateCompany` (IN `CID` BIGINT(20), IN `CNAME` VARCHAR(100), IN `MOBILE` BIGINT(20), IN `ALT_MOBILE` BIGINT(10), IN `EMAIL` VARCHAR(100), IN `ADDRESS` VARCHAR(500), IN `CITY` VARCHAR(50), IN `STATE` VARCHAR(50), IN `PINCODE` BIGINT(6), IN `GST` VARCHAR(20), IN `BANKNAME` VARCHAR(100), IN `ACNO` BIGINT(20), IN `IFSC` VARCHAR(20), IN `PAN` VARCHAR(20), IN `TIN` VARCHAR(20), IN `CST` VARCHAR(20), IN `STAX` VARCHAR(20), IN `LIC` VARCHAR(20), IN `LOGO` VARCHAR(2000))  BEGIN
UPDATE  tbl_company SET company_name = CNAME, mobile_no = MOBILE , alter_mobile_no = ALT_MOBILE, email = EMAIL , address = ADDRESS , city = CITY, state = STATE , pincode = PINCODE, gst_in_no = GST, bank_name = BANKNAME, ac_no = ACNO, ifsc = IFSC, pan_no = PAN, tin_no = TIN, cst_no = CST, stax_no = STAX, general_lic_no = LIC, company_logo = LOGO   where company_id = CID ;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `updateExpence` (IN `EID` BIGINT(20), IN `NAME` VARCHAR(100), IN `CATEGORY` BIGINT(20), IN `AMT` BIGINT(20))  BEGIN
	UPDATE tbl_expence SET expence_name = NAME, expense_id = CATEGORY, expence_amount = AMT WHERE expence_id = EID;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `updateExpense_type` (IN `EID` BIGINT(20), IN `ENAME` VARCHAR(100))  BEGIN
	UPDATE tbl_expense_type SET expense_name= ENAME WHERE expense_id  = EID ;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `updateGstslab` (IN `GID` BIGINT(20), IN `NAME` VARCHAR(100), IN `C_GST` DECIMAL(18,2), IN `S_GST` DECIMAL(18,2), IN `I_GST` DECIMAL(18,2))  BEGIN
	UPDATE tbl_gstslab_master SET gstslab_name = NAME, cgst = C_GST, sgst = S_GST, igst = I_GST WHERE gstslab_id = GID ;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `updateManageUser` (IN `UID` BIGINT(20), IN `UNAME` VARCHAR(100), IN `FNAME` VARCHAR(100), IN `EMAIL` VARCHAR(100), IN `MOBILE` BIGINT(10), IN `PWD` VARCHAR(20), IN `UIMG` VARCHAR(2000))  BEGIN
	UPDATE manage_user_tbl SET username = UNAME, full_name = FNAME , email = EMAIL , mobile = MOBILE , passward = PWD , user_image = UIMG WHERE user_id = UID;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `updateParty_master` (IN `PID` BIGINT(20), IN `GRP` INT(1), IN `NAME` VARCHAR(100), IN `MOBILE` BIGINT(20), IN `ALT_MOBILE` BIGINT(20), IN `EML` VARCHAR(100), IN `BILL_ADD` VARCHAR(250), IN `SHIP_ADD` VARCHAR(250), IN `GST_TYP` VARCHAR(100), IN `GSTIN` VARCHAR(20), IN `STAT` VARCHAR(50))  BEGIN
	UPDATE tbl_party_master SET party_group = GRP, party_name = NAME, mobile_no = MOBILE, alter_mobile_no = ALT_MOBILE, email = EML, billing_address  = BILL_ADD, shipping_address = SHIP_ADD, gst_type =  GST_TYP, gst_in = GSTIN, state = STAT WHERE party_id = PID;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `updatePayment_type` (IN `PID` BIGINT(20), IN `PTYPE` VARCHAR(100))  BEGIN
	UPDATE tbl_payment_type SET payment_type = PTYPE WHERE payment_type_id  = PID ;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `updateSize` (IN `SID` BIGINT(20), IN `STYPE` VARCHAR(100))  BEGIN
	UPDATE tbl_size SET size = STYPE WHERE size_id = SID; 
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `updateUnit` (IN `UID` BIGINT(20), IN `UTYPE` VARCHAR(100))  BEGIN
	UPDATE tbl_unit SET unit_name = UTYPE WHERE unit_id = UID ;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `updateUserPassword` (IN `UID` BIGINT(20), IN `PWD` VARCHAR(20))  BEGIN
	UPDATE manage_user_tbl SET passward = PWD WHERE user_id = UID;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `updateUserProfile` (IN `UID` BIGINT(20), IN `FNAME` VARCHAR(100), IN `EMAIL` VARCHAR(100), IN `MOBILE` BIGINT(10), IN `UIMG` VARCHAR(2000))  BEGIN
	UPDATE manage_user_tbl SET full_name = FNAME , email = EMAIL , mobile = MOBILE , user_image = UIMG WHERE user_id = UID;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `viewCategory` ()  BEGIN
  SELECT * FROM tbl_category;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `viewColor` ()  BEGIN
	SELECT * FROM tbl_color;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `viewCompany` ()  BEGIN
	SELECT * FROM tbl_company;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `viewExpence` ()  BEGIN
  SELECT te.*, tetyp.expense_name 
            FROM tbl_expence as te
            LEFT JOIN tbl_expense_type as tetyp ON te.expense_id = tetyp.expense_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `viewExpense_type` ()  BEGIN
	SELECT * FROM tbl_expense_type ;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `viewGstslab` ()  BEGIN
	SELECT * FROM tbl_gstslab_master ;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `viewLogin` (IN `UNAME` VARCHAR(25), IN `PWD` VARCHAR(25))  BEGIN
	SELECT * FROM manage_user_tbl WHERE username = UNAME AND passward = PWD;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `viewManageUser` ()  BEGIN
  SELECT * FROM manage_user_tbl;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `viewParty_master` ()  BEGIN
	SELECT * FROM tbl_party_master ;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `viewPayment_type` ()  BEGIN
	SELECT * FROM tbl_payment_type ;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `viewSize` ()  BEGIN
	SELECT * FROM tbl_size;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `viewUnit` ()  BEGIN
	SELECT * FROM tbl_unit;
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
  `added_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `manage_user_tbl`
--

INSERT INTO `manage_user_tbl` (`user_id`, `username`, `full_name`, `email`, `mobile`, `passward`, `user_image`, `is_admin`, `added_date`) VALUES
(1, 'admin', '', 'admin@gmail.com', 9328659886, '123', '', b'1', '2021-11-26 04:42:56'),
(3, 'bhautik', 'bhautik patel', 'bhautikpatel1201@gmail.com', 9328659886, '123', '9c052a33675e90af154dcb508354d377-1280x720816168.jpeg', b'1', '2021-11-26 06:03:44'),
(4, 'mihir', 'mihir pradhan', 'mihirhpradhan@gmail.com', 9376521396, '123', 'IMG_4454643293.PNG', b'1', '2021-11-26 14:41:34'),
(6, 'mansi', 'mansi mansi', 'mansi@patil.com', 9876543210, '123', '', b'0', '2021-12-04 11:15:47'),
(7, 'kp', 'kunal ga', 'kunalpawar354@gmail.com', 1234567890, '123', '1511cd3106f0c5308d75a99e1dd535c8913178.jpg', b'0', '2021-12-04 11:29:18');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_category`
--

CREATE TABLE `tbl_category` (
  `category_id` bigint(20) NOT NULL,
  `category_code` varchar(100) NOT NULL,
  `category_name` varchar(100) NOT NULL,
  `category_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_category`
--

INSERT INTO `tbl_category` (`category_id`, `category_code`, `category_name`, `category_date`) VALUES
(1, 'm001', 'mihir', '2021-12-11 09:31:49');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_color`
--

CREATE TABLE `tbl_color` (
  `color_id` bigint(20) NOT NULL,
  `color_name` varchar(100) NOT NULL,
  `added_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_color`
--

INSERT INTO `tbl_color` (`color_id`, `color_name`, `added_date`) VALUES
(2, 'GREEN', '2021-12-13 11:29:15');

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
(3, 'mihir', 9376521396, 4185123685, 'mihir.pradhan.786@gmail.com', 'Pandesara', 'SURAT', 'Gujarat', 394221, 'fghj', 'dfghj', 84518451, '7yfugi', 'pann', 'ybunk9', 'csttt', '8451', 'gybjn845', '848e7702c93ea493dd7499880a4e2001686551.jpg', 0),
(4, 'bhautik', 9637521485, 6541239650, 'mihir.pradhan.786@gmail.com', 'Pandesara', 'SURAT', 'Gujarat', 394221, 'fghj', 'dfghj', 52146325, '7yfugi', 'bca', 'gyujnk', 'abc', 'yuhbj', 'gybjn845', '1511cd3106f0c5308d75a99e1dd535c8768651.jpg', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_expence`
--

CREATE TABLE `tbl_expence` (
  `expence_id` bigint(20) NOT NULL,
  `expence_name` varchar(100) NOT NULL,
  `expense_id` bigint(20) NOT NULL,
  `expence_amount` bigint(20) NOT NULL,
  `expence_date` date NOT NULL DEFAULT current_timestamp(),
  `expence_year` year(4) NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_expence`
--

INSERT INTO `tbl_expence` (`expence_id`, `expence_name`, `expense_id`, `expence_amount`, `expence_date`, `expence_year`) VALUES
(1, 'water line', 1, 650, '2021-12-15', 2021),
(2, 'drink', 2, 50, '2021-12-15', 2021);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_expense_type`
--

CREATE TABLE `tbl_expense_type` (
  `expense_id` bigint(20) NOT NULL,
  `expense_name` varchar(100) NOT NULL,
  `added_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_expense_type`
--

INSERT INTO `tbl_expense_type` (`expense_id`, `expense_name`, `added_date`) VALUES
(1, 'maintenance', '2021-12-15 09:40:20'),
(2, 'coffee', '2021-12-15 11:04:45'),
(3, 'stationary', '2021-12-15 11:05:57');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_gstslab_master`
--

CREATE TABLE `tbl_gstslab_master` (
  `gstslab_id` bigint(20) NOT NULL,
  `gstslab_name` varchar(100) NOT NULL,
  `cgst` decimal(18,2) NOT NULL,
  `sgst` decimal(18,2) NOT NULL,
  `igst` decimal(18,2) NOT NULL,
  `added_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_gstslab_master`
--

INSERT INTO `tbl_gstslab_master` (`gstslab_id`, `gstslab_name`, `cgst`, `sgst`, `igst`, `added_date`) VALUES
(1, 'bhautik 14%', '7.00', '7.00', '14.00', '2021-12-11 10:12:35');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_party_master`
--

CREATE TABLE `tbl_party_master` (
  `party_id` bigint(20) NOT NULL,
  `party_group` int(6) NOT NULL,
  `party_name` varchar(100) NOT NULL,
  `mobile_no` bigint(20) NOT NULL,
  `alter_mobile_no` bigint(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `billing_address` varchar(250) NOT NULL,
  `shipping_address` varchar(250) NOT NULL,
  `gst_type` varchar(100) NOT NULL,
  `gst_in` varchar(20) NOT NULL,
  `state` varchar(50) NOT NULL,
  `added_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_party_master`
--

INSERT INTO `tbl_party_master` (`party_id`, `party_group`, `party_name`, `mobile_no`, `alter_mobile_no`, `email`, `billing_address`, `shipping_address`, `gst_type`, `gst_in`, `state`, `added_date`) VALUES
(1, 0, 'mihir', 0, 0, '', '', '', '', '', '', '2021-12-14 11:07:42');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_payment_type`
--

CREATE TABLE `tbl_payment_type` (
  `payment_type_id` bigint(20) NOT NULL,
  `payment_type` varchar(100) NOT NULL,
  `payment_date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_size`
--

CREATE TABLE `tbl_size` (
  `size_id` bigint(20) NOT NULL,
  `size` varchar(100) NOT NULL,
  `added_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_size`
--

INSERT INTO `tbl_size` (`size_id`, `size`, `added_date`) VALUES
(2, 'S', '2021-12-13 10:53:09');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_unit`
--

CREATE TABLE `tbl_unit` (
  `unit_id` bigint(20) NOT NULL,
  `unit_name` varchar(100) NOT NULL,
  `added_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_unit`
--

INSERT INTO `tbl_unit` (`unit_id`, `unit_name`, `added_date`) VALUES
(1, 'miliGram (mg)', '2021-12-13 11:22:49');

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
-- Indexes for table `tbl_color`
--
ALTER TABLE `tbl_color`
  ADD PRIMARY KEY (`color_id`);

--
-- Indexes for table `tbl_company`
--
ALTER TABLE `tbl_company`
  ADD PRIMARY KEY (`company_id`);

--
-- Indexes for table `tbl_expence`
--
ALTER TABLE `tbl_expence`
  ADD PRIMARY KEY (`expence_id`);

--
-- Indexes for table `tbl_expense_type`
--
ALTER TABLE `tbl_expense_type`
  ADD PRIMARY KEY (`expense_id`);

--
-- Indexes for table `tbl_gstslab_master`
--
ALTER TABLE `tbl_gstslab_master`
  ADD PRIMARY KEY (`gstslab_id`);

--
-- Indexes for table `tbl_party_master`
--
ALTER TABLE `tbl_party_master`
  ADD PRIMARY KEY (`party_id`);

--
-- Indexes for table `tbl_payment_type`
--
ALTER TABLE `tbl_payment_type`
  ADD PRIMARY KEY (`payment_type_id`);

--
-- Indexes for table `tbl_size`
--
ALTER TABLE `tbl_size`
  ADD PRIMARY KEY (`size_id`);

--
-- Indexes for table `tbl_unit`
--
ALTER TABLE `tbl_unit`
  ADD PRIMARY KEY (`unit_id`);

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
  MODIFY `category_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_color`
--
ALTER TABLE `tbl_color`
  MODIFY `color_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_company`
--
ALTER TABLE `tbl_company`
  MODIFY `company_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_expence`
--
ALTER TABLE `tbl_expence`
  MODIFY `expence_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_expense_type`
--
ALTER TABLE `tbl_expense_type`
  MODIFY `expense_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_gstslab_master`
--
ALTER TABLE `tbl_gstslab_master`
  MODIFY `gstslab_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_party_master`
--
ALTER TABLE `tbl_party_master`
  MODIFY `party_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_payment_type`
--
ALTER TABLE `tbl_payment_type`
  MODIFY `payment_type_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_size`
--
ALTER TABLE `tbl_size`
  MODIFY `size_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_unit`
--
ALTER TABLE `tbl_unit`
  MODIFY `unit_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
