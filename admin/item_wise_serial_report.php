<?php
	
	$title = "BILL DESK- Item Wise Serial Report";
	include_once('header.php');
    global $row_login_select;
    global $con;
					
?>
<script>

	var active_page = "";
	
	function fnc_pn(e){
		
		if(e == document.getElementById('btn_next'))
		{
			active_page = document.querySelector('#pagination > .btn-group > button.btn-info').value;
		
			console.log(active_page);
			
			fnc(document.getElementsByName('btn_page[]')[active_page]);
		}
		else if(e == document.getElementById('btn_prev'))
		{
			active_page = document.querySelector('#pagination > .btn-group > button.btn-info').value;
		
			console.log(active_page);
			
			fnc(document.getElementsByName('btn_page[]')[active_page - 2]);
		}
	}
	
	function fnc(e)
	{
		//for mfg date split
		let product_id = document.getElementById("cmb_product_name").value;
		
		$.ajax({  
			url:"item_wise_serial_report_ajax.php",
			type:"POST",  
			data:{ 'id' : e.value,'product_id' : product_id, 'pagging' : 1 },
			dataType :'json',
			success:function(data)  
			{  
				var count = parseInt(e.value) - 1;
				var page_no = e.value;
				
				//alert(count);
				$('#category_result').empty();
				let prd_id = 0;
				let table_data = "";


				if(data[0].total_records != 0)	
				{
					for(i=0;i<data.length;i++)
					{
						if(data[i].product_id != prd_id)
						{
							if(prd_id != 0)
								table_data += "</table></div></div></div></div></div></br>";

							table_data += "<div class='row'><div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'><div class='panel panel block4'><div class='panel-heading' style='background: darkgray; color:white;'>"+data[i].product_name+"<div class='pull-right'><a href='#' data-perform='panel-collapse'><i class='ti-plus' style='color:black;'></i></a></div></div><div class='panel-wrapper collapse' aria-expanded='false'><div class='panel-body'><table id='myTable' class='table table-striped'><tr><th>Serial No.</th><th>Avaliability</th></tr>";
							
							prd_id = parseInt(data[i].product_id);
						}
						table_data += "<tr><td>"+data[i].serial_no+"</td>";
						if(data[i].is_sold == 0 )
							table_data += "<td style='color:#25e90d;'><b>Avaliable</b></td></tr>";

						else if(data[i].is_sold == 1)
							table_data += "<td style='color:red;'><b>Sold</b></td></tr>";
						
						else if(data[i].is_sold == 2)
							table_data += "<td style='color:#f3c52b;'><b>Returned</b></td></tr>";
					}
					$('#category_result').append(table_data);
				}
						
				$('#pagination > .btn-group').empty();
					
				$('#pagination > .btn-group').append("<button type='button' class='btn btn-default mr-1' id='btn_prev' onclick = 'fnc_pn(this)'>Previous</button>");
				
				var len = Math.ceil(data[0].total_records/10);
				for(i=1 ;i <= len; i++)
				{
					$('#pagination > .btn-group').append("<button type='button' class='btn ' value = "+ i +" id='btn_page' name='btn_page[]' onclick = 'fnc(this)'>"+ i +"</button>");
				}
				if(data[0].total_records == 0)
				{	
					$('#pagination > .btn-group').append("<button type='button' class='btn ' value = "+ 1 +" id='btn_page' name='btn_page[]' onclick = 'fnc(this)'>"+ 1 +"</button>");
				}
				
				$('#pagination > .btn-group').append("<button type='button' class='btn btn-default ml-1' id='btn_next' onclick = 'fnc_pn(this)'>Next</button>");
					
				$('#pagination > .btn-group > button').filter(function(){return $(this).text() === page_no;}).addClass('btn-info').siblings().addClass('btn-default');
				
				var total_pages = $('#pagination .btn-group').children().length;
					
				console.log(total_pages);
				
				if($('#pagination > .btn-group').find('.btn-info').val() == 1)
				{
					$('#btn_prev').hide();
				}
				else if($('#pagination .btn-group').find('.btn-info').val() == total_pages - 2)
				{
					$('#btn_next').hide();
				}
				if(len == 1)
				{
					$('#btn_next').hide();
				}
				//fnc_btn(data[0].total_records);
			}
		});	
	}
	function nc_cat()
	{
		$('#btn_page').click();
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
				<div class="panel-heading">Item Wise Serial Report</div>
			</div>	
			<div class="row">
				<div class="col-md-12">
					<div class="panel-body">
						<form name="add_new" id="add_new" method="post">
							<div class="row">
								<div class="col-md-3">
									<div class="form-group">
										<label class="control-label">Product Name</label>
										<select id="cmb_product_name" name="cmb_product_name" class="form-control select2" onchange="nc_cat()">
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
							</div>
						</form>
					</div>	
				</div>	
			</div>
			<div` id="category_result">
						
			</div>
			<div id="pagination">
				<div class="btn-group" role="group">
				
				</div>
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
			url:"item_wise_serial_report_ajax.php",
			type:"POST",
			data:{ 'id' : 1,'product_id' : 0, 'pagging' : 1 },
			dataType :'json',
			success:function(data)  
			{  
				//alert(count);
				$('#category_result').empty();
				let prd_id = 0;
				let table_data = "";

				if(data[0].total_records != 0)	
				{
					for(i=0;i<data.length;i++)
					{
						if(data[i].product_id != prd_id)
						{
							if(prd_id != 0)
								table_data += "</table></div></div></div></div></div></br>";

							table_data += "<div class='row'><div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'><div class='panel panel block4'><div class='panel-heading' style='background: darkgray; color:white;'>"+data[i].product_name+"<div class='pull-right'><a href='#' data-perform='panel-collapse'><i class='ti-plus' style='color:black;'></i></a></div></div><div class='panel-wrapper collapse' aria-expanded='false'><div class='panel-body'><table id='myTable' class='table table-striped'><tr><th>Serial No.</th><th>Avaliability</th></tr>";
							
							prd_id = parseInt(data[i].product_id);
						}
						table_data += "<tr><td>"+data[i].serial_no+"</td>";
						if(data[i].is_sold == 0 )
							table_data += "<td style='color:#25e90d;'><b>Avaliable</b></td></tr>";

						else if(data[i].is_sold == 1)
							table_data += "<td style='color:red;'><b>Sold</b></td></tr>";
						
						else if(data[i].is_sold == 2)
							table_data += "<td style='color:#f3c52b;'><b> Returned</b></td></tr>";
					}
					$('#category_result').append(table_data);
				}	
				
				let len = Math.ceil(data[0].total_records/10);
				for(let i=1 ;i <= len; i++)
				{
					if(i != 1)
						$('#pagination > .btn-group').append("<button type='button' class='btn btn-default' value = "+ i +" id='btn_page' name='btn_page[]' onclick = 'fnc(this)'>"+ i +"</button>");
					else
						$('#pagination > .btn-group').append("<button type='button' class='btn btn-info' value = "+ i +" id='btn_page' name='btn_page[]' onclick = 'fnc(this)'>"+ i +"</button>");
				}
				if(len > 1)
					$('#pagination > .btn-group').append("<button type='button' class='btn btn-secondary ml-1' id='btn_next' onclick = 'fnc_pn(this)'>Next</button>");
					
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