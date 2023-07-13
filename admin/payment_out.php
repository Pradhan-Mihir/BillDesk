<?php
$title = "BILL DESK-Payment Out";
	include_once('header.php');
	global $con;
	
	//fetch active financial year
	$financial="SELECT financial_id from tbl_financial_master WHERE is_default=1";
	$rs_financial=mysqli_query($con,$financial);
	$row_financial=mysqli_fetch_array($rs_financial);
	
	//fetch active company id
	$company_id="SELECT * FROM tbl_company WHERE is_default=1";
	$rs_company_id=mysqli_query($con,$company_id);
	$row_company_id=mysqli_fetch_array($rs_company_id);

	
	//insert code
	if(isset($_POST['btn_save']))
	{		
		if($_POST['payment_out_id'] == '')
		{			
			if(!empty($_FILES["payment_out_img"]["name"]))
			{			
			$img3=$_FILES["payment_out_img"]["name"];
			$img3 = pathinfo($img3, PATHINFO_FILENAME).mt_rand(600000,999999).".".pathinfo($img3, PATHINFO_EXTENSION);				
			$tmp_name3=$_FILES["payment_out_img"]["tmp_name"];
			if(is_uploaded_file($tmp_name3))
			{
				copy($tmp_name3,"../images/payment_out_images/".$img3);
			}
			}
			else
			{
				$img3 = "";
			}
			//INSERT CODE
			$objname="payment out";
			$sql_payment_out_iu = "insert into tbl_payment_out(company_id,financial_id,party_id,receipt_no,payment_type_id,cheque_ref_no,date,description,image,paid,obj_name) values('".$row_company_id['company_id']."','".$row_financial['financial_id']."','".$_POST['cmb_party']."','".$_POST['txt_receipt_no']."','".$_POST['cmb_payment_type']."','".$_POST['txt_cheque_ref']."','".$_POST['txt_date']."','".$_POST['txt_description']."','".$img3."','".$_POST['txt_paid_amt']."','".$objname."')";
			$rs_payment_out_iu = mysqli_query($con,$sql_payment_out_iu);
			
			$sql_inv_id = "select max(payment_out_id) 'payment_out_id' from tbl_payment_out";
			$rs_inv_id = mysqli_query($con , $sql_inv_id);
			$inv_id = mysqli_fetch_array($rs_inv_id);
		
			//purchase or sales update code

            if($_POST['txt_pur_inv_detail'] != '')
            {
                $a = $_POST['txt_pur_inv_detail'];
                $arr = explode('|',$a);
                for($i = 1 ;$i < sizeof($arr); $i++)
                {
                    $varr = explode('-' , $arr[$i]);
                    $sql_purchase_update = "update tbl_purchase_invoice set pay = pay +".$varr[1]." where purchase_invoice_id = '".$varr[0]."'";
                    mysqli_query($con , $sql_purchase_update);
					
					$sql_company_update = "update tbl_company_ledger set debit = debit +".$varr[1]." where related_id = '".$varr[0]."' and related_obj_name = 'purchase' ";
					mysqli_query($con,$sql_company_update);
					
					$sql_party_update = "update tbl_company_ledger set debit = debit +".$varr[1]." where invoice_no = '".$varr[0]."' and invoice_type = 'purchase' ";
					mysqli_query($con,$sql_party_update);

                }
            }
            else if($_POST['txt_ser_inv_detail'] != '')
            {
                $a = $_POST['txt_ser_inv_detail'];
                $arr = explode('|',$a);
                for($i = 1 ;$i < sizeof($arr); $i++)
                {
                    $varr = explode('-' , $arr[$i]);
                    $sql_sales_return_update = "update tbl_sales_return set pay = pay +".$varr[1]." where sales_return_id = '".$varr[0]."'";
                    mysqli_query($con , $sql_sales_return_update);
					
					$sql_company_update = "update tbl_company_ledger set debit = debit +".$varr[1]." where related_id = '".$varr[0]."' and related_obj_name = 'sales return' ";
					mysqli_query($con,$sql_company_update);
					
					$sql_party_update = "update tbl_company_ledger set debit = debit +".$varr[1]." where invoice_no = '".$varr[0]."' and invoice_type = 'sales return' ";
					mysqli_query($con,$sql_party_update);

                }
            }


			//company_ledger
			$objname = "payment out";
			$credit=0.00;
			
			$sql_company_ledger="insert into tbl_company_ledger(company_id , related_id , related_obj_name,party_id ,date, details, credit, debit, financial_id, new_invoice_no) values('".$row_company_id['company_id']."' , '".$inv_id["payment_out_id"]."' ,'".$objname."','".$_POST['cmb_party']."' , '".$_POST['txt_date']."' , '".$_POST['txt_description']."' , '".$credit."','".$_POST['txt_paid_amt']."','".$row_financial['financial_id']."','".$_POST['txt_receipt_no']."')";
			$rs_company_ledger = mysqli_query($con,$sql_company_ledger);
			
			//party_ledger
			$party_typ = "payment out";
			$inv_typ = "payment out"; 
			$debit = 0.00;
			
			$sql_party_ledger = "insert into tbl_party_ledger (company_id , party_type , party_id , invoice_type , invoice_no , detail , credit , debit , date , financial_id , new_invoice_no) VALUES('".$row_company_id['company_id']."' , '".$party_typ."' , '".$_POST['cmb_party']."' , '".$inv_typ."', '".$inv_id["payment_out_id"]."' , '".$_POST['txt_description']."' ,'".$_POST['txt_paid_amt']."' , '".$debit."' , '".$_POST['txt_date']."' ,'".$row_financial['financial_id']."','".$_POST['txt_receipt_no']."' ) ";
			$rs_party_ledger = mysqli_query($con , $sql_party_ledger);
			
			//fetch party balance
			$sql_fetch_bal = "select opening_balance from tbl_party_master where party_id = '".$_POST['cmb_party']."' ";
			$rs_fetch_bal = mysqli_query($con,$sql_fetch_bal);
			$row_fetch_party_bal=mysqli_fetch_array($rs_fetch_bal);
			
			$sql_party_bal = "update tbl_party_master set opening_balance = '".$row_fetch_party_bal['opening_balance']."' + '".$_POST['txt_paid_amt']."' where party_id = '".$_POST['cmb_party']."' ";
			$rs_party_bal = mysqli_query($con,$sql_party_bal);
		}
		else
		{	
			$sql_image_select = "select image from tbl_payment_out where payment_out_id = '".$_POST['payment_out_id']."' ";
			$run_image_select = mysqli_query($con , $sql_image_select);
			
			if($run_image_select)
			{
				$row_image_select = mysqli_fetch_array($run_image_select);
				$image1=$row_image_select['image'];
			}
			
			if(!empty($_FILES["payment_out_img"]["name"]))
			{			
				$img3=$_FILES["payment_out_img"]["name"];
				$img3 = pathinfo($img3, PATHINFO_FILENAME).mt_rand(600000,999999).".".pathinfo($img3, PATHINFO_EXTENSION);				
				$tmp_name3=$_FILES["payment_out_img"]["tmp_name"];
				$path = '../images/payment_out_images/';
			
				if(is_uploaded_file($tmp_name3))
				{
					copy($tmp_name3,"../images/payment_out_images/".$img3);
					unlink($path.$image1);
				}
			}
			else
			{
				$img3 = $row_image_select['image'];
			}
			//UPDATE CODE
			$objname="payment out";
			$sql_payment_out_update = "update tbl_payment_out set company_id ='".$row_company_id['company_id']."',financial_id='".$row_financial['financial_id']."',party_id='".$_POST['cmb_party']."',payment_type_id='".$_POST['cmb_payment_type']."',cheque_ref_no='".$_POST['txt_cheque_ref']."',date='".$_POST['txt_date']."',description='".$_POST['txt_description']."',image='".$img3."',paid='".$_POST['txt_paid_amt']."',obj_name = '".$objname."' where payment_out_id ='".$_POST['payment_out_id']."' and obj_name = '".$objname."' ";

			//company_ledger
			//select maximum company ledger id
			$objname = "payment out";
			$credit=0.00;
			
			$sql_company_ledger_id = "select *  from tbl_company_ledger where related_id = '".$_POST['payment_out_id']."' and related_obj_name = '".$objname."' ";
			$rs_company_ledger_id = mysqli_query($con,$sql_company_ledger_id);
			$row_company_ledger_id = mysqli_fetch_array($rs_company_ledger_id);
			
			$sql_company_ledger="update tbl_company_ledger set company_id = '".$row_company_id['company_id']."',related_id = '".$_POST['payment_out_id']."',related_obj_name='".$objname."',party_id='".$_POST['cmb_party']."',date = '".$_POST['txt_date']."' ,details = '".$_POST['txt_description']."' , credit = '".$credit."' , debit = '".$_POST['txt_paid_amt']."',financial_id = '".$row_financial['financial_id']."',new_invoice_no='".$_POST['txt_receipt_no']."' where related_id = '".$_POST['payment_out_id']."' and related_obj_name = '".$objname."' ";
			$rs_company_ledger = mysqli_query($con,$sql_company_ledger);
			
			//party_ledger
			
			$party_typ = "payment out";
			$inv_typ = "payment out"; 
			$debit = 0.00;
			
			$sql_party_ledger = "update tbl_party_ledger set company_id='".$row_company_id['company_id']."',party_type='".$party_typ."',party_id='".$_POST['cmb_party']."',invoice_type='".$inv_typ."',invoice_no='".$_POST['payment_out_id']."',detail='".$_POST['txt_description']."',credit='".$_POST['txt_paid_amt']."',debit='".$debit."',date='".$_POST['txt_date']."',financial_id='".$row_financial['financial_id']."',new_invoice_no='".$_POST['txt_receipt_no']."' where invoice_no='".$_POST['payment_out_id']."' ";
			$rs_party_ledger = mysqli_query($con , $sql_party_ledger);
			
			//fetch party balance
			$sql_fetch_bal = "select opening_balance from tbl_party_master where party_id = '".$_POST['cmb_party']."' ";
			$rs_fetch_bal = mysqli_query($con,$sql_fetch_bal);
			$row_fetch_party_bal=mysqli_fetch_array($rs_fetch_bal);
			
			//fetch party old  balance
			$sql_fetch_bal_old = "select paid from tbl_payment_out where party_id = '".$_POST['cmb_party']."' ";
			$rs_fetch_bal_old = mysqli_query($con,$sql_fetch_bal_old);
			$row_fetch_party_bal_old=mysqli_fetch_array($rs_fetch_bal_old);
			
			$sql_party_bal = "update tbl_party_master set opening_balance = '".$row_fetch_party_bal['opening_balance']."' - '".$row_fetch_party_bal_old['paid']."' + '".$_POST['txt_paid_amt']."' where party_id = '".$_POST['cmb_party']."' ";
			$rs_party_bal = mysqli_query($con,$sql_party_bal);
			
			$rs_payment_out_iu = mysqli_query($con,$sql_payment_out_update);
		}
		
		if(!$rs_payment_out_iu)
		{
			die('User Data Not Inserted/Updated.'.mysqli_error($con));
		}
		else
		{
			echo "<script>window.location = 'payment_out_view.php';</script>";
		}
	}
?>
<script type="text/javascript" language="javascript">

	//RESTRIC FILE SIZE 2 MB
	function ValidateSize(file) {
        var FileSize = file.files[0].size / 1024 / 1024; // in MB
        if (FileSize > 2) {
            alert('File size exceeds 2 MB');
			file.value = '';
			return false;
           // $(file).val(''); //for clearing with Jquery
        }
		else 
		{
			document.getElementById('imgprw').src = window.URL.createObjectURL(file.files[0]);
        }
		return true;
    }
	function RemoveImage()
	{		
		document.getElementById('imgprw').removeAttribute('src');		
	}
	
	function fnc_payment_type_text()
	{
		var val_payment = $("#cmb_payment_type option:selected").text();
		
		if(val_payment == 'cheque' )
		{
			$("#dynamic_ref").show();
		}
		else
		{
			$("#dynamic_ref").hide();
		}	
	}
	

    function fnc_pr_clicker()
    {
        let val = document.getElementById('cmb_party').value;
        if(val == '')
        {
            $('#sales_return').show();
            $('#purchase').show();
            $("#purchase_body").empty();
            $("#sales_return_body").empty();
            return false;
        }

        if(document.getElementById('txt_pur_inv_detail').value != '' || document.getElementById('txt_ser_inv_detail').value != '')
        {
            let chk = '';
            let txt = '';
            let amt = '';
            let dat = '';
            let val = '';

            if(document.getElementById('txt_pur_inv_detail').value != '')
            {
                txt = document.getElementById('txt_pur_inv_detail');
                chk = document.getElementsByName('chk_purchase_select[]');
                amt = document.getElementsByName('purchase_input_amt[]');
            }
            else
            {
                txt = document.getElementById('txt_ser_inv_detail');
                chk = document.getElementsByName('chk_sales_select[]');
                amt = document.getElementsByName('sales_input_amt[]');
            }

            for(let i=0;i<chk.length;i++)
            {
                chk[i].checked = false;
                amt[i].value = '';
                amt[i].readOnly = true;
            }

            let ab = txt.value;
            // console.log(ab);
            // console.log(txt.value);
            dat = ab.split('|');

            // console.log(dat.length);
            for(let i=1;i<dat.length;i++)
            {
                console.log(i);
                val = dat[i].split('-');
                for(let j=0;j<chk.length;j++)
                {
                    if(val[0] == chk[j].value)
                    {
                        chk[j].checked = true;
                        amt[j].readOnly = false;
                        amt[j].value = val[1];
                       break;
                    }
                }
            }
            return;
        }


        $.ajax({
            url:"payment_out_fetch.php",
            type:"POST",
            data:{'party_id' : val ,'tabs' : 1 },
            dataType :'json',
            success:function(data)
            {
                $("#purchase_body").empty();
                $("#sales_return_body").empty();

                //const obj = JSON.parse(data);
                if(data[0].type == 'purchase') {
                    $('#sales_return').hide();
                    $('#purchase').show();
                    $('#purchase').click();
                    for (let i = 0; i < data.length; i++)
                        $("#purchase_body").append("<tr><td  style='text-align: center'><input type='checkbox' id='chk_purchase_select' name = 'chk_purchase_select[]' value = '" + data[i].id + "' onchange = 'fnc_bill_selector(this)' ></td><td  style='text-align: center'><label class = 'control-label' > " + data[i].date + " </label></td><td  style='text-align: center'><label class = 'control-label' > " + data[i].inv_no + " </label></td><td style='text-align: center'><label class = 'control-label' > " + data[i].total + " </label></td><td style='text-align: center'><label class = 'control-label' > " + data[i].due + " </label></td><td style='text-align: center'><input type = 'number' id = 'purchase_input_amt' name = 'purchase_input_amt[]' readonly class = 'form-control' onkeyup='if(this.value > " + data[i].due + ") this.value = " + data[i].due + ";'  onchange='if(this.value > " + data[i].due + ") this.value = " + data[i].due + ";' ></td></tr>");
                }
                else {
                    $('#purchase').hide();
                    $('#sales_return').show();
                    $('#sales_return').click();
                    for (let i = 0; i < data.length; i++)
                        $("#sales_return_body").append("<tr><td  style='text-align: center'><input type='checkbox' id='chk_sales_select' name = 'chk_sales_select[]' value = '"+data[i].id+"' onchange = 'fnc_bill_selector(this)'  ></td><td  style='text-align: center'><label class = 'control-label' > "+data[i].date +" </label></td><td  style='text-align: center'><label class = 'control-label' > "+data[i].inv_no +" </label></td><td style='text-align: center'><label class = 'control-label' > "+data[i].total +" </label></td><td style='text-align: center'><label class = 'control-label' > "+data[i].due +" </label></td><td style='text-align: center'><input type = 'number' id = 'sales_input_amt' name = 'sales_input_amt[]' readonly class = 'form-control' onkeyup='if(this.value > " + data[i].due + ") this.value = " + data[i].due + ";'  onchange='if(this.value > " + data[i].due + ") this.value = " + data[i].due + ";' ></td></tr>");
                }
            }
        });
    }

    function fnc_bill_selector(e)
    {
        console.log('checked fnc');
        let txt = '';
        let txt_val = '';
        let index = '';
        let amt = '';
        let chk = '';

        //defining the textbox to do manipulation on
        if(document.getElementById('chk_purchase_select') == undefined) {
            txt = document.getElementById('txt_ser_inv_detail');
            amt = document.getElementsByName('sales_input_amt[]');
            chk = document.getElementsByName('chk_sales_select[]');
        }
        else {
            txt = document.getElementById('txt_pur_inv_detail');
            amt = document.getElementsByName('purchase_input_amt[]');
            chk = document.getElementsByName('chk_purchase_select[]');
        }

        for(let i=0;i< chk.length;i++)
            if(e == chk[i])
            {
                index = i;
                break;
            }
        // console.log(index);
        txt_val = txt.value;

        //to do if checked
        if(e.checked == 1)
        {
            // console.log('sales checked');
            amt[index].readOnly  = false;
        }
        //to-do if not checked
        else
        {
            // console.log('sales unchecked');
            //txt_val = txt_val.replace('|' + e.value amt[index].value + '|', "");
            // console.log(txt_val);
            txt.value = txt_val;

            amt[index].value = '';
            amt[index].readOnly  = true;
        }
    }

    function fnc_pr_sal_save_btn(e)
    {
        let txt = '';
        let chk = '';
        chk.ckecked = undefined;
        let dat = '';
        let result = '';
        if(e == document.getElementById('btn_purchase_submit'))
        {
            txt = document.getElementsByName('purchase_input_amt[]');
            chk = document.getElementsByName('chk_purchase_select[]');
            dat = document.getElementById('txt_pur_inv_detail');
        }
        else
        {
            txt = document.getElementsByName('sales_input_amt[]');
            chk = document.getElementsByName('chk_sales_select[]');
            dat = document.getElementById('txt_ser_inv_detail');
        }
        dat.value = '';
        document.getElementById('txt_paid_amt').value = 0;
        for(let i=0;i<chk.length;i++)
        {
            if(chk[i].checked != 1)
                continue;
            result =  chk[i].value + '-' + txt[i].value;
            dat.value = dat.value.concat('|',result);
            document.getElementById('txt_paid_amt').value = parseFloat(document.getElementById('txt_paid_amt').value) +  parseFloat( txt[i].value );
        }

        $('#modal_close_btn').click();
    }

</script>

<style>

    .modal-batch {
        max-width: 80%;
    }

</style>

<div class="row">
	<div class="col-md-12">
		<div class="panel panel-info">
			<div class="panel-heading">Payment Out</div>
			<div class="panel-wrapper collapse in" aria-expanded="true">
				<div class="panel-body">
					<form action="" method="post" name="frm_payment_out" id="frm_payment_out" enctype="multipart/form-data">
						<div class="form-body">								
							<div class="row">
								<div class="col-md-4">
									<div class="form-group">
										<label class="control-label">Party</label>
										<select id="cmb_party" name="cmb_party"  class="form-control" onchange="$('#txt_pur_inv_detail').val(''); $('#txt_ser_inv_detail').val('');">
											<option value="">------SELECT PARTY------</option>
											<?php 
												$party="SELECT * FROM tbl_party_master";
												$rs_party=mysqli_query($con,$party);
												while($row_party=mysqli_fetch_array($rs_party))
												{ 
											?>
												<option value="<?php echo $row_party['party_id']; ?>" >
													<?php echo $row_party['party_name'];?>
												</option>
											<?php
												}
											?>
										</select>
									</div>
								</div>
								<!-- /span---->
								<div class="col-md-4">
									<div class="form-group">
														
									</div>
								</div>
								<!-- /span---->
								<div class="col-md-4">
									<div class="form-group">
										<label class="control-label">Receipt No</label>
										<input type="text" id="txt_receipt_no" name="txt_receipt_no" class="form-control" placeholder="Enter Receipt No" >										
									</div>
								</div>
							</div>
							<!-- /row-->
							<div class="row">
								<div class="col-md-4">
									<div class="form-group">
										<label class="control-label">Payment Type</label>
										<select id="cmb_payment_type" name="cmb_payment_type" class="form-control" onchange="fnc_payment_type_text();">
											<?php 
												$sql_payment="SELECT * FROM tbl_payment_type";
												$rs_payment=mysqli_query($con,$sql_payment);
												while($row_payment=mysqli_fetch_array($rs_payment))
												{ 
											?>
												<option value="<?php echo $row_payment['payment_type_id']; ?>"  ><?php echo $row_payment['payment_type'];?></option>
											<?php
												}
											?>
										</select>	
									</div>
								</div>
								<!-- /span---->
								<div class="col-md-4">
									<div class="form-group" id="dynamic_ref">
										<label class="control-label">Reference No.</label>
										<input type="number" id="txt_cheque_ref" name="txt_cheque_ref" class="form-control" >				
									</div>
								</div>
								<!-- /span---->
								<div class="col-md-4">
									<div class="form-group">
										<label class="control-label">Date</label>
										<input type="date" id="txt_date" name="txt_date" class="form-control" >									
									</div>
								</div>
							</div>
							<!-- /row-->
							<div class="row">
								<div class="col-md-4">
									<div class="form-group">
										<label class="control-label">Description</label>
										<textarea id="txt_description" name="txt_description" class="form-control" placeholder="Enter Description"></textarea>		
									</div>
								</div>
								<!-- /span---->
								<div class="col-md-4">
									<div class="form-group">
                                    <?php    if(!isset($_GET['id']))
                                        {   ?>
                                        <button type="button" style="margin-top: 37px;" id="btn_popup" class="btn btn-info" data-toggle="modal" onclick = "fnc_pr_clicker()" data-target="#info_model">Select</button>
                                    <?php    } ?>
									</div>
								</div>
								<!-- modal start -->
<div class="modal fade bs-example-modal-lg" id="info_model" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" id = "modal_close_btn" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
				<h4>Invoice Details</h4>
			</div>
			<div class="modal-body">
				<div class="col-lg-12 col-sm-12 col-xs-24">
					<ul class="nav customtab nav-tabs" role="tablist">
						<li role="presentation" class="nav-item"><a href="#purchase_content" id="purchase"  class="nav-link active" aria-controls="purchase" role="tab" data-toggle="tab" aria-expanded="true"><span class="visible-xs"><i class="ti-home"></i></span><span class="hidden-xs" > Purchase</span></a></li>
						<li role="presentation" class="nav-item"><a href="#sales_return_content" id="sales_return" class="nav-link" aria-controls="sales_return" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="ti-settings"></i></span> <span class="hidden-xs">Sales Return</span></a></li>
					</ul>
					<!-- Tab panes -->
					<div class="tab-content">
						<div role="tabpanel" class="tab-pane fade active in" id="purchase_content" >
							<div class="col-md-12">
								<table class='table table-striped'>
									<thead>
										<tr>
											<th style='text-align: center'>#</th>
											<th style='text-align: center'>Invoice Date</th>
											<th style='text-align: center'>Invoice No </th>
											<th style='text-align: center'>Total</th>
											<th style='text-align: center'>Due</th>
                                            <th style='text-align: center'>Amount</th>
										</tr>
									</thead>
									<tbody id="purchase_body">
									
									</tbody>
								</table>
                                <div id="purchase_footer" style="text-align:right;">
                                    <button type="button" style="margin-top: 37px;" id="btn_purchase_submit" class="btn btn-success" onclick="fnc_pr_sal_save_btn(this)">Save</button>
                                </div>
							</div>
							<div class="clearfix"></div>
						</div>
						
						
						<div role="tabpanel" class="tab-pane fade" id="sales_return_content" >
							<div class="col-md-12">
								<table class='table table-striped'>
									<thead>
                                    <tr>
                                        <th style='text-align: center'>#</th>
                                        <th style='text-align: center'>Invoice Date</th>
                                        <th style='text-align: center'>Invoice No </th>
                                        <th style='text-align: center'>Total</th>
                                        <th style='text-align: center'>Due</th>
                                        <th style='text-align: center'>Amount</th>
                                    </tr>
									</thead>
									<tbody id="sales_return_body">
									
									</tbody>
								</table>
                                <div id="sales_footer" style="text-align:right;">
                                        <button type="button" style="margin-top: 37px;" id="btn_sales_submit" class="btn btn-success" onclick="fnc_pr_sal_save_btn(this)">Save</button>
                                </div>
							</div>
							<div class="clearfix"></div>
						</div>
					</div>
                </div>											
			</div>
		</div>
	</div>
</div>
								<!-- /span---->
								<div class="col-md-4">
									<div class="form-group">
														
									</div>
								</div>
								<!-- /span---->
							</div>
							<!-- /row-->
							<div class="row">
								<div class="col-md-4">
									<div class="form-group">
										<label class="control-label">Image</label>
										<input type="file" id="input-file-now-custom-1" class="dropify"  name="payment_out_img" />							
									</div>
								</div>
								<!-- /span---->
								<div class="col-md-4">
									<div class="form-group">

									</div>
								</div>
								<!-- /span---->
								<div class="col-md-4">
									<div class="form-group">
										<label class="control-label">Paid</label>
										<input type="number" id="txt_paid_amt" name="txt_paid_amt" step="0.01" readonly class="form-control" placeholder="Enter Paid Amount" >
									</div>
								</div>
							</div>
							<!-- /row-->
						</div>
				
						<div class="form-actions">
							<div class = "row">
								<div  class = "col-md-8"> </div>
								<input type="hidden" name="txt_pur_inv_detail" id="txt_pur_inv_detail" value="" >
								<input type="hidden" name="txt_ser_inv_detail" id="txt_ser_inv_detail" value="">
								<input type="hidden" name="payment_out_id" id="payment_out_id" value="<?php if(isset($_GET['id'])){ echo base64_decode($_GET['id']);} ?>"/> 
								<button type="submit" id="btn_save" name="btn_save" class="btn btn-success"> <i class="fa fa-check"></i> Save</button> &nbsp;
								<button type="submit" id="btn_save_n_print" style = "background: #03a9f3;" name="btn_save_n_print" class="btn btn-success"> <i class="fa fa-check"></i>Save & Print</button>&nbsp;
								<button type="reset" name="btn_reset" id="btn_reset" style = "background: lightgrey;" class="btn btn-default">Cancel</button>
							</div>
						</div>
					</form>
				</div>	
			</div>
		</div>
	</div>
</div>
<!--./row-->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>	
<script>
	$(document).ready(function()
	{	
		$('#btn_save').click(function(e)
		{
			console.log('btn_clicked??!!');
		});
	
	
		$("#dynamic_ref").hide();
		$(".dropify-clear").click(function()
		{
		  var $this = $(this);
		  
		  if($this.value = 'undefined') 
		  {
				$('.dropify-clear').css("display", "none");
				$('.dropify-loader').css("display", "none");
				$('.dropify-preview').css("display", "block");
				$('.dropify-filename-inner').text('');  
		  }
		  else 
			{  
			
				$('.dropify-clear').css("display", "block");
				$('.dropify-loader').css("display", "none");
				$('.dropify-preview').css("display", "block");
				
			}
		});
    
    $('#payment_out_img').on('change', function() {
      $('.dropify-clear').css("display", "block");
      $('.dropify-loader').css("display", "none");
      $('.dropify-preview').css("display", "block");
    });
    
    $('.dropify-clear').click(function(e)
     {
       e.preventDefault();
       // your statements;
       $('.dropify-filename-inner').text('');    
     });

    //edit fetch
	var payment_out_id = $('#payment_out_id').val();
	
	if(payment_out_id != '' )
	{
		var imagePath1 = "../images/payment_out_images/";
		$.ajax({
			url:"payment_out_ajax.php",
			method:"POST",  
			data:{ 'id' : payment_out_id , 'edit' : 1 },
			success:function(data)  
			{  
				const obj = JSON.parse(data);
				// console.log(obj);
				document.getElementById("payment_out_id").value = payment_out_id;
				document.getElementById("cmb_party").value = obj.party_id;
				document.getElementById("txt_receipt_no").value = obj.receipt_no;
				document.getElementById("cmb_payment_type").value = obj.payment_type_id;
				document.getElementById("txt_date").value = obj.date;
				document.getElementById("txt_description").value = obj.description;
				
				var imagePath2 = obj.image;
				//alert(imagePath1 + imagePath2);
				$('#payment_out_img').attr("data-default-file",imagePath1 + imagePath2);
				$('.dropify-preview').css("display","block");
				$('.dropify-render').prepend('<img id = "edit_img"/>');
				$("#edit_img").attr("src", imagePath1 + imagePath2 );
				$('.dropify-filename-inner').text(imagePath2);
				$(".dropify-clear").css("display","initial");
				//$(".dropify-clear").trigger("click");
				//document.getElementById("btn_save").value = "Edit Company";	
				//$('#txt_pwd').attr('disabled', 'disabled');
				//$('#cpassword').attr('disabled', 'disabled');
				$('#payment_out_img').attr('disabled', 'disabled');
				document.getElementById("txt_paid_amt").value = obj.paid;
				
				var cheque = document.getElementById("txt_cheque_ref").value = obj.cheque_ref_no;
				if(cheque != '' && cheque !=0 && val_payment == 'cheque')
				{
					$("#dynamic_ref").show();
				}
				else
				{
					$("#dynamic_ref").hide();
				}
			}  
		});
	}
	
	});
	
	
</script>	
<?php
	include_once('footer.php');
?>
<script src="plugins/bower_components/dropify/dist/js/dropify.min.js"></script>
    <script>
    $(document).ready(function() {
        // Basic
        $('.dropify').dropify();

        // Translated
        $('.dropify-fr').dropify({
            messages: {
                default: 'Glissez-déposez un fichier ici ou cliquez',
                replace: 'Glissez-déposez un fichier ou cliquez pour remplacer',
                remove: 'Supprimer',
                error: 'Désolé, le fichier trop volumineux'
            }
        });

        // Used events
        var drEvent = $('#input-file-events').dropify();

        drEvent.on('dropify.beforeClear', function(event, element) {
            return confirm("Do you really want to delete \"" + element.file.name + "\" ?");
        });

        drEvent.on('dropify.afterClear', function(event, element) {
            alert('File deleted');
        });

        drEvent.on('dropify.errors', function(event, element) {
            // console.log('Has Errors');
        });

        var drDestroy = $('#input-file-to-destroy').dropify();
        drDestroy = drDestroy.data('dropify')
        $('#toggleDropify').on('click', function(e) {
            e.preventDefault();
            if (drDestroy.isDropified()) {
                drDestroy.destroy();
            } else {
                drDestroy.init();
            }
        })
    });
    </script>