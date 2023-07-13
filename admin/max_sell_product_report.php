<?php
	$title = "BILL DESK- Max Selling Product Report";
	include_once('header.php');

	$sql_company="SELECT * FROM tbl_company WHERE is_default=1";
	$rs_company_id=mysqli_query($con,$sql_company);
	$row_firm_address =mysqli_fetch_array($rs_company_id);

	$limit = 10;			
					
	$sql_email = "SELECT pro.product_name,pro.opening_stock,sid.product_id,sid.unit_id,sid.qty,un.unit_name,sid.total FROM tbl_sales_invoice_detail sid
						LEFT JOIN tbl_product_master pro ON pro.product_id = sid.product_id
						LEFT JOIN tbl_unit un ON un.unit_id = sid.unit_id 
						GROUP BY pro.product_name,sid.unit_id ORDER BY sum(sid.qty) desc";
	$result_email = mysqli_query($con,$sql_email);
	
	$counter = 0;
	
	$fetch_setting	=  "select * from tbl_max_sell_product_setting where  setting_id = 1 ";
	$result_setting = mysqli_query($con,$fetch_setting);		
	$row_setting = mysqli_fetch_array($result_setting);
	
	$invoice_mail = '<html>
						<head>
							<style>
								 #table_header
								{
								   text-align:center;
								   background:#ed121c !important;
								   color:white !important;
								   font-family: "Muli", sans-serif;
								}
							</style>
						</head>
						<body>
							<div class="table-responsive printableArea">
								<table id="myTable" class="table table-striped" border="1px">
									<thead id="table_header">
										<tr>
										  <th>SR NO.</th>
										  <th>ITEM NAME</th>';
											if($row_setting["item_unit_show"] != 0){ $invoice_mail .='<th>UNIT NAME</th> '; } $invoice_mail .='
										  ';if($row_setting["stock_show"] != 0){ $invoice_mail .='<th>STOCK QTY.</th> '; } 	$invoice_mail .='
										  ';if($row_setting["quantity_show"] != 0){ $invoice_mail .='<th>QUANTITY</th> '; } 	$invoice_mail .='
										</tr>
									</thead>
									<tbody>
											'; 
											$counter = 0;
											$total = 0.00;
											while($row_email = mysqli_fetch_array($result_email))
											{
												$counter++;
												
												$invoice_mail .= '<tr>
													<td class="text-center">'.$counter.'</td>		
													<td>'.$row_email["product_name"].'</td>';
													if($row_setting["item_unit_show"] != 0){ $invoice_mail .='<td>'.$row_email["unit_name"].'</td> '; } $invoice_mail .='
													';if($row_setting["stock_show"] != 0){ $invoice_mail .='<td>'.$row_email["opening_stock"].'</td>'; } $invoice_mail .='
													';if($row_setting["quantity_show"] != 0){ $invoice_mail .='<td>'.$row_email["qty"].'</td>'; } $invoice_mail .='
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
		$subject = "Max Sell Product Report";
		
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
		
		$update_setting = "update tbl_max_sell_product_setting set item_unit_show = '".$_POST['chk_unit']."',stock_show = '".$_POST['chk_stock_qty']."',quantity_show = '".$_POST['chk_qty']."' where setting_id = 1 ";
		
		$rs_update_setting = mysqli_query($con,$update_setting);
	}
	
?>
<script>
var prd_key = '';
var unit_key = '';

	
	function nc_cat(e)
	{
		var category = document.getElementById("cmb_category").value;
		var chk = document.getElementById('chk_stock');
		let export_table = '';
		let start_date = '';
		let end_date = '';

		if(e.getAttribute('id') == 'btn_export')
			export_table = 1;
		
		if(chk.checked)
		{
			var stock =1;
		}
		else
		{
			var stock = 0;
		}
		
		$.ajax({  
			url:"max_sell_product_report_ajax.php",
			type:"POST",  
			data:{'category':category,'stock':stock,'pagging' : 1 ,'export_table': export_table},
			dataType :'json',
			success:function(data)  
			{  
				if(e.getAttribute('id') != 'btn_export')
				{
					$('#table_data').empty();
					if(data[0].total_records != 0)	
					{	
						const table = $("#data_table").DataTable();  
						table.clear().draw();
						
						for(i=0;i<data.length;i++)
						{
							let table_data="<tr><td style='text-align: center'><button id='btn_popup_info' onclick='fnc_popup(this)' data-toggle='modal' data-target='#info_model' class='btn btn-default btn-circle' value="+data[i].button+"><i class='fa fa-check'></i></button></td><td style='text-align: center'>"+( i  + 1)   +"</td><td style='text-align: center'>"+data[i].product_name+"</td><td style='text-align: center'>"+data[i].unit_name+"</td><td style='text-align: center'><b><span ";
							
							
						
							if(data[i].opening_stock < 0 )
							{ 
								table_data += "style='color:red'";
							}
							else
							{
								table_data += "style='color:#25e90d'";
							}
							
							table_data += ">"+data[i].opening_stock+"</span></b></td><td style='text-align: center'>"+data[i].qty+"</td></tr>";
							
							const filter_tr = $(table_data);
							table.row.add(filter_tr).draw();
							
						}
					}
				}
				else // EXPORT THE TABLE 
				{
					
					var firm_address = '<?php echo trim($row_firm_address["address"])?>';
					var firm_city = '<?php echo $row_firm_address["city"]?>';
					var firm_pincode = '<?php echo $row_firm_address["pincode"]?>';
					var firm_gstin = '<?php echo $row_firm_address["gst_in_no"]?>';
					
					firm_address = firm_address.replace(/(\r\n|\n|\r)/gm, "");
					
					const d = new Date();
					var curr_year = d.getFullYear();
					var curr_month = d.getMonth() + 1;
					var curr_date = d.getDate();
					
					if(e.value == "Excel") // IF EXPORT IN EXCEL
					{
						var wb = XLSX.utils.book_new();
						
						const ws = XLSX.utils.json_to_sheet([]);
						
						/*-----------------------------------------------------------------------------------------------*/
						
							// add Data at A1,A2,A3,A4,A5 with merge cell 
							
							let title = [
											['|| Shree Ganeshay Namah ||'],
											['BILLDESK'],
											[firm_address+','+firm_city+'-'+firm_pincode],
											['GSTIN NO : '+firm_gstin],
											[]
										];
							
							var merge_row_1 = { s: {r:0, c:0}, e: {r:0, c:4} };
							var merge_row_2 = {s: {r:1, c:0}, e: {r:1, c:4} };
							var merge_row_3 = {s: {r:2, c:0}, e: {r:2, c:4} };
							var merge_row_4 = {s: {r:3, c:0}, e: {r:3, c:4} };
							var merge_row_5 = {s: {r:4, c:0}, e: {r:4, c:4} };
							
							var merge_row_6_col1 = {s: {r:5, c:0}, e: {r:5, c:0} }; // A6 : A6
							var merge_row_6_col2 = {s: {r:5, c:1}, e: {r:5, c:2} }; // B6 : C6
							var merge_row_6_col3 = {s: {r:5, c:3}, e: {r:5, c:4} }; // D6 : E6
							
							var merge_row_7 = {s: {r:6, c:0}, e: {r:6, c:4} };
							
							if(!ws['!merges']) 
							{
								ws['!merges'] = [];
								ws['!merges'].push(merge_row_1);
								ws['!merges'].push(merge_row_2);
								ws['!merges'].push(merge_row_3);
								ws['!merges'].push(merge_row_4);
								ws['!merges'].push(merge_row_5);
								ws['!merges'].push(merge_row_6_col1);
								ws['!merges'].push(merge_row_6_col2);
								ws['!merges'].push(merge_row_6_col3);
								ws['!merges'].push(merge_row_7);
							}	
							
							XLSX.utils.sheet_add_aoa(ws, title);
							
							var title_start_date = [['Start Date : '+start_date]];
							var title_report = [['Max Sell Product Report']];
							var title_end_date = [['End Date : '+end_date]];
							
							XLSX.utils.sheet_add_aoa(ws, title_start_date, {origin : 'A6'});
							XLSX.utils.sheet_add_aoa(ws, title_report, {origin : 'B6'});
							XLSX.utils.sheet_add_aoa(ws, title_end_date, {origin : 'D6'});
							
						/*-----------------------------------------------------------------------------------------------*/
						
							// A1,A2,A3,A4 with Style
							
							for (i=1;i<5;i++)
							{
								var cell_no = String.fromCharCode('65') + i;
								var size = 18;
								var text_bold = true;
								
								if(i == 2)
								{
									size = 16;
								}
								
								if(i == 3 || i == 4)
								{
									text_bold = false;
								}
								
								if(i == 4)
								{
									size = 12;
								}
								
								ws[cell_no].s = {
									font: {
										sz: size,
										bold: text_bold
									},
									alignment: {
										vertical: "center",
										horizontal: "center"
									}
								};
							}
							
							// A6,C6,E6 With Style
							
							ws['A6'].s = {
								font: {
									sz: 12,
									bold: false
								},
								alignment: {
									vertical: "center",
									horizontal: "center"
								}
							};
							
							ws['B6'].s = {
								font: {
									sz: 14,
									bold: true
								},
								alignment: {
									vertical: "center",
									horizontal: "center"
								}
							};
							
							ws['D6'].s = {
								font: {
									sz: 12,
									bold: false
								},
								alignment: {
									vertical: "center",
									horizontal: "center"
								}
							};
						
						/*-----------------------------------------------------------------------------------------------*/
						
							// Add Table Heading at A8 and add style of heading
							
							let Heading = [['SR No.','Item Name','Item Unit','Stock','Qty']];
							
							XLSX.utils.sheet_add_aoa(ws, Heading , {origin : 'A8'});
							

							for (i=65;i<70;i++)
							{
								var cell_no = String.fromCharCode(i)+"8";
								
								ws[cell_no].s = {
									font: {
										sz: 12,
										bold: true
									},
									alignment: {
										vertical: "center",
										horizontal: "center"
									}
								};
							}
						/*-----------------------------------------------------------------------------------------------*/
							
							// Cell Width of Table Heading
						
							var wscols = [
								{wch:8},
								{wch:20},
								{wch:20},
								{wch:20},
								{wch:20},
							];

							ws['!cols'] = wscols;
							
						/*-----------------------------------------------------------------------------------------------*/
							
							// Add Data at A9 with style 
						
							XLSX.utils.sheet_add_json(ws, data, { origin: 'A9', skipHeader: true });
							
							for(i = 65;i<65+4;i++)
							{
								for (j=9;j<9+data.length;j++)
								{
									var cell_no = String.fromCharCode(i)+ j;
									
									ws[cell_no].s = {
										font: {
											sz: 10,
										},
										alignment: {
											vertical: "center",
											horizontal: "center"
										}
									};
								}
							}
						/*-----------------------------------------------------------------------------------------------*/
						
							// Make Sheet add append excel data
							
							XLSX.utils.book_append_sheet(wb, ws, 'Stock Summary Report');
						
						/*-----------------------------------------------------------------------------------------------*/
							
							// Save Excel 
							
							var wbout = XLSX.write(wb, {bookType:'xlsx',  type: 'binary'});
							
							function s2ab(s) {
					  
								var buf = new ArrayBuffer(s.length);
								var view = new Uint8Array(buf);
								for (var i=0; i<s.length; i++) view[i] = s.charCodeAt(i) & 0xFF;
								return buf;
							}
		
							saveAs(new Blob([s2ab(wbout)],{type:"application/octet- stream"}),'max_sell_product_Report'+'_'+curr_date+'_'+curr_month+'_'+curr_year+'.xlsx');
					}
					else // IF EXPORT IN PDF
					{	
						
						var table_headers = {
							header_0:{
								col_1:{ text: 'SR No.',style: 'table_headers'},
								col_2:{ text: 'Item Name',style: 'table_headers'},
								col_3:{ text: 'Unit Name', style: 'table_headers'},
								col_5:{ text: 'Stock', style: 'table_headers'},
								col_6:{ text: 'Qty',style: 'table_headers'},
							}
						}
						
						var table_data =  data;
						
						var body = [];
						
						for (var key in table_headers)
						{
							if (table_headers.hasOwnProperty(key)){
								var header = table_headers[key];
								var row = new Array();
								row.push( header.col_1 );
								row.push( header.col_2 );
								row.push( header.col_3 );
								row.push( header.col_5 );
								row.push( header.col_6 );
								body.push(row);
							}
						}
						
						for (var key in table_data) 
						{
							if (table_data.hasOwnProperty(key))
							{
								var data = table_data[key];
								var row = new Array();
								row.push( data.sr_no.toString() );
								row.push( data.product_name.toString()  );
								row.push( data.unit_name.toString() );
								row.push( data.opening_stock.toString()  );
								row.push( data.qty.toString()  );
								body.push(row);
							}
						}
						
						
						var docDefinition = {
								content: 
								[
									{text: '|| Shree Ganeshay Namah ||', style: 'header'},
									{text: 'BILLDESK', style: 'subheader'},
									{text: firm_address+','+firm_city+'-'+firm_pincode, style: 'subheader1'},
									{text: 'GSTIN NO : '+firm_gstin, style: 'subheader1'},
									{text: '----------------------------------------------------------------------------------------------------------------------------', style: 'hr'},
									{text: 'Start Date : '+start_date, style: 'style_date1'},
									{text: 'Max Sell Product Report', style: 'style_report'},
									{text: 'End Date : '+end_date, style: 'style_date2'},
									{
										style: 'table_style',
										table: {
											widths:['auto',225 , 75,'auto','auto'],
											headerRows: 1,
											body: body
										},
										layout: {
											fillColor: function (rowIndex, node, columnIndex) {
												return (rowIndex % 2 === 0) ? '#CCCCCC' : null;
											}
										}
									}
								],
								styles: {
									header: {
										fontSize: 14,
										bold: true,
										alignment: 'center',
										margin: [0, 0, 0, 10]
									},
									subheader: {
										fontSize: 20,
										bold: true,
										alignment: 'center',
										margin: [0, 10, 0, 5]
									},
									subheader1: {
										fontSize: 15,
										italics: true,
										alignment: 'center',
										margin: [0, 10, 0, 5]
									},
									hr: {
										fontSize: 15,
									},
									style_date1: {
										fontSize: 12,
										bold: true,
										alignment: 'left',
										margin: [0, 25, 0, 5]
									},
									style_report: {
										fontSize: 18,
										bold: true,
										alignment: 'center',
										margin: [0, -22, 0, 5]
									},
									style_date2: {
										fontSize: 12,
										bold: true,
										alignment: 'right',
										margin: [0, -22, 0, 5]
									},
									table_style: {
										fontSize: 10,
										margin: [0, 20, 0, 0]
									},
									table_headers: {
										fontSize: 12,
										bold: true,
										alignment: 'center',
										margin: [0, 5, 0, 0]
									},
									table_total: {
										fontSize: 14,
										bold: true,
										alignment: 'center'
									}
								}		
						}
						
						// Save PDF 
						pdfMake.createPdf(docDefinition).download('Max_sell_product_Report'+'_'+curr_date+'_'+curr_month+'_'+curr_year+'.pdf');
						
					}
				}

			}
		});	
	}
	function fnc_popup(e)
	{
		//alert(e.value);
		let a = e.value;
		let b = a.split('|');
		
		prd_key = b[0];
		unit_key = b[1];
		$('#purchase_body').empty();
		$('#purchase_return_body').empty();
		$('#sales_body').empty();
		$('#sales_return_body').empty();
		$('#cashmemo_body').empty();
		$('#cashmemo_return_body').empty();
		//console.log('prd id = '+b[0]);
		//console.log('unit id = '+ b[1]);
		$('#purchase').click();
	}
	function fnc_tab(e)
	{
		var abc = e.getAttribute('id');
		//console.log(abc);
		
		$.ajax({  
			url:"max_sell_product_report_ajax.php",
			type:"POST",  
			data:{ 'name' : abc ,'prd_key':prd_key,'unit_key':unit_key,'tabs' : 1 },
			dataType :'json',
			success:function(data)  
			{  
				//const obj = JSON.parse(data);
				if(abc == 'purchase')
				{
					$("#purchase_body").empty();
					$("#purchase_body").append(fnc_data(data));
				}
				else if(abc == 'purchase_return')
				{
					$("#purchase_return_body").empty();
					$("#purchase_return_body").append(fnc_data(data));
				}
				else if(abc == 'sales')
				{
					$("#sales_body").empty();
					$("#sales_body").append(fnc_data(data));
				}
				else if(abc == 'sales_return')
				{
					$("#sales_return_body").empty();
					$("#sales_return_body").append(fnc_data(data));
				}
				else if(abc == 'cashmemo')
				{
					$("#cashmemo_body").empty();
					$("#cashmemo_body").append(fnc_data(data));
				}
				else if(abc == 'cashmemo_return')
				{
					$("#cashmemo_return_body").empty();
					$("#cashmemo_return_body").append(fnc_data(data));
				}
			}
		});	
	}
	function fnc_data(e)
	{
		let m='';
		//console.log('in for')
		for(i = 0 ;i < e.length ; i++)
		{
			m += "<tr><td td style='text-align: center'>"+(i + 1)+"</td><td td style='text-align: center'>"+e[i].product_name +"</td><td td style='text-align: center'>"+e[i].unit_name +"</td><td td style='text-align: center'>"+e[i].qty +"</td></tr>";
		}
		return m;
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
				<div class="panel-heading">Maximum Selling Product Report</div>
			</div>	
			
				<div class="col-md-12">
					<div class="panel-body">
						<form name="add_new" id="add_new" method="post">
							<div class="row">
								<div class="col-md-3">
									<div class="form-group">
										<label class="control-label">Category</label>
										<select id="cmb_category" name="cmb_category" class="form-control select2" onchange="nc_cat(this)">
											<option value="0">All Category</option>
											<?php 
												$query="SELECT cat.* FROM tbl_category cat LEFT JOIN tbl_company com ON com.company_id = cat.company_id WHERE com.is_default = 1;";
												$rs_cmb=mysqli_query($con,$query);
												while($row_cmb=mysqli_fetch_array($rs_cmb))
												{ 
											?>
												<option value="<?php echo $row_cmb['category_id']; ?>"><?php echo $row_cmb['category_name'];?></option>
											<?php
												} 
											?>
										</select>
									</div>
								</div>	
								
								<div class="col-md-3">
									<div class="form-group">
										<input type="checkbox" id="chk_stock" name="chk_stock" onchange = "nc_cat(this)" style="transform: scale(1.5);">&nbsp;
										<label class="control-label" style="margin-top: 45px;">Stock</label>
									</div>
								</div>	
								<div class="col-md-3" style="margin-block-start: auto;">
									<div class="form-group">
										<label id="export_label" class="control-label">Export In:</label>
										<input type="button" id="btn_export" value="Excel" onclick="nc_cat(this);" />
										<input type="button" id="btn_export" value="PDF" onclick="nc_cat(this); "/>
									</div>
								</div>
							<div class="form-actions">
								<p align="right">
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
																<label class="control-label">Item Unit</label>
															</div>
														</div>
														<div class="col-md-1">
															<div class="form-group">
																<input type="checkbox" id="chk_unit" name="chk_unit" <?php if($row_setting['item_unit_show'] == 1 ){echo "checked";}?>>
															</div>
														</div>
													</div>
													<div class="row">
														<div class="col-md-11">
															<div class="form-group">
																<label class="control-label">Stock</label>
															</div>
														</div>
														<div class="col-md-1">
															<div class="form-group">
																<input type="checkbox" id="chk_stock_qty" name="chk_stock_qty" <?php if($row_setting['stock_show'] == 1 ){echo "checked";}?>>
															</div>
														</div>
													</div>
													<div class="row">
														<div class="col-md-11">
															<div class="form-group">
																<label class="control-label">Quantity</label>
															</div>
														</div>
														<div class="col-md-1">
															<div class="form-group">
																<input type="checkbox" id="chk_qty" name="chk_qty" <?php if($row_setting['quantity_show'] == 1 ){echo "checked";}?>>
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
							
						</form>
					</div>	
				</div>	
			</div>
			<div class='table-responsive'>
				<table class='table table-striped' id="data_table">
					<thead>
						<tr>
							<th style='text-align: center'>INFO</th>
							<th style='text-align: center'>SR NO.</th>
							<th style='text-align: center'>ITEM NAME</th>
							<th style='text-align: center'>ITEM UNIT</th>
							<th style='text-align: center'>STOCK</th>
							<th style='text-align: center'>QTY.</th>
						</tr>
					</thead>
					<tbody id="table_data">
						
					</tbody>
				</table>
			</div>
		</div>
	</div>		
</div>
<div class="modal fade bs-example-modal-lg" id="info_model" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
				<h4>Information Of Product</h4>
			</div>
			<div class="modal-body">
				<div class="col-lg-12 col-sm-12 col-xs-24">
					<ul class="nav customtab nav-tabs" role="tablist">
						<li role="presentation" class="nav-item"><a href="#purchase_content" id="purchase" onclick="fnc_tab(this)" class="nav-link active" aria-controls="purchase" role="tab" data-toggle="tab" aria-expanded="true"><span class="visible-xs"><i class="ti-home"></i></span><span class="hidden-xs" > Purchase</span></a></li>
						<li role="presentation" class="nav-item"><a href="#purchase_return_content" id="purchase_return" onclick="fnc_tab(this)" class="nav-link" aria-controls="purhase_return" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="ti-user"></i></span> <span class="hidden-xs">Purchase Return</span></a></li>
						<li role="presentation" class="nav-item"><a href="#sales_content" id="sales" onclick="fnc_tab(this)" class="nav-link" aria-controls="sales" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="ti-email"></i></span> <span class="hidden-xs">Sales</span></a></li>
						<li role="presentation" class="nav-item"><a href="#sales_return_content" id="sales_return" onclick="fnc_tab(this)" class="nav-link" aria-controls="sales_return" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="ti-settings"></i></span> <span class="hidden-xs">Sales Return</span></a></li>
						<li role="presentation" class="nav-item"><a href="#cashmemo_content" id="cashmemo" onclick="fnc_tab(this)" class="nav-link" aria-controls="cashmemo" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="ti-email"></i></span> <span class="hidden-xs">Cashmemo</span></a></li>
						<li role="presentation" class="nav-item"><a href="#cashmemo_return_content" id="cashmemo_return" onclick="fnc_tab(this)" class="nav-link" aria-controls="cashmemo_return" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="ti-settings"></i></span> <span class="hidden-xs">Cashmemo Return</span></a></li>
					</ul>
					<!-- Tab panes -->
					<div class="tab-content">
						<div role="tabpanel" class="tab-pane fade active in" id="purchase_content" >
							<div class="col-md-12">
								<table class='table table-striped'>
									<thead>
										<tr>
											<th style='text-align: center'>Sr.no</th>
											<th style='text-align: center'>Product Name</th>
											<th style='text-align: center'>Unit Name</th>
											<th style='text-align: center'>Quantity</th>
										</tr>
									</thead>
									<tbody id="purchase_body">
									
									</tbody>
								</table>
							</div>
							<div class="clearfix"></div>
						</div>
						<div role="tabpanel" class="tab-pane fade" id="purchase_return_content" >
							<div class="col-md-12">
								<table class='table table-striped'>
									<thead>
										<tr>
											<th style='text-align: center'>Sr.no</th>
											<th style='text-align: center'>Product Name</th>
											<th style='text-align: center'>Unit Name</th>
											<th style='text-align: center'>Quantity</th>
										</tr>
									</thead>
									<tbody id="purchase_return_body">
									
									</tbody>
								</table>
							</div>
							<div class="clearfix"></div>
						</div>
						<div role="tabpanel" class="tab-pane fade" id="sales_content" >
							<div class="col-md-12">
								<table class='table table-striped'>
									<thead>
										<tr>
											<th style='text-align: center'>Sr.no</th>
											<th style='text-align: center'>Product Name</th>
											<th style='text-align: center'>Unit Name</th>
											<th style='text-align: center'>Quantity</th>
										</tr>
									</thead>
									<tbody id="sales_body">
									
									</tbody>
								</table>
							</div>
							<div class="clearfix"></div>
						</div>
						<div role="tabpanel" class="tab-pane fade" id="sales_return_content" >
							<div class="col-md-12">
								<table class='table table-striped'>
									<thead>
										<tr>
											<th style='text-align: center'>Sr.no</th>
											<th style='text-align: center'>Product Name</th>
											<th style='text-align: center'>Unit Name</th>
											<th style='text-align: center'>Quantity</th>
										</tr>
									</thead>
									<tbody id="sales_return_body">
									
									</tbody>
								</table>
							</div>
							<div class="clearfix"></div>
						</div>
						<div role="tabpanel" class="tab-pane fade" id="cashmemo_content" >
							<div class="col-md-12">
								<table class='table table-striped'>
									<thead>
										<tr>
											<th style='text-align: center'>Sr.no</th>
											<th style='text-align: center'>Product Name</th>
											<th style='text-align: center'>Unit Name</th>
											<th style='text-align: center'>Quantity</th>
										</tr>
									</thead>
									<tbody id="cashmemo_body">
									
									</tbody>
								</table>
							</div>
							<div class="clearfix"></div>
						</div>
						<div role="tabpanel" class="tab-pane fade" id="cashmemo_return_content" >
							<div class="col-md-12">
								<table class='table table-striped'>
									<thead>
										<tr>
											<th style='text-align: center'>Sr.no</th>
											<th style='text-align: center'>Product Name</th>
											<th style='text-align: center'>Unit Name</th>
											<th style='text-align: center'>Quantity</th>
										</tr>
									</thead>
									<tbody id="cashmemo_return_body">
									
									</tbody>
								</table>
							</div>
							<div class="clearfix"></div>
						</div>
					</div>
                        
                </div>											
			</div>
		</div>
	</div>
</div>
<?php	
	include_once('footer.php');
?>
<script src="assets/xlsx.bundle.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.15.6/xlsx.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/amcharts/3.21.15/plugins/export/libs/FileSaver.js/FileSaver.min.js"></script>

<!-- CDN FOR PDF -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>


<script>
    $(document).ready(function() {
		
		
		$.ajax({  
			url:"max_sell_product_report_ajax.php",
			type:"POST",
			data:{ 'id' : 1,'category':0,'stock':0,'pagging' : 1 },
			dataType :'json',
			success:function(data)  
			{  
				for(i=0;i<data.length;i++)
				{
					let table_data="<tr><td style='text-align: center'><button id='btn_popup_info' onclick='fnc_popup(this)' data-toggle='modal' data-target='#info_model' class='btn btn-default btn-circle' value="+data[i].button+"><i class='fa fa-check'></i></button></td><td style='text-align: center'>"+( i  + 1)   +"</td><td style='text-align: center'>"+data[i].product_name+"</td><td style='text-align: center'>"+data[i].unit_name+"</td><td style='text-align: center'><b><span ";
					
					 
				
					if(data[i].opening_stock < 0 )
					{ 
						table_data += "style='color:red'";
					}
					else
					{
						table_data += "style='color:#25e90d'";
					}
					
					table_data += ">"+data[i].opening_stock+"</span></b></td><td style='text-align: center'>"+data[i].qty+"</td></tr>";
					
					const table = $("#data_table").DataTable();
						const tr = $(table_data);
						table.row.add(tr).draw();
					
				}
			}
		}); 
		
		$("#txt_date").attr("disabled",true);
        
    });
</script>