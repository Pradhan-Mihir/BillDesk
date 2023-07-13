-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 31, 2022 at 05:44 PM
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
    DELETE FROM tbl_company_ledger  WHERE related_id  = ID;
	DELETE FROM tbl_cashmemo WHERE cashmemo_id  = ID;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `deleteCashmemo_return` (IN `ID` BIGINT(20))  BEGIN
	DELETE FROM tbl_cashmemo_return_detail  WHERE cashmemo_return_id  = ID;
    DELETE FROM tbl_company_ledger  WHERE related_id  = ID;
	DELETE FROM tbl_cashmemo_return WHERE cashmemo_return_id  = ID;
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
      DELETE FROM tbl_company_ledger  WHERE related_id  = PROID;
       DELETE FROM tbl_party_ledger  WHERE invoice_no  = PROID;
	DELETE FROM tbl_purchase_invoice  WHERE purchase_invoice_id  = PROID;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `deletePurchase_return_invoice` (IN `ID` BIGINT(20))  BEGIN
	DELETE FROM tbl_purchase_return_invoice_detail  WHERE purchase_return_invoice_id   = ID;
    DELETE FROM tbl_company_ledger  WHERE related_id  = ID;
       DELETE FROM tbl_party_ledger  WHERE invoice_no  = ID;
	DELETE FROM tbl_purchase_return_invoice WHERE purchase_return_invoice_id   = ID;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `deleteSales_invoice` (IN `SID` BIGINT(20))  BEGIN
	DELETE FROM tbl_sales_invoice_detail  WHERE sales_invoice_id  = SID;
    DELETE FROM tbl_company_ledger  WHERE related_id  =
SID;
       DELETE FROM tbl_party_ledger  WHERE invoice_no  = SID;
	DELETE FROM tbl_sales_invoice WHERE sales_invoice_id  = SID;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `deleteSales_return` (IN `SID` BIGINT(20))  BEGIN
	DELETE FROM tbl_sales_return_detail  WHERE sales_return_id = SID ;
    DELETE FROM tbl_company_ledger  WHERE related_id  = SID;
       DELETE FROM tbl_party_ledger  WHERE invoice_no  = SID;
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `fetchCashmemo_return` (IN `ID` BIGINT(20))  BEGIN
	SELECT * FROM tbl_cashmemo_return WHERE cashmemo_return_id = ID;
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `fetchPurchase_return_invoice` (IN `ID` BIGINT(20))  BEGIN
	SELECT * FROM tbl_purchase_return_invoice WHERE purchase_return_invoice_id = ID;
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `insertCashmemo` (IN `CIN` BIGINT, IN `CNAME` VARCHAR(50), IN `CMOBILE` BIGINT, IN `INV` BIGINT, IN `OUTOFF` TINYINT(4), IN `STAT` VARCHAR(50), IN `CDATE` DATE, IN `PAYID` BIGINT, IN `NAR` VARCHAR(500), IN `SUB` DECIMAL(18,2), IN `SAMOUNT` DECIMAL(18,2), IN `ISROUND` BIT, IN `ROFF` DECIMAL(18,2), IN `TOT` DECIMAL(18,2), IN `PAYAMT` DECIMAL(18,2), IN `FID` BIGINT, IN `NEWINV` VARCHAR(50))  BEGIN
  INSERT INTO tbl_cashmemo(company_id , customer_name, customer_mobile , invoice_no ,out_of_state, state_of_supply , cashmemo_date, payment_type_id , narration , sub_total , shipping_packing_amount , is_round_off , round_off , total , pay , financial_id , new_invoice_no) VALUES (CIN , CNAME , CMOBILE , INV ,OUTOFF, STAT , CDATE , PAYID , NAR , SUB , SAMOUNT , ISROUND , ROFF , TOT , PAYAMT , FID , NEWINV );
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insertCashmemo_return` (IN `CIN` BIGINT, IN `CNAME` VARCHAR(50), IN `CMOBILE` BIGINT, IN `INV` BIGINT, IN `OUTOFF` TINYINT(4), IN `STAT` VARCHAR(50), IN `CDATE` DATE, IN `PAYID` BIGINT, IN `NAR` VARCHAR(500), IN `SUB` DECIMAL(18,2), IN `SAMOUNT` DECIMAL(18,2), IN `ISROUND` BIT, IN `ROFF` DECIMAL(18,2), IN `TOT` DECIMAL(18,2), IN `PAYAMT` DECIMAL(18,2), IN `FID` BIGINT, IN `NEWINV` VARCHAR(50))  BEGIN
  INSERT INTO tbl_cashmemo_return (company_id , customer_name , customer_mobile , invoice_no , out_of_state,state_of_supply , cashmemo_return_date , payment_type_id , narration , sub_total , shipping_packing_amount , is_round_off , round_off , total , pay , financial_id , new_invoice_no) 
  VALUES (CIN , CNAME , CMOBILE , INV , OUTOFF,STAT , CDATE , PAYID , NAR , SUB , SAMOUNT , ISROUND , ROFF , TOT , PAYAMT , FID , NEWINV );
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `insertParty_master` (IN `GRP` INT(6), IN `NAME` VARCHAR(100), IN `MOBILE` BIGINT(20), IN `ALT_MOBILE` BIGINT(20), IN `EML` VARCHAR(100), IN `BILL_ADD` VARCHAR(250), IN `SHIP_ADD` VARCHAR(250), IN `GST_TYP` VARCHAR(100), IN `GSTIN` VARCHAR(20), IN `STAT` VARCHAR(50), IN `CID` INT(20), IN `ADD_1` VARCHAR(50), IN `ADD_2` VARCHAR(50), IN `ADD_3` VARCHAR(50), IN `ADD_4` VARCHAR(50))  BEGIN
	INSERT INTO tbl_party_master (party_group,party_name, mobile_no,alter_mobile_no,email,billing_address,shipping_address, gst_type,gst_in,state,company_id,additional_field_1_name,additional_field_2_name,additional_field_3_name,additional_field_4_name) VALUES (GRP,NAME,MOBILE,ALT_MOBILE,EML, BILL_ADD,SHIP_ADD,GST_TYP,GSTIN,STAT,CID,ADD_1,ADD_2,ADD_3,ADD_4);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insertPayment_type` (IN `PTYPE` VARCHAR(100))  BEGIN
	INSERT INTO tbl_payment_type ( payment_type) VALUES (PTYPE);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insertProduct_master` (IN `CID` BIGINT(20), IN `CAT` BIGINT(20), IN `BAR` VARCHAR(50), IN `PCODE` VARCHAR(50), IN `PNAME` VARCHAR(100), IN `GSTID` BIGINT(20), IN `HSN` VARCHAR(50), IN `U_ID` BIGINT(20), IN `P_ID` BIGINT(20), IN `S_ID` BIGINT(20), IN `PRATE` DECIMAL(18,2), IN `PTAX` VARCHAR(50), IN `SRATE` DECIMAL(18,2), IN `STAX` VARCHAR(50), IN `OPSTOCK` DECIMAL(18,2), IN `UPP` DECIMAL(18,2), IN `DES` VARCHAR(500), IN `MIN` DECIMAL(18,3), IN `PLOC` VARCHAR(100), IN `PDATE` DATE, IN `PIMG` VARCHAR(2000))  BEGIN
  INSERT INTO tbl_product_master (company_id , category_id , barcode , product_code , product_name , gstslab_id , hsn_code ,unit_id,primary_unit_id,secondary_unit_id,purchase_rate,purchase_tax_type,sales_rate,sales_tax_type,opening_stock,unit_per_price,description,min_stock_qty,product_location,product_date,product_image )
  VALUES (CID , CAT , BAR , PCODE , PNAME , GSTID , HSN ,U_ID,P_ID,S_ID, PRATE , PTAX , SRATE , STAX , OPSTOCK , UPP , DES , MIN , PLOC , PDATE , PIMG);	
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insertPurchase_invoice` (IN `CIN` BIGINT(20), IN `PID` BIGINT(20), IN `ROID` VARCHAR(50), IN `INVOICE` BIGINT(20), IN `OUTOFF` TINYINT(4), IN `STAT` VARCHAR(50), IN `PDATE` DATE, IN `PAYID` BIGINT(20), IN `NAR` VARCHAR(500), IN `SUB` DECIMAL(18,2), IN `SAMOUNT` DECIMAL(18,2), IN `ISROUND` BIT(1), IN `RNDOFF` DECIMAL(18,2), IN `TOT` DECIMAL(18,2), IN `PAY` DECIMAL(18,2), IN `FID` BIGINT(20), IN `NEWINV` VARCHAR(50))  BEGIN INSERT INTO tbl_purchase_invoice(company_id , party_id , ref_order_id , invoice_no ,out_of_state ,state_of_supply , purchase_invoice_date , payment_type_id , narration , sub_total , shipping_packing_ammount , is_round_off , round_off , total , pay , financial_id , new_invoice_no) VALUES (CIN , PID , ROID , INVOICE ,OUTOFF ,STAT , PDATE , PAYID , NAR , SUB , SAMOUNT , ISROUND , RNDOFF , TOT , PAY , FID , NEWINV ); END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insertPurchase_return_invoice` (IN `CIN` BIGINT, IN `PID` BIGINT, IN `ROID` VARCHAR(50), IN `INV` BIGINT, IN `OUTOFF` TINYINT(4), IN `STAT` VARCHAR(50), IN `PDATE` DATE, IN `PAYID` BIGINT, IN `NAR` VARCHAR(500), IN `SUB` DECIMAL(18,2), IN `SAMOUNT` DECIMAL(18,2), IN `ISROUND` BIT, IN `ROFF` DECIMAL(18,2), IN `TOT` DECIMAL(18,2), IN `PAYAMT` DECIMAL(18,2), IN `FID` BIGINT, IN `NEWINV` VARCHAR(50))  BEGIN
  INSERT INTO tbl_purchase_return_invoice (company_id , party_id , ref_order_id , invoice_no ,out_of_state ,state_of_supply , purchase_return_invoice_date , payment_type_id , narration , sub_total , shipping_packing_amount , is_round_off , round_off , total , pay , financial_id , new_invoice_no) 
  VALUES (CIN , PID , ROID , INV ,OUTOFF ,STAT , PDATE , PAYID , NAR , SUB , SAMOUNT , ISROUND , ROFF , TOT , PAYAMT , FID , NEWINV );
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insertSales_invoice` (IN `CIN` BIGINT, IN `PID` BIGINT, IN `INV` BIGINT, IN `STAT` VARCHAR(50), IN `OUTOFF` TINYINT(4), IN `SDATE` DATE, IN `PAYID` BIGINT, IN `NAR` VARCHAR(500), IN `SUB` DECIMAL(18,2), IN `SAMOUNT` DECIMAL(18,2), IN `ISROUND` BIT, IN `ROFF` DECIMAL(18,2), IN `TOT` DECIMAL(18,2), IN `PAYAMT` DECIMAL(18,2), IN `FID` BIGINT, IN `NEWINV` VARCHAR(50))  BEGIN
  INSERT INTO tbl_sales_invoice(company_id , party_id , invoice_no ,out_of_state ,state_of_supply , sales_invoice_date, payment_type_id , narration , sub_total , shipping_packing_amount , is_round_off , round_off , total , pay , financial_id , new_invoice_no) 
  VALUES (CIN , PID , INV ,OUTOFF ,STAT , SDATE , PAYID , NAR , SUB , SAMOUNT , ISROUND , ROFF , TOT , PAYAMT , FID , NEWINV );
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insertSales_return` (IN `CIN` BIGINT, IN `PID` BIGINT, IN `INV` BIGINT, IN `OUTOFF` TINYINT(4), IN `STAT` VARCHAR(50), IN `SDATE` DATE, IN `PAYID` BIGINT, IN `NAR` VARCHAR(500), IN `SUB` DECIMAL(18,2), IN `SAMOUNT` DECIMAL(18,2), IN `ISROUND` BIT, IN `ROFF` DECIMAL(18,2), IN `TOT` DECIMAL(18,2), IN `PAYAMT` DECIMAL(18,2), IN `FID` BIGINT, IN `NEWINV` VARCHAR(50))  BEGIN
  INSERT INTO tbl_sales_return(company_id , party_id , invoice_no ,out_of_state, state_of_supply , sales_return_date , payment_type_id , narration , sub_total , shipping_packing_amount , is_round_off , round_off , total , pay , financial_id , new_invoice_no) 
  VALUES (CIN , PID , INV ,OUTOFF, STAT , SDATE , PAYID , NAR , SUB , SAMOUNT , ISROUND , ROFF , TOT , PAYAMT , FID , NEWINV );
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insertSize` (IN `STYPE` VARCHAR(100))  BEGIN
	INSERT INTO tbl_size (size) VALUES (STYPE);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insertUnit` (IN `UTYPE` VARCHAR(100))  BEGIN
	INSERT INTO tbl_unit (unit_name) VALUES (UTYPE);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insertUnit_conconversion` (IN `P_UNIT` VARCHAR(50), IN `P_ID` BIGINT(20), IN `S_UNIT` VARCHAR(50), IN `S_ID` BIGINT(20), IN `U_RATE` DECIMAL(18,2), IN `ISDEFAULT` BIT(1))  BEGIN
	IF ISDEFAULT = 1 
	THEN 
		UPDATE tbl_unit_conversion SET is_default = 0; 
	END IF;

	INSERT INTO tbl_unit_conversion (primary_unit,primary_unit_id,secondary_unit,secondary_unit_id,rate,is_default)
	VALUES (P_UNIT,P_ID,S_UNIT,S_ID,U_RATE,ISDEFAULT);
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `updateParty_master` (IN `PID` BIGINT(20), IN `GRP` INT(1), IN `NAME` VARCHAR(100), IN `MOBILE` BIGINT(20), IN `ALT_MOBILE` BIGINT(20), IN `EML` VARCHAR(100), IN `BILL_ADD` VARCHAR(250), IN `SHIP_ADD` VARCHAR(250), IN `GST_TYP` VARCHAR(100), IN `GSTIN` VARCHAR(20), IN `STAT` VARCHAR(50), IN `ADD_1` VARCHAR(50), IN `ADD_2` VARCHAR(50), IN `ADD_3` VARCHAR(50), IN `ADD_4` VARCHAR(50))  BEGIN
                  UPDATE tbl_party_master SET party_group = GRP, party_name = NAME, mobile_no = MOBILE, alter_mobile_no = ALT_MOBILE, email = EML, billing_address  = BILL_ADD, shipping_address = SHIP_ADD, gst_type =  GST_TYP, gst_in = GSTIN, state = STAT ,additional_field_1_name = ADD_1 ,additional_field_2_name = ADD_2 ,additional_field_3_name = ADD_3 ,additional_field_4_name = ADD_4 WHERE party_id = PID;
                
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `viewCashmemo_return` ()  BEGIN
	SELECT cmr.*  FROM tbl_cashmemo_return cmr
	LEFT JOIN tbl_company com ON com.company_id = cmr.company_id
    LEFT JOIN tbl_financial_master fi ON fi.financial_id = cmr.financial_id
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `viewPurchase_return_invoice` ()  BEGIN
	SELECT pr.*,par.party_name  FROM tbl_purchase_return_invoice pr
	LEFT JOIN tbl_party_master par ON par.party_id = pr.party_id
	LEFT JOIN tbl_company com ON com.company_id = pr.company_id
    LEFT JOIN tbl_financial_master fi ON fi.financial_id = pr.financial_id
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
  `cashmemo_date` date NOT NULL,
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

INSERT INTO `tbl_cashmemo` (`cashmemo_id`, `company_id`, `customer_name`, `customer_mobile`, `invoice_no`, `out_of_state`, `state_of_supply`, `cashmemo_date`, `payment_type_id`, `narration`, `sub_total`, `shipping_packing_amount`, `is_round_off`, `round_off`, `total`, `pay`, `financial_id`, `new_invoice_no`, `is_gst_bill`) VALUES
(18, 4, 'mansi', 9016896222, 1, 0, 'GOA', '2022-01-24', 1, '', '2850.00', '50.00', b'1', '0.000', '2900.00', '2900.00', 8, '', b'0');

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
(13, 4, 18, 7, 7, 'packet', '120.00', '25.00', '3000.00', '5.00', '150.00', '2850.00', 4, '28.50', '1.00', '0.00', '0.00', '2850.00', 8, '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_cashmemo_return`
--

CREATE TABLE `tbl_cashmemo_return` (
  `cashmemo_return_id` bigint(20) NOT NULL,
  `company_id` bigint(20) NOT NULL,
  `customer_name` varchar(50) NOT NULL,
  `customer_mobile` bigint(20) NOT NULL,
  `invoice_no` bigint(20) NOT NULL,
  `out_of_state` tinyint(4) NOT NULL,
  `state_of_supply` varchar(50) NOT NULL,
  `cashmemo_return_date` date NOT NULL,
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

-- --------------------------------------------------------

--
-- Table structure for table `tbl_cashmemo_return_detail`
--

CREATE TABLE `tbl_cashmemo_return_detail` (
  `cashmemo_return_detail_id` bigint(20) NOT NULL,
  `company_id` bigint(20) NOT NULL,
  `cashmemo_return_id` bigint(20) NOT NULL,
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
-- Table structure for table `tbl_company_ledger`
--

CREATE TABLE `tbl_company_ledger` (
  `company_ledger_id` bigint(20) NOT NULL,
  `company_id` bigint(20) NOT NULL,
  `related_id` bigint(20) NOT NULL,
  `related_obj_name` varchar(50) NOT NULL,
  `date` date NOT NULL,
  `details` varchar(1000) NOT NULL,
  `credit` decimal(18,2) NOT NULL,
  `debit` decimal(18,2) NOT NULL,
  `financial_id` bigint(20) NOT NULL,
  `new_invoice_no` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
(1, 'bhautik 14%', '7.00', '7.00', '14.00', '2021-12-11 10:12:35', 4),
(3, 'mihir12%', '6.00', '6.00', '12.00', '2021-12-19 05:19:15', 4),
(4, 'mansi2%', '1.00', '1.00', '2.00', '2021-12-19 05:27:17', 4),
(5, 'bhumi 0%', '0.00', '0.00', '0.00', '2022-01-20 09:11:21', 4),
(6, 'vasu 20%', '10.00', '10.00', '20.00', '2022-01-20 09:11:42', 4),
(7, 'kunal 16%', '4.00', '4.00', '8.00', '2022-01-20 09:11:54', 4),
(8, 'vini 6%', '3.00', '3.00', '6.00', '2022-01-20 09:12:13', 4);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_party_ledger`
--

CREATE TABLE `tbl_party_ledger` (
  `party_ladger_id` bigint(20) NOT NULL,
  `company_id` bigint(20) NOT NULL,
  `party_group` int(11) NOT NULL,
  `party_id` bigint(20) NOT NULL,
  `invoice_type` varchar(50) NOT NULL,
  `invoice_no` bigint(20) NOT NULL,
  `detail` varchar(50) NOT NULL,
  `credit` decimal(18,2) NOT NULL,
  `debit` decimal(18,2) NOT NULL,
  `date` date NOT NULL,
  `financial_id` bigint(20) NOT NULL,
  `new_invoice_no` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
  `company_id` bigint(20) NOT NULL,
  `additional_field_1_name` varchar(50) NOT NULL,
  `additional_field_2_name` varchar(50) NOT NULL,
  `additional_field_3_name` varchar(50) NOT NULL,
  `additional_field_4_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_party_master`
--

INSERT INTO `tbl_party_master` (`party_id`, `party_group`, `party_name`, `mobile_no`, `alter_mobile_no`, `email`, `billing_address`, `shipping_address`, `gst_type`, `gst_in`, `state`, `added_date`, `company_id`, `additional_field_1_name`, `additional_field_2_name`, `additional_field_3_name`, `additional_field_4_name`) VALUES
(1, 1, 'mihir', 9376521396, 9328659886, 'mihirhpradhan@gmail.com', 'bhestan,surat', 'althan,surat', 'SGST', 'asdf123', 'GUJARAT', '2021-12-14 11:07:42', 4, '', '', '', ''),
(3, 1, 'kp', 9638527410, 7894561230, 'kp@gmail.com', 'katargam', 'sugc', 'SGST', 'fghj', 'GOA', '2021-12-19 05:29:05', 4, '', '', '', ''),
(4, 0, 'bhautik', 9328659886, 9016896222, 'bhautikpatel1201@gmail.com', 'Shivparnam residency', 'shivpranam residency', 'CGST', '1234667', 'GUJARAT', '2022-01-10 10:53:15', 4, '', '', '', ''),
(5, 0, 'mansi', 9016896222, 928659886, 'mansi1011@gmail.com', 'Narayan Nagar', 'Narayan Nagar', 'SGST', 'zxcvbnm', 'GUJARAT', '2022-01-21 15:43:12', 4, '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_party_setting`
--

CREATE TABLE `tbl_party_setting` (
  `party_setting_id` bigint(20) NOT NULL,
  `is_party_grouping` bit(1) NOT NULL,
  `is_shipping_address` bit(1) NOT NULL,
  `is_print_shipping_address` bit(1) NOT NULL,
  `is_enable_payment_reminder` bit(1) NOT NULL,
  `reminder_in_days` int(11) NOT NULL,
  `reminder_message` varchar(500) NOT NULL,
  `is_additional_field_1` bit(1) NOT NULL,
  `additional_field_1_name` varchar(50) NOT NULL,
  `is_a_f_1_show_in_print` bit(1) NOT NULL,
  `is_additional_field_2` bit(1) NOT NULL,
  `additional_field_2_name` varchar(50) NOT NULL,
  `is_a_f_2_show_in_print` bit(1) NOT NULL,
  `is_additional_field_3` bit(1) NOT NULL,
  `additional_field_3_name` varchar(50) NOT NULL,
  `is_a_f_3_show_in_print` bit(1) NOT NULL,
  `is_additional_field_4` bit(1) NOT NULL,
  `additional_field_4_name` varchar(50) NOT NULL,
  `is_a_f_4_show_in_print` bit(1) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_party_setting`
--

INSERT INTO `tbl_party_setting` (`party_setting_id`, `is_party_grouping`, `is_shipping_address`, `is_print_shipping_address`, `is_enable_payment_reminder`, `reminder_in_days`, `reminder_message`, `is_additional_field_1`, `additional_field_1_name`, `is_a_f_1_show_in_print`, `is_additional_field_2`, `additional_field_2_name`, `is_a_f_2_show_in_print`, `is_additional_field_3`, `additional_field_3_name`, `is_a_f_3_show_in_print`, `is_additional_field_4`, `additional_field_4_name`, `is_a_f_4_show_in_print`, `date`) VALUES
(1, b'1', b'1', b'1', b'1', 1, 'Hii your payment $10000 is on panding', b'1', 'Customer Building', b'1', b'1', 'Customer House No', b'1', b'1', 'Customer Height', b'1', b'1', 'Date Of Birth', b'1', '2002-01-12');

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
(2, 'cheque', '2021-12-31'),
(3, 'RTGS', '2022-01-26'),
(4, 'NEFT', '2022-01-26'),
(5, 'UPI', '2022-01-26');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_place_of_supply_master`
--

CREATE TABLE `tbl_place_of_supply_master` (
  `place_of_supply_id` bigint(20) NOT NULL,
  `state_title` varchar(50) NOT NULL,
  `alpha_code` varchar(10) NOT NULL,
  `gst_state_code` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_place_of_supply_master`
--

INSERT INTO `tbl_place_of_supply_master` (`place_of_supply_id`, `state_title`, `alpha_code`, `gst_state_code`) VALUES
(1, 'Andaman and Nicobar Islands', 'AN', '35'),
(2, 'Andhra Pradesh', 'AP', '37'),
(3, 'Arunachal Pradesh', 'AR', '12'),
(4, 'Assam', 'AS', '18'),
(5, 'Bihar', 'BR', '10'),
(6, 'Chandigarh', 'CH', '04'),
(7, 'Chhattisgarh', 'CG', '22'),
(8, 'Dadra and Nagar Haveli', 'DN', '26'),
(9, 'Daman and Diu', 'DD', '25'),
(10, 'Delhi', 'DL', '07'),
(11, 'Goa', 'GA', '30'),
(12, 'Gujarat', 'GJ', '24'),
(13, 'Haryana', 'HR', '06'),
(14, 'Himachal Pradesh', 'HP', '02'),
(15, 'Jammu and Kashmir', 'JK', '01'),
(16, 'Jharkhand', 'JH', '20'),
(17, 'Karnataka', 'KA', '29'),
(18, 'Kerala', 'KL', '32'),
(19, 'Ladakh', 'LA', '38'),
(20, 'Lakshadweep', 'LD', '31'),
(21, 'Maghya Pradesh', 'MP', '23'),
(22, 'Maharashtra', 'MH', '27'),
(23, 'Manipur', 'MN', '14'),
(24, 'Meghalaya', 'ML', '17'),
(25, 'Mizoram', 'MZ', '15'),
(26, 'Nagaland', 'NL', '13'),
(27, 'Odisha', 'OR', '21'),
(28, 'Other Territory', 'OT', '97'),
(29, 'Puducherry', 'PY', '34'),
(30, 'Punjab', 'PB', '03'),
(31, 'Rajasthan', 'RJ', '08'),
(32, 'Sikkim', 'SK', '11'),
(33, 'Tamil Nadu', 'TN', '33'),
(34, 'Telangana', 'TS', '36'),
(35, 'Tripura', 'TR', '16'),
(36, 'Uttar Pradesh', 'UP', '09'),
(37, 'Uttarakhand', 'UA', '05'),
(38, 'West Bengal', 'WB', '19'),
(39, 'Foreign Country', 'FC', '96');

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
  `primary_unit_id` bigint(20) NOT NULL,
  `secondary_unit_id` bigint(20) NOT NULL,
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

INSERT INTO `tbl_product_master` (`product_id`, `company_id`, `category_id`, `barcode`, `product_code`, `product_name`, `gstslab_id`, `hsn_code`, `unit_id`, `primary_unit_id`, `secondary_unit_id`, `purchase_rate`, `purchase_tax_type`, `sales_rate`, `sales_tax_type`, `opening_stock`, `unit_per_price`, `description`, `min_stock_qty`, `product_location`, `product_date`, `product_image`) VALUES
(1, 4, 5, 'abc', '123', 'pepsi', 3, '456', 1, 0, 0, '69.00', 'Excluding Gst', '210.00', 'Excluding Gst', '25.000', '12.00', 'rxdtcfygvuhbinjkm', '15.000', '65', '1212-12-12', '49abdd0f08f1c2092b274b95b7af3ee5780884.jpg'),
(2, 4, 2, 'pqr', 'blue001', 'black', 3, '123', 1, 0, 0, '1.00', 'Including Gst', '2.00', 'Including Gst', '0.000', '10.00', 'ok test 123', '2600.000', 'surat', '2021-12-09', 'crop721678.jpg'),
(5, 4, 6, '123PQR456', 'B102', 'pen', 3, 'nvb', 14, 0, 0, '79.00', 'Including Gst', '89.00', 'Including Gst', '100.000', '89.00', 'non veg burger with meat', '50.000', 'surat', '2021-12-23', 'burger755322.png'),
(6, 4, 4, '456XYZ789', 'P101', 'pencil', 3, 'pm', 1, 0, 0, '99.00', 'Including Gst', '120.00', 'Including Gst', '50.000', '120.00', 'margerita with extra cheese', '50.000', 'surat', '2021-12-23', 'margerita756610.jpg'),
(7, 4, 2, '980DFG021', 'P102', 'eraser', 3, 'pbth', 1, 0, 0, '110.00', 'Including Gst', '120.00', 'Including Gst', '100.000', '120.00', '', '100.000', 'surat', '2021-12-23', 'burn to hell825075.jpg'),
(8, 4, 2, 'ASDFGHJKL', 'S101', 'white_nerd', 3, 'PSp', 1, 0, 0, '50.00', 'Including Gst', '90.00', 'Including Gst', '50.000', '90.00', '', '50.000', 'surat', '2021-12-24', 'pepsi726713.jpg'),
(9, 4, 2, 'ZXCVBNMLk', 'P102', 'Coca-cola', 3, 'Ccc', 1, 0, 0, '60.00', 'Including Gst', '120.00', 'Including Gst', '50.000', '120.00', '', '50.000', 'surat', '2021-12-24', 'coca-cola856207.jpg'),
(10, 4, 2, 'asdfghjkl;', 'Kissan_Tomato_Ketchup_4', 'Kissan Fresh Tomato Ketchup', 1, '', 5, 0, 0, '100.00', 'Excluding Gst', '110.00', 'Including Gst', '1000.000', '100.00', 'bchbsja', '100.000', '', '2022-01-13', ''),
(11, 4, 4, 'hdujhsjhiufk', 'Oranges', 'Oranges_6', 3, 'jdfd', 1, 0, 0, '50.00', 'Including Gst', '70.00', 'Excluding Gst', '1000.000', '50.00', 'jhciskhncjshcssdfghjkl', '100.000', 'vapi', '2022-01-22', ''),
(12, 4, 5, 'ertyty', 'Apples_7', 'Apples', 4, 'sdfghjk', 1, 0, 0, '90.00', 'Including Gst', '100.00', 'Excluding Gst', '1000.000', '90.00', 'sdfghjk', '100.000', 'mumbai', '2022-01-27', ''),
(13, 4, 5, 'wert', 'Dates_8', 'Dates', 5, 'werty', 1, 0, 0, '100.00', 'Including Gst', '110.00', 'Excluding Gst', '1000.000', '110.00', 'dfghj', '100.000', 'pune', '2022-01-03', ''),
(14, 4, 6, '', 'Baby_Kiwi_9', 'Baby Kiwi', 5, 'rtyu', 2, 0, 0, '70.00', 'Excluding Gst', '90.00', 'Including Gst', '1000.000', '70.00', 'cvbn', '90.000', 'surat', '2022-01-12', ''),
(15, 4, 2, '', 'Grapes_11', 'Grapes', 7, 'ert', 6, 0, 0, '100.00', 'Excluding Gst', '110.00', 'Including Gst', '1000.000', '100.00', '', '100.000', '', '2022-01-20', ''),
(16, 4, 8, '', 'Pineapple_12', 'Pineapple', 8, '', 1, 0, 0, '70.00', 'Including Gst', '90.00', 'Excluding Gst', '1000.000', '90.00', '', '100.000', '', '2022-01-29', ''),
(17, 4, 2, '', 'Papaya_13', 'Papaya', 1, '', 13, 0, 0, '100.00', 'Excluding Gst', '110.00', 'Including Gst', '1000.000', '100.00', '', '100.000', '', '2022-01-29', ''),
(18, 4, 4, '', 'Mosambi_14', 'Mosambi', 3, '', 6, 0, 0, '150.00', 'Including Gst', '160.00', 'Excluding Gst', '1000.000', '150.00', '', '100.000', '', '2021-12-29', ''),
(19, 4, 5, '', 'Pomegranate_15', 'Pomegranate', 4, '', 6, 0, 0, '120.00', 'Excluding Gst', '130.00', 'Including Gst', '1000.000', '130.00', '', '100.000', '', '2022-01-18', ''),
(20, 4, 6, '', 'Apple_Ber_16', 'Apple Ber', 5, '', 1, 0, 0, '1000.00', 'Including Gst', '1100.00', 'Excluding Gst', '1000.000', '1000.00', '', '100.000', '', '2022-01-06', ''),
(21, 4, 7, '', 'Watermelon_17', 'Watermelon', 6, '', 1, 0, 0, '100.00', 'Excluding Gst', '120.00', 'Including Gst', '1000.000', '100.00', '', '100.000', '', '2022-01-10', ''),
(22, 4, 8, '', 'Anjeer_18', 'Anjeer', 8, '', 1, 0, 0, '150.00', 'Excluding Gst', '170.00', 'Including Gst', '1000.000', '150.00', '', '100.000', '', '2022-01-17', ''),
(23, 4, 2, '', 'Carrot_1', 'Carrot Red', 1, '', 1, 0, 0, '80.00', 'Including Gst', '100.00', 'Excluding Gst', '1000.000', '80.00', '', '100.000', '', '2022-01-31', ''),
(24, 4, 4, '', 'Nuts_2', 'Ground Nuts', 3, '', 7, 0, 0, '1000.00', 'Including Gst', '1200.00', 'Excluding Gst', '1000.000', '1000.00', '', '100.000', '', '2022-01-20', ''),
(25, 4, 5, '', 'Coconut_3', 'Coconut', 4, '', 8, 0, 0, '100.00', 'Excluding Gst', '120.00', 'Including Gst', '1000.000', '100.00', '', '100.000', '', '2022-01-18', ''),
(26, 4, 6, '', 'Onion_4', 'Onion', 6, '', 1, 0, 0, '100.00', 'Including Gst', '110.00', 'Excluding Gst', '1000.000', '100.00', '', '100.000', '', '2022-01-12', ''),
(27, 4, 7, '', 'Lauki_5', 'Lauki', 7, '', 13, 0, 0, '90.00', 'Excluding Gst', '120.00', 'Including Gst', '1000.000', '90.00', '', '100.000', '', '2022-01-06', ''),
(28, 4, 8, '', 'Tomato_6', 'Tomato', 8, '', 7, 0, 0, '70.00', 'Including Gst', '90.00', 'Excluding Gst', '1000.000', '70.00', '', '100.000', '', '2022-01-24', ''),
(29, 4, 2, '', 'Cucumber_7', 'Cucumber', 1, '', 1, 0, 0, '50.00', 'Excluding Gst', '70.00', 'Including Gst', '1000.000', '70.00', '', '100.000', '', '2022-01-20', ''),
(30, 4, 4, '', 'Beans_8', 'French Beans', 3, '', 1, 0, 0, '170.00', 'Excluding Gst', '180.00', 'Including Gst', '1000.000', '170.00', '', '100.000', '', '2022-02-02', ''),
(31, 4, 5, '', 'Corn_9', 'Sweet Corn', 4, '', 1, 0, 0, '150.00', 'Including Gst', '160.00', 'Excluding Gst', '1000.000', '150.00', '', '100.000', '', '2022-01-18', ''),
(32, 4, 6, '', 'Cucumber_10', 'Cucumber Regular ', 5, '', 7, 0, 0, '200.00', 'Including Gst', '210.00', 'Excluding Gst', '1000.000', '200.00', '', '100.000', '', '2022-01-30', ''),
(33, 4, 7, '', 'Potato_11', 'Sweet Potato', 6, '', 6, 0, 0, '100.00', 'Excluding Gst', '120.00', 'Including Gst', '1000.000', '100.00', '', '100.000', '', '2022-02-04', ''),
(34, 4, 8, '', 'Potato_12', 'Potato', 8, '', 1, 0, 0, '90.00', 'Including Gst', '100.00', 'Excluding Gst', '1000.000', '90.00', '', '100.000', '', '2022-01-28', ''),
(35, 4, 2, '', 'Peas_13', 'Green Peas', 1, '', 13, 0, 0, '50.00', 'Excluding Gst', '70.00', 'Including Gst', '1000.000', '50.00', '', '100.000', '', '2022-01-29', ''),
(36, 4, 4, '', 'Bhendi_14', 'Bhendi', 3, '', 1, 0, 0, '180.00', 'Including Gst', '190.00', 'Excluding Gst', '1000.000', '190.00', '', '100.000', '', '2022-01-10', ''),
(37, 4, 5, '', 'Capsicum_15', 'Green Capsicum', 4, '', 1, 0, 0, '100.00', 'Excluding Gst', '120.00', 'Including Gst', '1000.000', '100.00', '', '100.000', '', '2022-01-12', ''),
(38, 4, 6, '', 'Beetroot_16', 'BeetRoot', 5, '', 1, 0, 0, '200.00', 'Including Gst', '210.00', 'Excluding Gst', '1000.000', '210.00', '', '100.000', '', '2022-01-06', ''),
(39, 4, 7, '', 'Ginger_1', 'Ginger Indian', 6, '', 2, 0, 0, '30.00', 'Including Gst', '50.00', 'Excluding Gst', '1000.000', '30.00', '', '100.000', '', '2022-01-26', ''),
(40, 4, 8, '', 'Garlic_2', 'Indian Garlic', 7, '', 3, 0, 0, '40.00', 'Including Gst', '60.00', 'Excluding Gst', '1000.000', '60.00', '', '100.000', '', '2022-01-05', ''),
(41, 4, 2, '', 'Chilli_3', 'Green Chilli', 1, '', 7, 0, 0, '300.00', 'Excluding Gst', '310.00', 'Including Gst', '1000.000', '300.00', '', '100.000', '', '2022-01-18', ''),
(42, 4, 4, '', 'Lemon_4', 'Lemon', 3, '', 6, 0, 0, '80.00', 'Excluding Gst', '90.00', 'Including Gst', '1000.000', '80.00', '', '100.000', '', '2022-01-12', ''),
(43, 4, 5, '', 'Ginger_5', 'Ginger', 4, '', 1, 0, 0, '40.00', 'Including Gst', '50.00', 'Excluding Gst', '1000.000', '40.00', '', '100.000', '', '2022-01-26', ''),
(44, 4, 6, '', 'Broccoli_1', 'Broccoli', 5, '', 5, 0, 0, '400.00', 'Including Gst', '410.00', 'Excluding Gst', '1000.000', '400.00', '', '100.000', '', '2022-02-01', ''),
(45, 4, 7, '', 'Mushroom_2', 'Button Mushroom', 6, '', 8, 0, 0, '200.00', 'Excluding Gst', '220.00', 'Including Gst', '1000.000', '200.00', '', '100.000', '', '2022-01-12', ''),
(46, 4, 7, '', 'Dragonfruit_3', 'Dragonfruit', 7, '', 7, 0, 0, '500.00', 'Including Gst', '550.00', 'Excluding Gst', '1000.000', '500.00', '', '100.000', '', '2022-01-31', ''),
(47, 4, 7, '', 'Mulberry_4', 'Mulberry', 8, '', 1, 0, 0, '100.00', 'Including Gst', '150.00', 'Including Gst', '1000.000', '100.00', '', '100.000', '', '2022-01-26', ''),
(48, 4, 2, '', 'Capsicum_5', 'Red Capsicum', 1, '', 5, 0, 0, '1000.00', 'Including Gst', '1200.00', 'Excluding Gst', '1000.000', '1000.00', '', '100.000', '', '2022-01-18', ''),
(49, 4, 2, '', 'Tomato_6', 'Tomato', 1, '', 1, 0, 0, '100.00', 'Including Gst', '110.00', 'Excluding Gst', '1000.000', '100.00', '', '100.000', '', '2022-01-26', ''),
(50, 4, 4, '', 'Yellow_Capsicum_7', 'Yellow Capsicum', 4, '', 14, 0, 0, '1000.00', 'Excluding Gst', '1200.00', 'Including Gst', '1000.000', '1000.00', '', '100.000', '', '2022-01-25', ''),
(51, 4, 5, '', 'Zucchini_7', 'Zucchini', 5, '', 8, 0, 0, '700.00', 'Excluding Gst', '800.00', 'Including Gst', '1000.000', '700.00', '', '100.000', '', '2022-01-28', ''),
(52, 4, 6, '', 'Lemongrass_8', 'Lemongrass 1 bunch', 6, '', 7, 0, 0, '100.00', 'Excluding Gst', '150.00', 'Including Gst', '1000.000', '100.00', '', '100.000', '', '2022-01-10', ''),
(53, 4, 7, '', 'Lettuce_Leafy_9', 'Lettuce Leafy', 7, '', 1, 0, 0, '350.00', 'Including Gst', '400.00', 'Excluding Gst', '1000.000', '350.00', '', '100.000', '', '2022-01-19', ''),
(54, 4, 8, '', 'Cherry_Tomato_10', 'Cherry Tomato', 8, '', 1, 0, 0, '600.00', 'Including Gst', '610.00', 'Excluding Gst', '1000.000', '600.00', '', '100.000', '', '2022-01-11', ''),
(55, 4, 2, '', 'Zucchini_Yellow_11', 'Zucchini Yellow', 1, '', 1, 0, 0, '1000.00', 'Excluding Gst', '1200.00', 'Including Gst', '1000.000', '1000.00', '', '100.000', '', '2022-01-05', ''),
(56, 4, 4, '', 'Avocado_Hass_12', 'Avocado Hass', 3, '', 8, 0, 0, '500.00', 'Including Gst', '510.00', 'Excluding Gst', '1000.000', '500.00', '', '100.000', '', '2022-02-03', ''),
(57, 4, 5, '', 'Trikaya_13', 'Trikaya Lettuce Iceberg', 5, '', 8, 0, 0, '300.00', 'Including Gst', '310.00', 'Excluding Gst', '1000.000', '300.00', '', '100.000', '', '2022-01-12', ''),
(58, 4, 6, '', 'Basil_14', 'Basil', 3, '', 9, 0, 0, '180.00', 'Excluding Gst', '200.00', 'Including Gst', '1000.000', '180.00', '', '100.000', '', '2022-01-21', ''),
(59, 4, 7, '', 'Trikaya_Long_15', 'Trikaya Long', 8, '', 7, 0, 0, '50.00', 'Including Gst', '100.00', 'Excluding Gst', '1000.000', '50.00', '', '100.000', '', '2022-01-12', ''),
(60, 4, 8, '', 'Celery_16', 'Celery', 7, '', 1, 0, 0, '400.00', 'Including Gst', '450.00', 'Excluding Gst', '1000.000', '400.00', '', '100.000', '', '2022-01-03', ''),
(61, 4, 2, '', 'Amul_1', 'Amul Taaza Homogenised Toned Milk', 1, '', 5, 0, 0, '29.00', 'Excluding Gst', '30.00', 'Including Gst', '1000.000', '29.00', '', '100.000', '', '2022-02-02', ''),
(62, 4, 5, '', 'Milkshake_2', 'Chocolate Milkshake', 3, '', 9, 0, 0, '250.00', 'Including Gst', '300.00', 'Excluding Gst', '1000.000', '300.00', '', '100.000', '', '2022-01-17', ''),
(63, 4, 2, '', 'Winkin_3', 'Britannia Winkin', 1, '', 1, 0, 0, '800.00', 'Including Gst', '850.00', 'Excluding Gst', '1000.000', '800.00', '', '100.000', '', '2022-01-31', ''),
(64, 4, 4, '', 'Amul_4', 'Amul Masti Dahi', 3, '', 1, 0, 0, '30.00', 'Excluding Gst', '50.00', 'Including Gst', '1000.000', '30.00', '', '100.000', '', '2022-01-27', ''),
(65, 4, 5, '', 'Hershey_5', 'Strawberry Milkshake', 4, '', 5, 0, 0, '200.00', 'Including Gst', '250.00', 'Excluding Gst', '1000.000', '200.00', '', '100.000', '', '2022-01-04', ''),
(66, 4, 6, '', 'Hershey_6', 'Hershey Cookies', 5, '', 6, 0, 0, '300.00', 'Including Gst', '350.00', 'Excluding Gst', '1000.000', '300.00', '', '100.000', '', '2022-02-06', ''),
(67, 4, 6, '', 'Nestle_7', 'Milkmaid Sweetened ', 5, '', 6, 0, 0, '100.00', 'Excluding Gst', '150.00', 'Including Gst', '100.000', '100.00', '', '100.000', '', '2022-01-05', ''),
(68, 4, 7, '', 'Dairy_Whitener_8', 'Nestle Everyday Dairy Whitener', 7, '', 9, 0, 0, '300.00', 'Including Gst', '310.00', 'Excluding Gst', '1000.000', '300.00', '', '100.000', '', '2022-01-19', ''),
(69, 4, 8, '', 'Milk_9', 'Nestle A+ Slim Skimmed Milk', 8, '', 5, 0, 0, '100.00', 'Including Gst', '150.00', 'Excluding Gst', '1000.000', '100.00', '', '100.000', '', '2022-01-20', ''),
(70, 4, 2, '', 'Butter_10', 'Butter', 1, '', 1, 0, 0, '80.00', 'Including Gst', '100.00', 'Excluding Gst', '1000.000', '80.00', '', '100.000', '', '2022-01-12', ''),
(71, 4, 2, '', 'Amul_Mithai_11', 'Amul Mithai Mate', 1, '', 7, 0, 0, '1200.00', 'Excluding Gst', '1500.00', 'Including Gst', '1000.000', '1200.00', '', '100.000', '', '2022-01-24', ''),
(72, 4, 5, '', 'Delicious_12', 'Delicious Fat Spread', 4, '', 7, 0, 0, '300.00', 'Including Gst', '310.00', 'Excluding Gst', '1000.000', '300.00', '', '100.000', '', '2022-01-12', ''),
(73, 4, 6, '', 'bun_rusk_1', 'Premium Bake Rusk', 6, '', 2, 0, 0, '900.00', 'Including Gst', '950.00', 'Excluding Gst', '1000.000', '900.00', '', '100.000', '', '2022-01-27', ''),
(74, 4, 7, '', 'Parle_Rusk_2', 'Parle Elaichi Rusk', 7, '', 6, 0, 0, '200.00', 'Including Gst', '250.00', 'Excluding Gst', '1000.000', '200.00', '', '100.000', '', '2022-01-20', ''),
(75, 4, 8, '', 'Britannia_3', 'Britannia Rusk', 8, '', 7, 0, 0, '100.00', 'Excluding Gst', '150.00', 'Including Gst', '1000.000', '100.00', '', '100.000', '', '2022-01-21', ''),
(76, 4, 6, '', 'rusk_4', 'Premium Elaichi Rusk', 6, '', 1, 0, 0, '400.00', 'Including Gst', '450.00', 'Excluding Gst', '1000.000', '400.00', '', '100.000', '', '2022-01-11', ''),
(77, 4, 8, '', 'britana_toast_5', 'Britannia Toastea', 5, '', 8, 0, 0, '700.00', 'Including Gst', '750.00', 'Excluding Gst', '1000.000', '700.00', '', '100.000', '', '2022-01-22', ''),
(78, 4, 6, '', 'jeera_toast_6', 'Amul Jeera Toast', 7, '', 1, 0, 0, '200.00', 'Including Gst', '250.00', 'Excluding Gst', '1000.000', '200.00', '', '100.000', '', '2022-01-29', ''),
(79, 4, 5, '', 'Milk_toast_7', 'Amul Milk Toast', 4, '', 6, 0, 0, '1000.00', 'Including Gst', '1200.00', 'Excluding Gst', '1000.000', '1000.00', '', '100.000', '', '2022-01-28', ''),
(80, 4, 2, '', 'Britannia_Coco_Creme_1', 'Britannia Treat Coco Creme', 1, '', 7, 0, 0, '500.00', 'Excluding Gst', '510.00', 'Including Gst', '1000.000', '500.00', '', '100.000', '', '2022-01-29', ''),
(81, 4, 5, '', 'Muffets_2', 'Muffets & Tuffets', 6, '', 7, 0, 0, '330.00', 'Excluding Gst', '400.00', 'Including Gst', '100.000', '330.00', '', '100.000', '', '2022-01-17', ''),
(82, 4, 7, '', 'b_pav_3', 'Britannia Paw', 5, '', 7, 0, 0, '70.00', 'Including Gst', '100.00', 'Excluding Gst', '1000.000', '70.00', '', '100.000', '', '2022-01-29', ''),
(83, 4, 4, '', 'Multigrain_4', 'Multigrain Bread', 3, '', 6, 0, 0, '900.00', 'Including Gst', '950.00', 'Excluding Gst', '1000.000', '900.00', '', '100.000', '', '2022-01-13', ''),
(84, 4, 2, '', 'Bread_5', 'Brown Bread', 1, '', 6, 0, 0, '200.00', 'Including Gst', '250.00', 'Excluding Gst', '1000.000', '200.00', '', '100.000', '', '2022-01-24', ''),
(85, 4, 4, '', 'Bread_6', 'Whole Wheat Bread', 3, '', 2, 0, 0, '99.00', 'Including Gst', '120.00', 'Excluding Gst', '1000.000', '99.00', '', '100.000', '', '2022-01-29', ''),
(86, 4, 5, '', 'Pizza_base_7', 'Muffets & Tuffets Pizza Base', 4, '', 6, 0, 0, '300.00', 'Excluding Gst', '350.00', 'Including Gst', '1000.000', '300.00', '', '100.000', '', '2022-01-04', ''),
(87, 4, 6, '', 'Maida_Pizza_8', 'Maida Pizza Base', 5, '', 1, 0, 0, '400.00', 'Including Gst', '450.00', 'Excluding Gst', '1000.000', '400.00', '', '100.000', '', '2022-01-03', ''),
(88, 4, 7, '', 'Garden_pain_9', 'American Garden Plain', 6, '', 6, 0, 0, '400.00', 'Including Gst', '450.00', 'Excluding Gst', '1000.000', '400.00', '', '100.000', '', '2022-01-15', ''),
(89, 4, 8, '', 'Karachi_Fruit_Biscuit_1', 'Karachi Fruit Biscuit', 8, '', 6, 0, 0, '550.00', 'Including Gst', '600.00', 'Excluding Gst', '1000.000', '550.00', '', '100.000', '', '2022-01-04', ''),
(90, 4, 2, '', 'Butter_2', 'Amul Almond Butter', 1, '', 7, 0, 0, '660.00', 'Excluding Gst', '700.00', 'Including Gst', '1000.000', '660.00', '', '100.000', '', '2022-01-09', ''),
(91, 4, 4, '', 'Karachi_Bakery_3', 'Karachi Bakery Chocolate', 3, '', 6, 0, 0, '260.00', 'Including Gst', '300.00', 'Excluding Gst', '1000.000', '260.00', '', '100.000', '', '2022-01-16', ''),
(92, 4, 5, '', 'Cashew_4', 'Amul Cashew', 4, '', 5, 0, 0, '85.00', 'Excluding Gst', '100.00', 'Including Gst', '1000.000', '85.00', '', '100.000', '', '2022-01-12', ''),
(93, 4, 6, '', 'bikaji_5', 'Bikaji Cookies', 5, '', 6, 0, 0, '75.00', 'Including Gst', '90.00', 'Excluding Gst', '1000.000', '75.00', '', '100.000', '', '2022-01-06', ''),
(94, 4, 7, '', 'jeera_cookie_6', 'Amul Jeera Cookies', 7, '', 1, 0, 0, '199.00', 'Excluding Gst', '110.00', 'Including Gst', '1000.000', '99.00', '', '100.000', '', '2022-01-19', ''),
(95, 4, 8, '', 'bikaji_jeera_7', 'Bikaji Just Baked Jeera', 8, '', 3, 0, 0, '119.00', 'Including Gst', '150.00', 'Excluding Gst', '1000.000', '119.00', '', '100.000', '', '2022-01-13', ''),
(96, 4, 2, '', 'bikaji_8', 'Bikaji Just Baked Butter', 1, '', 7, 0, 0, '100.00', 'Including Gst', '120.00', 'Excluding Gst', '1000.000', '100.00', '', '100.000', '', '2022-01-24', ''),
(97, 4, 4, '', 'lovely_cookies_9', 'Lovely Chocochip Cookies', 3, '', 6, 0, 0, '120.00', 'Including Gst', '150.00', 'Excluding Gst', '1000.000', '120.00', '', '100.000', '', '2022-01-11', ''),
(98, 4, 7, '', 'Pista_Cookies_10', 'Butter Pista Cookies', 8, '', 6, 0, 0, '220.00', 'Including Gst', '250.00', 'Excluding Gst', '1000.000', '220.00', '', '100.000', '', '2022-01-19', ''),
(99, 4, 8, '', 'chees_slice_1', 'Britannia Cheese Slices', 7, '', 3, 0, 0, '229.00', 'Excluding Gst', '250.00', 'Including Gst', '1000.000', '229.00', '', '100.000', '', '2022-01-10', ''),
(100, 4, 5, '', 'bhujiya_srv_1', 'Haldiram Nagpur Bhujia Sev ', 4, '', 7, 0, 0, '120.00', 'Including Gst', '150.00', 'Excluding Gst', '1000.000', '120.00', '', '100.000', '', '2022-01-08', ''),
(101, 4, 6, '', 'mix_navratan_2', 'Snactac Navratan Mix', 6, '', 4, 0, 0, '99.00', 'Including Gst', '120.00', 'Excluding Gst', '1000.000', '99.00', '', '100.000', '', '2022-01-21', ''),
(102, 4, 7, '', 'Namkeen_Mixture_3', 'Rajam Snacks Madras Namkeen Mixture', 7, '', 7, 0, 0, '25.00', 'Including Gst', '40.00', 'Excluding Gst', '1000.000', '25.00', '', '100.000', '', '2022-02-06', ''),
(103, 4, 8, '', 'maida_kaju_4', 'Bikaji Namkeen Maida Kaju', 8, '', 7, 0, 0, '129.00', 'Including Gst', '140.00', 'Excluding Gst', '1000.000', '129.00', '', '100.000', '', '2022-02-04', ''),
(104, 4, 2, '', 'ragi_chips_5', 'Riya Namkeens Ragi Chips', 1, '', 7, 0, 0, '150.00', 'Excluding Gst', '160.00', 'Including Gst', '1000.000', '150.00', '', '100.000', '', '2022-01-16', ''),
(105, 4, 4, '', 'cookie_1', 'Unibic Choco Chip Cookies ', 3, '', 6, 0, 0, '210.00', 'Including Gst', '220.00', 'Excluding Gst', '1000.000', '210.00', '', '100.000', '', '2022-01-07', ''),
(106, 4, 5, '', 'good_day_choko_2', 'Britannia Good Day Choco-chip Cookies ', 4, '', 6, 0, 0, '175.00', 'Excluding Gst', '190.00', 'Including Gst', '1000.000', '175.00', '', '100.000', '', '2022-01-28', ''),
(107, 4, 6, '', 'fantasy_chokko_3', 'Sunfeast Dark Fantasy Choco Fill Cookies', 5, '', 7, 0, 0, '195.00', 'Including Gst', '210.00', 'Excluding Gst', '100.000', '195.00', '', '100.000', '', '2022-01-23', ''),
(108, 4, 7, '', 'happy_cookie_4', 'Parle Happy Happy Choco-Chip Cookies', 6, '', 8, 0, 0, '559.00', 'Including Gst', '570.00', 'Excluding Gst', '1000.000', '559.00', '', '100.000', '', '2022-01-19', ''),
(109, 4, 8, '', 'unibik_cookie_5', 'Unibic Fruit & Nut Cookies', 7, '', 1, 0, 0, '100.00', 'Excluding Gst', '120.00', 'Including Gst', '1000.000', '100.00', '', '100.000', '', '2022-02-04', ''),
(110, 4, 2, '', 'meggie_1', 'Sunfeast Yippee Power Up Masala Instant Atta Noodles', 8, '', 7, 0, 0, '120.00', 'Including Gst', '150.00', 'Excluding Gst', '1000.000', '120.00', '', '100.000', '', '2022-01-20', ''),
(111, 4, 5, '', 'meggie_2', 'Maggi 2-Minute Masala Instant Noodles', 5, '', 6, 0, 0, '595.00', 'Including Gst', '610.00', 'Excluding Gst', '1000.000', '595.00', '', '100.000', '', '2022-02-02', ''),
(112, 4, 2, '', 'meggie_3', 'Top Ramen New Masala Instant Noodles', 1, '', 7, 0, 0, '195.00', 'Excluding Gst', '210.00', 'Including Gst', '1000.000', '195.00', '', '100.000', '', '2022-01-06', ''),
(113, 4, 4, '', 'manchurian_meggie_4', 'Chings Secret Manchurian Instant Noodles', 3, '', 7, 0, 0, '669.00', 'Including Gst', '700.00', 'Excluding Gst', '1000.000', '669.00', '', '100.000', '', '2022-01-22', ''),
(114, 4, 5, '', 'ketchup_1', 'Del Monte Tomato Ketchup', 4, '', 5, 0, 0, '100.00', 'Including Gst', '150.00', 'Excluding Gst', '1000.000', '100.00', '', '100.000', '', '2022-01-15', ''),
(115, 4, 6, '', 'mayommaise_2', 'Funfoods Veg Mayonnaise', 5, '', 3, 0, 0, '60.00', 'Excluding Gst', '70.00', 'Including Gst', '1000.000', '60.00', '', '100.000', '', '2022-01-29', ''),
(116, 4, 7, '', 'sandwish_spread_3', 'Funfoods Eggless Thousand Island Sandwich Spread', 7, '', 13, 0, 0, '195.00', 'Including Gst', '210.00', 'Excluding Gst', '1000.000', '195.00', '', '100.000', '', '2022-01-03', ''),
(117, 4, 8, '', 'peanut_butter_5', 'Sundrop Creamy Peanut Butter', 7, '', 7, 0, 0, '95.00', 'Including Gst', '120.00', 'Excluding Gst', '1000.000', '95.00', '', '100.000', '', '2021-12-27', ''),
(124, 4, 2, '', '', '', 1, '', 6, 6, 7, '0.00', 'Including Gst', '0.00', 'Including Gst', '0.000', '0.00', '', '0.000', '', '0000-00-00', '');

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
  `is_gst_bill` bit(1) NOT NULL DEFAULT b'1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_purchase_invoice`
--

INSERT INTO `tbl_purchase_invoice` (`purchase_invoice_id`, `company_id`, `party_id`, `ref_order_id`, `invoice_no`, `out_of_state`, `state_of_supply`, `purchase_invoice_date`, `payment_type_id`, `narration`, `sub_total`, `shipping_packing_ammount`, `is_round_off`, `round_off`, `total`, `pay`, `financial_id`, `new_invoice_no`, `is_gst_bill`) VALUES
(35, 4, 4, 'BHK', 1, 0, 'GUJARAT', '2022-01-24', 1, '', '97.00', '3.00', b'1', '0.00', '100.00', '100.00', 8, '', b'1');

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
(37, 4, 35, 2, 2, 'miliGram (mg)', '1.00', '100.00', '100.00', '3.00', '3.00', '97.00', 6, '9.70', '10.00', '0.00', '0.00', '97.00', 8, '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_purchase_return_invoice`
--

CREATE TABLE `tbl_purchase_return_invoice` (
  `purchase_return_invoice_id` bigint(20) NOT NULL,
  `company_id` bigint(20) NOT NULL,
  `party_id` bigint(20) NOT NULL,
  `ref_order_id` varchar(50) NOT NULL,
  `invoice_no` bigint(20) NOT NULL,
  `out_of_state` tinyint(4) NOT NULL,
  `state_of_supply` varchar(50) NOT NULL,
  `purchase_return_invoice_date` date NOT NULL,
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

-- --------------------------------------------------------

--
-- Table structure for table `tbl_purchase_return_invoice_detail`
--

CREATE TABLE `tbl_purchase_return_invoice_detail` (
  `purchase_return_invoice_detail_id` bigint(20) NOT NULL,
  `company_id` bigint(20) NOT NULL,
  `purchase_return_invoice_id` bigint(20) NOT NULL,
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
(17, 4, 1, 1, 0, 'GUJARAT', '2022-01-24', 1, '', '1995.00', '50.00', b'1', '0.00', '2045.00', '2050.00', 8, '', b'0');

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
(16, 4, 0, 1, 1, 'kilogram(kg)', '210.00', '5.00', '1050.00', '2.50', '26.25', '1023.75', 1, '71.66', '7.00', '0.00', '0.00', '1023.75', 8, 'asdfghjkl'),
(18, 4, 17, 1, 1, 'kilogram(kg)', '210.00', '10.00', '2100.00', '5.00', '105.00', '1995.00', 3, '119.70', '6.00', '0.00', '0.00', '1995.00', 8, '');

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
(12, 'centimeter', '2022-01-13 04:09:10'),
(15, 'microgram', '2022-01-26 11:59:23');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_unit_conversion`
--

CREATE TABLE `tbl_unit_conversion` (
  `conversion_id` bigint(20) NOT NULL,
  `primary_unit` varchar(50) NOT NULL,
  `primary_unit_id` bigint(20) NOT NULL,
  `secondary_unit` varchar(50) NOT NULL,
  `secondary_unit_id` bigint(20) NOT NULL,
  `rate` decimal(18,2) NOT NULL,
  `is_default` bit(1) NOT NULL DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_unit_conversion`
--

INSERT INTO `tbl_unit_conversion` (`conversion_id`, `primary_unit`, `primary_unit_id`, `secondary_unit`, `secondary_unit_id`, `rate`, `is_default`) VALUES
(12, 'box', 6, 'packet', 7, '50.00', b'1'),
(13, 'kilogram(kg)', 1, 'miliGram (mg)', 2, '1000.00', b'0');

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
-- Indexes for table `tbl_cashmemo_return`
--
ALTER TABLE `tbl_cashmemo_return`
  ADD PRIMARY KEY (`cashmemo_return_id`);

--
-- Indexes for table `tbl_cashmemo_return_detail`
--
ALTER TABLE `tbl_cashmemo_return_detail`
  ADD PRIMARY KEY (`cashmemo_return_detail_id`);

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
-- Indexes for table `tbl_company_ledger`
--
ALTER TABLE `tbl_company_ledger`
  ADD PRIMARY KEY (`company_ledger_id`);

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
-- Indexes for table `tbl_party_ledger`
--
ALTER TABLE `tbl_party_ledger`
  ADD PRIMARY KEY (`party_ladger_id`);

--
-- Indexes for table `tbl_party_master`
--
ALTER TABLE `tbl_party_master`
  ADD PRIMARY KEY (`party_id`);

--
-- Indexes for table `tbl_party_setting`
--
ALTER TABLE `tbl_party_setting`
  ADD PRIMARY KEY (`party_setting_id`);

--
-- Indexes for table `tbl_payment_type`
--
ALTER TABLE `tbl_payment_type`
  ADD PRIMARY KEY (`payment_type_id`);

--
-- Indexes for table `tbl_place_of_supply_master`
--
ALTER TABLE `tbl_place_of_supply_master`
  ADD PRIMARY KEY (`place_of_supply_id`);

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
-- Indexes for table `tbl_purchase_return_invoice`
--
ALTER TABLE `tbl_purchase_return_invoice`
  ADD PRIMARY KEY (`purchase_return_invoice_id`);

--
-- Indexes for table `tbl_purchase_return_invoice_detail`
--
ALTER TABLE `tbl_purchase_return_invoice_detail`
  ADD PRIMARY KEY (`purchase_return_invoice_detail_id`);

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
-- Indexes for table `tbl_unit_conversion`
--
ALTER TABLE `tbl_unit_conversion`
  ADD PRIMARY KEY (`conversion_id`);

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
  MODIFY `cashmemo_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `tbl_cashmemo_detail`
--
ALTER TABLE `tbl_cashmemo_detail`
  MODIFY `cashmemo_detail_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tbl_cashmemo_return`
--
ALTER TABLE `tbl_cashmemo_return`
  MODIFY `cashmemo_return_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_cashmemo_return_detail`
--
ALTER TABLE `tbl_cashmemo_return_detail`
  MODIFY `cashmemo_return_detail_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
-- AUTO_INCREMENT for table `tbl_company_ledger`
--
ALTER TABLE `tbl_company_ledger`
  MODIFY `company_ledger_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

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
  MODIFY `gstslab_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tbl_party_ledger`
--
ALTER TABLE `tbl_party_ledger`
  MODIFY `party_ladger_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `tbl_party_master`
--
ALTER TABLE `tbl_party_master`
  MODIFY `party_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `tbl_payment_type`
--
ALTER TABLE `tbl_payment_type`
  MODIFY `payment_type_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_place_of_supply_master`
--
ALTER TABLE `tbl_place_of_supply_master`
  MODIFY `place_of_supply_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `tbl_product_master`
--
ALTER TABLE `tbl_product_master`
  MODIFY `product_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=125;

--
-- AUTO_INCREMENT for table `tbl_purchase_invoice`
--
ALTER TABLE `tbl_purchase_invoice`
  MODIFY `purchase_invoice_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `tbl_purchase_invoice_detail`
--
ALTER TABLE `tbl_purchase_invoice_detail`
  MODIFY `purchase_invoice_detail_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `tbl_purchase_return_invoice`
--
ALTER TABLE `tbl_purchase_return_invoice`
  MODIFY `purchase_return_invoice_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_purchase_return_invoice_detail`
--
ALTER TABLE `tbl_purchase_return_invoice_detail`
  MODIFY `purchase_return_invoice_detail_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_sales_invoice`
--
ALTER TABLE `tbl_sales_invoice`
  MODIFY `sales_invoice_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `tbl_sales_invoice_detail`
--
ALTER TABLE `tbl_sales_invoice_detail`
  MODIFY `sales_invoice_detail_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `tbl_sales_return`
--
ALTER TABLE `tbl_sales_return`
  MODIFY `sales_return_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `tbl_sales_return_detail`
--
ALTER TABLE `tbl_sales_return_detail`
  MODIFY `sales_return_detail_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `tbl_size`
--
ALTER TABLE `tbl_size`
  MODIFY `size_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tbl_unit`
--
ALTER TABLE `tbl_unit`
  MODIFY `unit_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `tbl_unit_conversion`
--
ALTER TABLE `tbl_unit_conversion`
  MODIFY `conversion_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
