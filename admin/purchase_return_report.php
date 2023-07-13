<?php
$title = "BILL DESK- Purchase Return Report";
	include_once('header.php');
	
	$sql_company="SELECT * FROM tbl_company WHERE is_default=1";
	$rs_company_id=mysqli_query($con,$sql_company);
	$row_firm_address = mysqli_fetch_array($rs_company_id);
?>
<script>
	function nc_cat(e)
	{
		//console.log(e.value);
		let party = document.getElementById("cmb_party").value;
		let start_date = document.getElementById("start_date").value;
		let end_date = document.getElementById("end_date").value;
		let status = document.getElementById("cmb_payment").value;
		let export_table = "";
		
		if(e.getAttribute('id') == 'btn_export')
		{
			export_table = 1;
		}
		$.ajax({  
			url:"purchase_return_report_ajax.php",
			type:"POST",  
			data:{ 'party': party ,'start_date' : start_date , 'end_date': end_date, 'status' : status ,'export_table': export_table, 'pagging' : 1},
			dataType :'json',
			success:function(data)  
			{  
				//alert(count);
				if(e.id != 'btn_export')
				{
					$('#purchase_details').empty();
					if(data[0].total_records != 0)	
					{	
						const table = $("#data_table").DataTable();  
						table.clear().draw();

						for(i=0;i<data.length;i++)
						{
							let table_data = "<tr><td style='text-align: center'>"+( i  + 1)   +"</td><td style='text-align: center'>"+data[i].purchase_return_invoice_date+"</td><td style='text-align: center'>"+data[i].party_name+"</td><td style='text-align: center'>"+data[i].total+"</td><td style='text-align: center'>"+data[i].pay+"</td><td style='text-align: center'>"+data[i].left+"</td><td style='text-align: center'><b><span style='color:"+data[i].color+"' >"+data[i].status+"</span></b></td></tr>";
							
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
						
							// add Data at A1,A2,A3,A4,A5,A6 with merge cell 
							
							let title = [
											['|| Shree Ganeshay Namah ||'],
											['BILLDESK'],
											[firm_address+','+firm_city+'-'+firm_pincode],
											['GSTIN NO : '+firm_gstin],
											[]
										];
							
							var merge_row_1 = {s: {r:0, c:0}, e: {r:0, c:6} };
							var merge_row_2 = {s: {r:1, c:0}, e: {r:1, c:6} };
							var merge_row_3 = {s: {r:2, c:0}, e: {r:2, c:6} };
							var merge_row_4 = {s: {r:3, c:0}, e: {r:3, c:6} };
							var merge_row_5 = {s: {r:4, c:0}, e: {r:4, c:6} };
							
							var merge_row_6_col1 = {s: {r:5, c:0}, e: {r:5, c:1} }; // A6 : B6
							var merge_row_6_col2 = {s: {r:5, c:2}, e: {r:5, c:4} }; // C6 : E6
							var merge_row_6_col3 = {s: {r:5, c:5}, e: {r:5, c:6} }; // F6 : G6
							
							var merge_row_7 = {s: {r:6, c:0}, e: {r:6, c:6} };
							
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
							var title_report = [['Purchase Return Report']];
							var title_end_date = [['End Date : '+end_date]];
							
							XLSX.utils.sheet_add_aoa(ws, title_start_date, {origin : 'A6'});
							XLSX.utils.sheet_add_aoa(ws, title_report, {origin : 'C6'});
							XLSX.utils.sheet_add_aoa(ws, title_end_date, {origin : 'F6'});
							
						/*-----------------------------------------------------------------------------------------------*/
						
							// A1,A2,A3,A4 with Style
							
							for (i=1;i<5;i++)
							{
								var cell_no = String.fromCharCode('65') + i;//asci no 65 = A
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
							
							// A6,C6,F6 With Style
							
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
							
							ws['C6'].s = {
								font: {
									sz: 14,
									bold: true
								},
								alignment: {
									vertical: "center",
									horizontal: "center"
								}
							};
							
							ws['F6'].s = {
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
							
							let Heading = [['SR No.','Purchase Return Date','Party Name','Total Amount','Pay','Due Amount','Status']];
							
							XLSX.utils.sheet_add_aoa(ws, Heading , {origin : 'A8'});
							
							for (i=65;i<71;i++)//ketli row krvani che 
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
								{wch:20},
								{wch:20}	
							];

							ws['!cols'] = wscols;
							
						/*-----------------------------------------------------------------------------------------------*/
							
							// Add Data at A9 with style 
						
							XLSX.utils.sheet_add_json(ws, data, { origin: 'A9', skipHeader: true });
							
							for(i = 65;i<65+7;i++)
							{
								for (j=9;j<9+data.length;j++)//row 9 thi start
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
							
							XLSX.utils.book_append_sheet(wb, ws, 'Purchase Return Report');
						
						/*-----------------------------------------------------------------------------------------------*/
							
							// Save Excel 
							
							var wbout = XLSX.write(wb, {bookType:'xlsx',  type: 'binary'});
							
							function s2ab(s) {
					  
								var buf = new ArrayBuffer(s.length);
								var view = new Uint8Array(buf);
								for (var i=0; i<s.length; i++) view[i] = s.charCodeAt(i) & 0xFF;
								return buf;
							}

							saveAs(new Blob([s2ab(wbout)],{type:"application/octet- stream"}),'Purchase_return_Report'+'_'+curr_date+'_'+curr_month+'_'+curr_year+'.xlsx');
					}
					/*-----------------------------------------------------------------------------------------------------
																															
									
																EXPORT IN PDF												
																																
																															
					--------------------------------------------------------------------------------------------------------*/
					else
					{	
						
						var table_headers = {
							header_0:{
								col_1:{ text: 'SR No.',style: 'table_headers'},
								col_2:{ text: 'Purchase Return Date',style: 'table_headers'},
								col_3:{ text: 'Party Name', style: 'table_headers'},
								col_4:{ text: 'Total Amount', style: 'table_headers'},
								col_5:{ text: 'Pay', style: 'table_headers'},
								col_6:{ text: 'Due Amount',style: 'table_headers'},
								col_7:{ text: 'Status',style: 'table_headers'}
							}
						}
						
						var table_data =  data;//data = ajax nu data
						
						var body = [];
						
						for (var key in table_headers)
						{
							if (table_headers.hasOwnProperty(key)){
								var header = table_headers[key];
								var row = new Array();
								row.push( header.col_1 );
								row.push( header.col_2 );
								row.push( header.col_3 );
								row.push( header.col_4 );
								row.push( header.col_5 );
								row.push( header.col_6 );
								row.push( header.col_7 );
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
								row.push( data.purchase_return_invoice_date.toString()  );
								row.push( data.party_name.toString() );
								row.push( data.total.toString()  );
								row.push( data.pay.toString()  );
								row.push( data.left.toString()  );
								row.push( data.status.toString()  );
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
									{text: 'Purchase Return Report', style: 'style_report'},
									{text: 'End Date : '+end_date, style: 'style_date2'},
									{
										style: 'table_style',
										table: {
											widths:['auto','auto','auto','auto','auto','auto','auto'],
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
						pdfMake.createPdf(docDefinition).download('Purchase_Return_Report'+'_'+curr_date+'_'+curr_month+'_'+curr_year+'.pdf');
						
					}
				}
			}
		});	
	}
</script>	
<script src="eliteadmin-ecommerce/js/xlsx.bundle.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.15.6/xlsx.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/exceljs/1.10.0/exceljs.min.js" integrity="sha256-NwTJQSOPRRgFqw5ol83SU70DgTvXvQ/dFdPcRJoCAFQ=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/amcharts/3.21.15/plugins/export/libs/FileSaver.js/FileSaver.min.js"></script>

<!-- CDN FOR PDF -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<div class="row">
	<div class="col-sm-12">			
		<div class="white-box">
			<div class="panel panel-info">
				<div class="panel-heading">Purchase Return Report</div>
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
								<div class="col-md-3">
									<div class="form-group">
										<label class="control-label">Party</label>
										<select id="cmb_party" name="cmb_party" class="form-control select2" onchange="nc_cat(this)">
											<option value="0">All Party</option>
											<?php 
												$sql_party="select * from tbl_party_master where party_type = 0";
												$rs_party=mysqli_query($con,$sql_party);
												while($row_party=mysqli_fetch_array($rs_party))
												{ 
											?>
												<option value="<?php echo $row_party['party_id']; ?>"><?php echo $row_party['party_name'];?></option>
											<?php
												} 
											?>
										</select>
									</div>
								</div>	
								<div class="col-md-3">
									<div class="form-group">
										<label class="control-label">Payment Status</label>
										<select id="cmb_payment" name="cmb_payment" class="form-control select2" onchange="nc_cat(this)">
											<option value="0">All Records</option>
											<option value="Paid">Paid</option>
											<option value="Unpaid">Unpaid</option>
											<option value="Partial">Partial</option>
										</select>
									</div>
								</div>	
								<div class="col-md-3">
									<div class="form-group">
										<label class="control-label">Date</label>
										<input type="date" id="start_date" name="start_date" class="form-control" onchange = "nc_cat(this)">
									</div>
								</div>	
								<div class="col-md-3">
									<div class="form-group">
										<label class="control-label">Date</label>
										<input type="date" id="end_date" name="end_date" class="form-control" onchange = "nc_cat(this)">
									</div>
								</div>	
							</div>
							<div class="col-md-3" style="margin-block-start: auto;">
								<div class="form-group">
									<label id="export_label" class="control-label">Export In:</label>
									<input type="button" id="btn_export" value="Excel" onclick="nc_cat(this);" />
									<input type="button" id="btn_export" value="PDF" onclick="nc_cat(this); "/>
								</div>
							</div>
						</form>
					</div>	
				</div>	
			</div>
			<div class='table-responsive'>
				<table class='table table-striped' id="data_table">
					<thead>
						<tr>
							<th style='text-align: center'>SR NO.</th>
							<th style='text-align: center'>PURCHASE DATE</th>
							<th style='text-align: center'>PARTY NAME</th>
							<th style='text-align: center'>TOTAL AMOUNT</th>
							<th style='text-align: center'>PAY</th>
							<th style='text-align: center'>DUE AMMOUNT</th>
							<th style='text-align: center'>STATUS</th>
						</tr>
					</thead>
					<tbody>
						
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
		//fnc(document.getElementById('btn_page')[0]);

		$.ajax({  
			url:"purchase_return_report_ajax.php",
			type:"POST",
			data:{'party': 0 ,'start_date' : '' , 'end_date': '', 'status' : 0 , 'pagging' : 1},
			dataType :'json',
			success:function(data)  
			{  
				
				if(data[0].total_records != 0)	
				{	
					for(i=0;i<data.length;i++)
					{
						let table_data = "<tr><td style='text-align: center'>"+ (i + 1)+"</td><td style='text-align: center'>"+data[i].purchase_return_invoice_date+"</td><td style='text-align: center'>"+data[i].party_name+"</td><td style='text-align: center'>"+data[i].total+"</td><td style='text-align: center'>"+data[i].pay+"</td><td style='text-align: center'>"+data[i].left+"</td><td style='text-align: center'><b><span style='color:"+data[i].color+"' >"+data[i].status+"</span></b></td></tr>";
						
						const table = $("#data_table").DataTable();
						const tr = $(table_data);
						table.row.add(tr).draw();
						
					}
				}
			}
		}); 
		
		$("#txt_date").attr("disabled",true);
        $(".print").click(function() {
            var mode = 'iframe'; //popup
            var close = mode == "popup";
            var options = {
                mode: mode,
                popClose: close
            };
            $("div.printableArea").printArea(options);
        });
    });
</script>