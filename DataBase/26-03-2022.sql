-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 26, 2022 at 12:42 PM
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `deleteIncome` (IN `INC_ID` BIGINT(20))  BEGIN
	DELETE FROM tbl_income_detail  WHERE income_id  = INC_ID ;
     	DELETE FROM tbl_company_ledger  WHERE related_id  = INC_ID ;
       	DELETE FROM tbl_party_ledger  WHERE invoice_no  = INC_ID ;
	DELETE FROM tbl_income WHERE income_id = INC_ID ;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `deleteManageUser` (IN `UID` BIGINT(20))  BEGIN
	DELETE FROM manage_user_tbl WHERE user_id = UID;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `deleteParty_group` (IN `PGID` BIGINT(20))  BEGIN
	DELETE FROM tbl_party_group WHERE party_group_id = PGID ;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `deleteParty_master` (IN `PID` BIGINT(20))  BEGIN
	DELETE FROM tbl_party_master WHERE party_id  = PID ;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `deletePayment_in` (IN `P_ID` BIGINT(20))  BEGIN
     	DELETE FROM tbl_company_ledger  WHERE related_id  = P_ID ;
       	DELETE FROM tbl_party_ledger  WHERE invoice_no  = P_ID ;
	DELETE FROM tbl_payment_in WHERE payment_in_id = P_ID ;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `deletePayment_out` (IN `P_ID` BIGINT(20))  BEGIN
     	DELETE FROM tbl_company_ledger  WHERE related_id  = P_ID ;
       	DELETE FROM tbl_party_ledger  WHERE invoice_no  = P_ID ;
	DELETE FROM tbl_payment_out WHERE payment_out_id = P_ID ;
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
       DELETE FROM tbl_payment_out  WHERE obj_id  = PROID;
	DELETE FROM tbl_purchase_invoice  WHERE purchase_invoice_id  = PROID;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `deletePurchase_return_invoice` (IN `ID` BIGINT(20))  BEGIN
	DELETE FROM tbl_purchase_return_invoice_detail  WHERE purchase_return_invoice_id   = ID;
    DELETE FROM tbl_company_ledger  WHERE related_id  = ID;
       DELETE FROM tbl_party_ledger  WHERE invoice_no  = ID;
      DELETE FROM tbl_payment_in  WHERE obj_id  = ID; 
	DELETE FROM tbl_purchase_return_invoice WHERE purchase_return_invoice_id   = ID;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `deleteSales_invoice` (IN `SID` BIGINT(20))  BEGIN
	DELETE FROM tbl_sales_invoice_detail  WHERE sales_invoice_id  = SID;
    DELETE FROM tbl_company_ledger  WHERE related_id  =
SID;
       DELETE FROM tbl_party_ledger  WHERE invoice_no  = SID;
       DELETE FROM tbl_payment_in  WHERE obj_id  = SID;
	DELETE FROM tbl_sales_invoice WHERE sales_invoice_id  = SID;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `deleteSales_return` (IN `SID` BIGINT(20))  BEGIN
	DELETE FROM tbl_sales_return_detail  WHERE sales_return_id = SID ;
    DELETE FROM tbl_company_ledger  WHERE related_id  = SID;
       DELETE FROM tbl_party_ledger  WHERE invoice_no  = SID;
       DELETE FROM tbl_payment_out  WHERE obj_id  = SID;
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `fetchParty_group` (IN `PGID` BIGINT(20))  BEGIN
	SELECT * FROM tbl_party_group WHERE party_group_id = PGID;
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `insertParty_group` (IN `PGNAME` VARCHAR(100))  BEGIN
	INSERT INTO tbl_party_group (party_group_name) VALUES (PGNAME);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insertParty_master` (IN `TYPE` INT(6), IN `NAME` VARCHAR(100), IN `GRP` INT, IN `MOBILE` BIGINT(20), IN `ALT_MOBILE` BIGINT(20), IN `EML` VARCHAR(100), IN `BILL_ADD` VARCHAR(250), IN `SHIP_ADD` VARCHAR(250), IN `GST_TYP` VARCHAR(100), IN `GSTIN` VARCHAR(20), IN `STAT` VARCHAR(50), IN `CID` INT(20), IN `ADD_1` VARCHAR(50), IN `ADD_2` VARCHAR(50), IN `ADD_3` VARCHAR(50), IN `ADD_4` VARCHAR(50), IN `OBALANCE` DECIMAL(18,2), IN `BALSTATUS` VARCHAR(50), IN `ASDATE` DATE)  BEGIN
	INSERT INTO tbl_party_master (party_type,party_name,party_group_id ,mobile_no,alter_mobile_no,email,billing_address,shipping_address, gst_type,gst_in,state,company_id,additional_field_1_name,additional_field_2_name,additional_field_3_name,additional_field_4_name,opening_balance,balance_status,as_of_date) VALUES (TYPE,NAME,GRP,MOBILE,ALT_MOBILE,EML, BILL_ADD,SHIP_ADD,GST_TYP,GSTIN,STAT,CID,ADD_1,ADD_2,ADD_3,ADD_4,OBALANCE,BALSTATUS,ASDATE);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insertPayment_type` (IN `PTYPE` VARCHAR(100))  BEGIN
	INSERT INTO tbl_payment_type ( payment_type) VALUES (PTYPE);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insertProduct_master` (IN `CID` BIGINT(20), IN `CAT` BIGINT(20), IN `BAR` VARCHAR(50), IN `PCODE` VARCHAR(50), IN `PNAME` VARCHAR(100), IN `GSTID` BIGINT(20), IN `HSN` VARCHAR(50), IN `U_ID` BIGINT(20), IN `P_ID` BIGINT(20), IN `S_ID` BIGINT(20), IN `PRATE` DECIMAL(18,2), IN `PTAX` VARCHAR(50), IN `SRATE` DECIMAL(18,2), IN `STAX` VARCHAR(50), IN `OPSTOCK` DECIMAL(18,2), IN `UPP` DECIMAL(18,2), IN `DES` VARCHAR(500), IN `MIN` DECIMAL(18,3), IN `PLOC` VARCHAR(100), IN `PDATE` DATE, IN `DONSALE` DECIMAL(18,2), IN `TRATE` DECIMAL(18,2), IN `ADDPUNIT` DECIMAL(18,2), IN `DTYPE` VARCHAR(100), IN `PIMG` VARCHAR(2000), IN `ISBATCH` BIT(1), IN `ISSERIAL` BIT(1))  BEGIN
  INSERT INTO tbl_product_master (company_id , category_id , barcode , product_code , product_name , gstslab_id , hsn_code ,unit_id,primary_unit_id,secondary_unit_id,purchase_rate,purchase_tax_type,sales_rate,sales_tax_type,opening_stock,closing_stock,unit_per_price,description,min_stock_qty,product_location,product_date,discount_on_sale,tax_rate,additional_cess_per_unit,discount_type,product_image,is_batch,is_serial )
  VALUES (CID , CAT , BAR , PCODE , PNAME , GSTID , HSN ,U_ID,P_ID,S_ID, PRATE , PTAX , SRATE , STAX , OPSTOCK , OPSTOCK , UPP , DES , MIN , PLOC , PDATE, DONSALE,TRATE, ADDPUNIT,DTYPE, PIMG,ISBATCH,ISSERIAL);	
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `updateParty_group` (IN `PGID` BIGINT(20), IN `PGNAME` VARCHAR(100))  BEGIN
	UPDATE tbl_party_group SET party_group_name = PGNAME WHERE party_group_id = PGID; 
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `updateParty_master` (IN `PID` BIGINT(20), IN `TYPE` BIGINT(20), IN `NAME` VARCHAR(100), IN `GRP` BIGINT(20), IN `MOBILE` BIGINT(20), IN `ALT_MOBILE` BIGINT(20), IN `EML` VARCHAR(100), IN `BILL_ADD` VARCHAR(250), IN `SHIP_ADD` VARCHAR(250), IN `GST_TYP` VARCHAR(100), IN `GSTIN` VARCHAR(20), IN `STAT` VARCHAR(50), IN `ADD_1` VARCHAR(50), IN `ADD_2` VARCHAR(50), IN `ADD_3` VARCHAR(50), IN `ADD_4` VARCHAR(50), IN `OBALANCE` DECIMAL(18,2), IN `BALSTATUS` VARCHAR(50), IN `ASDATE` DATE)  BEGIN
	UPDATE tbl_party_master SET party_type=TYPE, party_name = NAME, party_group_id = GRP ,mobile_no = MOBILE, alter_mobile_no = ALT_MOBILE, email = EML, billing_address  = BILL_ADD, shipping_address = SHIP_ADD, gst_type =  GST_TYP, gst_in = GSTIN, state = STAT,additional_field_1_name=ADD_1,additional_field_2_name=ADD_2,additional_field_3_name=ADD_3,additional_field_4_name=ADD_4,opening_balance =OBALANCE,balance_status=BALSTATUS,as_of_date=ASDATE WHERE party_id = PID;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `updatePayment_type` (IN `PID` BIGINT(20), IN `PTYPE` VARCHAR(100))  BEGIN
	UPDATE tbl_payment_type SET payment_type = PTYPE WHERE payment_type_id  = PID ;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `updateProduct_master` (IN `PID` BIGINT(20), IN `CAT` BIGINT(20), IN `BAR` VARCHAR(50), IN `PCODE` VARCHAR(50), IN `PNAME` VARCHAR(100), IN `GSTID` BIGINT(20), IN `HSN` VARCHAR(50), IN `U_ID` BIGINT(20), IN `P_ID` BIGINT(20), IN `S_ID` BIGINT(20), IN `PRATE` DECIMAL(18,2), IN `PTAX` VARCHAR(50), IN `SRATE` DECIMAL(18,2), IN `STAX` VARCHAR(50), IN `OPSTOCK` DECIMAL(18,2), IN `UPP` DECIMAL(18,2), IN `DES` VARCHAR(500), IN `MIN` DECIMAL(18,3), IN `PLOC` VARCHAR(100), IN `PDATE` DATE, IN `DONSALE` DECIMAL(18,2), IN `TRATE` DECIMAL(18,2), IN `ADDPUNIT` DECIMAL(18,2), IN `DTYPE` VARCHAR(100), IN `PIMG` VARCHAR(2000))  BEGIN
	UPDATE  tbl_product_master SET category_id = CAT, barcode = BAR, product_code = PCODE, product_name = PNAME, gstslab_id = GSTID, hsn_code = HSN, 
	unit_id = U_ID, primary_unit_id=P_ID,secondary_unit_id=S_ID,purchase_rate = PRATE, purchase_tax_type = PTAX, sales_rate = SRATE, sales_tax_type = STAX, opening_stock = OPSTOCK,
	unit_per_price = UPP, description = DES, min_stock_qty = MIN, product_location = PLOC, product_date = PDATE,discount_on_sale=DONSALE,tax_rate=TRATE,additional_cess_per_unit=ADDPUNIT,discount_type=DTYPE, product_image= PIMG WHERE product_id = PID;
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `viewCotation` ()  BEGIN
	SELECT co.* , par.party_name  FROM tbl_quotation co
	LEFT JOIN tbl_company com ON com.company_id = co.company_id
    	LEFT JOIN tbl_party_master par ON par.party_id = co.party_id
    	LEFT JOIN tbl_financial_master fi ON fi.financial_id = co.financial_id
	WHERE com.is_default = 1 and fi.is_default=1;
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `viewParty_group` ()  BEGIN
	SELECT * FROM tbl_party_group;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `viewParty_master` ()  BEGIN
   SELECT par.*,pg.party_group_name, com.company_name
FROM tbl_party_master par
LEFT JOIN tbl_company com ON com.company_id  = par.company_id
 LEFT JOIN tbl_party_group pg ON pg.party_group_id  = par.party_group_id
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
(1, 'admin', 'admin', 'admin@gmail.com', 9328659886, '123', 'default.png', b'1', '2021-11-26 04:42:56'),
(3, 'bhautik', 'bhautik patel', 'bhautikpatel1201@gmail.com', 9328659886, '123', 'photo_2021-12-07_16-12-40618063.jpg', b'1', '2021-11-26 06:03:44'),
(4, 'mihir', 'mihir pradhan', 'mihirhpradhan@gmail.com', 9376521396, '123', 'IMG_4456666538.PNG', b'1', '2021-11-26 14:41:34'),
(6, 'mansi', 'mansi mansi', 'mansi4653@gmail.com', 9876543210, '123', '', b'0', '2021-12-04 11:15:47'),
(7, 'kp', 'kunal gavar', 'kunalpawar354@gmail.com', 1234567890, '123', 'kunal648133.jpg', b'0', '2021-12-04 11:29:18'),
(8, 'pratik', 'pratik raval', 'pratikcraval@gmail.com', 9016150454, '123', '', b'0', '2022-02-26 09:47:24');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_bank_account`
--

CREATE TABLE `tbl_bank_account` (
  `bank_account_id` bigint(20) NOT NULL,
  `account_name` varchar(50) NOT NULL,
  `opening_balance` int(20) NOT NULL,
  `as_of_date` date NOT NULL,
  `is_print_upi` bit(1) NOT NULL,
  `is_print_bank_account` bit(1) NOT NULL,
  `account_number` varchar(50) NOT NULL,
  `ifsc_code` varchar(50) NOT NULL,
  `upi_qr_code` varchar(50) NOT NULL,
  `bank_name` varchar(50) NOT NULL,
  `account_holder_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_bank_account`
--

INSERT INTO `tbl_bank_account` (`bank_account_id`, `account_name`, `opening_balance`, `as_of_date`, `is_print_upi`, `is_print_bank_account`, `account_number`, `ifsc_code`, `upi_qr_code`, `bank_name`, `account_holder_name`) VALUES
(1, 'ICICI', 10000, '2022-02-02', b'1', b'1', '12398745', 'ICICI123456', '96385274', 'ICICI', 'Bhautik Patel'),
(4, 'Bank Of baroda', 10000, '2022-02-02', b'1', b'1', '12398745', 'ICICI123456', '9874265', 'Bank of baroda', 'mansi ');

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
-- Table structure for table `tbl_batch_tracking`
--

CREATE TABLE `tbl_batch_tracking` (
  `batch_tracking_id` bigint(20) NOT NULL,
  `company_id` bigint(20) NOT NULL,
  `product_id` bigint(20) NOT NULL,
  `mrp_price` decimal(18,2) NOT NULL,
  `batch_no` varchar(50) NOT NULL,
  `exp_date` date NOT NULL,
  `mfg_date` date NOT NULL,
  `model_no` varchar(50) NOT NULL,
  `size` varchar(50) NOT NULL,
  `quantity` decimal(18,2) NOT NULL,
  `is_sold` bit(4) NOT NULL DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_batch_tracking`
--

INSERT INTO `tbl_batch_tracking` (`batch_tracking_id`, `company_id`, `product_id`, `mrp_price`, `batch_no`, `exp_date`, `mfg_date`, `model_no`, `size`, `quantity`, `is_sold`) VALUES
(1, 4, 7, '10.00', 'E001', '2023-01-01', '2022-01-01', 'm123', 'S', '97.00', b'0000'),
(2, 4, 7, '20.00', 'E002', '2023-02-20', '2022-02-20', 'm456', 'M', '48.00', b'0000'),
(3, 4, 7, '40.00', 'E003', '2023-10-10', '2021-02-14', 'm789', 'L', '10.00', b'0000'),
(4, 4, 155, '10.00', 'P001', '2025-04-16', '2022-03-16', 'P101', '1 inch', '195.00', b'0000'),
(5, 4, 155, '20.00', 'P002', '2022-10-16', '2021-08-16', 'P102', '1.5 inch', '150.00', b'0000');

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
(2, 4, 'Bhautik', 9328659886, 1, 0, 'GUJARAT', '2022-03-26', 1, '', '550.00', '0.00', b'1', '0.000', '550.00', '550.00', 8, '', b'0');

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
  `new_invoice_no` varchar(50) NOT NULL,
  `serial_no` varchar(50) NOT NULL,
  `batch_no` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_cashmemo_detail`
--

INSERT INTO `tbl_cashmemo_detail` (`cashmemo_detail_id`, `company_id`, `cashmemo_id`, `product_id`, `unit_id`, `unit`, `rate`, `qty`, `gross_total`, `disc_per`, `disc_amt`, `sub_total`, `gstslab_id`, `gst`, `gst_per`, `igst`, `igst_per`, `total`, `financial_id`, `new_invoice_no`, `serial_no`, `batch_no`) VALUES
(6, 4, 2, 155, 11, 'meter', '10.00', '15.00', '150.00', '0.00', '0.00', '150.00', 3, '9.00', '6.00', '0.00', '0.00', '159.00', 8, '', '', '4'),
(7, 4, 2, 155, 11, 'meter', '20.00', '20.00', '400.00', '0.00', '0.00', '400.00', 3, '24.00', '6.00', '0.00', '0.00', '424.00', 8, '', '', '5');

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

--
-- Dumping data for table `tbl_cashmemo_return`
--

INSERT INTO `tbl_cashmemo_return` (`cashmemo_return_id`, `company_id`, `customer_name`, `customer_mobile`, `invoice_no`, `out_of_state`, `state_of_supply`, `cashmemo_return_date`, `payment_type_id`, `narration`, `sub_total`, `shipping_packing_amount`, `is_round_off`, `round_off`, `total`, `pay`, `financial_id`, `new_invoice_no`, `is_gst_bill`) VALUES
(1, 4, 'Bhautik', 9328659886, 1, 0, 'GUJARAT', '2022-03-26', 1, 'test 01.02', '50.00', '0.00', b'0', '0.000', '50.00', '50.00', 8, '', b'0');

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
  `new_invoice_no` varchar(50) NOT NULL,
  `serial_no` varchar(50) NOT NULL,
  `batch_no` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_cashmemo_return_detail`
--

INSERT INTO `tbl_cashmemo_return_detail` (`cashmemo_return_detail_id`, `company_id`, `cashmemo_return_id`, `product_id`, `unit_id`, `unit`, `rate`, `qty`, `gross_total`, `disc_per`, `disc_amt`, `sub_total`, `gstslab_id`, `gst`, `gst_per`, `igst`, `igst_per`, `total`, `financial_id`, `new_invoice_no`, `serial_no`, `batch_no`) VALUES
(1, 4, 1, 155, 11, 'meter', '10.00', '5.00', '50.00', '0.00', '0.00', '50.00', 3, '3.00', '6.00', '0.00', '0.00', '50.00', 8, '', '', '4');

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
(2, 'C101', 'fruits', 4, '2021-12-18 15:22:34'),
(4, 'C102', 'vegetables', 4, '2021-12-23 05:17:25'),
(5, 'C103', 'green vegetables', 4, '2021-12-23 05:17:35'),
(6, 'C104', 'milk products', 4, '2021-12-23 05:17:48'),
(7, 'C105', 'food products', 4, '2021-12-23 05:18:03'),
(8, 'C105', 'other', 4, '2021-12-23 05:18:14'),
(9, 'H', 'Hardware', 4, '2022-02-19 06:35:10');

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
(4, 'bhautik', 9637521485, 6541239650, 'bhautikpatel1201@gmail.com', 'Pandesara', 'SURAT', 'GUJARAT', 394221, 'fghj', 'dfghj', 52146325, '7yfugi', 'bca', 'gyujnk', 'abc', 'yuhbj', 'gybjn845', 'photo_2021-12-07_16-12-40980284.jpg', 1),
(7, '', 0, 0, '', '', '', '', 0, '', '', 0, '', '', '', '', '', '', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_company_ledger`
--

CREATE TABLE `tbl_company_ledger` (
  `company_ledger_id` bigint(20) NOT NULL,
  `company_id` bigint(20) NOT NULL,
  `related_id` bigint(20) NOT NULL,
  `related_obj_name` varchar(50) NOT NULL,
  `party_id` bigint(20) NOT NULL,
  `date` date NOT NULL,
  `details` varchar(1000) NOT NULL,
  `credit` decimal(18,2) NOT NULL,
  `debit` decimal(18,2) NOT NULL,
  `financial_id` bigint(20) NOT NULL,
  `new_invoice_no` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_company_ledger`
--

INSERT INTO `tbl_company_ledger` (`company_ledger_id`, `company_id`, `related_id`, `related_obj_name`, `party_id`, `date`, `details`, `credit`, `debit`, `financial_id`, `new_invoice_no`) VALUES
(2, 4, 2, 'purchase', 5, '2022-02-16', 'insert into vasu(head) values (brain)', '0.00', '3500.00', 8, 'tsthuh'),
(3, 4, 3, 'purchase', 22, '2022-01-16', 'test for update', '0.00', '5718.00', 8, '11.03'),
(4, 4, 4, 'purchase', 26, '2021-12-16', 'inserting', '0.00', '455.50', 8, '11.15'),
(5, 4, 5, 'purchase', 28, '2021-11-16', 'ok', '0.00', '4230.00', 8, '11.16'),
(6, 4, 6, 'purchase', 33, '2021-09-16', 'ok', '0.00', '2730.00', 8, 'tsthuh'),
(8, 4, 7, 'purchase', 35, '2021-10-16', 'ok', '0.00', '3000.00', 8, '11.27'),
(9, 4, 8, 'purchase', 37, '2021-08-16', 'ok1', '0.00', '7818.00', 8, '11.32'),
(10, 4, 9, 'purchase', 4, '2021-07-16', 'ok', '0.00', '4900.00', 8, '11.34'),
(11, 4, 10, 'purchase', 5, '2021-06-16', 'ok', '0.00', '0.00', 8, '11.36'),
(12, 4, 11, 'purchase', 22, '2021-05-16', 'ok', '0.00', '0.00', 8, '11.37'),
(13, 4, 12, 'purchase', 26, '2021-04-16', 'ok', '0.00', '0.00', 8, 'asdfgh'),
(14, 4, 13, 'purchase', 28, '2021-03-16', 'ok', '0.00', '4000.00', 9, '11.40'),
(15, 4, 14, 'purchase', 31, '2021-02-16', 'olk', '0.00', '4010.00', 9, '11.43'),
(16, 4, 15, 'purchase', 33, '2021-01-16', 'ok', '0.00', '5000.00', 9, '11.46'),
(17, 4, 16, 'purchase', 35, '2020-12-16', 'ok', '0.00', '4800.00', 9, '11.48'),
(18, 4, 17, 'purchase', 37, '2020-11-16', 'ok', '0.00', '3860.00', 9, '11.49'),
(19, 4, 18, 'purchase', 4, '2020-10-16', 'ok', '0.00', '5000.00', 9, '11.51'),
(20, 4, 19, 'purchase', 5, '2020-08-16', 'ok', '0.00', '3200.00', 9, '11.53'),
(21, 4, 20, 'purchase', 22, '2020-09-16', 'ok', '0.00', '3500.00', 9, '11.56'),
(22, 4, 21, 'purchase', 26, '2020-07-16', '', '0.00', '5400.00', 9, '12.15'),
(24, 4, 2, 'sales', 3, '2020-08-16', '', '4000.00', '0.00', 9, ''),
(25, 4, 3, 'sales', 23, '2020-09-16', '', '5000.00', '0.00', 9, ''),
(26, 4, 4, 'sales', 25, '2020-10-16', '', '0.00', '0.00', 9, ''),
(27, 4, 5, 'sales', 27, '2020-11-16', '', '4000.00', '0.00', 9, '05.19'),
(28, 4, 6, 'sales', 30, '2020-12-16', '', '3241.00', '0.00', 9, ''),
(29, 4, 7, 'sales', 32, '2021-01-16', '', '2000.00', '0.00', 9, ''),
(30, 4, 8, 'sales', 34, '2021-02-16', '', '2280.00', '0.00', 9, ''),
(31, 4, 9, 'sales', 36, '2021-03-16', '', '1500.00', '0.00', 9, ''),
(32, 4, 10, 'sales', 38, '2021-04-16', '', '3100.00', '0.00', 8, ''),
(33, 4, 11, 'sales', 1, '2021-05-16', '', '2400.00', '0.00', 8, ''),
(34, 4, 12, 'sales', 3, '2021-06-16', '', '4000.00', '0.00', 8, '05.29'),
(35, 4, 13, 'sales', 23, '2021-07-16', '', '1782.00', '0.00', 8, '05.31'),
(36, 4, 14, 'sales', 25, '2021-08-16', '', '4000.00', '0.00', 8, '05.33'),
(37, 4, 15, 'sales', 27, '2021-09-16', '', '3078.00', '0.00', 8, '05.36'),
(38, 4, 16, 'sales', 30, '2021-10-16', '', '2800.00', '0.00', 8, '05.39'),
(39, 4, 17, 'sales', 32, '2021-11-16', '', '2914.00', '0.00', 8, '05.41'),
(40, 4, 18, 'sales', 34, '2021-12-16', '', '7985.00', '0.00', 8, '05.50'),
(41, 4, 19, 'sales', 36, '2022-01-16', '', '4000.00', '0.00', 8, '05.54'),
(42, 4, 20, 'sales', 38, '2022-02-16', '', '11000.00', '0.00', 8, ''),
(43, 4, 21, 'sales', 1, '2022-03-16', '', '5400.00', '0.00', 8, '05.56'),
(44, 4, 22, 'purchase', 5, '2022-03-22', 'nothin', '0.00', '5845.30', 8, '11.00'),
(48, 4, 4, 'purchase_return', 5, '2022-03-25', 'test for insert with both batch and serial', '130.00', '0.00', 8, '10.20'),
(50, 4, 22, 'sales', 23, '2022-03-25', 'test for gst check', '1000.00', '0.00', 8, ''),
(51, 4, 0, 'cashmemo', 0, '2022-03-26', 'test 08.07', '1200.00', '0.00', 8, ''),
(52, 4, 0, 'cashmemo', 0, '2022-03-26', 'test 08.08', '2000.00', '0.00', 8, ''),
(53, 4, 0, 'cashmemo', 0, '2022-03-26', 'test 11.45', '100.00', '0.00', 8, 'ABC'),
(55, 4, 2, 'cashmemo', 0, '2022-03-26', '', '550.00', '0.00', 8, ''),
(56, 4, 1, 'cashmemo_return', 0, '2022-03-26', 'test 01.02', '0.00', '50.00', 8, ''),
(57, 4, 1, 'income', 0, '2022-03-16', '', '10000.00', '0.00', 8, ''),
(58, 4, 1, 'expence', 0, '2022-03-17', '', '0.00', '200.00', 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_expence`
--

CREATE TABLE `tbl_expence` (
  `expence_id` bigint(20) NOT NULL,
  `company_id` bigint(20) NOT NULL,
  `financial_id` bigint(20) NOT NULL,
  `expense_id` bigint(20) NOT NULL,
  `date` date NOT NULL,
  `payment_type_id` bigint(20) NOT NULL,
  `cheque_ref_no` int(20) NOT NULL,
  `is_round_off` bit(1) NOT NULL,
  `round_off` decimal(18,2) NOT NULL,
  `total` decimal(18,2) NOT NULL,
  `description` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_expence`
--

INSERT INTO `tbl_expence` (`expence_id`, `company_id`, `financial_id`, `expense_id`, `date`, `payment_type_id`, `cheque_ref_no`, `is_round_off`, `round_off`, `total`, `description`) VALUES
(1, 4, 8, 1, '2022-03-17', 1, 0, b'0', '0.00', '200.00', '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_expence_detail`
--

CREATE TABLE `tbl_expence_detail` (
  `expence_detail_id` bigint(20) NOT NULL,
  `expence_id` bigint(20) NOT NULL,
  `item_name` varchar(50) NOT NULL,
  `price` decimal(18,2) NOT NULL,
  `quantity` decimal(18,2) NOT NULL,
  `total` decimal(18,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_expence_detail`
--

INSERT INTO `tbl_expence_detail` (`expence_detail_id`, `expence_id`, `item_name`, `price`, `quantity`, `total`) VALUES
(1, 1, 'lights ', '200.00', '1.00', '200.00');

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
-- Table structure for table `tbl_income`
--

CREATE TABLE `tbl_income` (
  `income_id` bigint(20) NOT NULL,
  `company_id` bigint(20) NOT NULL,
  `financial_id` bigint(20) NOT NULL,
  `income_type_id` bigint(20) NOT NULL,
  `date` date NOT NULL,
  `payment_type_id` bigint(20) NOT NULL,
  `cheque_ref_no` int(20) NOT NULL,
  `is_round_off` bit(1) NOT NULL,
  `round_off` decimal(18,2) NOT NULL,
  `total` decimal(18,2) NOT NULL,
  `description` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_income`
--

INSERT INTO `tbl_income` (`income_id`, `company_id`, `financial_id`, `income_type_id`, `date`, `payment_type_id`, `cheque_ref_no`, `is_round_off`, `round_off`, `total`, `description`) VALUES
(1, 4, 8, 1, '2022-03-16', 1, 0, b'0', '0.00', '10000.00', '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_income_detail`
--

CREATE TABLE `tbl_income_detail` (
  `income_detail_id` bigint(20) NOT NULL,
  `income_id` bigint(20) NOT NULL,
  `item_name` varchar(50) NOT NULL,
  `price` decimal(18,2) NOT NULL,
  `quantity` decimal(18,2) NOT NULL,
  `total` decimal(18,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_income_detail`
--

INSERT INTO `tbl_income_detail` (`income_detail_id`, `income_id`, `item_name`, `price`, `quantity`, `total`) VALUES
(1, 1, 'Paisa hi paisa hoga', '5000.00', '2.00', '10000.00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_income_type`
--

CREATE TABLE `tbl_income_type` (
  `income_type_id` bigint(20) NOT NULL,
  `income_type_name` varchar(50) NOT NULL,
  `added_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_income_type`
--

INSERT INTO `tbl_income_type` (`income_type_id`, `income_type_name`, `added_date`) VALUES
(1, 'Charrity', '2022-02-15 06:07:35'),
(5, 'Debris', '2022-02-15 12:28:04');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_max_sell_product_setting`
--

CREATE TABLE `tbl_max_sell_product_setting` (
  `setting_id` bigint(20) NOT NULL,
  `item_unit_show` bit(1) NOT NULL,
  `stock_show` bit(1) NOT NULL,
  `quantity_show` bit(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_max_sell_product_setting`
--

INSERT INTO `tbl_max_sell_product_setting` (`setting_id`, `item_unit_show`, `stock_show`, `quantity_show`) VALUES
(1, b'1', b'1', b'0');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_party_group`
--

CREATE TABLE `tbl_party_group` (
  `party_group_id` bigint(20) NOT NULL,
  `party_group_name` varchar(50) NOT NULL,
  `added_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_party_group`
--

INSERT INTO `tbl_party_group` (`party_group_id`, `party_group_name`, `added_date`) VALUES
(1, 'xyz', '2022-02-01 14:48:54'),
(2, 'abc', '2022-02-01 14:49:02'),
(3, 'birla group', '2022-02-01 14:49:10'),
(4, 'ambani group', '2022-02-01 14:49:16');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_party_ledger`
--

CREATE TABLE `tbl_party_ledger` (
  `party_ladger_id` bigint(20) NOT NULL,
  `company_id` bigint(20) NOT NULL,
  `party_type` varchar(50) NOT NULL,
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

--
-- Dumping data for table `tbl_party_ledger`
--

INSERT INTO `tbl_party_ledger` (`party_ladger_id`, `company_id`, `party_type`, `party_id`, `invoice_type`, `invoice_no`, `detail`, `credit`, `debit`, `date`, `financial_id`, `new_invoice_no`) VALUES
(3, 4, '0', 22, 'purchase', 3, 'test for update', '5817.00', '5718.00', '2022-01-16', 8, '11.07'),
(4, 4, '0', 5, 'purchase_return', 4, 'test for insert with both batch and serial', '130.00', '60.00', '2022-03-25', 8, '10.20'),
(5, 4, '0', 28, 'purchase', 5, 'ok', '4230.00', '4230.00', '2021-11-16', 8, '11.16'),
(6, 4, '0', 33, 'purchase', 6, 'ok', '2735.00', '2730.00', '2021-09-16', 8, 'tsthuh'),
(8, 4, '0', 35, 'purchase', 7, 'ok', '3000.00', '3000.00', '2021-10-16', 8, '11.27'),
(9, 4, '0', 37, 'purchase', 8, 'ok1', '7818.00', '7818.00', '2021-08-16', 8, '11.32'),
(10, 4, '0', 4, 'purchase', 9, 'ok', '4900.00', '4900.00', '2021-07-16', 8, '11.34'),
(11, 4, '0', 5, 'purchase', 10, 'ok', '6200.00', '0.00', '2021-06-16', 8, '11.36'),
(12, 4, '0', 22, 'purchase', 11, 'ok', '2034.45', '0.00', '2021-05-16', 8, '11.37'),
(13, 4, '0', 26, 'purchase', 12, 'ok', '2760.10', '0.00', '2021-04-16', 8, 'asdfgh'),
(14, 4, '0', 28, 'purchase', 13, 'ok', '4175.00', '4000.00', '2021-03-16', 9, '11.40'),
(15, 4, '0', 31, 'purchase', 14, 'olk', '4010.00', '4010.00', '2021-02-16', 9, '11.43'),
(16, 4, '0', 33, 'purchase', 15, 'ok', '5000.00', '5000.00', '2021-01-16', 9, '11.46'),
(17, 4, '0', 35, 'purchase', 16, 'ok', '4850.00', '4800.00', '2020-12-16', 9, '11.48'),
(18, 4, '0', 37, 'purchase', 17, 'ok', '3860.00', '3860.00', '2020-11-16', 9, '11.49'),
(19, 4, '0', 4, 'purchase', 18, 'ok', '5480.00', '5000.00', '2020-10-16', 9, '11.51'),
(20, 4, '0', 5, 'purchase', 19, 'ok', '3200.00', '3200.00', '2020-08-16', 9, '11.53'),
(21, 4, '0', 22, 'purchase', 20, 'ok', '3700.00', '3500.00', '2020-09-16', 9, '11.56'),
(22, 4, '0', 26, 'purchase', 21, '', '5444.00', '5400.00', '2020-07-16', 9, '12.15'),
(24, 4, '0', 4, 'purchase_return', 2, 'test pepsi - e tot 2\r\npine 5', '524.00', '1081.00', '2022-03-24', 8, '17.47'),
(25, 4, '0', 22, 'purchase', 3, 'test for update', '5817.00', '5718.00', '2022-01-16', 8, '11.07'),
(26, 4, '0', 5, 'purchase_return', 4, 'test for insert with both batch and serial', '130.00', '60.00', '2022-03-25', 8, '10.20'),
(27, 4, '1', 27, 'sales', 5, '', '4000.00', '4275.00', '2020-11-16', 9, '05.19'),
(28, 4, '1', 30, 'sales', 6, '', '3241.00', '3241.00', '2020-12-16', 9, ''),
(29, 4, '1', 32, 'sales', 7, '', '2000.00', '2968.00', '2021-01-16', 9, ''),
(30, 4, '1', 34, 'sales', 8, '', '2280.00', '2280.00', '2021-02-16', 9, ''),
(31, 4, '1', 36, 'sales', 9, '', '1500.00', '1510.00', '2021-03-16', 9, ''),
(32, 4, '1', 38, 'sales', 10, '', '3100.00', '3100.00', '2021-04-16', 8, ''),
(33, 4, '1', 1, 'sales', 11, '', '2400.00', '2485.00', '2021-05-16', 8, ''),
(34, 4, '1', 3, 'sales', 12, '', '4000.00', '4300.00', '2021-06-16', 8, '05.29'),
(35, 4, '1', 23, 'sales', 13, '', '1782.00', '1782.00', '2021-07-16', 8, '05.31'),
(36, 4, '1', 25, 'sales', 14, '', '4000.00', '4700.00', '2021-08-16', 8, '05.33'),
(37, 4, '1', 27, 'sales', 15, '', '3078.00', '3078.00', '2021-09-16', 8, '05.36'),
(38, 4, '1', 30, 'sales', 16, '', '2800.00', '3019.00', '2021-10-16', 8, '05.39'),
(39, 4, '1', 32, 'sales', 17, '', '2914.00', '2914.00', '2021-11-16', 8, '05.41'),
(40, 4, '1', 34, 'sales', 18, '', '7985.00', '7985.00', '2021-12-16', 8, '05.50'),
(41, 4, '1', 36, 'sales', 19, '', '4000.00', '4500.00', '2022-01-16', 8, '05.54'),
(42, 4, '1', 38, 'sales', 20, '', '11000.00', '11973.00', '2022-02-16', 8, ''),
(43, 4, '1', 1, 'sales', 21, '', '5400.00', '5400.00', '2022-03-16', 8, '05.56'),
(44, 4, '0', 5, 'purchase', 22, 'nothin', '6096.84', '5845.30', '2022-03-22', 8, '11.00'),
(48, 4, '0', 5, 'purchase_return', 4, 'test for insert with both batch and serial', '130.00', '60.00', '2022-03-25', 8, '10.20'),
(49, 4, '1', 1, 'sales_return', 1, 'test one ', '199.50', '100.00', '2022-03-25', 8, 'zxcvbnm'),
(50, 4, '0', 5, 'purchase', 22, 'nothin', '6096.84', '5845.30', '2022-03-22', 8, '11.00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_party_master`
--

CREATE TABLE `tbl_party_master` (
  `party_id` bigint(20) NOT NULL,
  `party_type` int(6) NOT NULL,
  `party_name` varchar(100) NOT NULL,
  `party_group_id` bigint(20) NOT NULL,
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
  `additional_field_4_name` varchar(50) NOT NULL,
  `opening_balance` decimal(18,2) NOT NULL,
  `balance_status` varchar(50) NOT NULL,
  `as_of_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_party_master`
--

INSERT INTO `tbl_party_master` (`party_id`, `party_type`, `party_name`, `party_group_id`, `mobile_no`, `alter_mobile_no`, `email`, `billing_address`, `shipping_address`, `gst_type`, `gst_in`, `state`, `added_date`, `company_id`, `additional_field_1_name`, `additional_field_2_name`, `additional_field_3_name`, `additional_field_4_name`, `opening_balance`, `balance_status`, `as_of_date`) VALUES
(1, 1, 'mihir', 3, 9376521396, 9328659886, 'mihirhpradhan@gmail.com', 'bhestan,surat', 'althan,surat', 'SGST', '1ghjkl', 'JAMMU AND KASHMIR', '2021-12-14 11:07:42', 4, 'qsdc', 'qwedfgh', '5.6', '2000-04-14', '-11400.00', 'to recieve', '2022-11-11'),
(3, 1, 'kp', 2, 9638527410, 7894561230, 'kunalpawar354@gmail.com', 'katargam', 'sugc', 'SGST', 'fghj', 'GOA', '2021-12-19 05:29:05', 4, '', '', '', '', '-3638.00', 'to pay', '2022-02-23'),
(4, 0, 'bhautik', 3, 9328659886, 9016896222, 'bhautikpatel1201@gmail.com', 'Shivparnam residency', 'shivpranam residency', 'CGST', '1234667', 'GUJARAT', '2022-01-10 10:53:15', 4, '', '', '', '', '35086.10', 'to pay', '2022-03-01'),
(5, 0, 'mansi', 4, 9016896222, 928659886, 'mansi4653@gmail.com', 'Narayan Nagar', 'Narayan Nagar', 'SGST', 'zxcvbnm', 'MAHARASHTRA', '2022-01-21 15:43:12', 4, 'a', 'b', 'c', '', '47412.30', 'to recieve', '2022-03-02'),
(22, 0, 'Vasu', 3, 9638527410, 123456789, 'vasupatel166@gmail.com', '', '', 'SGST', '11dfghjkl', 'SIKKIM', '2022-02-12 06:49:32', 4, 'qsdc', 'qwedfgh', '5.6', '2001-01-01', '27471.00', 'to pay', '2022-02-12'),
(23, 1, 'pratik', 2, 7865239870, 0, 'pratikcraval@gmail.com', 'pune', 'ahemdabad', 'gst', '32bvggv', 'KERALA', '2022-03-08 20:32:43', 4, '', '67', '', '2002-12-12', '-1504.00', 'to pay', '2022-01-10'),
(25, 1, 'vini', 4, 8564637464, 0, 'pandeyvinita268@gmail.com', 'mumbai', 'vapi', 'sgst', '15hvgnvg', 'MIZORAM', '2022-03-08 20:38:59', 4, '', '30', '', '2002-03-03', '1300.00', 'to pay', '2022-03-03'),
(26, 0, 'yash', 1, 6574382547, 0, 'yash@gmail.com', 'vadodra', 'vapi', 'igst', '11bklkdra', 'SIKKIM', '2022-03-10 17:25:50', 4, '', '87', '', '2002-03-03', '58075.50', 'to pay', '2022-03-05'),
(27, 1, 'tej', 2, 7865234509, 0, 'tejshahhh@gmail.com', 'mumbai', 'pune', 'sgst', '12hvgtfth', 'ARUNACHAL PRADESH', '2022-03-10 17:30:16', 4, '', '34', '', '2001-09-27', '8922.00', 'to pay', '2022-09-09'),
(28, 0, 'ashvini', 3, 7890125436, 0, 'ashvini@gmail.com', 'rander', 'rander', 'gst', '20bvgchggn', 'JHARKHAND', '2022-03-10 17:35:07', 4, '', '30', '', '2000-11-27', '44574.00', 'to pay', '2022-12-14'),
(30, 1, 'ashish', 4, 4325907631, 0, 'ashish@gmail.com', 'bhatar', 'bhatar', 'sgst', '31pwiihj', 'LAKSHADWEEP', '2022-03-10 17:38:59', 4, '', '98', '', '2000-05-10', '26309.00', 'to pay', '2014-09-16'),
(31, 0, 'rudra', 4, 6732190987, 0, 'RUDRA@gmail.com', 'piplod', 'piplod', 'gst', '4bnczxfdsf', 'CHANDIGARH', '2022-03-10 17:40:55', 4, '', '60', '', '2016-09-06', '49010.00', 'to pay', '2009-10-31'),
(32, 1, 'mohini', 1, 3214532675, 0, 'mohini@gmail.com', 'citilight', 'citilight', 'igst', '21oiouigh', 'ODISHA', '2022-03-10 17:42:37', 4, '', '34', '', '2005-04-14', '20786.00', 'to pay', '2019-04-30'),
(33, 0, 'mihir patil', 2, 1243568798, 0, 'mihir@gmail.com', 'adajan', 'adajan', 'sgst', '1bvbvhg', 'JAMMU AND KASHMIR', '2022-03-10 17:44:52', 4, '', '75', '', '2005-05-12', '35530.00', 'to pay', '2016-10-31'),
(34, 1, 'siddharth', 3, 5643128790, 0, 'siddharth@gmail.com', 'VESU,', 'VESU', 'sgst', '24AGFHS', 'GUJARAT', '2022-03-10 17:51:47', 4, '', '76', '', '1998-06-09', '31650.00', 'to pay', '2022-03-31'),
(35, 0, 'reena', 4, 5676456943, 0, 'reena@gmail.com', 'panjrapor', 'panjrapor', 'sgst', '34nbnbdbfx', 'PONDICHERRY', '2022-03-10 17:55:09', 4, '', '56', '', '1995-06-01', '30296.00', 'to pay', '2019-11-30'),
(36, 1, 'pakhi', 4, 6543210987, 0, 'pakhi@gmail.com', 'dumas', 'dumas', 'gst', '17hgfdsa', 'MEGHALAYA', '2022-03-10 17:57:21', 4, '', '80', '', '2001-10-24', '31840.00', 'to pay', '2022-09-30'),
(37, 0, 'zoya', 1, 7890563412, 0, 'zoya@gmail.com', 'bimrad', 'bimrad', 'sgst', '16kdsnjkn', 'TRIPURA', '2022-03-10 17:59:26', 4, '', '45', '', '2006-11-11', '50186.00', 'to pay', '2020-01-31'),
(38, 1, 'aditya', 3, 5645567889, 0, 'aditya@gmail.com', 'khjod', 'khjod', 'igst', '38ndnmd', 'LADAKH', '2022-03-10 18:01:17', 4, '', '29', '', '2006-12-12', '27680.00', 'to pay', '2020-03-31');

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
(1, b'1', b'1', b'1', b'1', 1, 'Hii your payment $10000 is on panding', b'1', 'Customer Building', b'1', b'1', 'Customer House No', b'1', b'1', 'Customer Height', b'1', b'1', 'Date Of Birth', b'1', '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_payment_in`
--

CREATE TABLE `tbl_payment_in` (
  `payment_in_id` bigint(20) NOT NULL,
  `company_id` bigint(20) NOT NULL,
  `financial_id` bigint(20) NOT NULL,
  `party_id` bigint(20) NOT NULL,
  `receipt_no` bigint(20) NOT NULL,
  `payment_type_id` bigint(20) NOT NULL,
  `cheque_ref_no` bigint(20) NOT NULL,
  `date` date NOT NULL,
  `description` varchar(500) NOT NULL,
  `image` varchar(1000) NOT NULL,
  `received` decimal(18,2) NOT NULL,
  `obj_name` varchar(50) NOT NULL,
  `obj_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_payment_in`
--

INSERT INTO `tbl_payment_in` (`payment_in_id`, `company_id`, `financial_id`, `party_id`, `receipt_no`, `payment_type_id`, `cheque_ref_no`, `date`, `description`, `image`, `received`, `obj_name`, `obj_id`) VALUES
(2, 4, 9, 3, 2, 1, 0, '2020-08-16', '', '', '4000.00', 'sales', 2),
(3, 4, 9, 23, 3, 1, 0, '2020-09-16', '', '', '5000.00', 'sales', 3),
(4, 4, 9, 25, 4, 1, 0, '2020-10-16', '', '', '0.00', 'sales', 4),
(5, 4, 9, 27, 5, 1, 0, '2020-11-16', '', '', '4000.00', 'sales', 5),
(6, 4, 9, 30, 6, 1, 0, '2020-12-16', '', '', '3241.00', 'sales', 6),
(7, 4, 9, 32, 7, 1, 0, '2021-01-16', '', '', '2000.00', 'sales', 7),
(8, 4, 9, 34, 8, 1, 0, '2021-02-16', '', '', '2280.00', 'sales', 8),
(9, 4, 9, 36, 9, 1, 0, '2021-03-16', '', '', '1500.00', 'sales', 9),
(10, 4, 8, 38, 1, 1, 0, '2021-04-16', '', '', '3100.00', 'sales', 10),
(11, 4, 8, 1, 2, 1, 0, '2021-05-16', '', '', '2400.00', 'sales', 11),
(12, 4, 8, 3, 3, 1, 0, '2021-06-16', '', '', '4000.00', 'sales', 12),
(13, 4, 8, 23, 4, 1, 0, '2021-07-16', '', '', '1782.00', 'sales', 13),
(14, 4, 8, 25, 5, 1, 0, '2021-08-16', '', '', '4000.00', 'sales', 14),
(15, 4, 8, 27, 6, 1, 0, '2021-09-16', '', '', '3078.00', 'sales', 15),
(16, 4, 8, 30, 7, 1, 0, '2021-10-16', '', '', '2800.00', 'sales', 16),
(17, 4, 8, 32, 8, 1, 0, '2021-11-16', '', '', '2914.00', 'sales', 17),
(18, 4, 8, 34, 9, 1, 0, '2021-12-16', '', '', '7985.00', 'sales', 18),
(19, 4, 8, 36, 10, 1, 0, '2022-01-16', '', '', '4000.00', 'sales', 19),
(20, 4, 8, 38, 11, 1, 0, '2022-02-16', '', '', '11000.00', 'sales', 20),
(21, 4, 8, 1, 12, 1, 0, '2022-03-16', '', '', '5400.00', 'sales', 21),
(25, 4, 8, 5, 1, 1, 0, '2022-03-25', 'test for insert with both batch and serial', '', '130.00', 'purchase_return', 4),
(26, 4, 8, 23, 13, 1, 0, '2022-03-25', 'test for gst check', '', '1000.00', 'sales', 22),
(27, 4, 8, 0, 1, 1, 0, '2022-03-26', 'test 08.07', '', '1200.00', 'cashmemo', 0),
(28, 4, 8, 0, 1, 1, 0, '2022-03-26', 'test 08.08', '', '2000.00', 'cashmemo', 0),
(29, 4, 8, 0, 1, 1, 0, '2022-03-26', 'test 11.45', '', '100.00', 'cashmemo', 0),
(30, 4, 8, 0, 1, 1, 0, '2022-03-26', 'test 11.51', '', '500.00', 'cashmemo', 1),
(31, 4, 8, 0, 1, 1, 0, '2022-03-26', '', '', '550.00', 'cashmemo', 2);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_payment_out`
--

CREATE TABLE `tbl_payment_out` (
  `payment_out_id` bigint(20) NOT NULL,
  `company_id` bigint(20) NOT NULL,
  `financial_id` bigint(20) NOT NULL,
  `party_id` bigint(20) NOT NULL,
  `receipt_no` bigint(20) NOT NULL,
  `payment_type_id` bigint(20) NOT NULL,
  `cheque_ref_no` bigint(20) NOT NULL,
  `date` date NOT NULL,
  `description` varchar(500) NOT NULL,
  `image` varchar(1000) NOT NULL,
  `paid` decimal(18,2) NOT NULL,
  `obj_name` varchar(50) NOT NULL,
  `obj_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_payment_out`
--

INSERT INTO `tbl_payment_out` (`payment_out_id`, `company_id`, `financial_id`, `party_id`, `receipt_no`, `payment_type_id`, `cheque_ref_no`, `date`, `description`, `image`, `paid`, `obj_name`, `obj_id`) VALUES
(1, 4, 8, 4, 1, 1, 0, '2022-03-16', 'test for purchase', '', '378.10', 'purchase', 1),
(2, 4, 8, 5, 2, 2, 254136, '2022-02-16', 'insert into vasu(head) values (brain)', '', '3500.00', 'purchase', 2),
(3, 4, 8, 22, 3, 1, 0, '2022-03-16', 'test for insert', '', '5718.00', 'purchase', 3),
(4, 4, 8, 26, 4, 1, 0, '2021-12-16', 'inserting', '', '455.50', 'purchase', 4),
(5, 4, 8, 28, 5, 1, 0, '2021-11-16', 'ok', '', '4230.00', 'purchase', 5),
(6, 4, 8, 33, 6, 1, 0, '2021-09-16', 'ok', '', '2730.00', 'purchase', 6),
(8, 4, 8, 35, 7, 1, 0, '2021-10-16', 'ok', '', '3000.00', 'purchase', 7),
(9, 4, 8, 37, 8, 1, 0, '2021-08-16', 'ok1', '', '7818.00', 'purchase', 8),
(10, 4, 8, 4, 9, 1, 0, '2021-07-16', 'ok', '', '4900.00', 'purchase', 9),
(11, 4, 8, 5, 10, 1, 0, '2021-06-16', 'ok', '', '0.00', 'purchase', 10),
(12, 4, 8, 22, 11, 1, 0, '2021-05-16', 'ok', '', '0.00', 'purchase', 11),
(13, 4, 8, 26, 12, 1, 0, '2021-04-16', 'ok', '', '0.00', 'purchase', 12),
(14, 4, 9, 28, 1, 1, 0, '2021-03-16', 'ok', '', '4000.00', 'purchase', 13),
(15, 4, 9, 31, 2, 1, 0, '2021-02-16', 'olk', '', '4010.00', 'purchase', 14),
(16, 4, 9, 33, 3, 1, 0, '2021-01-16', 'ok', '', '5000.00', 'purchase', 15),
(17, 4, 9, 35, 4, 1, 0, '2020-12-16', 'ok', '', '4800.00', 'purchase', 16),
(18, 4, 9, 37, 5, 1, 0, '2020-11-16', 'ok', '', '3860.00', 'purchase', 17),
(19, 4, 9, 4, 6, 1, 0, '2022-03-16', 'ok', '', '5000.00', 'purchase', 18),
(20, 4, 9, 5, 7, 1, 0, '2020-09-16', 'ok', '', '3200.00', 'purchase', 19),
(21, 4, 9, 22, 8, 1, 0, '2020-09-16', 'ok', '', '3500.00', 'purchase', 20),
(22, 4, 9, 26, 9, 1, 0, '2020-07-16', '', '', '5400.00', 'purchase', 21),
(23, 4, 8, 5, 13, 1, 0, '2022-03-22', 'nothin', '', '5845.30', 'purchase', 22),
(24, 4, 8, 1, 1, 1, 0, '2022-03-25', 'test one ', '', '100.00', 'sales_return', 1),
(25, 4, 8, 0, 1, 1, 0, '2022-03-26', 'test 01.02', '', '50.00', 'cashmemo_return', 1);

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
(5, 'UPI', '2022-01-26'),
(6, 'Bank', '2022-02-02'),
(7, 'ICICI', '2022-02-02'),
(9, 'Bank of baroda', '2022-02-02');

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
(1, 'ANDAMAN AND NICOBAR ISLANDS', 'AN', '35'),
(2, 'ANDHRA PRADESH', 'AP', '37'),
(3, 'ARUNACHAL PRADESH', 'AR', '12'),
(4, 'ASSAM', 'AS', '18'),
(5, 'BIHAR', 'BR', '10'),
(6, 'CHANDIGARH', 'CH', '4'),
(7, 'CHHATTISGARH', 'CG', '22'),
(8, 'DADRA AND NAGAR HAVELI', 'DN', '26'),
(9, 'DAMAN AND DIU', 'DD', '25'),
(10, 'DELHI', 'DL', '7'),
(11, 'GOA', 'GA', '30'),
(12, 'GUJARAT', 'GJ', '24'),
(13, 'HARYANA', 'HR', '6'),
(14, 'HIMACHAL PRADESH', 'HP', '2'),
(15, 'JAMMU AND KASHMIR', 'JK', '1'),
(16, 'JHARKHAND', 'JH', '20'),
(17, 'KARNATAKA', 'KA', '29'),
(18, 'KERALA', 'KL', '32'),
(19, 'LADAKH', 'LA', '38'),
(20, 'LAKSHADWEEP', 'LD', '31'),
(21, 'MAGHYA PRADESH', 'MP', '23'),
(22, 'MAHARASHTRA', 'MH', '27'),
(23, 'MANIPUR', 'MN', '14'),
(24, 'MEGHALAYA', 'ML', '17'),
(25, 'MIZORAM', 'MZ', '15'),
(26, 'NAGALAND', 'NL', '13'),
(27, 'ODISHA', 'OR', '21'),
(28, 'OTHER TERRITORY', 'OT', '97'),
(29, 'PONDICHERRY', 'PY', '34'),
(30, 'PUNJAB', 'PB', '3'),
(31, 'RAJASTHAN', 'RJ', '8'),
(32, 'SIKKIM', 'SK', '11'),
(33, 'TAMIL NADU', 'TN', '33'),
(34, 'TELANGANA', 'TS', '36'),
(35, 'TRIPURA', 'TR', '16'),
(36, 'UTTAR PRADESH', 'UP', '9'),
(37, 'UTTARAKHAND', 'UA', '5'),
(38, 'WEST BENGAL', 'WB', '19'),
(39, 'FOREIGN COUNTRY', 'FC', '96');

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
  `closing_stock` decimal(18,2) NOT NULL,
  `unit_per_price` decimal(18,2) NOT NULL,
  `description` varchar(500) NOT NULL,
  `min_stock_qty` decimal(18,3) NOT NULL,
  `product_location` varchar(100) NOT NULL,
  `product_date` date NOT NULL,
  `discount_on_sale` decimal(18,2) NOT NULL,
  `tax_rate` decimal(18,2) NOT NULL,
  `additional_cess_per_unit` decimal(18,2) NOT NULL,
  `discount_type` varchar(100) NOT NULL,
  `product_image` varchar(2000) NOT NULL,
  `is_batch` bit(1) NOT NULL,
  `is_serial` bit(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_product_master`
--

INSERT INTO `tbl_product_master` (`product_id`, `company_id`, `category_id`, `barcode`, `product_code`, `product_name`, `gstslab_id`, `hsn_code`, `unit_id`, `primary_unit_id`, `secondary_unit_id`, `purchase_rate`, `purchase_tax_type`, `sales_rate`, `sales_tax_type`, `opening_stock`, `closing_stock`, `unit_per_price`, `description`, `min_stock_qty`, `product_location`, `product_date`, `discount_on_sale`, `tax_rate`, `additional_cess_per_unit`, `discount_type`, `product_image`, `is_batch`, `is_serial`) VALUES
(1, 4, 5, 'abc', '123', 'pepsi', 3, '456', 1, 1, 0, '69.00', 'Excluding Gst', '210.00', 'Excluding Gst', '1019.000', '1025.00', '12.00', 'rxdtcfygvuhbinjkm', '100.000', '65', '1212-12-12', '0.00', '0.00', '0.00', '', 'pepsi.jpg', b'0', b'1'),
(2, 4, 2, 'pqr', 'blue001', 'black', 3, '123', 1, 1, 0, '1.00', 'Including Gst', '2.00', 'Including Gst', '1000.000', '1010.00', '10.00', 'ok test 123', '100.000', 'surat', '2021-12-09', '0.00', '0.00', '0.00', '', 'black.jpg', b'0', b'1'),
(5, 4, 6, '123PQR456', 'B102', 'pen', 3, 'nvb', 14, 14, 0, '79.00', 'Including Gst', '89.00', 'Including Gst', '1000.000', '1000.00', '89.00', 'non veg burger with meat', '100.000', 'surat', '2021-12-23', '0.00', '0.00', '0.00', '', 'burger755322.png', b'1', b'0'),
(6, 4, 4, '456XYZ789', 'P101', 'pencil', 3, 'pm', 1, 1, 0, '99.00', 'Including Gst', '120.00', 'Including Gst', '1000.000', '1015.00', '120.00', 'margerita with extra cheese', '100.000', 'surat', '2021-12-23', '0.00', '0.00', '0.00', '', 'margerita756610.jpg', b'1', b'0'),
(7, 4, 2, '980DFG021', 'P102', 'eraser', 3, 'pbth', 1, 1, 0, '110.00', 'Including Gst', '120.00', 'Including Gst', '1004.000', '1207.00', '120.00', '', '100.000', 'surat', '2021-12-23', '0.00', '69.00', '0.00', '', 'burn to hell825075.jpg', b'1', b'0'),
(8, 4, 2, 'ASDFGHJKL', 'S101', 'white_nerd', 3, 'PSp', 1, 1, 0, '50.00', 'Including Gst', '90.00', 'Including Gst', '1000.000', '930.00', '90.00', '', '100.000', 'surat', '2021-12-24', '0.00', '0.00', '0.00', '', 'pepsi726713.jpg', b'0', b'1'),
(9, 4, 2, 'ZXCVBNMLk', 'P102', 'Coca-cola', 3, 'Ccc', 1, 1, 0, '60.00', 'Including Gst', '120.00', 'Including Gst', '1000.000', '1010.00', '120.00', '', '100.000', 'surat', '2021-12-24', '0.00', '0.00', '0.00', '', 'coca-cola856207.jpg', b'1', b'0'),
(10, 4, 7, 'asdfghjkl;', 'Kissan_Tomato_Ketchup_4', 'Kissan Fresh Tomato Ketchup', 1, '', 5, 5, 7, '100.00', 'Excluding Gst', '110.00', 'Including Gst', '1000.000', '983.00', '100.00', 'bchbsja', '100.000', '', '2022-01-13', '0.00', '0.00', '0.00', '', 'kissan.jpg', b'0', b'1'),
(11, 4, 2, 'hdujhsjhiufk', 'Oranges', 'Oranges_6', 3, 'jdfd', 1, 1, 2, '50.00', 'Including Gst', '70.00', 'Excluding Gst', '1000.000', '960.00', '50.00', 'jhciskhncjshcssdfghjkl', '100.000', 'vapi', '2022-01-22', '0.00', '0.00', '0.00', '', 'oranges.jpg', b'1', b'0'),
(12, 4, 2, 'ertyty', 'Apples_7', 'Apple', 4, 'sdfghjk', 1, 1, 2, '90.00', 'Including Gst', '100.00', 'Excluding Gst', '1000.000', '973.00', '90.00', 'sdfghjk', '100.000', 'mumbai', '2022-01-27', '0.00', '0.00', '0.00', '', 'apple.jpg', b'0', b'1'),
(13, 4, 2, 'wert', 'Dates_8', 'Dates', 5, 'werty', 1, 1, 2, '100.00', 'Including Gst', '110.00', 'Excluding Gst', '1000.000', '995.00', '110.00', 'dfghj', '100.000', 'pune', '2022-01-03', '0.00', '0.00', '0.00', '', 'dates.jpg', b'1', b'0'),
(14, 4, 2, '', 'Baby_Kiwi_9', 'Baby Kiwi', 5, 'rtyu', 6, 6, 7, '70.00', 'Excluding Gst', '90.00', 'Including Gst', '1000.000', '1021.00', '70.00', 'cvbn', '100.000', 'surat', '2022-01-12', '0.00', '0.00', '0.00', '', 'baby kiwi.jpg', b'0', b'1'),
(15, 4, 2, '', 'Grapes_11', 'Graps', 7, 'ert', 1, 1, 6, '100.00', 'Excluding Gst', '110.00', 'Including Gst', '1000.000', '1023.00', '100.00', '', '100.000', '', '2022-01-20', '0.00', '0.00', '0.00', '', 'graps.jpg', b'0', b'1'),
(16, 4, 2, '', 'Pineapple_12', 'Pineapple', 8, '', 1, 1, 6, '70.00', 'Including Gst', '90.00', 'Excluding Gst', '1009.000', '1119.00', '90.00', '', '100.000', '', '2022-01-29', '0.00', '0.00', '0.00', '', 'pineapple.jpg', b'1', b'0'),
(17, 4, 2, '', 'Papaya_13', 'Papaya', 1, '', 1, 1, 6, '100.00', 'Excluding Gst', '110.00', 'Including Gst', '1000.000', '1000.00', '100.00', '', '100.000', '', '2022-01-29', '0.00', '0.00', '0.00', '', 'papaya.jpg', b'1', b'0'),
(18, 4, 2, '', 'Mosambi_14', 'Mosambi', 3, '', 1, 1, 2, '150.00', 'Including Gst', '160.00', 'Excluding Gst', '1000.000', '1039.00', '150.00', '', '100.000', '', '2021-12-29', '0.00', '0.00', '0.00', '', 'mosambii.jpg', b'1', b'0'),
(19, 4, 2, '', 'Pomegranate_15', 'Pomegranate', 4, '', 1, 1, 6, '120.00', 'Excluding Gst', '130.00', 'Including Gst', '1000.000', '1000.00', '130.00', '', '100.000', '', '2022-01-18', '0.00', '0.00', '0.00', '', 'pomegranate.jpg', b'0', b'0'),
(20, 4, 2, '', 'Apple_Ber_16', 'Apple Ber', 5, '', 1, 1, 6, '1000.00', 'Including Gst', '1100.00', 'Excluding Gst', '1000.000', '1000.00', '1000.00', '', '100.000', '', '2022-01-06', '0.00', '0.00', '0.00', '', 'apple ber.jpg', b'0', b'1'),
(21, 4, 2, '', 'Watermelon_17', 'Watermelon', 6, '', 1, 1, 2, '100.00', 'Excluding Gst', '120.00', 'Including Gst', '1000.000', '995.00', '100.00', '', '100.000', '', '2022-01-10', '0.00', '0.00', '0.00', '', 'watermelon.jpg', b'1', b'0'),
(22, 4, 2, '', 'Anjeer_18', 'Anjeer', 8, '', 1, 1, 6, '150.00', 'Excluding Gst', '170.00', 'Including Gst', '1000.000', '1006.00', '150.00', '', '100.000', '', '2022-01-17', '0.00', '0.00', '0.00', '', 'anjeer.jpg', b'0', b'1'),
(23, 4, 4, '', 'Carrot_1', 'Carrot Red', 1, '', 1, 1, 7, '80.00', 'Including Gst', '100.00', 'Excluding Gst', '1000.000', '990.00', '80.00', '', '100.000', '', '2022-01-31', '0.00', '0.00', '0.00', '', 'carrot red.jpg', b'1', b'0'),
(24, 4, 8, '', 'Nuts_2', 'Ground Nuts', 3, '', 7, 7, 5, '1000.00', 'Including Gst', '1200.00', 'Excluding Gst', '1000.000', '1004.00', '1000.00', '', '100.000', '', '2022-01-20', '0.00', '0.00', '0.00', '', 'ground nuts.jpg', b'0', b'1'),
(25, 4, 2, '', 'Coconut_3', 'Coconut', 4, '', 1, 1, 8, '100.00', 'Excluding Gst', '120.00', 'Including Gst', '1000.000', '996.00', '100.00', '', '100.000', '', '2022-01-18', '0.00', '0.00', '0.00', '', 'coconuts.jpg', b'1', b'0'),
(26, 4, 4, '', 'Onion_4', 'Onion', 6, '', 1, 1, 8, '100.00', 'Including Gst', '110.00', 'Excluding Gst', '1000.000', '1002.00', '100.00', '', '100.000', '', '2022-01-12', '0.00', '0.00', '0.00', '', 'onion.jpg', b'0', b'1'),
(27, 4, 4, '', 'Lauki_5', 'Lauki', 7, '', 1, 1, 6, '90.00', 'Excluding Gst', '120.00', 'Including Gst', '1000.000', '1000.00', '90.00', '', '100.000', '', '2022-01-06', '0.00', '0.00', '0.00', '', 'laukii.jpg', b'0', b'1'),
(28, 4, 4, '', 'Tomato_6', 'Tomato', 8, '', 1, 1, 6, '70.00', 'Including Gst', '90.00', 'Excluding Gst', '1000.000', '980.00', '70.00', '', '100.000', '', '2022-01-24', '0.00', '0.00', '0.00', '', 'tomato.jpg', b'0', b'0'),
(29, 4, 4, '', 'Cucumber_7', 'Cucumber', 1, '', 1, 1, 6, '50.00', 'Excluding Gst', '70.00', 'Including Gst', '1000.000', '1000.00', '70.00', '', '100.000', '', '2022-01-20', '0.00', '0.00', '0.00', '', 'cucumbers.jpg', b'0', b'0'),
(30, 4, 4, '', 'Beans_8', 'French Beans', 3, '', 1, 1, 7, '170.00', 'Excluding Gst', '180.00', 'Including Gst', '1000.000', '1000.00', '170.00', '', '100.000', '', '2022-02-02', '0.00', '0.00', '0.00', '', 'french beans.jpg', b'0', b'0'),
(31, 4, 7, '', 'Corn_9', 'Sweet Corn', 4, '', 1, 1, 7, '150.00', 'Including Gst', '160.00', 'Excluding Gst', '1000.000', '980.00', '150.00', '', '100.000', '', '2022-01-18', '0.00', '0.00', '0.00', '', 'sweet corn.jpg', b'0', b'0'),
(32, 4, 4, '', 'Cucumber_10', 'Cucumber Regular ', 5, '', 1, 1, 6, '200.00', 'Including Gst', '210.00', 'Excluding Gst', '1000.000', '1000.00', '200.00', '', '100.000', '', '2022-01-30', '0.00', '0.00', '0.00', '', 'cucumber regular.jpg', b'0', b'0'),
(33, 4, 4, '', 'Potato_11', 'Sweet Potato', 6, '', 1, 1, 6, '100.00', 'Excluding Gst', '120.00', 'Including Gst', '1000.000', '997.00', '100.00', '', '100.000', '', '2022-02-04', '0.00', '0.00', '0.00', '', 'sweet potato.jpg', b'0', b'0'),
(34, 4, 4, '', 'Potato_12', 'Potato', 8, '', 1, 1, 8, '90.00', 'Including Gst', '100.00', 'Excluding Gst', '1000.000', '995.00', '90.00', '', '100.000', '', '2022-01-28', '0.00', '0.00', '0.00', '', 'potato.jpg', b'0', b'0'),
(35, 4, 4, '', 'Peas_13', 'Green Peas', 1, '', 1, 1, 6, '50.00', 'Excluding Gst', '70.00', 'Including Gst', '1000.000', '1000.00', '50.00', '', '100.000', '', '2022-01-29', '0.00', '0.00', '0.00', '', 'green peas.jpg', b'0', b'0'),
(36, 4, 4, '', 'Bhendi_14', 'Bhendiii', 3, '', 1, 1, 8, '180.00', 'Including Gst', '190.00', 'Excluding Gst', '1000.000', '1000.00', '190.00', '', '100.000', '', '2022-01-10', '0.00', '0.00', '0.00', '', 'bhendiii.jpg', b'0', b'0'),
(37, 4, 4, '', 'Capsicum_15', 'Green Capsicum', 4, '', 1, 1, 6, '100.00', 'Excluding Gst', '120.00', 'Including Gst', '1000.000', '1000.00', '100.00', '', '100.000', '', '2022-01-12', '0.00', '0.00', '0.00', '', 'green capcicum.jpg', b'0', b'0'),
(38, 4, 4, '', 'Beetroot_16', 'BeetRoot', 5, '', 1, 1, 8, '200.00', 'Including Gst', '210.00', 'Excluding Gst', '1000.000', '1000.00', '210.00', '', '100.000', '', '2022-01-06', '0.00', '0.00', '0.00', '', 'beetroot.jpg', b'0', b'0'),
(39, 4, 4, '', 'Ginger_1', 'Ginger Indian', 6, '', 1, 1, 8, '30.00', 'Including Gst', '50.00', 'Excluding Gst', '1000.000', '1000.00', '30.00', '', '100.000', '', '2022-01-26', '0.00', '0.00', '0.00', '', 'ginger indian.jpg', b'0', b'1'),
(40, 4, 4, '', 'Garlic_2', 'Indian Garlic', 7, '', 1, 1, 8, '40.00', 'Including Gst', '60.00', 'Excluding Gst', '1000.000', '1000.00', '60.00', '', '100.000', '', '2022-01-05', '0.00', '0.00', '0.00', '', 'indian garlic.jpg', b'0', b'1'),
(41, 4, 4, '', 'Chilli_3', 'Green Chilli', 1, '', 1, 1, 5, '300.00', 'Excluding Gst', '310.00', 'Including Gst', '1000.000', '995.00', '300.00', '', '100.000', '', '2022-01-18', '0.00', '0.00', '0.00', '', 'green chilli.jpg', b'0', b'0'),
(42, 4, 4, '', 'Lemon_4', 'Lemon', 3, '', 1, 1, 6, '80.00', 'Excluding Gst', '90.00', 'Including Gst', '1000.000', '970.00', '80.00', '', '100.000', '', '2022-01-12', '0.00', '0.00', '0.00', '', 'lemon.jpg', b'0', b'0'),
(43, 4, 4, '', 'Ginger_5', 'Ginger', 4, '', 1, 1, 8, '40.00', 'Including Gst', '50.00', 'Excluding Gst', '1000.000', '950.00', '40.00', '', '100.000', '', '2022-01-26', '0.00', '0.00', '0.00', '', 'ginger.jpg', b'0', b'0'),
(44, 4, 4, '', 'Broccoli_1', 'Broccoli', 5, '', 1, 1, 6, '400.00', 'Including Gst', '410.00', 'Excluding Gst', '1000.000', '1020.00', '400.00', '', '100.000', '', '2022-02-01', '0.00', '0.00', '0.00', '', 'broccoliii.jpg', b'0', b'0'),
(45, 4, 4, '', 'Mushroom_2', 'Button Mushroom', 6, '', 8, 8, 6, '200.00', 'Excluding Gst', '220.00', 'Including Gst', '1000.000', '1000.00', '200.00', '', '100.000', '', '2022-01-12', '0.00', '0.00', '0.00', '', 'button mashroom.jpg', b'0', b'0'),
(46, 4, 2, '', 'Dragonfruit_3', 'Dragonfruit', 7, '', 1, 1, 6, '500.00', 'Including Gst', '550.00', 'Excluding Gst', '1000.000', '1000.00', '500.00', '', '100.000', '', '2022-01-31', '0.00', '0.00', '0.00', '', 'dragon fruit.jpg', b'0', b'0'),
(47, 4, 2, '', 'Mulberry_4', 'Mulberry', 8, '', 8, 8, 6, '100.00', 'Including Gst', '150.00', 'Including Gst', '1000.000', '1000.00', '100.00', '', '100.000', '', '2022-01-26', '0.00', '0.00', '0.00', '', 'mulberry.jpg', b'0', b'0'),
(48, 4, 4, '', 'Capsicum_5', 'Red Capsicum', 1, '', 1, 1, 6, '1000.00', 'Including Gst', '1200.00', 'Excluding Gst', '1000.000', '1005.00', '1000.00', '', '100.000', '', '2022-01-18', '0.00', '0.00', '0.00', '', 'red capsicum.jpg', b'0', b'0'),
(49, 4, 4, '', 'Tomato_6', 'Tomato', 1, '', 1, 1, 6, '100.00', 'Including Gst', '110.00', 'Excluding Gst', '1000.000', '1010.00', '100.00', '', '100.000', '', '2022-01-26', '0.00', '0.00', '0.00', '', 'tomato.jpg', b'0', b'0'),
(50, 4, 4, '', 'Yellow_Capsicum_7', 'Yellow Capsicum', 4, '', 1, 1, 6, '1000.00', 'Excluding Gst', '1200.00', 'Including Gst', '1000.000', '999.00', '1000.00', '', '100.000', '', '2022-01-25', '0.00', '0.00', '0.00', '', 'yallow capsicum.jpg', b'0', b'0'),
(51, 4, 4, '', 'Zucchini_7', 'Zucchini', 5, '', 1, 1, 6, '700.00', 'Excluding Gst', '800.00', 'Including Gst', '1000.000', '997.00', '700.00', '', '100.000', '', '2022-01-28', '0.00', '0.00', '0.00', '', 'zucchinii.jpg', b'0', b'1'),
(52, 4, 5, '', 'Lemongrass_8', 'Lemongrass 1 bunch', 6, '', 1, 1, 6, '100.00', 'Excluding Gst', '150.00', 'Including Gst', '1000.000', '1010.00', '100.00', '', '100.000', '', '2022-01-10', '0.00', '0.00', '0.00', '', 'lemon graas.jpg', b'0', b'0'),
(53, 4, 5, '', 'Lettuce_Leafy_9', 'Lettuce Leafy', 7, '', 1, 1, 8, '350.00', 'Including Gst', '400.00', 'Excluding Gst', '1000.000', '1000.00', '350.00', '', '100.000', '', '2022-01-19', '0.00', '0.00', '0.00', '', 'lettuce leafy.jpg', b'0', b'0'),
(54, 4, 4, '', 'Cherry_Tomato_10', 'Cherry Tomato', 8, '', 1, 1, 6, '600.00', 'Including Gst', '610.00', 'Excluding Gst', '1000.000', '1000.00', '600.00', '', '100.000', '', '2022-01-11', '0.00', '0.00', '0.00', '', 'cherry tomato.jpg', b'0', b'0'),
(55, 4, 4, '', 'Zucchini_Yellow_11', 'Zucchini Yellow', 1, '', 1, 1, 8, '1000.00', 'Excluding Gst', '1200.00', 'Including Gst', '1000.000', '1000.00', '1000.00', '', '100.000', '', '2022-01-05', '0.00', '0.00', '0.00', '', 'zucchinii yellow.jpg', b'0', b'0'),
(56, 4, 2, '', 'Avocado_Hass_12', 'Avocado Hass', 3, '', 1, 1, 6, '500.00', 'Including Gst', '510.00', 'Excluding Gst', '1000.000', '1010.00', '500.00', '', '100.000', '', '2022-02-03', '0.00', '0.00', '0.00', '', 'avocado hass.jpg', b'0', b'0'),
(57, 4, 5, '', 'Trikaya_13', 'Trikaya Lettuce Iceberg', 5, '', 1, 1, 8, '300.00', 'Including Gst', '310.00', 'Excluding Gst', '1000.000', '970.00', '300.00', '', '100.000', '', '2022-01-12', '0.00', '0.00', '0.00', '', 'Lettuce iceberg.jpg', b'0', b'0'),
(58, 4, 5, '', 'Basil_14', 'Basil', 3, '', 1, 1, 8, '180.00', 'Excluding Gst', '200.00', 'Including Gst', '1000.000', '990.00', '180.00', '', '100.000', '', '2022-01-21', '0.00', '0.00', '0.00', '', 'basil.jpg', b'0', b'0'),
(59, 4, 5, '', 'Trikaya_Long_15', 'Trikaya Long', 8, '', 1, 1, 8, '50.00', 'Including Gst', '100.00', 'Excluding Gst', '1000.000', '985.00', '50.00', '', '100.000', '', '2022-01-12', '0.00', '0.00', '0.00', '', 'trikaya long.jpg', b'0', b'0'),
(60, 4, 5, '', 'Celery_16', 'Celery', 7, '', 1, 1, 6, '400.00', 'Including Gst', '450.00', 'Excluding Gst', '1000.000', '1000.00', '400.00', '', '100.000', '', '2022-01-03', '0.00', '0.00', '0.00', '', 'celery.jpg', b'0', b'0'),
(61, 4, 6, '', 'Amul_1', 'Amul Taaza Homogenised Toned Milk', 1, '', 9, 9, 7, '29.00', 'Excluding Gst', '30.00', 'Including Gst', '1000.000', '1000.00', '29.00', '', '100.000', '', '2022-02-02', '0.00', '0.00', '0.00', '', 'amul taaza.jpg', b'0', b'0'),
(62, 4, 6, '', 'Milkshake_2', 'Chocolate Milkshake', 3, '', 9, 9, 3, '250.00', 'Including Gst', '300.00', 'Excluding Gst', '1000.000', '1000.00', '300.00', '', '100.000', '', '2022-01-17', '0.00', '0.00', '0.00', '', 'chocolate milkshake.jpg', b'0', b'0'),
(63, 4, 6, '', 'Winkin_3', 'Britannia Winkin', 1, '', 9, 9, 7, '800.00', 'Including Gst', '850.00', 'Excluding Gst', '1000.000', '1000.00', '800.00', '', '100.000', '', '2022-01-31', '0.00', '0.00', '0.00', '', 'britania winkin.jpg', b'0', b'0'),
(64, 4, 6, '', 'Amul_4', 'Amul Masti Dahi', 3, '', 6, 6, 7, '30.00', 'Excluding Gst', '50.00', 'Including Gst', '1000.000', '1000.00', '30.00', '', '100.000', '', '2022-01-27', '0.00', '0.00', '0.00', '', 'amul masti dahi.jpg', b'0', b'0'),
(65, 4, 6, '', 'Hershey_5', 'Strawberry Milkshake', 4, '', 9, 9, 4, '200.00', 'Including Gst', '250.00', 'Excluding Gst', '1000.000', '1000.00', '200.00', '', '100.000', '', '2022-01-04', '0.00', '0.00', '0.00', '', 'strobarry milkshake.jpg', b'0', b'0'),
(66, 4, 6, '', 'Hershey_6', 'Hershey Cookies', 5, '', 1, 1, 7, '300.00', 'Including Gst', '350.00', 'Excluding Gst', '1000.000', '1000.00', '300.00', '', '100.000', '', '2022-02-06', '0.00', '0.00', '0.00', '', 'hershey cookies.jpg', b'0', b'0'),
(67, 4, 6, '', 'Nestle_7', 'Milkmaid Sweetened ', 5, '', 9, 9, 4, '100.00', 'Excluding Gst', '150.00', 'Including Gst', '1000.000', '1000.00', '100.00', '', '100.000', '', '2022-01-05', '0.00', '0.00', '0.00', '', 'milkmaid sweetened.jpg', b'0', b'0'),
(68, 4, 7, '', 'Dairy_Whitener_8', 'Nestle Everyday Dairy Whitener', 7, '', 1, 1, 7, '300.00', 'Including Gst', '310.00', 'Excluding Gst', '1000.000', '1000.00', '300.00', '', '100.000', '', '2022-01-19', '0.00', '0.00', '0.00', '', 'nestle everyday dairy whitener.jpg', b'0', b'0'),
(69, 4, 6, '', 'Milk_9', 'Nestle A+ Slim Skimmed Milk', 8, '', 9, 9, 7, '100.00', 'Including Gst', '150.00', 'Excluding Gst', '1000.000', '990.00', '100.00', '', '100.000', '', '2022-01-20', '0.00', '0.00', '0.00', '', 'nestle a+ slim fat free milk.jpg', b'1', b'0'),
(70, 4, 6, '', 'Butter_10', 'Butter', 1, '', 6, 6, 7, '80.00', 'Including Gst', '100.00', 'Excluding Gst', '1000.000', '990.00', '80.00', '', '100.000', '', '2022-01-12', '0.00', '0.00', '0.00', '', 'butter.jpg', b'0', b'0'),
(71, 4, 6, '', 'Amul_Mithai_11', 'Amul Mithai Mate', 1, '', 9, 9, 4, '1200.00', 'Excluding Gst', '1500.00', 'Including Gst', '1000.000', '1000.00', '1200.00', '', '100.000', '', '2022-01-24', '0.00', '0.00', '0.00', '', 'amul mithaai maid.jpg', b'0', b'0'),
(72, 4, 6, '', 'Delicious_12', 'Delicious Fat Spread', 4, '', 1, 1, 7, '300.00', 'Including Gst', '310.00', 'Excluding Gst', '1000.000', '1000.00', '300.00', '', '100.000', '', '2022-01-12', '0.00', '0.00', '0.00', '', 'delicious fat spread.jpg', b'0', b'0'),
(73, 4, 7, '', 'bun_rusk_1', 'Premium Bake Rusk', 6, '', 1, 1, 7, '900.00', 'Including Gst', '950.00', 'Excluding Gst', '1000.000', '1000.00', '900.00', '', '100.000', '', '2022-01-27', '0.00', '0.00', '0.00', '', 'premium bake rusk.jpg ', b'0', b'0'),
(74, 4, 7, '', 'Parle_Rusk_2', 'Parle Elaichi Rusk', 7, '', 1, 1, 7, '200.00', 'Including Gst', '250.00', 'Excluding Gst', '1000.000', '1000.00', '200.00', '', '100.000', '', '2022-01-20', '0.00', '0.00', '0.00', '', 'parle elaichi rusk.jpg', b'0', b'0'),
(75, 4, 7, '', 'Britannia_3', 'Britannia Rusk', 8, '', 1, 1, 7, '100.00', 'Excluding Gst', '150.00', 'Including Gst', '1000.000', '1000.00', '100.00', '', '100.000', '', '2022-01-21', '0.00', '0.00', '0.00', '', 'britania rusk.jpg', b'0', b'0'),
(76, 4, 7, '', 'rusk_4', 'Premium Elaichi Rusk', 6, '', 1, 1, 6, '400.00', 'Including Gst', '450.00', 'Excluding Gst', '1000.000', '1000.00', '400.00', '', '100.000', '', '2022-01-11', '0.00', '0.00', '0.00', '', 'premium elaichi rusk.jpg', b'0', b'0'),
(77, 4, 7, '', 'britana_toast_5', 'Britannia Toastea', 5, '', 1, 1, 7, '700.00', 'Including Gst', '750.00', 'Excluding Gst', '1000.000', '1000.00', '700.00', '', '100.000', '', '2022-01-22', '0.00', '0.00', '0.00', '', 'britania toatea.jpg', b'0', b'0'),
(78, 4, 7, '', 'jeera_toast_6', 'Amul Jeera Toast', 7, '', 1, 1, 7, '200.00', 'Including Gst', '250.00', 'Excluding Gst', '1000.000', '1000.00', '200.00', '', '100.000', '', '2022-01-29', '0.00', '0.00', '0.00', '', 'amul jeera toast.jpg', b'0', b'0'),
(79, 4, 6, '', 'Milk_toast_7', 'Amul Milk Toast', 4, '', 1, 1, 7, '1000.00', 'Including Gst', '1200.00', 'Excluding Gst', '1000.000', '1000.00', '1000.00', '', '100.000', '', '2022-01-28', '0.00', '0.00', '0.00', '', 'amul milk toast.jpg', b'0', b'0'),
(80, 4, 7, '', 'Britannia_Coco_Creme_1', 'Britannia Treat Coco Creme', 1, '', 7, 7, 8, '500.00', 'Excluding Gst', '510.00', 'Including Gst', '1000.000', '1000.00', '500.00', '', '100.000', '', '2022-01-29', '0.00', '0.00', '0.00', '', 'britannia treat coco cream.jpg', b'0', b'0'),
(81, 4, 7, '', 'Muffets_2', 'Muffets & Tuffets', 6, '', 7, 7, 0, '330.00', 'Excluding Gst', '400.00', 'Including Gst', '1000.000', '1000.00', '330.00', '', '100.000', '', '2022-01-17', '0.00', '0.00', '0.00', '', 'muffest and tuffest.jpg', b'0', b'0'),
(82, 4, 7, '', 'b_pav_3', 'Britannia Paw', 5, '', 8, 8, 7, '70.00', 'Including Gst', '100.00', 'Excluding Gst', '1000.000', '1000.00', '70.00', '', '100.000', '', '2022-01-29', '0.00', '0.00', '0.00', '', 'britannia paw.jpg', b'0', b'0'),
(83, 4, 7, '', 'Multigrain_4', 'Multigrain Bread', 3, '', 8, 8, 7, '900.00', 'Including Gst', '950.00', 'Excluding Gst', '1000.000', '997.00', '900.00', '', '100.000', '', '2022-01-13', '0.00', '0.00', '0.00', '', 'multigrain bread.jpg', b'0', b'0'),
(84, 4, 7, '', 'Bread_5', 'Brown Bread', 1, '', 8, 8, 7, '200.00', 'Including Gst', '250.00', 'Excluding Gst', '1000.000', '1000.00', '200.00', '', '100.000', '', '2022-01-24', '0.00', '0.00', '0.00', '', 'brown bread.jpg', b'0', b'0'),
(85, 4, 7, '', 'Bread_6', 'Whole Wheat Bread', 3, '', 8, 8, 7, '99.00', 'Including Gst', '120.00', 'Excluding Gst', '1000.000', '1025.00', '99.00', '', '100.000', '', '2022-01-29', '0.00', '0.00', '0.00', '', 'whole wheat bread.jpg', b'0', b'0'),
(86, 4, 7, '', 'Pizza_base_7', 'Muffets & Tuffets Pizza Base', 4, '', 8, 8, 7, '300.00', 'Excluding Gst', '350.00', 'Including Gst', '1000.000', '1000.00', '300.00', '', '100.000', '', '2022-01-04', '0.00', '0.00', '0.00', '', 'muffest and tuffest pizza base.jpg', b'0', b'0'),
(87, 4, 7, '', 'Maida_Pizza_8', 'Maida Pizza Base', 5, '', 6, 6, 7, '400.00', 'Including Gst', '450.00', 'Excluding Gst', '1000.000', '1005.00', '400.00', '', '100.000', '', '2022-01-03', '0.00', '0.00', '0.00', '', 'maida pizza base.jpg', b'0', b'0'),
(88, 4, 7, '', 'Garden_pain_9', 'American Garden Plain', 6, '', 6, 6, 7, '400.00', 'Including Gst', '450.00', 'Excluding Gst', '1000.000', '1000.00', '400.00', '', '100.000', '', '2022-01-15', '0.00', '0.00', '0.00', '', 'american garden plain.jpg', b'0', b'0'),
(89, 4, 7, '', 'Karachi_Fruit_Biscuit_1', 'Karachi Fruit Biscuit', 8, '', 1, 1, 6, '550.00', 'Including Gst', '600.00', 'Excluding Gst', '1000.000', '1000.00', '550.00', '', '100.000', '', '2022-01-04', '0.00', '0.00', '0.00', '', 'karachii fruit biscuit.jpg', b'0', b'0'),
(90, 4, 6, '', 'Butter_2', 'Amul Almond Butter', 1, '', 1, 1, 6, '660.00', 'Excluding Gst', '700.00', 'Including Gst', '1000.000', '1000.00', '660.00', '', '100.000', '', '2022-01-09', '0.00', '0.00', '0.00', '', 'amul almond butter.jpg', b'0', b'0'),
(91, 4, 7, '', 'Karachi_Bakery_3', 'Karachi Bakery Chocolate', 3, '', 6, 6, 7, '260.00', 'Including Gst', '300.00', 'Excluding Gst', '1000.000', '995.00', '260.00', '', '100.000', '', '2022-01-16', '0.00', '0.00', '0.00', '', 'karachii bakrey chocolate.jpg', b'0', b'0'),
(92, 4, 7, '', 'Cashew_4', 'Amul Cashew', 4, '', 1, 1, 6, '85.00', 'Excluding Gst', '100.00', 'Including Gst', '1000.000', '1000.00', '85.00', '', '100.000', '', '2022-01-12', '0.00', '0.00', '0.00', '', 'amul cashew.jpg', b'0', b'0'),
(93, 4, 7, '', 'bikaji_5', 'Bikaji Cookies', 5, '', 1, 1, 6, '75.00', 'Including Gst', '90.00', 'Excluding Gst', '1000.000', '1000.00', '75.00', '', '100.000', '', '2022-01-06', '0.00', '0.00', '0.00', '', 'bikajii cookies.jpg', b'0', b'0'),
(94, 4, 7, '', 'jeera_cookie_6', 'Amul Jeera Cookies', 7, '', 6, 6, 7, '199.00', 'Excluding Gst', '110.00', 'Including Gst', '1000.000', '1000.00', '99.00', '', '100.000', '', '2022-01-19', '0.00', '0.00', '0.00', '', 'amul jeera cookies.jpg', b'0', b'0'),
(95, 4, 7, '', 'bikaji_jeera_7', 'Bikaji Just Baked Jeera', 8, '', 6, 6, 7, '119.00', 'Including Gst', '150.00', 'Excluding Gst', '1000.000', '1000.00', '119.00', '', '100.000', '', '2022-01-13', '0.00', '0.00', '0.00', '', 'bikajii just baked jeera.jpg', b'0', b'0'),
(96, 4, 7, '', 'bikaji_8', 'Bikaji Just Baked Butter', 1, '', 6, 6, 7, '100.00', 'Including Gst', '120.00', 'Excluding Gst', '1000.000', '1000.00', '100.00', '', '100.000', '', '2022-01-24', '0.00', '0.00', '0.00', '', 'bikaji just baked butter.jpg', b'0', b'0'),
(97, 4, 7, '', 'lovely_cookies_9', 'Lovely Chocochip Cookies', 3, '', 6, 6, 7, '120.00', 'Including Gst', '150.00', 'Excluding Gst', '1000.000', '1000.00', '120.00', '', '100.000', '', '2022-01-11', '0.00', '0.00', '0.00', '', 'lovely chocochips cookies.jpg', b'0', b'0'),
(98, 4, 7, '', 'Pista_Cookies_10', 'Butter Pista Cookies', 8, '', 6, 6, 7, '220.00', 'Including Gst', '250.00', 'Excluding Gst', '1000.000', '1000.00', '220.00', '', '100.000', '', '2022-01-19', '0.00', '0.00', '0.00', '', 'butter pista cookies.jpg', b'0', b'0'),
(99, 4, 6, '', 'chees_slice_1', 'Britannia Cheese Slices', 7, '', 6, 6, 7, '229.00', 'Excluding Gst', '250.00', 'Including Gst', '1000.000', '1000.00', '229.00', '', '100.000', '', '2022-01-10', '0.00', '0.00', '0.00', '', 'britannia cheeses slices.jpg', b'0', b'0'),
(100, 4, 7, '', 'bhujiya_srv_1', 'Haldiram Nagpur Bhujia Sev ', 4, '', 5, 5, 7, '120.00', 'Including Gst', '150.00', 'Excluding Gst', '1000.000', '1000.00', '120.00', '', '100.000', '', '2022-01-08', '0.00', '0.00', '0.00', '', 'haldiram nagpur bhujia sev.jpg', b'0', b'0'),
(101, 4, 7, '', 'mix_navratan_2', 'Snactac Navratan Mix', 6, '', 5, 5, 7, '99.00', 'Including Gst', '120.00', 'Excluding Gst', '1000.000', '1000.00', '99.00', '', '100.000', '', '2022-01-21', '0.00', '0.00', '0.00', '', 'snactac navratan mix.jpg', b'0', b'0'),
(102, 4, 7, '', 'Namkeen_Mixture_3', 'Rajam Snacks Madras Namkeen Mixture', 7, '', 5, 5, 7, '25.00', 'Including Gst', '40.00', 'Excluding Gst', '1000.000', '1000.00', '25.00', '', '100.000', '', '2022-02-06', '0.00', '0.00', '0.00', '', 'Rajam Snacks Madras Namkeen Mixture.jpg', b'0', b'0'),
(103, 4, 7, '', 'maida_kaju_4', 'Bikaji Namkeen Maida Kaju', 8, '', 1, 1, 6, '129.00', 'Including Gst', '140.00', 'Excluding Gst', '1000.000', '1000.00', '129.00', '', '100.000', '', '2022-02-04', '0.00', '0.00', '0.00', '', 'bikaji namkeen maida kaju.jpg', b'0', b'0'),
(104, 4, 7, '', 'ragi_chips_5', 'Riya Namkeens Ragi Chips', 1, '', 5, 5, 7, '150.00', 'Excluding Gst', '160.00', 'Including Gst', '1000.000', '1000.00', '150.00', '', '100.000', '', '2022-01-16', '0.00', '0.00', '0.00', '', 'dira namkeen ragi chips.jpg', b'0', b'0'),
(105, 4, 7, '', 'cookie_1', 'Unibic Choco Chip Cookies ', 3, '', 6, 6, 7, '210.00', 'Including Gst', '220.00', 'Excluding Gst', '1000.000', '1000.00', '210.00', '', '100.000', '', '2022-01-07', '0.00', '0.00', '0.00', '', 'unibic choco chips cookies.jpg', b'0', b'0'),
(106, 4, 7, '', 'good_day_choko_2', 'Britannia Good Day Choco-chip Cookies ', 4, '', 6, 6, 7, '175.00', 'Excluding Gst', '190.00', 'Including Gst', '1000.000', '1000.00', '175.00', '', '100.000', '', '2022-01-28', '0.00', '0.00', '0.00', '', 'britannia good day choco chips cookies.jpg', b'0', b'0'),
(107, 4, 7, '', 'fantasy_chokko_3', 'Sunfeast Dark Fantasy Choco Fill Cookies', 5, '', 7, 7, 6, '195.00', 'Including Gst', '210.00', 'Excluding Gst', '1000.000', '1000.00', '195.00', '', '100.000', '', '2022-01-23', '0.00', '0.00', '0.00', '', 'sunfeast dark fentasy choco chips fill cookies.jpg ', b'0', b'0'),
(108, 4, 7, '', 'happy_cookie_4', 'Parle Happy Happy Choco-Chip Cookies', 6, '', 6, 6, 7, '559.00', 'Including Gst', '570.00', 'Excluding Gst', '1000.000', '1010.00', '559.00', '', '100.000', '', '2022-01-19', '0.00', '0.00', '0.00', '', 'parle happy happy choco chips cookies.jpg', b'0', b'0'),
(109, 4, 7, '', 'unibik_cookie_5', 'Unibic Fruit & Nut Cookies', 7, '', 6, 6, 7, '100.00', 'Excluding Gst', '120.00', 'Including Gst', '1000.000', '1010.00', '100.00', '', '100.000', '', '2022-02-04', '0.00', '0.00', '0.00', '', 'unibic fruit and nut cookies.jpg', b'0', b'0'),
(110, 4, 7, '', 'meggie_1', 'Sunfeast Yippee Power Up Masala Instant Atta Noodles', 8, '', 8, 8, 7, '120.00', 'Including Gst', '150.00', 'Excluding Gst', '1000.000', '1010.00', '120.00', '', '100.000', '', '2022-01-20', '0.00', '0.00', '0.00', '', 'sunfeats yippee power up masala instant atta noodles.jpg', b'0', b'0'),
(111, 4, 7, '', 'meggie_2', 'Maggi 2-Minute Masala Instant Noodles', 5, '', 6, 6, 7, '595.00', 'Including Gst', '610.00', 'Excluding Gst', '1000.000', '1005.00', '595.00', '', '100.000', '', '2022-02-02', '0.00', '0.00', '0.00', '', 'maggi 2 minute masala instant noodles.jpg', b'0', b'0'),
(112, 4, 7, '', 'meggie_3', 'Top Ramen New Masala Instant Noodles', 1, '', 6, 6, 7, '195.00', 'Excluding Gst', '210.00', 'Including Gst', '1000.000', '1000.00', '195.00', '', '100.000', '', '2022-01-06', '0.00', '0.00', '0.00', '', 'top raman new masala instant noodles.jpg', b'0', b'0'),
(113, 4, 7, '', 'manchurian_meggie_4', 'Chings Secret Manchurian Instant Noodles', 3, '', 6, 6, 7, '669.00', 'Including Gst', '700.00', 'Excluding Gst', '1000.000', '1010.00', '669.00', '', '100.000', '', '2022-01-22', '0.00', '0.00', '0.00', '', 'chings secret manchurian instant masala noodles.jpg', b'0', b'0'),
(114, 4, 7, '', 'ketchup_1', 'Del Monte Tomato Ketchup', 4, '', 5, 5, 7, '100.00', 'Including Gst', '150.00', 'Excluding Gst', '1000.000', '1020.00', '100.00', '', '100.000', '', '2022-01-15', '0.00', '0.00', '0.00', '', 'del monte tomato ketchup.jpg', b'0', b'0'),
(115, 4, 7, '', 'mayommaise_2', 'Funfoods Veg Mayonnaise', 5, '', 3, 3, 7, '60.00', 'Excluding Gst', '70.00', 'Including Gst', '1000.000', '1010.00', '60.00', '', '100.000', '', '2022-01-29', '0.00', '0.00', '0.00', '', 'funfoods veg mayonnaise.jpg', b'0', b'0'),
(116, 4, 7, '', 'sandwish_spread_3', 'Funfoods Eggless Thousand Island Sandwich Spread', 7, '', 13, 13, 0, '195.00', 'Including Gst', '210.00', 'Excluding Gst', '1000.000', '1000.00', '195.00', '', '100.000', '', '2022-01-03', '0.00', '0.00', '0.00', '', 'funfoods eggless thousand island sandwich spread.jpg', b'0', b'0'),
(117, 4, 7, '', 'peanut_butter_5', 'Sundrop Creamy Peanut Butter', 7, '', 5, 5, 3, '95.00', 'Including Gst', '120.00', 'Excluding Gst', '1000.000', '990.00', '95.00', '', '100.000', '', '2021-12-27', '10.00', '10.00', '10.00', 'IGST', 'sundrop peanut butter.jpg', b'0', b'0'),
(152, 4, 7, 'ABC123PQR', 'peanut_butter_5', 'Sundrop Creamy Peanut Butter', 7, 'cvb', 7, 7, 3, '95.00', 'Including Gst', '120.00', 'Excluding Gst', '1000.000', '1000.00', '95.00', 'qwdfbnmkoiuytdxv', '100.000', 'surat', '2021-12-27', '10.00', '10.00', '10.00', 'IGST', 'sundrop peanut butter.jpg', b'0', b'0'),
(153, 4, 7, 'ABC123PQR', 'peanut_butter_5', 'Sundrop Creamy Peanut Butter', 7, 'cvb', 7, 7, 3, '95.00', 'Including Gst', '120.00', 'Excluding Gst', '1000.000', '1000.00', '95.00', 'qwdfbnmkoiuytdxv', '100.000', 'surat', '2021-12-27', '10.00', '20.00', '10.00', 'IGST', 'sundrop peanut butter.jpg', b'0', b'0'),
(154, 4, 9, 'beep beep', 'beep beep', 'socket', 8, 'beep beep', 6, 6, 7, '100.00', 'Including Gst', '200.00', 'Including Gst', '1000.000', '1014.00', '0.00', '120', '100.000', 'surat', '2022-02-02', '100.00', '120.00', '0.00', 'cfvgbhnjk', 'socket.jpg', b'0', b'1'),
(155, 4, 9, 'beep beep', 'beep beep', 'pipe', 3, 'beep beep', 6, 6, 7, '100.00', 'Including Gst', '200.00', 'Including Gst', '1000.000', '1238.00', '100.00', '100', '100.000', 'beep beep', '0000-00-00', '0.00', '0.00', '0.00', 'beep beep', 'pipes.jpg', b'1', b'0');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_product_setting`
--

CREATE TABLE `tbl_product_setting` (
  `product_setting_id` bigint(20) NOT NULL,
  `is_enable_item` bit(1) NOT NULL,
  `what_do_you_sell` varchar(100) NOT NULL,
  `is_serial_no` bit(1) NOT NULL,
  `is_barcode_scan` bit(1) NOT NULL,
  `is_stock_maintenance` bit(1) NOT NULL,
  `is_show_low_stock_dialog` bit(1) NOT NULL,
  `is_item_unit` bit(1) NOT NULL,
  `is_default_unit` bit(1) NOT NULL,
  `is_item_category` bit(1) NOT NULL,
  `is_party_wise_rate` bit(1) NOT NULL,
  `is_description` bit(1) NOT NULL,
  `is_item_wise_tax` bit(1) NOT NULL,
  `is_item_wise_discount` bit(1) NOT NULL,
  `is_update_sale_price` bit(1) NOT NULL,
  `quantity_upto_decimal` int(10) NOT NULL,
  `is_seial_no` bit(1) NOT NULL,
  `serial_no` varchar(50) NOT NULL,
  `is_mrp_price` bit(1) NOT NULL,
  `mrp_price` varchar(50) NOT NULL,
  `is_batch_no` bit(1) NOT NULL,
  `batch_no` varchar(50) NOT NULL,
  `is_exp_date` bit(1) NOT NULL,
  `exp_date` varchar(50) NOT NULL,
  `is_mfg_date` bit(1) NOT NULL,
  `mfg_date` varchar(50) NOT NULL,
  `is_model_no` bit(1) NOT NULL,
  `model_no` varchar(50) NOT NULL,
  `is_size` bit(1) NOT NULL,
  `size` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_product_setting`
--

INSERT INTO `tbl_product_setting` (`product_setting_id`, `is_enable_item`, `what_do_you_sell`, `is_serial_no`, `is_barcode_scan`, `is_stock_maintenance`, `is_show_low_stock_dialog`, `is_item_unit`, `is_default_unit`, `is_item_category`, `is_party_wise_rate`, `is_description`, `is_item_wise_tax`, `is_item_wise_discount`, `is_update_sale_price`, `quantity_upto_decimal`, `is_seial_no`, `serial_no`, `is_mrp_price`, `mrp_price`, `is_batch_no`, `batch_no`, `is_exp_date`, `exp_date`, `is_mfg_date`, `mfg_date`, `is_model_no`, `model_no`, `is_size`, `size`) VALUES
(1, b'1', 'Product', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', b'1', 1, b'1', '', b'0', '', b'1', '', b'0', '', b'0', '', b'0', '', b'0', '');

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
(1, 4, 4, 'bhautik001', 1, 0, 'GUJARAT', '2022-03-16', 1, 'test for purchase updtae?', '344.50', '40.00', b'1', '0.00', '384.50', '378.10', 8, 'updatesd???', b'1'),
(2, 4, 5, 'paise la', 2, 1, 'MAHARASHTRA', '2022-02-16', 2, 'insert into vasu(head) values (brain)', '3626.00', '50.00', b'0', '0.00', '3676.00', '3500.00', 8, 'tsthuh', b'1'),
(3, 4, 22, 'vasu op', 3, 1, 'SIKKIM', '2022-01-16', 1, 'test for update', '5563.00', '254.00', b'1', '0.00', '5817.00', '5718.00', 8, '11.07', b'1'),
(4, 4, 26, 'yash noob', 4, 1, 'SIKKIM', '2021-12-16', 1, 'inserting', '1495.50', '40.00', b'1', '0.00', '1535.50', '455.50', 8, '11.15', b'1'),
(5, 4, 28, 'ashvi', 5, 1, 'JHARKHAND', '2021-11-16', 1, 'ok', '4230.00', '0.00', b'0', '0.00', '4230.00', '4230.00', 8, '11.16', b'1'),
(6, 4, 33, 'rudy', 6, 1, 'JAMMU AND KASHMIR', '2021-09-16', 1, 'ok', '2710.00', '25.00', b'0', '0.00', '2735.00', '2730.00', 8, 'tsthuh', b'1'),
(7, 4, 35, 'reena 1st inv', 7, 1, 'PONDICHERRY', '2021-10-16', 1, 'ok', '3000.00', '0.00', b'0', '0.00', '3000.00', '3000.00', 8, '11.27', b'1'),
(8, 4, 37, 'zoyaaa1', 8, 1, 'TRIPURA', '2021-08-16', 1, 'ok1', '7368.00', '450.00', b'0', '0.00', '7818.00', '7818.00', 8, '11.32', b'1'),
(9, 4, 4, 'bhau 2', 9, 0, 'GUJARAT', '2021-07-16', 1, 'ok', '4900.00', '0.00', b'0', '0.00', '4900.00', '4900.00', 8, '11.34', b'1'),
(10, 4, 5, 'chotu', 10, 1, 'MAHARASHTRA', '2021-06-16', 1, 'ok', '6200.00', '0.00', b'0', '0.00', '6200.00', '0.00', 8, '11.36', b'1'),
(11, 4, 22, 'vasu ka name liya hai insert toh ho jana chaiyea', 11, 1, 'SIKKIM', '2021-05-16', 1, 'ok', '2034.45', '0.00', b'0', '0.00', '2034.45', '0.00', 8, '11.37', b'1'),
(12, 4, 26, 'noob', 12, 1, 'SIKKIM', '2021-04-16', 1, 'ok', '2760.10', '0.00', b'0', '0.00', '2760.10', '0.00', 8, 'asdfgh', b'1'),
(13, 4, 28, 'asd', 1, 1, 'JHARKHAND', '2021-03-16', 1, 'ok', '4175.00', '0.00', b'0', '0.00', '4175.00', '4000.00', 9, '11.40', b'1'),
(14, 4, 31, 'rudd', 2, 1, 'DELHI', '2021-02-16', 1, 'olk', '3970.00', '40.00', b'0', '0.00', '4010.00', '4010.00', 9, '11.43', b'1'),
(15, 4, 33, 'chotu ka chotu', 3, 1, 'JAMMU AND KASHMIR', '2021-01-16', 1, 'ok', '5000.00', '0.00', b'0', '0.00', '5000.00', '5000.00', 9, '11.46', b'1'),
(16, 4, 35, 'ree ree ', 4, 1, 'PONDICHERRY', '2020-12-16', 1, 'ok', '4850.00', '0.00', b'0', '0.00', '4850.00', '4800.00', 9, '11.48', b'1'),
(17, 4, 37, 'zoo zoo', 5, 1, 'TRIPURA', '2020-11-16', 1, 'ok', '3860.00', '0.00', b'0', '0.00', '3860.00', '3860.00', 9, '11.49', b'1'),
(18, 4, 4, 'bhau 3', 6, 0, 'GUJARAT', '2020-10-16', 1, 'ok', '5480.00', '0.00', b'1', '0.00', '5480.00', '5000.00', 9, '11.51', b'1'),
(19, 4, 5, 'chotu', 7, 0, 'GUJARAT', '2020-08-16', 1, 'ok', '3200.00', '0.00', b'1', '0.00', '3200.00', '3200.00', 9, '11.53', b'1'),
(20, 4, 22, 'vasu op in the chat', 8, 1, 'SIKKIM', '2020-09-16', 1, 'ok', '3700.00', '0.00', b'0', '0.00', '3700.00', '3500.00', 9, '11.56', b'1'),
(21, 4, 26, 'noob', 9, 1, 'SIKKIM', '2020-07-16', 1, '', '5444.00', '0.00', b'0', '0.00', '5444.00', '5400.00', 9, '12.15', b'1'),
(22, 4, 5, 'ohk', 13, 0, 'GUJARAT', '2022-03-22', 1, 'nothin', '5956.84', '140.00', b'1', '0.00', '6096.84', '5845.30', 8, '11.00', b'1');

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
  `new_invoice_no` varchar(50) NOT NULL,
  `serial_no` varchar(50) NOT NULL,
  `batch_no` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_purchase_invoice_detail`
--

INSERT INTO `tbl_purchase_invoice_detail` (`purchase_invoice_detail_id`, `company_id`, `purchase_invoice_id`, `product_id`, `unit_id`, `unit`, `rate`, `qty`, `gross_total`, `disc_per`, `disc_amt`, `sub_total`, `gstslab_id`, `gst`, `gst_per`, `igst`, `igst_per`, `total`, `financial_id`, `new_invoice_no`, `serial_no`, `batch_no`) VALUES
(1, 4, 1, 1, 1, 'kilogram(kg)', '69.00', '5.00', '345.00', '2.00', '6.90', '338.10', 3, '20.29', '6.00', '0.00', '0.00', '358.28', 8, 'updatesd???', '|1|2|3|4|5', ''),
(2, 4, 1, 1, 1, 'kilogram(kg)', '1.00', '10.00', '10.00', '36.00', '3.60', '6.40', 5, '0.00', '0.00', '0.00', '0.00', '6.00', 8, 'updatesd???', '|6|7|8|9|10', ''),
(3, 4, 2, 7, 1, 'kilogram(kg)', '10.00', '100.00', '1000.00', '1.00', '10.00', '990.00', 1, '0.00', '0.00', '138.60', '14.00', '990.00', 8, 'tsthuh', '', '1'),
(4, 4, 2, 7, 1, 'kilogram(kg)', '20.00', '100.00', '2000.00', '2.00', '40.00', '1960.00', 3, '0.00', '0.00', '235.20', '12.00', '1960.00', 8, 'tsthuh', '', '2'),
(5, 4, 2, 7, 1, 'kilogram(kg)', '40.00', '10.00', '400.00', '3.00', '12.00', '388.00', 4, '0.00', '0.00', '7.76', '2.00', '388.00', 8, 'tsthuh', '', '3'),
(6, 4, 2, 10, 5, 'pouch', '100.00', '3.00', '300.00', '4.00', '12.00', '288.00', 7, '0.00', '0.00', '23.04', '8.00', '311.04', 8, 'tsthuh', '|11|12|13', ''),
(7, 4, 3, 154, 6, 'box', '100.00', '7.00', '700.00', '1.00', '7.00', '693.00', 8, '0.00', '0.00', '41.58', '6.00', '693.00', 8, '11.07', '|14|15|16|17|18|19|20', ''),
(8, 4, 3, 155, 11, 'meter', '10.00', '200.00', '2000.00', '2.00', '40.00', '1960.00', 3, '0.00', '0.00', '235.20', '12.00', '1960.00', 8, '11.07', '', '4'),
(9, 4, 3, 155, 11, 'meter', '20.00', '150.00', '3000.00', '3.00', '90.00', '2910.00', 3, '0.00', '0.00', '349.20', '12.00', '2910.00', 8, '11.07', '', '5'),
(10, 4, 4, 12, 1, 'kilogram(kg)', '90.00', '5.00', '450.00', '1.00', '4.50', '445.50', 4, '0.00', '0.00', '8.91', '2.00', '445.00', 8, '11.15', '|21|22|23|24|25', ''),
(11, 4, 4, 14, 6, 'box', '70.00', '15.00', '1050.00', '0.00', '0.00', '1050.00', 5, '0.00', '0.00', '0.00', '0.00', '1050.00', 8, '11.15', '', ''),
(12, 4, 5, 15, 1, 'kilogram(kg)', '100.00', '22.00', '2200.00', '28.00', '616.00', '1584.00', 7, '0.00', '0.00', '126.72', '8.00', '1710.72', 8, '11.16', '', ''),
(13, 4, 5, 16, 1, 'kilogram(kg)', '70.00', '90.00', '6300.00', '58.00', '3654.00', '2646.00', 8, '0.00', '0.00', '158.76', '6.00', '2646.00', 8, '11.16', '', ''),
(14, 4, 6, 20, 1, 'kilogram(kg)', '1000.00', '2.00', '2000.00', '2.00', '40.00', '1960.00', 5, '0.00', '0.00', '0.00', '0.00', '1960.00', 8, 'tsthuh', '|26|27', ''),
(15, 4, 6, 18, 6, 'box', '150.00', '5.00', '750.00', '0.00', '0.00', '750.00', 3, '0.00', '0.00', '90.00', '12.00', '750.00', 8, 'tsthuh', '', ''),
(18, 4, 7, 109, 6, 'box', '100.00', '10.00', '1000.00', '0.00', '0.00', '1000.00', 7, '0.00', '0.00', '80.00', '8.00', '1080.00', 8, '11.27', '', ''),
(19, 4, 7, 114, 5, 'pouch', '100.00', '20.00', '2000.00', '0.00', '0.00', '2000.00', 4, '0.00', '0.00', '40.00', '2.00', '2000.00', 8, '11.27', '', ''),
(20, 4, 8, 113, 6, 'box', '669.00', '10.00', '6690.00', '40.00', '2676.00', '4014.00', 3, '0.00', '0.00', '481.68', '12.00', '4014.00', 8, '11.32', '', ''),
(21, 4, 8, 108, 6, 'box', '559.00', '10.00', '5590.00', '40.00', '2236.00', '3354.00', 6, '0.00', '0.00', '670.80', '20.00', '3354.00', 8, '11.32', '', ''),
(22, 4, 9, 50, 1, 'kilogram(kg)', '1000.00', '5.00', '5000.00', '2.00', '100.00', '4900.00', 4, '49.00', '1.00', '0.00', '0.00', '4949.00', 8, '11.34', '', ''),
(23, 4, 10, 48, 1, 'kilogram(kg)', '1000.00', '5.00', '5000.00', '40.00', '2000.00', '3000.00', 1, '0.00', '0.00', '420.00', '14.00', '3000.00', 8, '11.36', '', ''),
(24, 4, 10, 50, 1, 'kilogram(kg)', '1000.00', '4.00', '4000.00', '20.00', '800.00', '3200.00', 4, '0.00', '0.00', '64.00', '2.00', '3264.00', 8, '11.36', '', ''),
(25, 4, 11, 115, 3, 'bottle', '60.00', '10.00', '600.00', '1.00', '6.00', '594.00', 5, '0.00', '0.00', '0.00', '0.00', '594.00', 8, '11.37', '', ''),
(26, 4, 11, 85, 8, 'bag', '99.00', '15.00', '1485.00', '3.00', '44.55', '1440.45', 3, '0.00', '0.00', '172.85', '12.00', '1440.00', 8, '11.37', '', ''),
(27, 4, 12, 85, 8, 'bag', '99.00', '10.00', '990.00', '1.00', '9.90', '980.10', 3, '0.00', '0.00', '117.61', '12.00', '980.00', 8, 'asdfgh', '', ''),
(28, 4, 12, 87, 6, 'box', '400.00', '5.00', '2000.00', '11.00', '220.00', '1780.00', 5, '0.00', '0.00', '0.00', '0.00', '1780.00', 8, 'asdfgh', '', ''),
(29, 4, 13, 110, 8, 'bag', '120.00', '10.00', '1200.00', '0.00', '0.00', '1200.00', 8, '0.00', '0.00', '72.00', '6.00', '1200.00', 9, '11.40', '', ''),
(30, 4, 13, 111, 6, 'box', '595.00', '5.00', '2975.00', '0.00', '0.00', '2975.00', 5, '0.00', '0.00', '0.00', '0.00', '2975.00', 9, '11.40', '', ''),
(31, 4, 14, 49, 1, 'kilogram(kg)', '100.00', '10.00', '1000.00', '28.00', '280.00', '720.00', 1, '0.00', '0.00', '100.80', '14.00', '720.00', 9, '11.43', '', ''),
(32, 4, 14, 56, 1, 'kilogram(kg)', '500.00', '10.00', '5000.00', '35.00', '1750.00', '3250.00', 3, '0.00', '0.00', '390.00', '12.00', '3250.00', 9, '11.43', '', ''),
(33, 4, 15, 52, 1, 'kilogram(kg)', '100.00', '10.00', '1000.00', '0.00', '0.00', '1000.00', 6, '0.00', '0.00', '200.00', '20.00', '1200.00', 9, '11.46', '', ''),
(34, 4, 15, 44, 1, 'kilogram(kg)', '400.00', '20.00', '8000.00', '50.00', '4000.00', '4000.00', 5, '0.00', '0.00', '0.00', '0.00', '4000.00', 9, '11.46', '', ''),
(35, 4, 16, 1, 1, 'kilogram(kg)', '69.00', '10.00', '690.00', '0.00', '0.00', '690.00', 3, '0.00', '0.00', '82.80', '12.00', '772.80', 9, '11.48', '', ''),
(36, 4, 16, 2, 1, 'kilogram(kg)', '1.00', '200.00', '200.00', '0.00', '0.00', '200.00', 3, '0.00', '0.00', '24.00', '12.00', '200.00', 9, '11.48', '', ''),
(37, 4, 16, 6, 1, 'kilogram(kg)', '99.00', '40.00', '3960.00', '0.00', '0.00', '3960.00', 3, '0.00', '0.00', '475.20', '12.00', '3960.00', 9, '11.48', '', ''),
(38, 4, 17, 154, 6, 'box', '100.00', '15.00', '1500.00', '1.00', '15.00', '1485.00', 8, '0.00', '0.00', '89.10', '6.00', '1485.00', 9, '11.49', '', ''),
(39, 4, 17, 155, 11, 'meter', '100.00', '25.00', '2500.00', '5.00', '125.00', '2375.00', 3, '0.00', '0.00', '285.00', '12.00', '2375.00', 9, '11.49', '', ''),
(40, 4, 18, 16, 1, 'kilogram(kg)', '70.00', '14.00', '980.00', '0.00', '0.00', '980.00', 8, '29.40', '3.00', '0.00', '0.00', '980.00', 9, '11.51', '', ''),
(41, 4, 18, 18, 6, 'box', '150.00', '30.00', '4500.00', '0.00', '0.00', '4500.00', 3, '270.00', '6.00', '0.00', '0.00', '4500.00', 9, '11.51', '', ''),
(42, 4, 19, 11, 1, 'kilogram(kg)', '50.00', '10.00', '500.00', '0.00', '0.00', '500.00', 1, '35.00', '7.00', '0.00', '0.00', '500.00', 9, '11.53', '', ''),
(43, 4, 19, 9, 1, 'kilogram(kg)', '60.00', '20.00', '1200.00', '0.00', '0.00', '1200.00', 8, '36.00', '3.00', '0.00', '0.00', '1200.00', 9, '11.53', '', ''),
(44, 4, 19, 8, 1, 'kilogram(kg)', '50.00', '30.00', '1500.00', '0.00', '0.00', '1500.00', 3, '90.00', '6.00', '0.00', '0.00', '1500.00', 9, '11.53', '', ''),
(45, 4, 20, 18, 6, 'box', '150.00', '10.00', '1500.00', '0.00', '0.00', '1500.00', 3, '0.00', '0.00', '180.00', '12.00', '1500.00', 9, '11.56', '', ''),
(46, 4, 20, 7, 1, 'kilogram(kg)', '110.00', '20.00', '2200.00', '0.00', '0.00', '2200.00', 3, '0.00', '0.00', '264.00', '12.00', '2200.00', 9, '11.56', '', ''),
(47, 4, 21, 53, 1, 'kilogram(kg)', '350.00', '10.00', '3500.00', '1.00', '35.00', '3465.00', 1, '0.00', '0.00', '485.10', '14.00', '3465.00', 9, '12.15', '', ''),
(48, 4, 21, 14, 6, 'box', '70.00', '15.00', '1050.00', '2.00', '21.00', '1029.00', 5, '0.00', '0.00', '0.00', '0.00', '1029.00', 9, '12.15', '', ''),
(49, 4, 22, 22, 1, 'kilogram(kg)', '150.00', '6.00', '900.00', '8.00', '72.00', '828.00', 8, '24.84', '3.00', '0.00', '0.00', '852.84', 8, '11.00', '|28|29|30|31|32|33', ''),
(50, 4, 22, 24, 7, 'packet', '1000.00', '4.00', '4000.00', '0.00', '0.00', '4000.00', 3, '240.00', '6.00', '0.00', '0.00', '4000.00', 8, '11.00', '|34|35|36|37', ''),
(51, 4, 22, 15, 1, 'kilogram(kg)', '100.00', '6.00', '600.00', '0.00', '0.00', '600.00', 7, '24.00', '4.00', '0.00', '0.00', '624.00', 8, '11.00', '|38|39|40|41|42|43', ''),
(52, 4, 22, 14, 6, 'box', '70.00', '4.00', '280.00', '0.00', '0.00', '280.00', 5, '0.00', '0.00', '0.00', '0.00', '280.00', 8, '11.00', '|44|45|46|47', ''),
(53, 4, 22, 26, 1, 'kilogram(kg)', '100.00', '2.00', '200.00', '0.00', '0.00', '200.00', 6, '20.00', '10.00', '0.00', '0.00', '200.00', 8, '11.00', '|48|49', ''),
(54, 4, 0, 1, 1, 'kilogram(kg)', '69.00', '3.00', '207.00', '0.00', '0.00', '207.00', 3, '12.42', '6.00', '0.00', '0.00', '150.42', 8, '17.47', '|50', ''),
(55, 4, 0, 16, 1, 'kilogram(kg)', '70.00', '5.00', '350.00', '0.00', '0.00', '350.00', 8, '10.50', '3.00', '0.00', '0.00', '360.50', 8, '17.47', '', '');

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

--
-- Dumping data for table `tbl_purchase_return_invoice`
--

INSERT INTO `tbl_purchase_return_invoice` (`purchase_return_invoice_id`, `company_id`, `party_id`, `ref_order_id`, `invoice_no`, `out_of_state`, `state_of_supply`, `purchase_return_invoice_date`, `payment_type_id`, `narration`, `sub_total`, `shipping_packing_amount`, `is_round_off`, `round_off`, `total`, `pay`, `financial_id`, `new_invoice_no`, `is_gst_bill`) VALUES
(4, 4, 5, 'mansi01', 1, 1, 'MAHARASHTRA', '2022-03-25', 1, 'test for insert with both batch and serial', '50.00', '10.00', b'1', '0.00', '60.00', '130.00', 8, '10.20', b'0');

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
  `new_invoice_no` varchar(50) NOT NULL,
  `serial_no` varchar(50) NOT NULL,
  `batch_no` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_purchase_return_invoice_detail`
--

INSERT INTO `tbl_purchase_return_invoice_detail` (`purchase_return_invoice_detail_id`, `company_id`, `purchase_return_invoice_id`, `product_id`, `unit_id`, `unit`, `rate`, `qty`, `gross_total`, `disc_per`, `disc_amt`, `sub_total`, `gstslab_id`, `gst`, `gst_per`, `igst`, `igst_per`, `total`, `financial_id`, `new_invoice_no`, `serial_no`, `batch_no`) VALUES
(14, 4, 4, 7, 1, 'kilogram(kg)', '10.00', '1.00', '10.00', '0.00', '0.00', '10.00', 3, '0.00', '0.00', '1.20', '12.00', '10.00', 8, '10.20', '', '1'),
(15, 4, 4, 7, 1, 'kilogram(kg)', '10.00', '2.00', '20.00', '0.00', '0.00', '20.00', 3, '0.00', '0.00', '2.40', '12.00', '20.00', 8, '10.20', '', '2'),
(16, 4, 4, 14, 6, 'box', '10.00', '2.00', '20.00', '0.00', '0.00', '20.00', 3, '0.00', '0.00', '2.40', '12.00', '20.00', 8, '10.20', '46|46|46|46|46|46|46|46|46|46|46|46|46|46|46|46|46', '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_quotation`
--

CREATE TABLE `tbl_quotation` (
  `quotation_id` bigint(20) NOT NULL,
  `company_id` bigint(20) NOT NULL,
  `party_id` bigint(20) NOT NULL,
  `invoice_no` bigint(20) NOT NULL,
  `out_of_state` tinyint(4) NOT NULL,
  `state_of_supply` varchar(50) NOT NULL,
  `quotation_date` date NOT NULL,
  `narration` varchar(500) NOT NULL,
  `sub_total` decimal(18,2) NOT NULL,
  `shipping_packing_amount` decimal(18,2) NOT NULL,
  `is_round_off` bit(1) NOT NULL,
  `round_off` decimal(18,2) NOT NULL,
  `total` decimal(18,2) NOT NULL,
  `financial_id` bigint(20) NOT NULL,
  `new_invoice_no` varchar(50) NOT NULL,
  `is_gst_bill` bit(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_quotation_detail`
--

CREATE TABLE `tbl_quotation_detail` (
  `quotation_detail_id` bigint(20) NOT NULL,
  `company_id` bigint(20) NOT NULL,
  `quotation_id` bigint(20) NOT NULL,
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
  `new_invoice_no` varchar(50) NOT NULL,
  `serial_no` varchar(50) NOT NULL,
  `batch_no` varchar(50) NOT NULL
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

--
-- Dumping data for table `tbl_sales_invoice`
--

INSERT INTO `tbl_sales_invoice` (`sales_invoice_id`, `company_id`, `party_id`, `invoice_no`, `out_of_state`, `state_of_supply`, `sales_invoice_date`, `payment_type_id`, `narration`, `sub_total`, `shipping_packing_amount`, `is_round_off`, `round_off`, `total`, `pay`, `financial_id`, `new_invoice_no`, `is_gst_bill`) VALUES
(1, 4, 1, 1, 1, 'JAMMU AND KASHMIR', '2020-07-16', 1, '', '2300.00', '0.00', b'1', '0.00', '2300.00', '2000.00', 9, '03.18', b'0'),
(2, 4, 3, 2, 1, 'GOA', '2020-08-16', 1, '', '4700.00', '0.00', b'1', '0.00', '4700.00', '4000.00', 9, '', b'0'),
(3, 4, 23, 3, 1, 'KERALA', '2020-09-16', 1, '', '5230.00', '0.00', b'1', '0.00', '5230.00', '5000.00', 9, '', b'0'),
(4, 4, 25, 4, 1, 'MIZORAM', '2020-10-16', 1, '', '2375.20', '0.00', b'1', '0.00', '2375.20', '0.00', 9, '', b'0'),
(5, 4, 27, 5, 1, 'ARUNACHAL PRADESH', '2020-11-16', 1, '', '4275.00', '0.00', b'1', '0.00', '4275.00', '4000.00', 9, '05.19', b'0'),
(6, 4, 30, 6, 1, 'LAKSHADWEEP', '2020-12-16', 1, '', '3240.80', '0.00', b'1', '0.20', '3241.00', '3241.00', 9, '', b'0'),
(7, 4, 32, 7, 1, 'ODISHA', '2021-01-16', 1, '', '2968.00', '0.00', b'1', '0.00', '2968.00', '2000.00', 9, '', b'0'),
(8, 4, 34, 8, 0, 'GUJARAT', '2021-02-16', 1, '', '2280.00', '0.00', b'1', '0.00', '2280.00', '2280.00', 9, '', b'0'),
(9, 4, 36, 9, 1, 'MEGHALAYA', '2021-03-16', 1, '', '1510.00', '0.00', b'1', '0.00', '1510.00', '1500.00', 9, '', b'0'),
(10, 4, 38, 1, 1, 'LADAKH', '2021-04-16', 1, '', '3100.00', '0.00', b'1', '0.00', '3100.00', '3100.00', 8, '', b'0'),
(11, 4, 1, 2, 1, 'JAMMU AND KASHMIR', '2021-05-16', 1, '', '2485.00', '0.00', b'1', '0.00', '2485.00', '2400.00', 8, '', b'0'),
(12, 4, 3, 3, 1, 'GOA', '2021-06-16', 1, '', '4275.00', '25.00', b'1', '0.00', '4300.00', '4000.00', 8, '05.29', b'0'),
(13, 4, 23, 4, 1, 'KERALA', '2021-07-16', 1, '', '1782.00', '0.00', b'1', '0.00', '1782.00', '1782.00', 8, '05.31', b'0'),
(14, 4, 25, 5, 1, 'MIZORAM', '2021-08-16', 1, '', '4700.00', '0.00', b'1', '0.00', '4700.00', '4000.00', 8, '05.33', b'0'),
(15, 4, 27, 6, 1, 'ARUNACHAL PRADESH', '2021-09-16', 1, '', '3078.00', '0.00', b'1', '0.00', '3078.00', '3078.00', 8, '05.36', b'0'),
(16, 4, 30, 7, 1, 'LAKSHADWEEP', '2021-10-16', 1, '', '3019.00', '0.00', b'1', '0.00', '3019.00', '2800.00', 8, '05.39', b'0'),
(17, 4, 32, 8, 1, 'ODISHA', '2021-11-16', 1, '', '2914.00', '0.00', b'1', '0.00', '2914.00', '2914.00', 8, '05.41', b'0'),
(18, 4, 34, 9, 0, 'GUJARAT', '2021-12-16', 1, '', '7985.00', '0.00', b'1', '0.00', '7985.00', '7985.00', 8, '05.50', b'0'),
(19, 4, 36, 10, 1, 'MEGHALAYA', '2022-01-16', 1, '', '4500.00', '0.00', b'1', '0.00', '4500.00', '4000.00', 8, '05.54', b'0'),
(20, 4, 38, 11, 1, 'LADAKH', '2022-02-16', 1, '', '11973.00', '0.00', b'1', '0.00', '11973.00', '11000.00', 8, '', b'0'),
(21, 4, 1, 12, 1, 'JAMMU AND KASHMIR', '2022-03-16', 1, '', '5400.00', '0.00', b'1', '0.00', '5400.00', '5400.00', 8, '05.56', b'0'),
(22, 4, 23, 13, 1, 'KERALA', '2022-03-25', 1, 'test for gst check', '1140.00', '0.00', b'1', '0.00', '1140.00', '1000.00', 8, '', b'0');

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
  `new_invoice_no` varchar(50) NOT NULL,
  `serial_no` varchar(50) NOT NULL,
  `batch_no` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_sales_invoice_detail`
--

INSERT INTO `tbl_sales_invoice_detail` (`sales_invoice_detail_id`, `company_id`, `sales_invoice_id`, `product_id`, `unit_id`, `unit`, `rate`, `qty`, `gross_total`, `disc_per`, `disc_amt`, `sub_total`, `gstslab_id`, `gst`, `gst_per`, `igst`, `igst_per`, `total`, `financial_id`, `new_invoice_no`, `serial_no`, `batch_no`) VALUES
(1, 4, 1, 1, 1, 'kilogram(kg)', '210.00', '10.00', '2100.00', '0.00', '0.00', '2100.00', 3, '0.00', '0.00', '252.00', '12.00', '2352.00', 9, '03.18', '', ''),
(2, 4, 1, 7, 1, 'kilogram(kg)', '20.00', '10.00', '200.00', '0.00', '0.00', '200.00', 3, '0.00', '0.00', '24.00', '12.00', '224.00', 9, '03.18', '', '2'),
(3, 4, 2, 9, 1, 'kilogram(kg)', '120.00', '10.00', '1200.00', '0.00', '0.00', '1200.00', 3, '0.00', '0.00', '144.00', '12.00', '1344.00', 9, '', '', ''),
(4, 4, 2, 11, 1, 'kilogram(kg)', '70.00', '50.00', '3500.00', '0.00', '0.00', '3500.00', 3, '0.00', '0.00', '420.00', '12.00', '3920.00', 9, '', '', ''),
(5, 4, 3, 10, 5, 'pouch', '110.00', '5.00', '550.00', '0.00', '0.00', '550.00', 1, '0.00', '0.00', '77.00', '14.00', '627.00', 9, '', '', ''),
(6, 4, 3, 50, 1, 'kilogram(kg)', '1200.00', '2.00', '2400.00', '5.00', '120.00', '2280.00', 4, '0.00', '0.00', '45.60', '2.00', '2325.60', 9, '', '', ''),
(7, 4, 3, 51, 1, 'kilogram(kg)', '800.00', '3.00', '2400.00', '0.00', '0.00', '2400.00', 5, '0.00', '0.00', '0.00', '0.00', '2400.00', 9, '', '', ''),
(8, 4, 4, 25, 1, 'kilogram(kg)', '120.00', '4.00', '480.00', '1.00', '4.80', '475.20', 4, '0.00', '0.00', '9.50', '2.00', '484.70', 9, '', '', ''),
(9, 4, 4, 23, 1, 'kilogram(kg)', '100.00', '10.00', '1000.00', '0.00', '0.00', '1000.00', 1, '0.00', '0.00', '140.00', '14.00', '1140.00', 9, '', '', ''),
(10, 4, 4, 28, 1, 'kilogram(kg)', '90.00', '10.00', '900.00', '0.00', '0.00', '900.00', 8, '0.00', '0.00', '54.00', '6.00', '954.00', 9, '', '', ''),
(11, 4, 5, 8, 1, 'kilogram(kg)', '90.00', '50.00', '4500.00', '5.00', '225.00', '4275.00', 3, '0.00', '0.00', '513.00', '12.00', '4788.00', 9, '05.19', '', ''),
(12, 4, 6, 12, 1, 'kilogram(kg)', '100.00', '20.00', '2000.00', '10.00', '200.00', '1800.00', 4, '0.00', '0.00', '36.00', '2.00', '1836.00', 9, '', '21|', ''),
(13, 4, 6, 34, 1, 'kilogram(kg)', '100.00', '5.00', '500.00', '0.00', '0.00', '500.00', 8, '0.00', '0.00', '30.00', '6.00', '530.00', 9, '', '', ''),
(14, 4, 6, 18, 6, 'box', '160.00', '6.00', '960.00', '2.00', '19.20', '940.80', 3, '0.00', '0.00', '112.90', '12.00', '1053.70', 9, '', '', ''),
(15, 4, 7, 154, 6, 'box', '200.00', '8.00', '1600.00', '2.00', '32.00', '1568.00', 8, '0.00', '0.00', '94.08', '6.00', '1662.08', 9, '', '', ''),
(16, 4, 7, 155, 11, 'meter', '200.00', '7.00', '1400.00', '0.00', '0.00', '1400.00', 3, '0.00', '0.00', '168.00', '12.00', '1568.00', 9, '', '', ''),
(17, 4, 8, 14, 6, 'box', '90.00', '12.00', '1080.00', '0.00', '0.00', '1080.00', 5, '0.00', '0.00', '0.00', '0.00', '1080.00', 9, '', '', ''),
(18, 4, 8, 50, 1, 'kilogram(kg)', '1200.00', '1.00', '1200.00', '0.00', '0.00', '1200.00', 4, '12.00', '1.00', '0.00', '0.00', '1212.00', 9, '', '', ''),
(19, 4, 9, 21, 1, 'kilogram(kg)', '120.00', '5.00', '600.00', '0.00', '0.00', '600.00', 6, '0.00', '0.00', '120.00', '20.00', '720.00', 9, '', '', ''),
(20, 4, 9, 15, 1, 'kilogram(kg)', '110.00', '5.00', '550.00', '0.00', '0.00', '550.00', 7, '0.00', '0.00', '44.00', '8.00', '594.00', 9, '', '', ''),
(21, 4, 9, 33, 1, 'kilogram(kg)', '120.00', '3.00', '360.00', '0.00', '0.00', '360.00', 6, '0.00', '0.00', '72.00', '20.00', '432.00', 9, '', '', ''),
(22, 4, 10, 53, 1, 'kilogram(kg)', '400.00', '5.00', '2000.00', '0.00', '0.00', '2000.00', 7, '0.00', '0.00', '160.00', '8.00', '2160.00', 8, '', '', ''),
(23, 4, 11, 70, 6, 'box', '100.00', '10.00', '1000.00', '0.00', '0.00', '1000.00', 1, '0.00', '0.00', '140.00', '14.00', '1140.00', 8, '', '', ''),
(24, 4, 11, 91, 6, 'box', '300.00', '5.00', '1500.00', '1.00', '15.00', '1485.00', 3, '0.00', '0.00', '178.20', '12.00', '1663.20', 8, '', '', ''),
(25, 4, 12, 8, 1, 'kilogram(kg)', '90.00', '50.00', '4500.00', '5.00', '225.00', '4275.00', 3, '0.00', '0.00', '513.00', '12.00', '4788.00', 8, '05.29', '', ''),
(26, 4, 13, 28, 1, 'kilogram(kg)', '90.00', '10.00', '900.00', '2.00', '18.00', '882.00', 8, '0.00', '0.00', '52.92', '6.00', '934.92', 8, '05.31', '', ''),
(27, 4, 13, 16, 1, 'kilogram(kg)', '90.00', '10.00', '900.00', '0.00', '0.00', '900.00', 8, '0.00', '0.00', '54.00', '6.00', '954.00', 8, '05.31', '', ''),
(28, 4, 14, 69, 9, 'litter', '150.00', '10.00', '1500.00', '0.00', '0.00', '1500.00', 8, '0.00', '0.00', '90.00', '6.00', '1590.00', 8, '05.33', '', ''),
(29, 4, 14, 31, 1, 'kilogram(kg)', '160.00', '20.00', '3200.00', '0.00', '0.00', '3200.00', 4, '0.00', '0.00', '64.00', '2.00', '3264.00', 8, '05.33', '', ''),
(30, 4, 15, 53, 1, 'kilogram(kg)', '400.00', '5.00', '2000.00', '0.00', '0.00', '2000.00', 7, '0.00', '0.00', '160.00', '8.00', '2160.00', 8, '05.36', '', ''),
(31, 4, 15, 20, 1, 'kilogram(kg)', '1100.00', '1.00', '1100.00', '2.00', '22.00', '1078.00', 5, '0.00', '0.00', '0.00', '0.00', '1078.00', 8, '05.36', '', ''),
(32, 4, 16, 59, 1, 'kilogram(kg)', '100.00', '15.00', '1500.00', '0.00', '0.00', '1500.00', 8, '0.00', '0.00', '90.00', '6.00', '1590.00', 8, '05.39', '', ''),
(33, 4, 16, 41, 1, 'kilogram(kg)', '310.00', '5.00', '1550.00', '2.00', '31.00', '1519.00', 1, '0.00', '0.00', '212.66', '14.00', '1731.66', 8, '05.39', '', ''),
(34, 4, 17, 43, 1, 'kilogram(kg)', '50.00', '50.00', '2500.00', '5.00', '125.00', '2375.00', 4, '0.00', '0.00', '47.50', '2.00', '2422.50', 8, '05.41', '', ''),
(35, 4, 17, 13, 1, 'kilogram(kg)', '110.00', '5.00', '550.00', '2.00', '11.00', '539.00', 5, '0.00', '0.00', '0.00', '0.00', '539.00', 8, '05.41', '', ''),
(36, 4, 18, 7, 1, 'kilogram(kg)', '120.00', '8.00', '960.00', '5.00', '48.00', '912.00', 3, '54.72', '6.00', '0.00', '0.00', '966.72', 8, '05.50', '', ''),
(37, 4, 18, 83, 8, 'bag', '950.00', '3.00', '2850.00', '2.00', '57.00', '2793.00', 3, '167.58', '6.00', '0.00', '0.00', '2960.58', 8, '05.50', '', ''),
(38, 4, 18, 58, 1, 'kilogram(kg)', '200.00', '10.00', '2000.00', '0.00', '0.00', '2000.00', 3, '120.00', '6.00', '0.00', '0.00', '2120.00', 8, '05.50', '', ''),
(39, 4, 18, 50, 1, 'kilogram(kg)', '1200.00', '2.00', '2400.00', '5.00', '120.00', '2280.00', 4, '22.80', '1.00', '0.00', '0.00', '2302.80', 8, '05.50', '', ''),
(40, 4, 19, 6, 1, 'kilogram(kg)', '120.00', '25.00', '3000.00', '5.00', '150.00', '2850.00', 3, '0.00', '0.00', '342.00', '12.00', '3192.00', 8, '05.54', '', ''),
(41, 4, 19, 10, 5, 'pouch', '110.00', '15.00', '1650.00', '0.00', '0.00', '1650.00', 1, '0.00', '0.00', '231.00', '14.00', '1881.00', 8, '05.54', '', ''),
(42, 4, 20, 42, 1, 'kilogram(kg)', '90.00', '30.00', '2700.00', '1.00', '27.00', '2673.00', 3, '0.00', '0.00', '320.76', '12.00', '2993.76', 8, '', '', ''),
(43, 4, 20, 57, 1, 'kilogram(kg)', '310.00', '30.00', '9300.00', '0.00', '0.00', '9300.00', 5, '0.00', '0.00', '0.00', '0.00', '9300.00', 8, '', '', ''),
(44, 4, 21, 50, 1, 'kilogram(kg)', '1200.00', '5.00', '6000.00', '10.00', '600.00', '5400.00', 4, '0.00', '0.00', '108.00', '2.00', '5508.00', 8, '05.56', '', ''),
(45, 4, 10, 20, 1, 'kilogram(kg)', '1100.00', '1.00', '1100.00', '0.00', '0.00', '1100.00', 5, '0.00', '0.00', '0.00', '0.00', '1100.00', 8, '', '', ''),
(46, 4, 22, 12, 1, 'kilogram(kg)', '100.00', '12.00', '1200.00', '5.00', '60.00', '1140.00', 4, '0.00', '0.00', '22.80', '2.00', '1162.80', 8, '', '', '');

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
(1, 4, 1, 1, 1, 'JAMMU AND KASHMIR', '2022-03-25', 1, 'test one ', '199.50', '0.00', b'0', '0.00', '199.50', '100.00', 8, 'zxcvbnm', b'0');

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
  `new_invoice_no` varchar(50) NOT NULL,
  `serial_no` varchar(50) NOT NULL,
  `batch_no` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_sales_return_detail`
--

INSERT INTO `tbl_sales_return_detail` (`sales_return_detail_id`, `company_id`, `sales_return_id`, `product_id`, `unit_id`, `unit`, `rate`, `qty`, `gross_total`, `disc_per`, `disc_amt`, `sub_total`, `gstslab_id`, `gst`, `gst_per`, `igst`, `igst_per`, `total`, `financial_id`, `new_invoice_no`, `serial_no`, `batch_no`) VALUES
(1, 4, 1, 1, 1, 'kilogram(kg)', '210.00', '1.00', '210.00', '5.00', '10.50', '199.50', 3, '0.00', '0.00', '23.94', '12.00', '222.88', 8, 'zxcvbnm', '2|', '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_serial_no`
--

CREATE TABLE `tbl_serial_no` (
  `serial_no_id` bigint(20) NOT NULL,
  `company_id` bigint(20) NOT NULL,
  `product_id` bigint(20) NOT NULL,
  `serial_no` varchar(50) NOT NULL,
  `is_sold` bit(4) NOT NULL DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_serial_no`
--

INSERT INTO `tbl_serial_no` (`serial_no_id`, `company_id`, `product_id`, `serial_no`, `is_sold`) VALUES
(1, 4, 1, 'p', b'0001'),
(2, 4, 1, 'e', b'0010'),
(3, 4, 1, 'p', b'0000'),
(4, 4, 1, 's', b'0000'),
(5, 4, 1, 'i', b'0000'),
(6, 4, 2, 'b', b'0000'),
(7, 4, 2, 'l', b'0000'),
(8, 4, 2, 'a', b'0000'),
(9, 4, 2, 'c', b'0000'),
(10, 4, 2, 'k', b'0000'),
(11, 4, 10, 'ket', b'0000'),
(12, 4, 10, 'ch', b'0000'),
(13, 4, 10, 'up', b'0000'),
(14, 4, 154, 'S', b'0000'),
(15, 4, 154, 'O', b'0000'),
(16, 4, 154, 'C', b'0000'),
(17, 4, 154, 'K', b'0000'),
(18, 4, 154, 'E', b'0000'),
(19, 4, 154, 'T', b'0000'),
(20, 4, 154, 'Socket', b'0000'),
(21, 4, 12, 'A', b'0001'),
(22, 4, 12, 'P', b'0000'),
(23, 4, 12, 'P', b'0000'),
(24, 4, 12, 'L', b'0000'),
(25, 4, 12, 'e', b'0001'),
(26, 4, 20, 'Beer', b'0000'),
(27, 4, 20, 'Apple', b'0000'),
(28, 4, 22, 'A', b'0000'),
(29, 4, 22, 'N', b'0000'),
(30, 4, 22, 'J', b'0000'),
(31, 4, 22, 'E', b'0000'),
(32, 4, 22, 'E', b'0000'),
(33, 4, 22, 'R', b'0000'),
(34, 4, 24, 'N', b'0000'),
(35, 4, 24, 'U', b'0000'),
(36, 4, 24, 'T', b'0000'),
(37, 4, 24, 'S', b'0000'),
(38, 4, 15, 'G', b'0000'),
(39, 4, 15, 'R', b'0000'),
(40, 4, 15, 'A', b'0000'),
(41, 4, 15, 'P', b'0000'),
(42, 4, 15, 'E', b'0000'),
(43, 4, 15, 'S', b'0000'),
(44, 4, 14, 'B', b'0000'),
(45, 4, 14, 'A', b'0000'),
(46, 4, 14, 'B', b'0010'),
(47, 4, 14, 'Y', b'0000'),
(48, 4, 26, 'ONI', b'0000'),
(49, 4, 26, 'ON', b'0000'),
(50, 4, 1, '2', b'0000'),
(51, 4, 1, '2', b'0000');

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
-- Table structure for table `tbl_stock_summary_setting`
--

CREATE TABLE `tbl_stock_summary_setting` (
  `print_setting_id` bigint(20) NOT NULL,
  `sale_price_show` bit(1) NOT NULL,
  `purchase_price_show` bit(1) NOT NULL,
  `stock_qty_show` bit(1) NOT NULL,
  `stock_value_show` bit(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_stock_summary_setting`
--

INSERT INTO `tbl_stock_summary_setting` (`print_setting_id`, `sale_price_show`, `purchase_price_show`, `stock_qty_show`, `stock_value_show`) VALUES
(1, b'0', b'0', b'0', b'0');

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
(15, 'microgram', '2022-01-26 11:59:23'),
(16, 'gram', '2022-02-19 06:35:22');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_unit_conversion`
--

CREATE TABLE `tbl_unit_conversion` (
  `conversion_id` bigint(20) NOT NULL,
  `product_id` bigint(20) NOT NULL,
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

INSERT INTO `tbl_unit_conversion` (`conversion_id`, `product_id`, `primary_unit`, `primary_unit_id`, `secondary_unit`, `secondary_unit_id`, `rate`, `is_default`) VALUES
(12, 18, 'box', 6, 'packet', 7, '50.00', b'1'),
(13, 1, 'kilogram(kg)', 1, 'gram', 2, '1000.00', b'0'),
(14, 117, 'pouch', 5, 'bottle', 3, '0.00', b'1'),
(15, 152, 'packet', 7, 'bottle', 3, '12.00', b'1'),
(16, 153, 'packet', 7, 'bottle', 3, '10.00', b'1'),
(17, 12, 'kilogram(kg)', 1, 'miliGram (mg)', 2, '0.00', b'1'),
(18, 154, 'box', 6, 'packet', 7, '10.00', b'1'),
(19, 155, 'meter', 11, 'centimeter', 12, '100.00', b'1'),
(20, 36, 'kilogram(kg)', 1, 'gram', 16, '1000.00', b'1');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `oauth_provider` enum('google','facebook','twitter','linkedin') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'google',
  `oauth_uid` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `first_name` varchar(25) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(25) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `gender` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `locale` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `picture` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `manage_user_tbl`
--
ALTER TABLE `manage_user_tbl`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `tbl_bank_account`
--
ALTER TABLE `tbl_bank_account`
  ADD PRIMARY KEY (`bank_account_id`);

--
-- Indexes for table `tbl_barcode_master`
--
ALTER TABLE `tbl_barcode_master`
  ADD PRIMARY KEY (`barcode_id`);

--
-- Indexes for table `tbl_batch_tracking`
--
ALTER TABLE `tbl_batch_tracking`
  ADD PRIMARY KEY (`batch_tracking_id`);

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
-- Indexes for table `tbl_expence_detail`
--
ALTER TABLE `tbl_expence_detail`
  ADD PRIMARY KEY (`expence_detail_id`);

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
-- Indexes for table `tbl_income`
--
ALTER TABLE `tbl_income`
  ADD PRIMARY KEY (`income_id`);

--
-- Indexes for table `tbl_income_detail`
--
ALTER TABLE `tbl_income_detail`
  ADD PRIMARY KEY (`income_detail_id`);

--
-- Indexes for table `tbl_income_type`
--
ALTER TABLE `tbl_income_type`
  ADD PRIMARY KEY (`income_type_id`);

--
-- Indexes for table `tbl_max_sell_product_setting`
--
ALTER TABLE `tbl_max_sell_product_setting`
  ADD PRIMARY KEY (`setting_id`);

--
-- Indexes for table `tbl_party_group`
--
ALTER TABLE `tbl_party_group`
  ADD PRIMARY KEY (`party_group_id`);

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
-- Indexes for table `tbl_payment_in`
--
ALTER TABLE `tbl_payment_in`
  ADD PRIMARY KEY (`payment_in_id`);

--
-- Indexes for table `tbl_payment_out`
--
ALTER TABLE `tbl_payment_out`
  ADD PRIMARY KEY (`payment_out_id`);

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
-- Indexes for table `tbl_product_setting`
--
ALTER TABLE `tbl_product_setting`
  ADD PRIMARY KEY (`product_setting_id`);

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
-- Indexes for table `tbl_quotation`
--
ALTER TABLE `tbl_quotation`
  ADD PRIMARY KEY (`quotation_id`);

--
-- Indexes for table `tbl_quotation_detail`
--
ALTER TABLE `tbl_quotation_detail`
  ADD PRIMARY KEY (`quotation_detail_id`);

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
-- Indexes for table `tbl_serial_no`
--
ALTER TABLE `tbl_serial_no`
  ADD PRIMARY KEY (`serial_no_id`);

--
-- Indexes for table `tbl_size`
--
ALTER TABLE `tbl_size`
  ADD PRIMARY KEY (`size_id`);

--
-- Indexes for table `tbl_stock_summary_setting`
--
ALTER TABLE `tbl_stock_summary_setting`
  ADD PRIMARY KEY (`print_setting_id`);

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
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `manage_user_tbl`
--
ALTER TABLE `manage_user_tbl`
  MODIFY `user_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tbl_bank_account`
--
ALTER TABLE `tbl_bank_account`
  MODIFY `bank_account_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_barcode_master`
--
ALTER TABLE `tbl_barcode_master`
  MODIFY `barcode_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_batch_tracking`
--
ALTER TABLE `tbl_batch_tracking`
  MODIFY `batch_tracking_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_cashmemo`
--
ALTER TABLE `tbl_cashmemo`
  MODIFY `cashmemo_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_cashmemo_detail`
--
ALTER TABLE `tbl_cashmemo_detail`
  MODIFY `cashmemo_detail_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_cashmemo_return`
--
ALTER TABLE `tbl_cashmemo_return`
  MODIFY `cashmemo_return_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_cashmemo_return_detail`
--
ALTER TABLE `tbl_cashmemo_return_detail`
  MODIFY `cashmemo_return_detail_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_category`
--
ALTER TABLE `tbl_category`
  MODIFY `category_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tbl_color`
--
ALTER TABLE `tbl_color`
  MODIFY `color_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `tbl_company`
--
ALTER TABLE `tbl_company`
  MODIFY `company_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_company_ledger`
--
ALTER TABLE `tbl_company_ledger`
  MODIFY `company_ledger_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `tbl_expence`
--
ALTER TABLE `tbl_expence`
  MODIFY `expence_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_expence_detail`
--
ALTER TABLE `tbl_expence_detail`
  MODIFY `expence_detail_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
-- AUTO_INCREMENT for table `tbl_income`
--
ALTER TABLE `tbl_income`
  MODIFY `income_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_income_detail`
--
ALTER TABLE `tbl_income_detail`
  MODIFY `income_detail_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_income_type`
--
ALTER TABLE `tbl_income_type`
  MODIFY `income_type_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_party_group`
--
ALTER TABLE `tbl_party_group`
  MODIFY `party_group_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_party_ledger`
--
ALTER TABLE `tbl_party_ledger`
  MODIFY `party_ladger_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `tbl_party_master`
--
ALTER TABLE `tbl_party_master`
  MODIFY `party_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `tbl_payment_in`
--
ALTER TABLE `tbl_payment_in`
  MODIFY `payment_in_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `tbl_payment_out`
--
ALTER TABLE `tbl_payment_out`
  MODIFY `payment_out_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `tbl_payment_type`
--
ALTER TABLE `tbl_payment_type`
  MODIFY `payment_type_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tbl_place_of_supply_master`
--
ALTER TABLE `tbl_place_of_supply_master`
  MODIFY `place_of_supply_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `tbl_product_master`
--
ALTER TABLE `tbl_product_master`
  MODIFY `product_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=159;

--
-- AUTO_INCREMENT for table `tbl_purchase_invoice`
--
ALTER TABLE `tbl_purchase_invoice`
  MODIFY `purchase_invoice_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `tbl_purchase_invoice_detail`
--
ALTER TABLE `tbl_purchase_invoice_detail`
  MODIFY `purchase_invoice_detail_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `tbl_purchase_return_invoice`
--
ALTER TABLE `tbl_purchase_return_invoice`
  MODIFY `purchase_return_invoice_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_purchase_return_invoice_detail`
--
ALTER TABLE `tbl_purchase_return_invoice_detail`
  MODIFY `purchase_return_invoice_detail_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `tbl_quotation`
--
ALTER TABLE `tbl_quotation`
  MODIFY `quotation_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_quotation_detail`
--
ALTER TABLE `tbl_quotation_detail`
  MODIFY `quotation_detail_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_sales_invoice`
--
ALTER TABLE `tbl_sales_invoice`
  MODIFY `sales_invoice_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `tbl_sales_invoice_detail`
--
ALTER TABLE `tbl_sales_invoice_detail`
  MODIFY `sales_invoice_detail_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `tbl_sales_return`
--
ALTER TABLE `tbl_sales_return`
  MODIFY `sales_return_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_sales_return_detail`
--
ALTER TABLE `tbl_sales_return_detail`
  MODIFY `sales_return_detail_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_serial_no`
--
ALTER TABLE `tbl_serial_no`
  MODIFY `serial_no_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `tbl_size`
--
ALTER TABLE `tbl_size`
  MODIFY `size_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tbl_unit`
--
ALTER TABLE `tbl_unit`
  MODIFY `unit_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `tbl_unit_conversion`
--
ALTER TABLE `tbl_unit_conversion`
  MODIFY `conversion_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
