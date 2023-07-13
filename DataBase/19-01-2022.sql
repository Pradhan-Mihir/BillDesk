-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 19, 2022 at 05:00 PM
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
CREATE DEFINER=`root`@`localhost` PROCEDURE `deleteBarcode_master` (IN `BID` BIGINT(20))  BEGIN
	DELETE FROM tbl_barcode_master WHERE barcode_id = BID;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `deleteCashmemo` (IN `ID` BIGINT(20))  BEGIN
	DELETE FROM tbl_cashmemo_detail  WHERE cashmemo_id  = ID;
	DELETE FROM tbl_cashmemo WHERE cashmemo_id  = ID;
END$$

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

CREATE DEFINER=`root`@`localhost` PROCEDURE `deleteFinancial_master` (IN `EID` BIGINT(20))  BEGIN
	DELETE FROM tbl_financial_master WHERE financial_id = EID;
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `deleteProduct_master` (IN `PID` BIGINT(20))  BEGIN
  DELETE FROM tbl_product_master  WHERE product_id = PID;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `deletePurchase_invoice` (IN `PROID` BIGINT(20))  BEGIN
	 DELETE FROM tbl_purchase_invoice_detail  WHERE purchase_invoice_id  = PROID;
	DELETE FROM tbl_purchase_invoice  WHERE purchase_invoice_id  = PROID;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `deleteSales_invoice` (IN `SID` BIGINT(20))  BEGIN
	DELETE FROM tbl_sales_invoice_detail  WHERE sales_invoice_id  = SID;
	DELETE FROM tbl_sales_invoice WHERE sales_invoice_id  = SID;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `deleteSales_return` (IN `SID` BIGINT(20))  BEGIN
	DELETE FROM tbl_sales_return_detail  WHERE sales_return_id = SID ;
	DELETE FROM tbl_sales_return WHERE sales_return_id = SID ;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `deleteSize` (IN `SID` BIGINT(20))  BEGIN
	DELETE FROM tbl_size WHERE size_id = SID ;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `deleteUnit` (IN `UID` BIGINT(20))  BEGIN
	DELETE FROM tbl_unit WHERE unit_id = UID ;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `fetchBarcode_master` (IN `BID` BIGINT(20))  BEGIN
	SELECT * FROM tbl_barcode_master WHERE barcode_id =BID;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `fetchCashmemo` (IN `ID` BIGINT(20))  BEGIN
	SELECT * FROM tbl_cashmemo WHERE cashmemo_id = ID;
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `fetchFinancial_master` (IN `FID` BIGINT(20))  BEGIN
	SELECT * FROM tbl_financial_master WHERE financial_id = FID;
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `fetchProduct_master` (IN `PID` BIGINT(20))  BEGIN
  SELECT * FROM tbl_product_master WHERE product_id = PID;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `fetchPurchaseinvoice` (IN `PROID` BIGINT(20))  BEGIN
	SELECT * FROM tbl_purchase_invoice WHERE purchase_invoice_id = PROID;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `fetchSales_invoice` (IN `PROID` BIGINT(20))  BEGIN
	SELECT * FROM tbl_sales_invoice WHERE sales_invoice_id = PROID;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `fetchSales_return` (IN `SID` BIGINT(20))  BEGIN
	SELECT * FROM tbl_sales_return WHERE sales_return_id = SID;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `fetchSize` (IN `SID` BIGINT(20))  BEGIN
	SELECT * FROM tbl_size WHERE size_id = SID;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `fetchUnit` (IN `UID` BIGINT(20))  BEGIN
	SELECT * FROM tbl_unit WHERE unit_id = UID ;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insertBarcode_master` (IN `CID` BIGINT(20), IN `BCODE` VARCHAR(100), IN `PNAME` VARCHAR(100), IN `PCODE` VARCHAR(100), IN `GID` BIGINT(20), IN `SRATE` DECIMAL(18,2), IN `MDATE` DATE, IN `EDATE` DATE, IN `SBARCODE` INT(11), IN `PBARCODE` INT(11), IN `ISB` TINYINT(4))  BEGIN 

INSERT INTO tbl_barcode_master (company_id , barcode , product_name ,product_code ,gstslab_id,sales_rate,mfg_date,exp_date,start_barcode_from,print_barcode_at , is_show_barcode) VALUES(CID , BCODE , PNAME , PCODE , GID ,SRATE , MDATE , EDATE , SBARCODE , PBARCODE,ISB);

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insertCashmemo` (IN `CIN` BIGINT, IN `CNAME` VARCHAR(50), IN `CMOBILE` BIGINT, IN `INV` BIGINT, IN `STAT` VARCHAR(50), IN `SDATE` DATE, IN `PAYID` BIGINT, IN `NAR` VARCHAR(500), IN `SUB` DECIMAL(18,2), IN `SAMOUNT` DECIMAL(18,2), IN `ISROUND` BIT, IN `ROFF` DECIMAL(18,2), IN `TOT` DECIMAL(18,2), IN `PAYAMT` DECIMAL(18,2), IN `FID` BIGINT, IN `NEWINV` VARCHAR(50))  BEGIN
  INSERT INTO tbl_cashmemo(company_id , customer_name, customer_mobile , invoice_no , state_of_supply , sales_invoice_date, payment_type_id , narration , sub_total , shipping_packing_amount , is_round_off , round_off , total , pay , financial_id , new_invoice_no) 
  VALUES (CIN , CNAME , CMOBILE , INV , STAT , SDATE , PAYID , NAR , SUB , SAMOUNT , ISROUND , ROFF , TOT , PAYAMT , FID , NEWINV );
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insertCategory` (IN `CAT_CODE` VARCHAR(100), IN `CAT_NAME` VARCHAR(100), IN `CID` BIGINT(20))  BEGIN
	INSERT INTO  tbl_category (category_code , category_name ,company_id) values (CAT_CODE,CAT_NAME ,CID);	
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insertColor` (IN `CTYPE` VARCHAR(100))  BEGIN
	INSERT INTO tbl_color (color_name) VALUES (CTYPE);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insertCompany` (IN `CNAME` VARCHAR(100), IN `MOBILE` BIGINT(20), IN `ALT_MOBILE` BIGINT(10), IN `EMAIL` VARCHAR(100), IN `ADDRESS` VARCHAR(500), IN `CITY` VARCHAR(50), IN `STATE` VARCHAR(50), IN `PINCODE` BIGINT(6), IN `GST` VARCHAR(20), IN `BANKNAME` VARCHAR(100), IN `ACNO` BIGINT(20), IN `IFSC` VARCHAR(20), IN `PAN` VARCHAR(20), IN `TIN` VARCHAR(20), IN `CST` VARCHAR(20), IN `STAX` VARCHAR(20), IN `LIC` VARCHAR(20), IN `LOGO` VARCHAR(2000), IN `ISDEFAULT` BIT(1))  BEGIN
IF ISDEFAULT = 1 
	THEN 
		UPDATE tbl_company SET is_default = 0; 
	END IF;

	INSERT INTO  tbl_company ( company_name , mobile_no , alter_mobile_no , email , address , city , state , pincode , gst_in_no , bank_name , ac_no , ifsc , pan_no , tin_no , cst_no , stax_no , general_lic_no , company_logo ,is_default)
	values ( CNAME , MOBILE , ALT_MOBILE , EMAIL , ADDRESS , CITY , STATE , PINCODE , GST , BANKNAME , ACNO , IFSC , PAN , TIN , CST , STAX , LIC , LOGO , ISDEFAULT);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insertExpence` (IN `NAME` VARCHAR(100), IN `CATEGORY` BIGINT(20), IN `AMT` BIGINT(20), IN `FID` BIGINT(20), IN `CID` BIGINT(20))  BEGIN
	INSERT INTO tbl_expence (expence_name , expense_id , expence_amount,financial_id,company_id ) VALUES (NAME , CATEGORY , AMT,FID,CID);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insertExpense_type` (IN `ENAME` VARCHAR(100))  BEGIN
	INSERT INTO tbl_expense_type (expense_name) VALUES (ENAME);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insertFinancial_master` (IN `FYEAR` BIGINT(20), IN `FNAME` VARCHAR(100), IN `SDATE` DATE, IN `EDATE` DATE, IN `ISDEFAULT` BIT(1), IN `UID` BIGINT(20))  BEGIN
  IF ISDEFAULT = 1 THEN
      UPDATE tbl_financial_master SET is_default = 0;
       END IF;
  INSERT INTO tbl_financial_master (financial_year , financial_name , start_date ,end_date ,is_default,user_id)  VALUES(FYEAR , FNAME , SDATE , EDATE , ISDEFAULT ,UID);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insertGstslab` (IN `NAME` VARCHAR(100), IN `C_GST` DECIMAL(18,2), IN `S_GST` DECIMAL(18,2), IN `I_GST` DECIMAL(18,2), IN `CID` BIGINT(20))  BEGIN
	INSERT INTO tbl_gstslab_master ( gstslab_name , cgst , sgst , igst,company_id) VALUES ( NAME , C_GST , S_GST , I_GST,CID);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insertManageUser` (IN `UNAME` VARCHAR(100), IN `FNAME` VARCHAR(100), IN `EMAIL` VARCHAR(100), IN `MOBILE` BIGINT(10), IN `PWD` VARCHAR(20), IN `UIMG` VARCHAR(2000))  BEGIN
	INSERT INTO  manage_user_tbl (username, full_name, email, mobile, passward, user_image) values (UNAME, FNAME, EMAIL , MOBILE , PWD , UIMG );
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insertParty_master` (IN `GRP` INT(6), IN `NAME` VARCHAR(100), IN `MOBILE` BIGINT(20), IN `ALT_MOBILE` BIGINT(20), IN `EML` VARCHAR(100), IN `BILL_ADD` VARCHAR(250), IN `SHIP_ADD` VARCHAR(250), IN `GST_TYP` VARCHAR(100), IN `GSTIN` VARCHAR(20), IN `STAT` VARCHAR(50), IN `CID` INT(20))  BEGIN
	INSERT INTO tbl_party_master (party_group,party_name, mobile_no,alter_mobile_no,email,billing_address,shipping_address, gst_type,gst_in,state,company_id) VALUES (GRP,NAME,MOBILE,ALT_MOBILE,EML, BILL_ADD,SHIP_ADD,GST_TYP,GSTIN,STAT,CID);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insertPayment_type` (IN `PTYPE` VARCHAR(100))  BEGIN
	INSERT INTO tbl_payment_type ( payment_type) VALUES (PTYPE);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insertProduct_master` (IN `CID` BIGINT(20), IN `CAT` BIGINT(20), IN `BAR` VARCHAR(50), IN `PCODE` VARCHAR(50), IN `PNAME` VARCHAR(100), IN `GSTID` BIGINT(20), IN `HSN` VARCHAR(50), IN `UID` BIGINT(20), IN `PRATE` DECIMAL(18,2), IN `PTAX` VARCHAR(50), IN `SRATE` DECIMAL(18,2), IN `STAX` VARCHAR(50), IN `OPSTOCK` DECIMAL(18,2), IN `UPP` DECIMAL(18,2), IN `DES` VARCHAR(500), IN `MIN` DECIMAL(18,3), IN `PLOC` VARCHAR(100), IN `PDATE` DATE, IN `PIMG` VARCHAR(2000))  BEGIN
  INSERT INTO tbl_product_master (company_id , category_id , barcode , product_code , product_name , gstslab_id , hsn_code , unit_id , purchase_rate , purchase_tax_type , sales_rate , sales_tax_type , opening_stock , unit_per_price , description , min_stock_qty , product_location , product_date , product_image) 
  VALUES (CID , CAT , BAR , PCODE , PNAME , GSTID , HSN , UID , PRATE , PTAX , SRATE , STAX , OPSTOCK , UPP , DES , MIN , PLOC , PDATE , PIMG);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insertPurchase_invoice` (IN `CIN` BIGINT(20), IN `PID` BIGINT(20), IN `ROID` VARCHAR(50), IN `INVOICE` BIGINT(20), IN `STAT` VARCHAR(50), IN `PDATE` DATE, IN `PAYID` BIGINT(20), IN `NAR` VARCHAR(500), IN `SUB` DECIMAL(18,2), IN `SAMOUNT` DECIMAL(18,2), IN `ISROUND` BIT(1), IN `RNDOFF` DECIMAL(18,2), IN `TOT` DECIMAL(18,2), IN `PAY` DECIMAL(18,2), IN `FID` BIGINT(20), IN `NEWINV` VARCHAR(50))  BEGIN INSERT INTO tbl_purchase_invoice(company_id , party_id , ref_order_id , invoice_no , state_of_supply , purchase_invoice_date , payment_type_id , narration , sub_total , shipping_packing_ammount , is_round_off , round_off , total , pay , financial_id , new_invoice_no) VALUES (CIN , PID , ROID , INVOICE , STAT , PDATE , PAYID , NAR , SUB , SAMOUNT , ISROUND , RNDOFF , TOT , PAY , FID , NEWINV ); END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insertSales_invoice` (IN `CIN` BIGINT, IN `PID` BIGINT, IN `INV` BIGINT, IN `STAT` VARCHAR(50), IN `SDATE` DATE, IN `PAYID` BIGINT, IN `NAR` VARCHAR(500), IN `SUB` DECIMAL(18,2), IN `SAMOUNT` DECIMAL(18,2), IN `ISROUND` BIT, IN `ROFF` DECIMAL(18,2), IN `TOT` DECIMAL(18,2), IN `PAYAMT` DECIMAL(18,2), IN `FID` BIGINT, IN `NEWINV` VARCHAR(50))  BEGIN
  INSERT INTO tbl_sales_invoice(company_id , party_id , invoice_no , state_of_supply , sales_invoice_date, payment_type_id , narration , sub_total , shipping_packing_amount , is_round_off , round_off , total , pay , financial_id , new_invoice_no) 
  VALUES (CIN , PID , INV , STAT , SDATE , PAYID , NAR , SUB , SAMOUNT , ISROUND , ROFF , TOT , PAYAMT , FID , NEWINV );
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insertSales_return` (IN `CIN` BIGINT, IN `PID` BIGINT, IN `INV` BIGINT, IN `STAT` VARCHAR(50), IN `SDATE` DATE, IN `PAYID` BIGINT, IN `NAR` VARCHAR(500), IN `SUB` DECIMAL(18,2), IN `SAMOUNT` DECIMAL(18,2), IN `ISROUND` BIT, IN `ROFF` DECIMAL(18,2), IN `TOT` DECIMAL(18,2), IN `PAYAMT` DECIMAL(18,2), IN `FID` BIGINT, IN `NEWINV` VARCHAR(50))  BEGIN
  INSERT INTO tbl_sales_return(company_id , party_id , invoice_no , state_of_supply , sales_return_date , payment_type_id , narration , sub_total , shipping_packing_amount , is_round_off , round_off , total , pay , financial_id , new_invoice_no) 
  VALUES (CIN , PID , INV , STAT , SDATE , PAYID , NAR , SUB , SAMOUNT , ISROUND , ROFF , TOT , PAYAMT , FID , NEWINV );
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insertSize` (IN `STYPE` VARCHAR(100))  BEGIN
	INSERT INTO tbl_size (size) VALUES (STYPE);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insertUnit` (IN `UTYPE` VARCHAR(100))  BEGIN
	INSERT INTO tbl_unit (unit_name) VALUES (UTYPE);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `updateBarcode_master` (IN `BID` BIGINT(20), IN `BCODE` VARCHAR(100), IN `PNAME` VARCHAR(100), IN `PCODE` VARCHAR(100), IN `GID` BIGINT(20), IN `SRATE` DECIMAL(18,2), IN `MDATE` DATE, IN `EDATE` DATE, IN `SBARCODE` INT(11), IN `PBARCODE` INT(11), IN `ISB` TINYINT(4))  BEGIN
	UPDATE  tbl_barcode_master SET barcode = BCODE, product_name = PNAME , product_code = PCODE,gstslab_id = GID , sales_rate = SRATE , mfg_date = MDATE, exp_date = EDATE , start_barcode_from = SBARCODE, print_barcode_at = PBARCODE, is_show_barcode=ISB where barcode_id = BID ;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `updateCategory` (IN `CAT_ID` BIGINT(20), IN `CAT_CODE` VARCHAR(100), IN `CAT_NAME` VARCHAR(100))  BEGIN
  UPDATE tbl_category SET category_code = CAT_CODE , category_name = CAT_NAME WHERE category_id = CAT_ID;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `updateColor` (IN `CID` BIGINT(20), IN `CTYPE` VARCHAR(100))  BEGIN
	UPDATE tbl_color SET color_name = CTYPE WHERE color_id = CID; 
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `updateCompany` (IN `CID` BIGINT(20), IN `CNAME` VARCHAR(100), IN `MOBILE` BIGINT(20), IN `ALT_MOBILE` BIGINT(10), IN `EMAIL` VARCHAR(100), IN `ADDRESS` VARCHAR(500), IN `CITY` VARCHAR(50), IN `STATE` VARCHAR(50), IN `PINCODE` BIGINT(6), IN `GST` VARCHAR(20), IN `BANKNAME` VARCHAR(100), IN `ACNO` BIGINT(20), IN `IFSC` VARCHAR(20), IN `PAN` VARCHAR(20), IN `TIN` VARCHAR(20), IN `CST` VARCHAR(20), IN `STAX` VARCHAR(20), IN `LIC` VARCHAR(20), IN `LOGO` VARCHAR(2000), IN `ISDEFAULT` BIT(1))  BEGIN
IF ISDEFAULT=1
THEN
	UPDATE tbl_company SET is_default = 0;
END IF;
	UPDATE  tbl_company SET company_name = CNAME, mobile_no = MOBILE , alter_mobile_no = ALT_MOBILE, email = EMAIL , address = ADDRESS , city = CITY, state = STATE , pincode = PINCODE, gst_in_no = GST, bank_name = BANKNAME, ac_no = ACNO, ifsc = IFSC, pan_no = PAN, tin_no = TIN, cst_no = CST, stax_no = STAX, general_lic_no = LIC, company_logo = LOGO ,is_default=ISDEFAULT  where company_id = CID ;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `updateExpence` (IN `EID` BIGINT(20), IN `NAME` VARCHAR(100), IN `CATEGORY` BIGINT(20), IN `AMT` BIGINT(20))  BEGIN
	UPDATE tbl_expence SET expence_name = NAME, expense_id = CATEGORY, expence_amount = AMT WHERE expence_id = EID;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `updateExpense_type` (IN `EID` BIGINT(20), IN `ENAME` VARCHAR(100))  BEGIN
	UPDATE tbl_expense_type SET expense_name= ENAME WHERE expense_id  = EID ;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `updateFinancial_master` (IN `FID` BIGINT(20), IN `FYEAR` BIGINT(20), IN `FNAME` VARCHAR(100), IN `SDATE` DATE, IN `EDATE` DATE, IN `ISDEFAULT` BIT(1))  BEGIN
IF ISDEFAULT=1
THEN
	UPDATE tbl_financial_master SET is_default = 0;
END IF;      
  	UPDATE tbl_financial_master SET financial_year = FYEAR ,financial_name = FNAME ,start_date = SDATE , end_date = EDATE , is_default = ISDEFAULT WHERE financial_id  = FID;  
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `updateProduct_master` (IN `PID` BIGINT(20), IN `CAT` BIGINT(20), IN `BAR` VARCHAR(50), IN `PCODE` VARCHAR(50), IN `PNAME` VARCHAR(100), IN `GSTID` BIGINT(20), IN `HSN` VARCHAR(50), IN `UID` BIGINT(20), IN `PRATE` DECIMAL(18,2), IN `PTAX` VARCHAR(50), IN `SRATE` DECIMAL(18,2), IN `STAX` VARCHAR(50), IN `OPSTOCK` DECIMAL(18,2), IN `UPP` DECIMAL(18,2), IN `DES` VARCHAR(500), IN `MIN` DECIMAL(18,3), IN `PLOC` VARCHAR(100), IN `PDATE` DATE, IN `PIMG` VARCHAR(2000))  BEGIN
	UPDATE  tbl_product_master SET category_id = CAT, barcode = BAR, product_code = PCODE, product_name = PNAME, gstslab_id = GSTID, hsn_code = HSN, 
	unit_id = UID, purchase_rate = PRATE, purchase_tax_type = PTAX, sales_rate = SRATE, sales_tax_type = STAX, opening_stock = OPSTOCK,
	unit_per_price = UPP, description = DES, min_stock_qty = MIN, product_location = PLOC, product_date = PDATE, product_image= PIMG WHERE product_id = PID;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `updatePurchase_invoice` (IN `PROID` BIGINT(20), IN `CIN` BIGINT(20), IN `PID` BIGINT(20), IN `ROID` VARCHAR(50), IN `INVOICE` BIGINT(20), IN `STATE` VARCHAR(50), IN `PDATE` DATE, IN `PAYID` BIGINT(20), IN `NARRATION` VARCHAR(500), IN `SUBTOTAL` DECIMAL(18,2), IN `SAMOUNT` DECIMAL(18,2), IN `ISROUND` BIT(1), IN `ROUNDOFF` DECIMAL(18,2), IN `TOTAL` DECIMAL(18,2), IN `PAYAMT` DECIMAL(18,2), IN `FID` BIGINT(20), IN `NEWINVOICE` VARCHAR(50))  BEGIN
	UPDATE  tbl_purchase_invoice SET company_id = CIN , party_id = PID , ref_order_id = ROID , invoice_no = INVOICE , state_of_supply = STATE , 
	purchase_invoice_date = PDATE , payment_type_id = PAYID , narration = NARRATION , sub_total = SUBTOTAL , shipping_packing_ammount = SAMOUNT , 
	is_round_off = ISROUND , round_off = ROUNDOFF , total = TOTAL , pay = PAYAMT , financial_id = FID , new_invoice_no = NEWINVOICE WHERE purchase_invoice_id = PROID;
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `viewBarcode_master` ()  BEGIN
	SELECT bar.*, com.company_name
FROM tbl_barcode_master bar 
LEFT JOIN tbl_company com ON com.company_id  = bar.company_id
WHERE com.is_default = 1 ;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `viewCashmemo` ()  BEGIN
	SELECT cm.*  FROM tbl_cashmemo cm
	LEFT JOIN tbl_company com ON com.company_id = cm.company_id
    LEFT JOIN tbl_financial_master fi ON fi.financial_id = cm.financial_id
	WHERE com.is_default = 1 and fi.is_default=1;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `viewCategory` ()  BEGIN
 SELECT com.company_name , cat.* FROM tbl_category cat
LEFT JOIN  tbl_company com ON com.company_id = cat.company_id
WHERE com.is_default = 1;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `viewColor` ()  BEGIN
	SELECT * FROM tbl_color;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `viewCompany` ()  BEGIN
	SELECT * FROM tbl_company;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `viewExpence` ()  BEGIN
SELECT se.expense_name , fin.financial_name ,com.company_name ,  ce.* 
FROM tbl_expence ce 
    LEFT JOIN  tbl_expense_type se ON se.expense_id = ce.expense_id
    LEFT JOIN tbl_financial_master fin ON fin.financial_id  = ce.financial_id
    LEFT JOIN tbl_company com ON com.company_id  = ce.company_id
    WHERE com.is_default = 1 ;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `viewExpense_type` ()  BEGIN
	SELECT * FROM tbl_expense_type ;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `viewFinancial_master` ()  BEGIN
	SELECT * FROM tbl_financial_master;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `viewGstslab` ()  BEGIN

SELECT gst.*, com.company_name
FROM tbl_gstslab_master gst 
LEFT JOIN tbl_company com ON com.company_id  = gst.company_id
WHERE com.is_default = 1 ;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `viewLogin` (IN `UNAME` VARCHAR(25), IN `PWD` VARCHAR(25))  BEGIN
	SELECT * FROM manage_user_tbl WHERE username = UNAME AND passward = PWD;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `viewManageUser` ()  BEGIN
  SELECT * FROM manage_user_tbl;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `viewParty_master` ()  BEGIN
  SELECT par.*, com.company_name
                FROM tbl_party_master par
                LEFT JOIN tbl_company com ON com.company_id  = par.company_id
                WHERE com.is_default = 1 ;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `viewPayment_type` ()  BEGIN
	SELECT * FROM tbl_payment_type ;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `viewProduct_master` ()  BEGIN
	SELECT pro.* , unit.unit_name , com.company_name , gst.gstslab_name ,cat.category_name FROM tbl_product_master pro
	LEFT JOIN tbl_company com ON com.company_id = pro.company_id
	LEFT JOIN tbl_category cat ON cat.category_id = pro.category_id
	LEFT JOIN tbl_unit unit ON unit.unit_id = pro.unit_id
	LEFT JOIN tbl_gstslab_master gst ON gst.gstslab_id = pro.gstslab_id
	WHERE com.is_default = 1;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `viewPurchaseinvoice` ()  BEGIN
	SELECT pi.* , par.party_name  FROM tbl_purchase_invoice pi
	LEFT JOIN tbl_company com ON com.company_id = pi.company_id
    LEFT JOIN tbl_party_master par ON par.party_id = pi.party_id
    LEFT JOIN tbl_financial_master fi ON fi.financial_id = pi.financial_id
	WHERE com.is_default = 1 and fi.is_default=1;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `viewSales_invoice` ()  BEGIN
	SELECT si.* , par.party_name  FROM tbl_sales_invoice si
	LEFT JOIN tbl_company com ON com.company_id = si.company_id
    LEFT JOIN tbl_party_master par ON par.party_id = si.party_id
    LEFT JOIN tbl_financial_master fi ON fi.financial_id = si.financial_id
	WHERE com.is_default = 1 and fi.is_default=1;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `viewSales_return` ()  BEGIN
	SELECT sr.* , par.party_name  FROM tbl_sales_return sr
	LEFT JOIN tbl_company com ON com.company_id = sr.company_id
    LEFT JOIN tbl_party_master par ON par.party_id = sr.party_id
    LEFT JOIN tbl_financial_master fi ON fi.financial_id = sr.financial_id
	WHERE com.is_default = 1 and fi.is_default=1;
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
(1, 'admin', '', 'admin@gmail.com', 9328659886, '123', 'default.png', b'1', '2021-11-26 04:42:56'),
(3, 'bhautik', 'bhautik patel', 'bhautikpatel1201@gmail.com', 9328659886, '123', 'photo_2021-12-07_16-12-40618063.jpg', b'1', '2021-11-26 06:03:44'),
(4, 'mihir', 'mihir pradhan', 'mihirhpradhan@gmail.com', 9376521396, '123', 'IMG_4456666538.PNG', b'1', '2021-11-26 14:41:34'),
(6, 'mansi', 'mansi mansi', 'mansi4653@gmail.com', 9876543210, '123', '', b'0', '2021-12-04 11:15:47'),
(7, 'kp', 'kunal gavar', 'kunalpawar354@gmail.com', 1234567890, '123', 'kunal648133.jpg', b'0', '2021-12-04 11:29:18');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_barcode_master`
--

CREATE TABLE `tbl_barcode_master` (
  `barcode_id` bigint(20) NOT NULL,
  `company_id` bigint(20) NOT NULL,
  `barcode` varchar(100) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `product_code` varchar(100) NOT NULL,
  `gstslab_id` bigint(20) NOT NULL,
  `sales_rate` decimal(18,2) NOT NULL,
  `mfg_date` date NOT NULL,
  `exp_date` date NOT NULL,
  `start_barcode_from` int(11) NOT NULL,
  `print_barcode_at` int(11) NOT NULL,
  `is_show_barcode` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_barcode_master`
--

INSERT INTO `tbl_barcode_master` (`barcode_id`, `company_id`, `barcode`, `product_name`, `product_code`, `gstslab_id`, `sales_rate`, `mfg_date`, `exp_date`, `start_barcode_from`, `print_barcode_at`, `is_show_barcode`) VALUES
(5, 4, 'ABC123PQR', 'Veg Burger', 'V101', 1, '100.00', '2021-12-20', '2021-12-20', 1, 2, 1),
(6, 1, 'XYZ456KLM', 'Pizza', 'P101', 4, '100.00', '2021-12-20', '2021-12-20', 1, 3, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_cashmemo`
--

CREATE TABLE `tbl_cashmemo` (
  `cashmemo_id` bigint(20) NOT NULL,
  `company_id` bigint(20) NOT NULL,
  `customer_name` varchar(50) NOT NULL,
  `customer_mobile` bigint(20) NOT NULL,
  `invoice_no` bigint(20) NOT NULL,
  `out_of_state` tinyint(4) NOT NULL,
  `state_of_supply` varchar(50) NOT NULL,
  `sales_invoice_date` date NOT NULL,
  `payment_type_id` bigint(20) NOT NULL,
  `narration` varchar(500) NOT NULL,
  `sub_total` decimal(18,2) NOT NULL,
  `shipping_packing_amount` decimal(18,2) NOT NULL,
  `is_round_off` bit(1) NOT NULL,
  `round_off` decimal(18,3) NOT NULL,
  `total` decimal(18,2) NOT NULL,
  `pay` decimal(18,2) NOT NULL,
  `financial_id` bigint(20) NOT NULL,
  `new_invoice_no` varchar(50) NOT NULL,
  `is_gst_bill` bit(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_cashmemo`
--

INSERT INTO `tbl_cashmemo` (`cashmemo_id`, `company_id`, `customer_name`, `customer_mobile`, `invoice_no`, `out_of_state`, `state_of_supply`, `sales_invoice_date`, `payment_type_id`, `narration`, `sub_total`, `shipping_packing_amount`, `is_round_off`, `round_off`, `total`, `pay`, `financial_id`, `new_invoice_no`, `is_gst_bill`) VALUES
(1, 4, 'Vasu', 9638527410, 1, 0, 'GUJARAT', '2022-01-19', 1, '', '196.00', '9.00', b'0', '0.000', '205.00', '120.00', 8, '', b'0'),
(3, 4, 'pratik', 741085296, 2, 0, 'ANDAMAN AND NICOBAR ISLANDS', '2022-01-19', 1, '', '1900.00', '100.00', b'0', '0.000', '2000.00', '2000.00', 8, '', b'0');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_cashmemo_detail`
--

CREATE TABLE `tbl_cashmemo_detail` (
  `cashmemo_detail_id` bigint(20) NOT NULL,
  `company_id` bigint(20) NOT NULL,
  `cashmemo_id` bigint(20) NOT NULL,
  `product_id` bigint(20) NOT NULL,
  `unit_id` bigint(20) NOT NULL,
  `unit` varchar(50) NOT NULL,
  `rate` decimal(18,2) NOT NULL,
  `qty` decimal(18,2) NOT NULL,
  `gross_total` decimal(18,2) NOT NULL,
  `disc_per` decimal(18,2) NOT NULL,
  `disc_amt` decimal(18,2) NOT NULL,
  `sub_total` decimal(18,2) NOT NULL,
  `gstslab_id` bigint(20) NOT NULL,
  `gst` decimal(18,2) NOT NULL,
  `gst_per` decimal(18,2) NOT NULL,
  `igst` decimal(18,2) NOT NULL,
  `igst_per` decimal(18,2) NOT NULL,
  `total` decimal(18,2) NOT NULL,
  `financial_id` bigint(20) NOT NULL,
  `new_invoice_no` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_cashmemo_detail`
--

INSERT INTO `tbl_cashmemo_detail` (`cashmemo_detail_id`, `company_id`, `cashmemo_id`, `product_id`, `unit_id`, `unit`, `rate`, `qty`, `gross_total`, `disc_per`, `disc_amt`, `sub_total`, `gstslab_id`, `gst`, `gst_per`, `igst`, `igst_per`, `total`, `financial_id`, `new_invoice_no`) VALUES
(1, 4, 1, 2, 1, 'kilogram(kg)', '2.00', '100.00', '196.00', '2.00', '4.00', '0.00', 3, '0.00', '0.00', '0.00', '0.00', '0.00', 8, ''),
(2, 4, 3, 2, 1, 'kilogram(kg)', '2.00', '1000.00', '1900.00', '5.00', '100.00', '0.00', 3, '0.00', '0.00', '0.00', '0.00', '0.00', 8, '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_category`
--

CREATE TABLE `tbl_category` (
  `category_id` bigint(20) NOT NULL,
  `category_code` varchar(100) NOT NULL,
  `category_name` varchar(100) NOT NULL,
  `company_id` bigint(20) NOT NULL,
  `category_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_category`
--

INSERT INTO `tbl_category` (`category_id`, `category_code`, `category_name`, `company_id`, `category_date`) VALUES
(1, 'm001', 'mihir', 1, '2021-12-11 09:31:49'),
(2, 'C101', 'Soft Drink', 4, '2021-12-18 15:22:34'),
(4, 'C102', 'Pizza', 4, '2021-12-23 05:17:25'),
(5, 'C103', 'Sandwich', 4, '2021-12-23 05:17:35'),
(6, 'C104', 'Burger', 4, '2021-12-23 05:17:48'),
(7, 'C105', 'Chinese', 4, '2021-12-23 05:18:03'),
(8, 'C105', 'sizler', 4, '2021-12-23 05:18:14');

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
(2, 'GREEN', '2021-12-13 11:29:15'),
(14, 'BLUE', '2021-12-15 15:12:01'),
(15, 'RED', '2021-12-15 15:12:06');

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
(1, 'mihir', 9376521396, 4185123685, 'mihir.pradhan.786@gmail.com', 'Pandesara', 'SURAT', '', 394221, 'fghj', 'dfghj', 84518451, '7yfugi', 'pann', 'ybunk9', 'csttt', '8451', 'gybjn845', '4713431738955.jpg', 0),
(4, 'bhautik', 9637521485, 6541239650, 'mihir.pradhan.786@gmail.com', 'Pandesara', 'SURAT', 'Gujarat', 394221, 'fghj', 'dfghj', 52146325, '7yfugi', 'bca', 'gyujnk', 'abc', 'yuhbj', 'gybjn845', 'photo_2021-12-07_16-12-40980284.jpg', 1);

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
  `financial_id` bigint(20) NOT NULL,
  `company_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_expence`
--

INSERT INTO `tbl_expence` (`expence_id`, `expence_name`, `expense_id`, `expence_amount`, `expence_date`, `financial_id`, `company_id`) VALUES
(3, 'xerox', 3, 56, '2021-12-17', 8, 1),
(4, 'chai', 2, 50, '2021-12-17', 8, 1),
(5, 'water line', 1, 51659, '2021-12-17', 17, 4),
(6, 'be fees', 2, 8520, '2021-12-17', 20, 4),
(7, 'Samosa', 2, 17, '2021-12-19', 8, 4);

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
(2, 'drink', '2021-12-15 11:04:45'),
(3, 'stationary', '2021-12-15 11:05:57');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_financial_master`
--

CREATE TABLE `tbl_financial_master` (
  `financial_id` bigint(20) NOT NULL,
  `financial_year` bigint(20) NOT NULL,
  `financial_name` varchar(100) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `is_default` bit(1) NOT NULL DEFAULT b'0',
  `user_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_financial_master`
--

INSERT INTO `tbl_financial_master` (`financial_id`, `financial_year`, `financial_name`, `start_date`, `end_date`, `is_default`, `user_id`) VALUES
(8, 2021, '2021-2022', '2021-04-01', '2022-03-31', b'1', 1),
(9, 2020, '2020-2021', '2020-04-01', '2021-03-31', b'0', 1),
(14, 2024, '2024-2025', '2024-04-01', '2025-03-31', b'0', 1),
(17, 2021, '2021-2022', '2021-04-01', '2022-03-31', b'0', 1),
(20, 2080, '2080-2081', '2080-04-01', '2081-03-31', b'0', 1);

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
  `added_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `company_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_gstslab_master`
--

INSERT INTO `tbl_gstslab_master` (`gstslab_id`, `gstslab_name`, `cgst`, `sgst`, `igst`, `added_date`, `company_id`) VALUES
(1, 'bhautik 14%', '7.00', '7.00', '14.00', '2021-12-11 10:12:35', 1),
(3, 'mihir12%', '6.00', '6.00', '12.00', '2021-12-19 05:19:15', 4),
(4, 'mansi2%', '1.00', '1.00', '2.00', '2021-12-19 05:27:17', 4);

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
  `added_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `company_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_party_master`
--

INSERT INTO `tbl_party_master` (`party_id`, `party_group`, `party_name`, `mobile_no`, `alter_mobile_no`, `email`, `billing_address`, `shipping_address`, `gst_type`, `gst_in`, `state`, `added_date`, `company_id`) VALUES
(1, 0, 'mihir', 9376521396, 9328659886, 'mihirhpradhan@gmail.com', 'bhestan,surat', 'althan,surat', 'SGST', 'asdf123', 'GUJARAT', '2021-12-14 11:07:42', 4),
(3, 0, 'kp', 9638527410, 7894561230, 'kp@gmail.com', 'katargam', 'sugc', 'SGST', 'fghj', 'GOA', '2021-12-19 05:29:05', 4),
(4, 0, 'bhautik', 9328659886, 9016896222, 'bhautikpatel1201@gmail.com', 'Shivparnam residency', 'shivpranam residency', 'CGST', '1234667', 'GUJARAT', '2022-01-10 10:53:15', 4);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_payment_type`
--

CREATE TABLE `tbl_payment_type` (
  `payment_type_id` bigint(20) NOT NULL,
  `payment_type` varchar(100) NOT NULL,
  `payment_date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_payment_type`
--

INSERT INTO `tbl_payment_type` (`payment_type_id`, `payment_type`, `payment_date`) VALUES
(1, 'cash', '2021-12-18'),
(2, 'cheque', '2021-12-31');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_product_master`
--

CREATE TABLE `tbl_product_master` (
  `product_id` bigint(20) NOT NULL,
  `company_id` bigint(20) NOT NULL,
  `category_id` bigint(20) NOT NULL,
  `barcode` varchar(50) NOT NULL,
  `product_code` varchar(50) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `gstslab_id` bigint(20) NOT NULL,
  `hsn_code` varchar(50) NOT NULL,
  `unit_id` bigint(20) NOT NULL,
  `purchase_rate` decimal(18,2) NOT NULL,
  `purchase_tax_type` varchar(50) NOT NULL,
  `sales_rate` decimal(18,2) NOT NULL,
  `sales_tax_type` varchar(50) NOT NULL,
  `opening_stock` decimal(18,3) NOT NULL,
  `unit_per_price` decimal(18,2) NOT NULL,
  `description` varchar(500) NOT NULL,
  `min_stock_qty` decimal(18,3) NOT NULL,
  `product_location` varchar(100) NOT NULL,
  `product_date` date NOT NULL,
  `product_image` varchar(2000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_product_master`
--

INSERT INTO `tbl_product_master` (`product_id`, `company_id`, `category_id`, `barcode`, `product_code`, `product_name`, `gstslab_id`, `hsn_code`, `unit_id`, `purchase_rate`, `purchase_tax_type`, `sales_rate`, `sales_tax_type`, `opening_stock`, `unit_per_price`, `description`, `min_stock_qty`, `product_location`, `product_date`, `product_image`) VALUES
(1, 4, 5, 'abc', '123', 'pepsi', 3, '456', 1, '69.00', 'Excluding Gst', '210.00', 'Excluding Gst', '25.000', '12.00', 'rxdtcfygvuhbinjkm', '15.000', '65', '1212-12-12', '49abdd0f08f1c2092b274b95b7af3ee5780884.jpg'),
(2, 4, 2, 'pqr', 'blue001', 'black', 3, '123', 1, '1.00', 'Including Gst', '2.00', 'Including Gst', '0.000', '10.00', 'ok test 123', '2600.000', 'surat', '2021-12-09', 'crop721678.jpg'),
(5, 4, 6, '123PQR456', 'B102', 'pen', 3, 'nvb', 14, '79.00', 'Including Gst', '89.00', 'Including Gst', '100.000', '89.00', 'non veg burger with meat', '50.000', 'surat', '2021-12-23', 'burger755322.png'),
(6, 4, 4, '456XYZ789', 'P101', 'pencil', 3, 'pm', 1, '99.00', 'Including Gst', '120.00', 'Including Gst', '50.000', '120.00', 'margerita with extra cheese', '50.000', 'surat', '2021-12-23', 'margerita756610.jpg'),
(7, 4, 2, '980DFG021', 'P102', 'eraser', 3, 'pbth', 1, '110.00', 'Including Gst', '120.00', 'Including Gst', '100.000', '120.00', '', '100.000', 'surat', '2021-12-23', 'burn to hell825075.jpg'),
(8, 4, 2, 'ASDFGHJKL', 'S101', 'white_nerd', 3, 'PSp', 1, '50.00', 'Including Gst', '90.00', 'Including Gst', '50.000', '90.00', '', '50.000', 'surat', '2021-12-24', 'pepsi726713.jpg'),
(9, 4, 2, 'ZXCVBNMLk', 'P102', 'Coca-cola', 4, 'Ccc', 1, '60.00', 'Including Gst', '120.00', 'Including Gst', '50.000', '120.00', '', '50.000', 'surat', '2021-12-24', 'coca-cola856207.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_purchase_invoice`
--

CREATE TABLE `tbl_purchase_invoice` (
  `purchase_invoice_id` bigint(20) NOT NULL,
  `company_id` bigint(20) NOT NULL,
  `party_id` bigint(20) NOT NULL,
  `ref_order_id` varchar(50) NOT NULL,
  `invoice_no` bigint(20) NOT NULL,
  `out_of_state` tinyint(4) NOT NULL,
  `state_of_supply` varchar(50) NOT NULL,
  `purchase_invoice_date` date NOT NULL,
  `payment_type_id` bigint(20) NOT NULL,
  `narration` varchar(500) NOT NULL,
  `sub_total` decimal(18,2) NOT NULL,
  `shipping_packing_ammount` decimal(18,2) NOT NULL,
  `is_round_off` bit(1) NOT NULL,
  `round_off` decimal(18,2) NOT NULL,
  `total` decimal(18,2) NOT NULL,
  `pay` decimal(18,2) NOT NULL,
  `financial_id` bigint(20) NOT NULL,
  `new_invoice_no` varchar(50) NOT NULL,
  `is_gst_bill` bit(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_purchase_invoice`
--

INSERT INTO `tbl_purchase_invoice` (`purchase_invoice_id`, `company_id`, `party_id`, `ref_order_id`, `invoice_no`, `out_of_state`, `state_of_supply`, `purchase_invoice_date`, `payment_type_id`, `narration`, `sub_total`, `shipping_packing_ammount`, `is_round_off`, `round_off`, `total`, `pay`, `financial_id`, `new_invoice_no`, `is_gst_bill`) VALUES
(4, 4, 1, '101', 2, 0, 'GUJARAT', '2022-01-08', 1, 'cvbnm', '487.50', '50.00', b'1', '0.50', '538.00', '540.00', 8, '', b'0'),
(15, 4, 1, '123XYZ', 3, 0, 'GUJARAT', '2022-01-08', 1, 'asdfghjkl', '491.00', '9.00', b'1', '0.00', '500.00', '500.00', 8, '', b'0');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_purchase_invoice_detail`
--

CREATE TABLE `tbl_purchase_invoice_detail` (
  `purchase_invoice_detail_id` bigint(20) NOT NULL,
  `company_id` bigint(20) NOT NULL,
  `purchase_invoice_id` bigint(20) NOT NULL,
  `product_id` bigint(20) NOT NULL,
  `unit_id` bigint(20) NOT NULL,
  `unit` varchar(50) NOT NULL,
  `rate` decimal(18,2) NOT NULL,
  `qty` decimal(18,2) NOT NULL,
  `gross_total` decimal(18,2) NOT NULL,
  `disc_per` decimal(18,2) NOT NULL,
  `disc_amt` decimal(18,2) NOT NULL,
  `sub_total` decimal(18,2) NOT NULL,
  `gstslab_id` bigint(20) NOT NULL,
  `gst` decimal(18,2) NOT NULL,
  `gst_per` decimal(18,2) NOT NULL,
  `igst` decimal(18,2) NOT NULL,
  `igst_per` decimal(18,2) NOT NULL,
  `total` decimal(18,2) NOT NULL,
  `financial_id` bigint(20) NOT NULL,
  `new_invoice_no` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_purchase_invoice_detail`
--

INSERT INTO `tbl_purchase_invoice_detail` (`purchase_invoice_detail_id`, `company_id`, `purchase_invoice_id`, `product_id`, `unit_id`, `unit`, `rate`, `qty`, `gross_total`, `disc_per`, `disc_amt`, `sub_total`, `gstslab_id`, `gst`, `gst_per`, `igst`, `igst_per`, `total`, `financial_id`, `new_invoice_no`) VALUES
(5, 4, 15, 5, 0, '', '10.00', '10.00', '1.00', '99.00', '0.00', '0.00', 3, '0.00', '0.00', '0.00', '0.00', '0.00', 8, ''),
(6, 4, 15, 6, 0, '', '20.00', '20.00', '2.00', '392.00', '0.00', '0.00', 0, '0.00', '0.00', '0.00', '0.00', '0.00', 8, ''),
(14, 4, 4, 8, 1, 'kilogram(kg)', '50.00', '10.00', '487.50', '2.50', '12.50', '0.00', 3, '0.00', '0.00', '0.00', '0.00', '0.00', 8, '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sales_invoice`
--

CREATE TABLE `tbl_sales_invoice` (
  `sales_invoice_id` bigint(20) NOT NULL,
  `company_id` bigint(20) NOT NULL,
  `party_id` bigint(20) NOT NULL,
  `invoice_no` bigint(20) NOT NULL,
  `out_of_state` tinyint(4) NOT NULL,
  `state_of_supply` varchar(50) NOT NULL,
  `sales_invoice_date` date NOT NULL,
  `payment_type_id` bigint(20) NOT NULL,
  `narration` varchar(500) NOT NULL,
  `sub_total` decimal(18,2) NOT NULL,
  `shipping_packing_amount` decimal(18,2) NOT NULL,
  `is_round_off` bit(1) NOT NULL,
  `round_off` decimal(18,2) NOT NULL,
  `total` decimal(18,2) NOT NULL,
  `pay` decimal(18,2) NOT NULL,
  `financial_id` bigint(20) NOT NULL,
  `new_invoice_no` varchar(50) NOT NULL,
  `is_gst_bill` bit(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_sales_invoice`
--

INSERT INTO `tbl_sales_invoice` (`sales_invoice_id`, `company_id`, `party_id`, `invoice_no`, `out_of_state`, `state_of_supply`, `sales_invoice_date`, `payment_type_id`, `narration`, `sub_total`, `shipping_packing_amount`, `is_round_off`, `round_off`, `total`, `pay`, `financial_id`, `new_invoice_no`, `is_gst_bill`) VALUES
(20, 4, 3, 1, 0, 'GOA', '2022-01-19', 1, 'asdfghjkl', '1513.88', '7.00', b'1', '0.13', '1521.00', '1521.00', 8, 'zxcvbnm', b'0'),
(21, 4, 4, 2, 0, 'GUJARAT', '2022-01-19', 1, '', '210.00', '0.00', b'0', '0.00', '210.00', '0.00', 8, '', b'0');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sales_invoice_detail`
--

CREATE TABLE `tbl_sales_invoice_detail` (
  `sales_invoice_detail_id` bigint(20) NOT NULL,
  `company_id` bigint(20) NOT NULL,
  `sales_invoice_id` bigint(20) NOT NULL,
  `product_id` bigint(20) NOT NULL,
  `unit_id` bigint(20) NOT NULL,
  `unit` varchar(50) NOT NULL,
  `rate` decimal(18,2) NOT NULL,
  `qty` decimal(18,2) NOT NULL,
  `gross_total` decimal(18,2) NOT NULL,
  `disc_per` decimal(18,2) NOT NULL,
  `disc_amt` decimal(18,2) NOT NULL,
  `sub_total` decimal(18,2) NOT NULL,
  `gstslab_id` bigint(20) NOT NULL,
  `gst` decimal(18,2) NOT NULL,
  `gst_per` decimal(18,2) NOT NULL,
  `igst` decimal(18,2) NOT NULL,
  `igst_per` decimal(18,2) NOT NULL,
  `total` decimal(18,2) NOT NULL,
  `financial_id` bigint(20) NOT NULL,
  `new_invoice_no` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_sales_invoice_detail`
--

INSERT INTO `tbl_sales_invoice_detail` (`sales_invoice_detail_id`, `company_id`, `sales_invoice_id`, `product_id`, `unit_id`, `unit`, `rate`, `qty`, `gross_total`, `disc_per`, `disc_amt`, `sub_total`, `gstslab_id`, `gst`, `gst_per`, `igst`, `igst_per`, `total`, `financial_id`, `new_invoice_no`) VALUES
(26, 4, 20, 5, 0, '', '89.00', '5.00', '433.88', '2.50', '11.13', '0.00', 3, '0.00', '0.00', '0.00', '0.00', '0.00', 8, 'zxcvbnm'),
(27, 4, 20, 6, 1, 'kilogram(kg)', '120.00', '10.00', '1080.00', '10.00', '120.00', '0.00', 3, '0.00', '0.00', '0.00', '0.00', '0.00', 8, 'zxcvbnm'),
(28, 4, 21, 1, 1, 'kilogram(kg)', '210.00', '1.00', '210.00', '0.00', '0.00', '0.00', 3, '0.00', '0.00', '0.00', '0.00', '0.00', 8, '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sales_return`
--

CREATE TABLE `tbl_sales_return` (
  `sales_return_id` bigint(20) NOT NULL,
  `company_id` bigint(20) NOT NULL,
  `party_id` bigint(20) NOT NULL,
  `invoice_no` bigint(20) NOT NULL,
  `out_of_state` tinyint(4) NOT NULL,
  `state_of_supply` varchar(50) NOT NULL,
  `sales_return_date` date NOT NULL,
  `payment_type_id` bigint(20) NOT NULL,
  `narration` varchar(500) NOT NULL,
  `sub_total` decimal(18,2) NOT NULL,
  `shipping_packing_amount` decimal(18,2) NOT NULL,
  `is_round_off` bit(1) NOT NULL,
  `round_off` decimal(18,2) NOT NULL,
  `total` decimal(18,2) NOT NULL,
  `pay` decimal(18,2) NOT NULL,
  `financial_id` bigint(20) NOT NULL,
  `new_invoice_no` varchar(50) NOT NULL,
  `is_gst_bill` bit(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_sales_return`
--

INSERT INTO `tbl_sales_return` (`sales_return_id`, `company_id`, `party_id`, `invoice_no`, `out_of_state`, `state_of_supply`, `sales_return_date`, `payment_type_id`, `narration`, `sub_total`, `shipping_packing_amount`, `is_round_off`, `round_off`, `total`, `pay`, `financial_id`, `new_invoice_no`, `is_gst_bill`) VALUES
(1, 4, 3, 1, 0, 'GOA', '2022-01-19', 1, 'asdfghjkl', '0.00', '5.00', b'1', '0.00', '0.00', '860.00', 8, 'qwertyuio', b'0');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sales_return_detail`
--

CREATE TABLE `tbl_sales_return_detail` (
  `sales_return_detail_id` bigint(20) NOT NULL,
  `company_id` bigint(20) NOT NULL,
  `sales_return_id` bigint(20) NOT NULL,
  `product_id` bigint(20) NOT NULL,
  `unit_id` bigint(20) NOT NULL,
  `unit` varchar(50) NOT NULL,
  `rate` decimal(18,2) NOT NULL,
  `qty` decimal(18,2) NOT NULL,
  `gross_total` decimal(18,2) NOT NULL,
  `disc_per` decimal(18,2) NOT NULL,
  `disc_amt` decimal(18,2) NOT NULL,
  `sub_total` decimal(18,2) NOT NULL,
  `gstslab_id` bigint(20) NOT NULL,
  `gst` decimal(18,2) NOT NULL,
  `gst_per` decimal(18,2) NOT NULL,
  `igst` decimal(18,2) NOT NULL,
  `igst_per` decimal(18,2) NOT NULL,
  `total` decimal(18,2) NOT NULL,
  `financial_id` bigint(20) NOT NULL,
  `new_invoice_no` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_sales_return_detail`
--

INSERT INTO `tbl_sales_return_detail` (`sales_return_detail_id`, `company_id`, `sales_return_id`, `product_id`, `unit_id`, `unit`, `rate`, `qty`, `gross_total`, `disc_per`, `disc_amt`, `sub_total`, `gstslab_id`, `gst`, `gst_per`, `igst`, `igst_per`, `total`, `financial_id`, `new_invoice_no`) VALUES
(1, 4, 1, 5, 0, '', '89.00', '10.00', '845.50', '5.00', '44.50', '0.00', 3, '0.00', '0.00', '0.00', '0.00', '0.00', 8, 'qwertyuio'),
(2, 4, 1, 0, 0, '', '0.00', '1.00', '0.00', '0.00', '0.00', '0.00', 3, '0.00', '0.00', '0.00', '0.00', '0.00', 8, 'qwertyuio');

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
(3, 'XS', '2021-12-17 11:02:43'),
(4, 'S', '2021-12-17 11:02:46'),
(5, 'M', '2021-12-17 11:02:58'),
(6, 'L', '2021-12-17 11:03:03'),
(7, 'XL', '2021-12-17 11:03:06'),
(8, '2XL', '2021-12-17 11:03:15'),
(9, '3XL', '2021-12-17 11:03:39'),
(10, '4XL', '2021-12-17 11:03:44'),
(11, '5XL', '2021-12-17 11:03:49'),
(12, '6XL', '2021-12-17 11:03:55');

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
(1, 'kilogram(kg)', '2021-12-20 10:08:53'),
(2, 'miliGram (mg)', '2021-12-13 11:22:49'),
(3, 'bottle', '2022-01-13 04:05:19'),
(4, 'can', '2022-01-13 04:05:23'),
(5, 'pouch', '2022-01-13 04:05:32'),
(6, 'box', '2022-01-13 04:05:36'),
(7, 'packet', '2022-01-13 04:05:42'),
(8, 'bag', '2022-01-13 04:05:46'),
(9, 'litter', '2022-01-13 04:08:31'),
(10, 'mililitter', '2022-01-13 04:08:39'),
(11, 'meter', '2022-01-13 04:08:54'),
(12, 'centimeter', '2022-01-13 04:09:10');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `manage_user_tbl`
--
ALTER TABLE `manage_user_tbl`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `tbl_barcode_master`
--
ALTER TABLE `tbl_barcode_master`
  ADD PRIMARY KEY (`barcode_id`);

--
-- Indexes for table `tbl_cashmemo`
--
ALTER TABLE `tbl_cashmemo`
  ADD PRIMARY KEY (`cashmemo_id`);

--
-- Indexes for table `tbl_cashmemo_detail`
--
ALTER TABLE `tbl_cashmemo_detail`
  ADD PRIMARY KEY (`cashmemo_detail_id`);

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
-- Indexes for table `tbl_financial_master`
--
ALTER TABLE `tbl_financial_master`
  ADD PRIMARY KEY (`financial_id`);

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
-- Indexes for table `tbl_product_master`
--
ALTER TABLE `tbl_product_master`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `tbl_purchase_invoice`
--
ALTER TABLE `tbl_purchase_invoice`
  ADD PRIMARY KEY (`purchase_invoice_id`);

--
-- Indexes for table `tbl_purchase_invoice_detail`
--
ALTER TABLE `tbl_purchase_invoice_detail`
  ADD PRIMARY KEY (`purchase_invoice_detail_id`);

--
-- Indexes for table `tbl_sales_invoice`
--
ALTER TABLE `tbl_sales_invoice`
  ADD PRIMARY KEY (`sales_invoice_id`);

--
-- Indexes for table `tbl_sales_invoice_detail`
--
ALTER TABLE `tbl_sales_invoice_detail`
  ADD PRIMARY KEY (`sales_invoice_detail_id`);

--
-- Indexes for table `tbl_sales_return`
--
ALTER TABLE `tbl_sales_return`
  ADD PRIMARY KEY (`sales_return_id`);

--
-- Indexes for table `tbl_sales_return_detail`
--
ALTER TABLE `tbl_sales_return_detail`
  ADD PRIMARY KEY (`sales_return_detail_id`);

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
-- AUTO_INCREMENT for table `tbl_barcode_master`
--
ALTER TABLE `tbl_barcode_master`
  MODIFY `barcode_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_cashmemo`
--
ALTER TABLE `tbl_cashmemo`
  MODIFY `cashmemo_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_cashmemo_detail`
--
ALTER TABLE `tbl_cashmemo_detail`
  MODIFY `cashmemo_detail_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_category`
--
ALTER TABLE `tbl_category`
  MODIFY `category_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tbl_color`
--
ALTER TABLE `tbl_color`
  MODIFY `color_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `tbl_company`
--
ALTER TABLE `tbl_company`
  MODIFY `company_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_expence`
--
ALTER TABLE `tbl_expence`
  MODIFY `expence_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_expense_type`
--
ALTER TABLE `tbl_expense_type`
  MODIFY `expense_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_financial_master`
--
ALTER TABLE `tbl_financial_master`
  MODIFY `financial_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `tbl_gstslab_master`
--
ALTER TABLE `tbl_gstslab_master`
  MODIFY `gstslab_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_party_master`
--
ALTER TABLE `tbl_party_master`
  MODIFY `party_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_payment_type`
--
ALTER TABLE `tbl_payment_type`
  MODIFY `payment_type_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_product_master`
--
ALTER TABLE `tbl_product_master`
  MODIFY `product_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tbl_purchase_invoice`
--
ALTER TABLE `tbl_purchase_invoice`
  MODIFY `purchase_invoice_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `tbl_purchase_invoice_detail`
--
ALTER TABLE `tbl_purchase_invoice_detail`
  MODIFY `purchase_invoice_detail_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `tbl_sales_invoice`
--
ALTER TABLE `tbl_sales_invoice`
  MODIFY `sales_invoice_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `tbl_sales_invoice_detail`
--
ALTER TABLE `tbl_sales_invoice_detail`
  MODIFY `sales_invoice_detail_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `tbl_sales_return`
--
ALTER TABLE `tbl_sales_return`
  MODIFY `sales_return_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_sales_return_detail`
--
ALTER TABLE `tbl_sales_return_detail`
  MODIFY `sales_return_detail_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_size`
--
ALTER TABLE `tbl_size`
  MODIFY `size_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tbl_unit`
--
ALTER TABLE `tbl_unit`
  MODIFY `unit_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
