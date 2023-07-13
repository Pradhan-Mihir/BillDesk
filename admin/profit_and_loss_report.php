<?php
	include_once('header.php');
    global $row_login_select;
    global $con;
					
	$sql_email = "select product_name,sales_rate,purchase_rate,opening_stock from tbl_product_master";
	$result_email = mysqli_query($con,$sql_email);
	
	$counter = 0;
	
	$fetch_setting	=  "select * from tbl_stock_summary_setting where  print_setting_id = 1 ";
	$result_setting = mysqli_query($con,$fetch_setting);		
	$row_setting = mysqli_fetch_array($result_setting);
	
	$invoice_mail = '<html>
						<head></head>
						<body>
							<div class="table-responsive printableArea">
								<table id="myTable" class="table table-striped" border="1px">
									<thead>
										<tr>
										  <th>SR NO.</th>
										  <th>ITEM NAME</th>';
										  if($row_setting["sale_price_show"] != 0){ $invoice_mail .='<th>SALES RATE</th> '; } $invoice_mail .='
										  ';if($row_setting["purchase_price_show"] != 0){ $invoice_mail .='<th>PURCHASE RATE</th> '; } $invoice_mail .='
										  ';if($row_setting["stock_qty_show"] != 0){ $invoice_mail .='<th>STOCK QTY.</th> '; } 	$invoice_mail .='
										  ';if($row_setting["stock_value_show"] != 0){ $invoice_mail .='<th>TOTAL</th> '; } 	$invoice_mail .='
										</tr>
									</thead>
									<tbody>
											'; 
											$counter = 0;
											$total = 0.00;
											while($row_email = mysqli_fetch_array($result_email))
											{
												$counter++;
												$total = $row_email['purchase_rate'] * $row_email['opening_stock'];
												
												$invoice_mail .= '<tr>
													<td class="text-center">'.$counter.'</td>		
													<td>'.$row_email["product_name"].'</td>';
													if($row_setting["sale_price_show"] != 0){ $invoice_mail .='<td>'.$row_email["sales_rate"].'</td> '; } $invoice_mail .='
													';if($row_setting["purchase_price_show"] != 0){ $invoice_mail .='<td>'.$row_email["purchase_rate"].'</td>'; } $invoice_mail .='
													';if($row_setting["stock_qty_show"] != 0){ $invoice_mail .='<td>'.$row_email["opening_stock"].'</td>'; } $invoice_mail .='
													';if($row_setting["stock_value_show"] != 0){ $invoice_mail .='<td>'.$total.'</td>'; } $invoice_mail .='
												</tr>';
											}	
											
									$invoice_mail .= '</tbody>
								</table>
							</div>
						</body>
					</html>';
					
	if(isset($_POST['btn_print_email']))
	{
		$to = $row_login_select['email'];
		$subject = "Stock Summary Report";
		
		$message = $invoice_mail;
		$header  = "MIME-Version: 1.0\r\n";
		$header .= "Content-type: text/html; charset: iso-8859-1"."\r\n";
		$header .= "From:billdesk675@gmail.com";
		
		if(mail($to,$subject,$message,$header))
		{
			echo "<script>alert('mail sent successfully...!');</script>";
		}
		else
		{
			die('Mail Not Sent'.mysqli_error($con));
		}
	}
	if(isset($_POST['btn_save']))
	{
		//for chk sale error
		if(isset($_POST['chk_sale'])) 
			$chk_sale = inputvalid($_POST['chk_sale']);
		else
			$chk_sale = false;
		
		//for chk purchase error
		if(isset($_POST['chk_purchase'])) 
			$chk_purchase = inputvalid($_POST['chk_purchase']);
		else
			$chk_purchase = false;
		
		//for chk qty error
		if(isset($_POST['chk_stock_qty'])) 
			$chk_stock_qty = inputvalid($_POST['chk_stock_qty']);
		else
			$chk_stock_qty = false;
		
		//for chk value error
		if(isset($_POST['chk_stock_value'])) 
			$chk_stock_value = inputvalid($_POST['chk_stock_value']);
		else
			$chk_stock_value = false;
		
		$update_setting = "update tbl_stock_summary_setting set sale_price_show = '".$chk_sale."',purchase_price_show = '".$chk_purchase."',stock_qty_show = '".$chk_stock_qty."',stock_value_show='".$chk_stock_value."' where print_setting_id = 1 ";
		
		$rs_update_setting = mysqli_query($con,$update_setting);
	}
?>
<script>
	function nc_cat()
	{
		//for mfg date split
		let start_date = document.getElementById("txt_start_date").value;
		let end_date = document.getElementById("txt_end_date").value;
		
		$.ajax({  
			url:"profit_and_loss_report_ajax.php",
			type:"POST",  
			data:{ 'start_date': start_date ,'end_date' : end_date , 'report' : 1 },
			dataType :'json',
			success:function(data)  
			{  
				//alert(count);
				$('#category_result').empty();
				if(data[0].total_records != 0)	
				{	
					for(i=0;i<data.length;i++)
					{
						let table_data = "<tr><td style='text-align: center'>"+( i  + 1)   +"</td><td style='text-align: center'>"+data[i].product_name+"</td><td style='text-align: center'>"+data[i].mrp_price+"</td><td style='text-align: center'>"+data[i].batch_no+"</td><td style='text-align: center'>"+data[i].model_no+"</td><td style='text-align: center'>"+data[i].mfg_date+"</td><td style='text-align: center'>"+data[i].exp_date+"</td><td style='text-align: center'>"+data[i].size+"</td><td style='text-align: center'><b><span ";
						
					 
						if(data[i].quantity > 0 )
						{ 
							table_data += "style='color:#25e90d'";
						}
						else
						{
							table_data += "style='color:red'";
							
						}
						
						table_data += ">"+data[i].quantity+"</span></b></td></tr>";
					
						$("#category_result").append(table_data);
						
					}
				}	
				
			}
		});	
	}
</script>	
<style>
	#pagination{
    display: flex;
    justify-content: right;
    align-items: right;
  }
</style>
<div class="row">
	<div class="col-sm-12">			
		<div class="white-box">
			<div class="panel panel-info">
				<div class="panel-heading">Profit And Loss Report</div>
			</div>	
			<div class="row">
				<div class="col-md-12">
					<div class="panel-body">
						<form name="add_new" id="add_new" method="post">
							<div class="form-actions">
								<p align="right">
									<button id="print" class="fcbtn btn btn-info btn-outline btn-1e print" type="button"><i class="fa fa-file-pdf-o"></i></button>
									
									<button id="print_popup" name = "print_popup" class="fcbtn btn btn-info btn-outline btn-1e" type="button" data-toggle="modal" data-target="#print_option_model"> <span><i class="fa fa-print"></i></span></button>
										
									<div class="modal fade" id="print_option_model" role="dialog">
										<div class="modal-dialog">
											<div class="modal-content">
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
													<h4>Print Options</h4>
												</div>
												<div class="modal-body">
													<div class="row">
														<div class="col-md-11">
															<div class="form-group">
																<label class="control-label">Sale Price</label>
															</div>
														</div>
														<div class="col-md-1">
															<div class="form-group">
																<input type="checkbox" id="chk_sale" name="chk_sale" <?php if($row_setting['sale_price_show'] == 1 ){echo "checked";}?>>
															</div>
														</div>
													</div>
													<div class="row">
														<div class="col-md-11">
															<div class="form-group">
																<label class="control-label">Purchase Price</label>
															</div>
														</div>
														<div class="col-md-1">
															<div class="form-group">
																<input type="checkbox" id="chk_purchase" name="chk_purchase" <?php if($row_setting['purchase_price_show'] == 1 ){echo "checked";}?>>
															</div>
														</div>
													</div>
													<div class="row">
														<div class="col-md-11">
															<div class="form-group">
																<label class="control-label">Stock Quantity</label>
															</div>
														</div>
														<div class="col-md-1">
															<div class="form-group">
																<input type="checkbox" id="chk_stock_qty" name="chk_stock_qty" <?php if($row_setting['stock_qty_show'] == 1 ){echo "checked";}?>>
															</div>
														</div>
													</div>	
													<div class="row">
														<div class="col-md-11">
															<div class="form-group">
																<label class="control-label">Stock Value</label>
															</div>
														</div>
														<div class="col-md-1">
															<div class="form-group">
																<input type="checkbox" id="chk_stock_value" name="chk_stock_value" <?php if($row_setting['stock_value_show'] == 1 ){echo "checked";}?>>
															</div>
														</div>
													</div>
													<div class="form-actions">
														<button type="submit" name="btn_save" id="btn_save" class="btn btn-info">Ok</button>
														<button type="submit" name="btn_print_email" id="btn_print_email" class="btn btn-info">Email Pdf</button>
														<button id="print" class="btn btn-info print" type="button">Save Pdf</button>
														<button type="button" name="btn_msg" id="btn_msg" class="btn btn-info">Message Pdf</button>
														<button type="close" name="btn_reset" id="btn_reset" class="btn btn-info">Cancel</button>
													</div>
												</div>
											</div>
										</div>
									</div>
									
								</p>
							</div>
							<div class="row">
								<div class="col-lg-2">
									<div class="form-group">
										<label class="control-label">Start Date</label>
										<input class="form-control" type="date" name="txt_start_date" id="txt_start_date" onchange="nc_cat()"/>
									</div>
								</div>
								<div class="col-lg-2">
									<div class="form-group">
										<label class="control-label">End Date</label>
										<input class="form-control" type="date" name="txt_end_date" id="txt_end_date" onchange="nc_cat()"/>
									</div>
								</div>
							</div>
						</form>
					</div>	
				</div>	
			</div>
			<div class='table-responsive printableArea'>
				<table class='table table-striped'>
					<thead>
						<tr>
							<th style='text-align: left'>Particular</th>
							<th style='text-align: right'>Amount</th>
						</tr>
					</thead>
					<tbody id="category_result">
						<tr>
							<td><label>Purhase(+)</label></td>
							<td style="text-align:right;"><div id="purchase" style="border:0px;text-align:right;">&#8377;</div></td>
						</tr>
						<tr>
							<td><label>Purchase Discount(-)</label></td>
							<td style="text-align:right;"><div id="purchase_discount" style="border:0px;text-align:right;">&#8377;</div></td>
						</tr>
						<tr>
							<td><label>Purchase Return(-)</label></td>
							<td style="text-align:right;"><div id="purchase_return" style="border:0px;text-align:right;">&#8377;</div></td>
						</tr>
						<tr>
							<td><label>Purchase Return Discount(+)</label></td>
							<td style="text-align:right;"><div id="purchase_return_discount" style="border:0px;text-align:right;">&#8377;</div></td>
						</tr>
						<tr>
							<td><label>Sales(+)</label></td>
							<td style="text-align:right;"><div id="sales" style="border:0px;text-align:right;">&#8377;</div></td>
						</tr>
						<tr>	
							<td><label>Sales Discount(-)</label></td>
							<td style="text-align:right;"><div id="sales_discount" style="border:0px;text-align:right;">&#8377;</div></td>
						</tr>
						<tr>
							<td><label>Sales Return(+)</label></td>
							<td style="text-align:right;"><div id="sales_return" style="border:0px;text-align:right;">&#8377;</div></td>
						</tr>
						<tr>
							<td><label>Sales Return Discount(+)</label></td>
							<td style="text-align:right;"><div id="sales_return_discount" style="border:0px;text-align:right;">&#8377;</div></td>
						</tr>
						<tr>
							<td><label>Cashmemo(+)</label></td>
							<td style="text-align:right;"><div id="cashmemo" style="border:0px;text-align:right;">&#8377;</div></td>
						</tr>
						<tr>
							<td><label>Cashmemo Discount(+)</label></td>
							<td style="text-align:right;"><div id="cashmemo_discount" style="border:0px;text-align:right;">&#8377;</div></td>
						</tr>
						<tr>
							<td><label>Cashmemo Return(+)</label></td>
							<td style="text-align:right;"><div id="cashmemo_return" style="border:0px;text-align:right;">&#8377;</div></td>
						</tr>
						<tr>
							<td><label>Cashmemo Return Discount(+)</label></td>
							<td style="text-align:right;"><div id="cashmemo_return_discount" style="border:0px;text-align:right;">&#8377;</div></td>
						</tr>
						<tr>
							<td><label>Income(+)</label></td>
							<td style="text-align:right;"><div id="income" style="border:0px;text-align:right;">&#8377;</div></td>
						</tr>
						<tr>
							<td><label>Expence(-)</label></td>
							<td style="text-align:right;"><div id="expence" style="border:0px;text-align:right;">&#8377;</div></td>
						</tr>
						<tr>
							<td><label>Opening Stock(-)</label></td>
							<td style="text-align:right;"><div id="opening_stock" style="border:0px;text-align:right;">&#8377;</div></td>
						</tr>
						<tr>
							<td><label>Closing Stock(+)</label></td>
							<td style="text-align:right;"><div id="closing_stock" style="border:0px;text-align:right;">&#8377;</div></td>
						</tr>
						<tr>
							<td><label>Tax Payable(+)</label></td>
							<td style="text-align:right;"><div id="tax_pay" style="border:0px;text-align:right;">&#8377;</div></td>
						</tr>
						<tr>
							<td><label>Tax Receivable(+)</label></td>
							<td style="text-align:right;"><div id="tax_receive" style="border:0px;text-align:right;">&#8377;</div></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>		
</div>

<?php	
	include_once('footer.php');
?>
<script src="eliteadmin-ecommerce/js/jquery.PrintArea.js" type="text/JavaScript"></script>
<script>
    $(document).ready(function() {
		
		$.ajax({  
			url:"profit_and_loss_report_ajax.php",
			type:"POST",
			data:{'start_date': '' ,'end_date' : '' , 'report' : 1 },
			dataType :'json',
			success:function(data)  
			{  
				//alert(count);
				//$('#category_result').empty();
				$("#purchase").html('<span style="color:red">'+data.purchase+'</span>');
				$("#purchase_discount").html('<span style="color:#25e90d">'+data.purchase_discount+'</span>');
				$("#purchase_return").html('<span style="color:#25e90d">'+data.purchase_return+'</span>');
				$("#purchase_return_discount").html('<span style="color:red">'+data.purchase_return_discount+'</span>');
				$("#sales").html('<span style="color:#25e90d">'+data.sales+'</span>');
				$("#sales_discount").html('<span style="color:red">'+data.sales_discount+'</span>');
				$("#sales_return").html('<span style="color:red">'+data.sales_return+'</span>');
				$("#sales_return_discount").html('<span style="color:#25e90d">'+data.sales_return_discount+'</span>');
				$("#cashmemo").html('<span style="color:#25e90d">'+data.cashmemo+'</span>');
				$("#cashmemo_discount").html('<span style="color:red">'+data.cashmemo_discount+'</span>');
				$("#cashmemo_return").html('<span style="color:red">'+data.cashmemo_return+'</span>');
				$("#cashmemo_return_discount").html('<span style="color:#25e90d">'+data.cashmemo_return_discount+'</span>');
				$("#income").html('<span style="color:#25e90d">'+data.income+'</span>');
				$("#expence").html('<span style="color:red">'+data.expence+'</span>');
				$("#opening_stock").html('<span style="color:red">'+data.opening_stock+'</span>');
				$("#closing_stock").html('<span style="color:#25e90d">'+data.closing_stock+'</span>');
				$("#tax_pay").html('<span style="color:red">'+data.tax_payable+'</span>');
				$("#tax_receive").html('<span style="color:#25e90d">'+data.tax_receivable+'</span>');
			}
		}); 

        $(".print").click(function() {
            let mode = 'iframe'; //popup
            let close = mode == "popup";
            let options = {
                mode: mode,
                popClose: close
            };
            $("div.printableArea").printArea(options);
        });
    });
</script>