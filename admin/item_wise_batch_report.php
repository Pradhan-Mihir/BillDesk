<?php
	$title = "BILL DESK- Item Wise Batch Report";
	include_once('header.php');
    global $row_login_select;
    global $con;

	$sql_company="SELECT * FROM tbl_company WHERE is_default=1";
	$rs_company_id=mysqli_query($con,$sql_company);
	$row_firm_address =mysqli_fetch_array($rs_company_id);
					
?>
<script>
	function nc_cat(e)
	{
		//for mfg date split
		let mfg_start_date = document.getElementById("txt_mfg_start_date").value;
		let mfg_end_date = document.getElementById("txt_mfg_end_date").value;
		let exp_end_date = document.getElementById("txt_exp_start_date").value;
		let exp_start_date = document.getElementById("txt_exp_end_date").value;
		let start_date = mfg_start_date +' / '+ mfg_end_date;
		let end_date = exp_start_date +' / '+ exp_end_date;
		
		let size = document.getElementById("cmb_size").value;
		let batch_no = document.getElementById("cmb_batch_no").value;
		let model_no = document.getElementById("cmb_model_no").value;
		let chk = document.getElementById("chk_stock");
		let product_id = document.getElementById("cmb_product_name").value;

		if(e.getAttribute('id') == 'btn_export')
			export_table = 1;

		console.log(product_id);
		if(chk.checked)
		{
			stock =1;
		}
		else
		{
			stock = 0;
		}
		
		$.ajax({  
			url:"item_wise_batch_report_ajax.php",
			type:"POST",  
			data:{ 'mfg_start_date': mfg_start_date ,'mfg_end_date' : mfg_end_date , 'exp_start_date' : exp_start_date , 'exp_end_date' : exp_end_date , 'size': size , 'batch_no' : batch_no , 'model_no' : model_no , 'stock' : stock , 'product_id' : product_id, 'pagging' : 1 , 'export_table' : export_table },
			dataType :'json',
			success:function(data)  
			{  
				if(e.getAttribute('id') != 'btn_export')
				{
					$('#category_result').empty();
					if(data[0].total_records != 0)	
					{	
						const table = $("#data_table").DataTable();  
						table.clear().draw();
						
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
							
							var merge_row_1 = { s: {r:0, c:0}, e: {r:0, c:8} };
							var merge_row_2 = {s: {r:1, c:0}, e: {r:1, c:8} };
							var merge_row_3 = {s: {r:2, c:0}, e: {r:2, c:8} };
							var merge_row_4 = {s: {r:3, c:0}, e: {r:3, c:8} };
							var merge_row_5 = {s: {r:4, c:0}, e: {r:4, c:8} };
							
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
							
							var title_start_date = [['Mfg. Date : '+start_date]];
							var title_report = [['Max Sell Product Report']];
							var title_end_date = [['Exp. Date : '+end_date]];
							
							XLSX.utils.sheet_add_aoa(ws, title_start_date, {origin : 'A6'});
							XLSX.utils.sheet_add_aoa(ws, title_report, {origin : 'D6'});
							XLSX.utils.sheet_add_aoa(ws, title_end_date, {origin : 'G6'});
							
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
							
							ws['D6'].s = {
								font: {
									sz: 14,
									bold: true
								},
								alignment: {
									vertical: "center",
									horizontal: "center"
								}
							};
							
							ws['G6'].s = {
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
							
							let Heading = [['SR No.','Item Name','MRP','Batch No.' , 'Model No.' , 'Mfg. Date' , 'Exp. Date' , 'Size' ,'Qty']];
							
							XLSX.utils.sheet_add_aoa(ws, Heading , {origin : 'A8'});
							

							for (i=65;i<74;i++)
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
								{wch:20},
								{wch:20},
								{wch:20},
							];

							ws['!cols'] = wscols;
							
						/*-----------------------------------------------------------------------------------------------*/
							
							// Add Data at A9 with style 
						
							XLSX.utils.sheet_add_json(ws, data, { origin: 'A9', skipHeader: true });
							
							for(i = 65;i<65+9;i++)
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
							
							XLSX.utils.book_append_sheet(wb, ws, 'Item Wise Batch Report');
						
						/*-----------------------------------------------------------------------------------------------*/
							
							// Save Excel 
							
							var wbout = XLSX.write(wb, {bookType:'xlsx',  type: 'binary'});
							
							function s2ab(s) {
					  
								var buf = new ArrayBuffer(s.length);
								var view = new Uint8Array(buf);
								for (var i=0; i<s.length; i++) view[i] = s.charCodeAt(i) & 0xFF;
								return buf;
							}
		
							saveAs(new Blob([s2ab(wbout)],{type:"application/octet- stream"}),'Item_Wise_Batch_Report'+'_'+curr_date+'_'+curr_month+'_'+curr_year+'.xlsx');
					}
					else // IF EXPORT IN PDF
					{	
						[['SR No.','Item Name','MRP','Batch No.' , 'Model No.' , 'Mfg. Date' , 'Exp. Date' , 'Size' ,'Qty']];
						var table_headers = {
							header_0:{
								col_1:{ text: 'SR No.',style: 'table_headers'},
								col_2:{ text: 'Item Name',style: 'table_headers'},
								col_3:{ text: 'MRP', style: 'table_headers'},
								col_4:{ text: 'Batch No.', style: 'table_headers'},
								col_5:{ text: 'Model No.', style: 'table_headers'},
								col_6:{ text: 'Mfg. Date', style: 'table_headers'},
								col_7:{ text: 'Exp. Date', style: 'table_headers'},
								col_8:{ text: 'Size', style: 'table_headers'},
								col_9:{ text: 'Qty',style: 'table_headers'},
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
								row.push( header.col_4 );
								row.push( header.col_5 );
								row.push( header.col_6 );
								row.push( header.col_7 );
								row.push( header.col_8 );
								row.push( header.col_9 );
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
								row.push( data.mrp_price.toString()  );
								row.push( data.batch_no.toString() );
								row.push( data.model_no.toString()  );
								row.push( data.mfg_date.toString()  );
								row.push( data.exp_date.toString()  );
								row.push( data.size.toString()  );
								row.push( data.quantity.toString()  );
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
									{text: 'Item Wise Batch Report', style: 'style_report'},
									{text: 'End Date : '+end_date, style: 'style_date2'},
									{
										style: 'table_style',
										table: {
											widths:['auto','auto','auto','auto','auto','auto','auto','auto','auto'],
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
						pdfMake.createPdf(docDefinition).download('Item_Wise_Batch_Report'+'_'+curr_date+'_'+curr_month+'_'+curr_year+'.pdf');
						
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
				<div class="panel-heading">Item Wise Batch Report</div>
			</div>	
			<div class="row">
				<div class="col-md-12">
					<div class="panel-body">
						<form name="add_new" id="add_new" method="post">
							<div class="row">
								<div class="col-md-3">
									<div class="form-group">
										<label class="control-label">Product Name</label>
										<select id="cmb_product_name" name="cmb_product_name" class="form-control select2" onchange="nc_cat(this)">
											<option value="0">All Product</option>
											<?php 
												$query_product="SELECT pro.* FROM tbl_product_master pro LEFT JOIN tbl_company com ON com.company_id = pro.company_id WHERE com.is_default = 1;";
												$rs_cmb_product=mysqli_query($con,$query_product);
												while($row_cmb_product=mysqli_fetch_array($rs_cmb_product))
												{ 
											?>
												<option value="<?php echo $row_cmb_product['product_id']; ?>"><?php echo $row_cmb_product['product_name'];?></option>
											<?php
												} 
											?>
										</select>
									</div>
								</div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label">Batch No</label>
                                        <select id="cmb_batch_no" name="cmb_batch_no" class="form-control select2" onchange="nc_cat(this)">
											<option value="0">Select Batch No</option>
											<?php 
												$query_batch_no="SELECT bat.batch_no FROM tbl_batch_tracking bat LEFT JOIN tbl_company com ON com.company_id = bat.company_id WHERE com.is_default = 1;";
												$rs_cmb_batch_no=mysqli_query($con,$query_batch_no);
												while($row_cmb_batch_no=mysqli_fetch_array($rs_cmb_batch_no))
												{ 
											?>
												<option value="<?php echo $row_cmb_batch_no['batch_no']; ?>"><?php echo $row_cmb_batch_no['batch_no'];?></option>
											<?php
												} 
											?>
										</select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label">Model No</label>
                                        <select id="cmb_model_no" name="cmb_model_no" class="form-control select2" onchange="nc_cat(this)">
											<option value="0">Select Model No</option>
											<?php 
												$query_model_no="SELECT bat.model_no FROM tbl_batch_tracking bat LEFT JOIN tbl_company com ON com.company_id = bat.company_id WHERE com.is_default = 1;";
												$rs_cmb_model_no=mysqli_query($con,$query_model_no);
												while($row_cmb_model_no=mysqli_fetch_array($rs_cmb_model_no))
												{ 
											?>
												<option value="<?php echo $row_cmb_model_no['model_no']; ?>"><?php echo $row_cmb_model_no['model_no'];?></option>
											<?php
												} 
											?>
										</select>
                                    </div>
                                </div>
								<div class="col-md-3">
									<div class="form-group">
										<label class="control-label">Size</label>
                                        <select id="cmb_size" name="cmb_size" class="form-control select2" onchange="nc_cat(this)">
											<option value="0">Select Size</option>
											<?php 
												$query_size="SELECT bat.size FROM tbl_batch_tracking bat LEFT JOIN tbl_company com ON com.company_id = bat.company_id WHERE com.is_default = 1 group by bat.size";
												$rs_cmb_size=mysqli_query($con,$query_size);
												while($row_cmb_size=mysqli_fetch_array($rs_cmb_size))
												{ 
											?>
												<option value="<?php echo $row_cmb_size['size']; ?>"><?php echo $row_cmb_size['size'];?></option>
											<?php
												} 
											?>
										</select>
									</div>
								</div>	
							</div>
							<div class="row">
								<div class="col-lg-2">
									<div class="form-group">
										<label class="control-label">Mfg Start Date</label>
										<input class="form-control" type="date" name="txt_mfg_start_date" id="txt_mfg_start_date" onchange="nc_cat(this)"/>
									</div>
								</div>
								<div class="col-lg-2">
									<div class="form-group">
										<label class="control-label">Mfg End Date</label>
										<input class="form-control" type="date" name="txt_mfg_end_date" id="txt_mfg_end_date" onchange="nc_cat(this)"/>
									</div>
								</div>
								<div class="col-lg-3">
									<div class="form-group">
										<input type="checkbox" id="chk_stock" name="chk_stock" style = "transform: scale(1.5)" onchange = "nc_cat(this)">&nbsp;
										<label class="control-label" for="chk_stock" style="margin-top: 37px;">Show Only items in stock</label>
									</div>
								</div>
								<div class="col-lg-2">
									<div class="form-group">
										<label class="control-label">Exp Start Date</label>
										<input class="form-control" type="date" name="txt_exp_start_date" id="txt_exp_start_date" onchange="nc_cat(this)"/>
									</div>
								</div>
								<div class="col-lg-2">
									<div class="form-group">
										<label class="control-label">Exp End Date</label>
										<input class="form-control" type="date" name="txt_exp_end_date" id="txt_exp_end_date" onchange="nc_cat(this)"/>
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
			<div class='table-responsive printableArea'>
				<table class='table table-striped' id="data_table">
					<thead>
						<tr>
							<th style='text-align: center'>SR NO.</th>
							<th style='text-align: center'>Product Name</th>
							<th style='text-align: center'>MRP</th>
							<th style='text-align: center'>Batch No</th>
							<th style='text-align: center'>Model No</th>
							<th style='text-align: center'>Mfg Date</th>
							<th style='text-align: center'>Exp Date</th>
							<th style='text-align: center'>Size</th>
							<th style='text-align: center'>Quantity</th>
						</tr>
					</thead>
					<tbody id="category_result">
						
					</tbody>
				</table>
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
			url:"item_wise_batch_report_ajax.php",
			type:"POST",
			data:{ 'id' : 1,'mfg_start_date': '' ,'mfg_end_date' : '' , 'exp_start_date' : '' , 'exp_end_date': '' , 'size':0 , 'batch_no' : 0 , 'model_no' : 0 , 'stock' : 0 , 'product_id' : 0, 'pagging' : 1 },
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
					
						const table = $("#data_table").DataTable();
						const tr = $(table_data);
						table.row.add(tr).draw();
						
					}
				}
					
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