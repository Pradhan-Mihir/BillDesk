<?php
	include_once("header.php");
	
	$date = date("Y/m/d");
	$month = date("m");
	$row_financial_id = mysqli_fetch_array(mysqli_query($con,"SELECT financial_id 'financial_id' from tbl_financial_master where is_default = 1"));
	
	$you_receive = "select sum(received) as you_receive from tbl_payment_in where financial_id = '".$row_financial_id['financial_id']."'";
	$rs_you_receive = mysqli_query($con,$you_receive);
	$row_you_receive = mysqli_fetch_array($rs_you_receive);
	
	$you_pay = "select sum(paid) as you_paid from tbl_payment_out where financial_id = '".$row_financial_id['financial_id']."' ";
	$rs_you_pay = mysqli_query($con,$you_pay);
	$row_you_pay = mysqli_fetch_array($rs_you_pay);
	
	$total_purchase = "select sum(pay) as purchase_pay from tbl_purchase_invoice where financial_id = '".$row_financial_id['financial_id']."' ";
	$rs_purchase = mysqli_query($con,$total_purchase);
	$row_purchase = mysqli_fetch_array($rs_purchase);
	
?>

 <script>
	function fnc(e)
	{
		$("#line_chart").empty();
		$.ajax({  
			url:"dashboard_graph_fetch.php",
			type:"POST",
			data:{ 'id' : e.value,'graph' : 1 },
			dataType :'json',
			success:function(data)  
			{  	
				var sal = [];
				for(i=1;i<=12;i++)
				{
					sal[i] = data[i];
				}
			
			
				const monthNames = ["","Apr", "May", "Jun","Jul", "Aug", "Sep", "Oct", "Nov", "Dec","Jan", "Feb", "Mar"
				];
				Morris.Area({
					element: 'line_chart',
					data: [
						{y: 1, sales: sal[4]},
						{y: 2, sales:sal[5]},
						{y: 3, sales:sal[6]},
						{y: 4, sales:sal[7]},
						{y: 5, sales:sal[8]},
						{y: 6, sales:sal[9]},
						{y: 7, sales:sal[10]},
						{y: 8, sales:sal[11]},
						{y: 9, sales:sal[12]},
						{y: 10, sales:sal[1]},
						{y: 11, sales:sal[2]},
						{y: 12, sales:sal[3]}
					],
					xkey: 'y',
					parseTime: false,
					ykeys: ['sales'],
					xLabelFormat: function (x) {
						var index = parseInt(x.src.y);
						return monthNames[index];
					},
					xLabels: "month",
					labels: ['sales'],
					lineColors: ['#7dc9db'],
					hideHover: 'auto',
					

				});
			}
		}); 
	}
	function fnc_exp_graph(e)
	{
		$("#line_exp_chart").empty();
		$.ajax({  
			url:"dashboard_graph_fetch.php",
			type:"POST",
			data:{ 'id' : e.value,'exp_graph' : 1 },
			dataType :'json',
			success:function(data)  
			{  	
				var exp = [];
				for(i=1;i<=31;i++)
				{
					exp[i] = data[i];
				}
				
				let days = [];
				if(e.value == 'This Month')
				{
					days = ["","1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24","25","26","27","28","29","30","31"
					];
				}
				else
				{
					days = ["","jan","feb","mar","apr","may","jun","jul","aug","sep","oct","nov","dec"];
				}
					
					if(e == "This Month")
					{
						Morris.Line({
						element: 'line_exp_chart',
							data: [
								{y: 1, expence: exp[1]},
								{y: 2, expence:exp[2]},
								{y: 3, expence:exp[3]},
								{y: 4, expence:exp[4]},
								{y: 5, expence:exp[5]},
								{y: 6, expence:exp[6]},
								{y: 7, expence:exp[7]},
								{y: 8, expence:exp[8]},
								{y: 9, expence:exp[9]},
								{y: 10, expence:exp[10]},
								{y: 11, expence:exp[11]},
								{y: 12, expence:exp[12]},
								{y: 13, expence: exp[13]},
								{y: 14, expence:exp[14]},
								{y: 15, expence:exp[15]},
								{y: 16, expence:exp[16]},
								{y: 17, expence:exp[17]},
								{y: 18, expence:exp[18]},
								{y: 19, expence:exp[19]},
								{y: 20, expence:exp[20]},
								{y: 21, expence:exp[21]},
								{y: 22, expence:exp[22]},
								{y: 23, expence:exp[23]},
								{y: 24, expence:exp[24]},
								{y: 25, expence:exp[25]},
								{y: 26, expence:exp[26]},
								{y: 27, expence:exp[27]},
								{y: 28, expence:exp[28]},
								{y: 29, expence:exp[29]},
								{y: 30, expence:exp[30]},
								{y: 31, expence:exp[31]}
							],
							xkey: 'y',
							parseTime: false,
							ykeys: ['expence'],
							xLabelFormat: function (x) {
								var index = parseInt(x.src.y);
								return days[index];
							},
							xLabels: "days",
							labels: ['expence'],
							lineColors: ['#7dc9db'],
							hideHover: 'auto',
					

						});
					}	
					else
					{
						Morris.Line({
						element: 'line_exp_chart',
							data: [
								{y: 1, expence: exp[1]},
								{y: 2, expence:exp[2]},
								{y: 3, expence:exp[3]},
								{y: 4, expence:exp[4]},
								{y: 5, expence:exp[5]},
								{y: 6, expence:exp[6]},
								{y: 7, expence:exp[7]},
								{y: 8, expence:exp[8]},
								{y: 9, expence:exp[9]},
								{y: 10, expence:exp[10]},
								{y: 11, expence:exp[11]},
								{y: 12, expence:exp[12]}
							],
							xkey: 'y',
							parseTime: false,
							ykeys: ['expence'],
							xLabelFormat: function (x) {
								var index = parseInt(x.src.y);
								return days[index];
							},
							xLabels: "days",
							labels: ['expence'],
							lineColors: ['#7dc9db'],
							hideHover: 'auto',
					

						});
					}
			}
		}); 
	}
</script>      

<!-- /.row -->
<div class="row">
	<div class="col-lg-4 col-md-4 col-sm-8 col-xs-12">
		<div class="white-box">
			<h2><i class="fa fa-arrow-down text-success"></i>&nbsp;We'll Receive</h2>
			<div class="text-left"> 
				<h2>&#8377;&nbsp;<?php if($row_you_receive['you_receive'] != ''){ echo $row_you_receive['you_receive'];} else { echo 0.00; } ?></h2>
			</div>
		</div>
	</div>
	<div class="col-lg-4 col-md-4 col-sm-8 col-xs-12">
		<div class="white-box">
			<h2><i class="fa fa-arrow-up" style="color: red;"></i>&nbsp;We'll Pay</h2>
			<div class="text-left"> 
				<h2>&#8377;&nbsp;<?php if($row_you_pay['you_paid'] != ''){ echo $row_you_pay['you_paid'];} else { echo 0.00; }?></h2>
			</div>
		</div>
	</div>
	<div class="col-lg-4 col-md-4 col-sm-8 col-xs-12">
		<div class="white-box">
			<h2><i class="fa fa-shopping-cart text-info"></i>&nbsp;Purchase</h2>
			<div class="text-left"> 
				<h2>&#8377;&nbsp;<?php if($row_purchase['purchase_pay'] != ''){ echo $row_purchase['purchase_pay'];} else { echo 0.00; } ?></h2>
			</div>
		</div>
	</div>
</div>
<!--row -->
<!--row -->
<div class="row">
	<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
		<div class="white-box">
			<h3 class="box-title" style="text-align:center;">&nbsp;Sales</h3>
			<div class="row">
				<select id="cmb_year" name="cmb_year" onchange="fnc(this)">
					<?php 
						$dates = range('2020', date('Y'));
						foreach($dates as $date)
						{

							if (date('m', strtotime($date)) <= 3)
							{  
							  //Upto June
							  $year = ($date-1) . '-' . $date;
							}
							else 
							{
							  //After June
							  $year = $date . '-' . ($date + 1);
							}
							
							//echo "<script>alert($date)</script>";

							if($date == date('Y'))
							{
							  echo "<option selected value='$year'>$year</option>";
							}
							else
							{
							  echo "<option value='$year'>$year</option>";
							}
							
						}
					?>
				</select>
			</div>
			<ul class="list-inline text-right">
				<li>
					<h4><i class="fa fa-circle m-r-5" style="color: #7dc9db;"></i>Sales</h4>
				</li>
			</ul>
			<div id="line_chart" style="width:100%;"></div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
		<div class="white-box">
			<h3 style="text-align:center;"><i class="icon-wallet" style="color:#93069d;"></i>&nbsp;Expense</h3>
			<div class="row">
				<select id="cmb_expense_graph" name="cmb_expense_graph" onchange="fnc_exp_graph(this)">
					<option value="This Month">This Month</option>
					<option value="This Quarter">This Quarter</option>
				</select>
			</div>
			<ul class="list-inline text-right">
				<li>
					<h5><i class="fa fa-circle m-r-5" style="color: #7dc9db;"></i>Expense</h5>
				</li>
			</ul>
			<div id="line_exp_chart" style="height: 315px;"></div>
		</div>
	</div>
</div>
<!-- row -->
<div class="row">
	<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
		<div class="white-box">
			<h3 class="box-title">Product Overview</h3>
			<div class="table-responsive">
				<table id = "myTable"class="table product-overview">
					<thead>
						<tr>
							<th>Product Image</th>
							<th>Category</th>
							<th>Product Name</th>
							<th>Purchase Rate</th>
							<th>Sales Rate</th>
							<th>Quantity</th>
						</tr>
					</thead>
					<tbody>
					<?php
						$low_stock = "select cat.category_name,pro.product_name,pro.opening_stock, pro.product_image,pro.purchase_rate,pro.sales_rate 
						from tbl_product_master pro 
						LEFT JOIN tbl_category cat on pro.category_id = cat.category_id 
						where opening_stock < min_stock_qty ";
						
						$result_low_stock = mysqli_query($con,$low_stock);
						
						while($row = mysqli_fetch_array($result_low_stock))
						{	
					?>
						<tr>
							<td><img src="../images/product_images/<?php echo $row['product_image']; ?>"  width="80px" height="80px"></td>
							<td><?php echo $row['category_name']; ?></td>
							<td><?php echo $row['product_name']; ?></td>
							<td><?php echo $row['purchase_rate']; ?></td>
							<td><?php echo $row['sales_rate']; ?></td>
							<td><span class="label label-danger"><?php if($row['opening_stock'] < 0 ){echo "Out Of Stock";} else{ echo $row['opening_stock']; }?> </span></td>
						</tr>
					<?php 
						}
					?>	
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<!-- /.right-sidebar -->

<?php
	include_once("footer.php");
?>	
<script>
	$(document).ready(function(){
		var a = $("#cmb_year").val();
		
		$.ajax({  
			url:"dashboard_graph_fetch.php",
			type:"POST",
			data:{ 'id' : a,'graph' : 1 },
			dataType :'json',
			success:function(data)  
			{  	
				var sal = [];
				for(i=1;i<=12;i++)
				{
					sal[i] = data[i];
				}
			
			
				const monthNames = ["","Apr", "May", "Jun","Jul", "Aug", "Sep", "Oct", "Nov", "Dec","Jan", "Feb", "Mar"
				];
				Morris.Area({
					element: 'line_chart',
					data: [
						{y: 1, sales: sal[4]},
						{y: 2, sales:sal[5]},
						{y: 3, sales:sal[6]},
						{y: 4, sales:sal[7]},
						{y: 5, sales:sal[8]},
						{y: 6, sales:sal[9]},
						{y: 7, sales:sal[10]},
						{y: 8, sales:sal[11]},
						{y: 9, sales:sal[12]},
						{y: 10, sales:sal[1]},
						{y: 11, sales:sal[2]},
						{y: 12, sales:sal[3]}
					],
					xkey: 'y',
					parseTime: false,
					ykeys: ['sales'],
					xLabelFormat: function (x) {
						var index = parseInt(x.src.y);
						return monthNames[index];
					},
					xLabels: "month",
					labels: ['sales'],
					lineColors: ['#7dc9db'],
					hideHover: 'auto',
					

				});
			}
		}); 
		
		var e = $("#cmb_expense_graph").val();
		
		$.ajax({  
			url:"dashboard_graph_fetch.php",
			type:"POST",
			data:{ 'id' : e,'exp_graph' : 1 },
			dataType :'json',
			success:function(data)  
			{  	
				var exp = [];
				for(i=1;i<=31;i++)
				{
					exp[i] = data[i];
				}
				
				let days = [];
				if(e == 'This Month')
				{
					days = ["","1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24","25","26","27","28","29","30","31"
					];
				}
				else
				{
					days = ["","jan","feb","mar","apr","may","jun","jul","aug","sep","oct","nov","dec"];
				}
				
					if(e == "This Month")
					{
						Morris.Line({
						element: 'line_exp_chart',
							data: [
								{y: 1, expence: exp[1]},
								{y: 2, expence:exp[2]},
								{y: 3, expence:exp[3]},
								{y: 4, expence:exp[4]},
								{y: 5, expence:exp[5]},
								{y: 6, expence:exp[6]},
								{y: 7, expence:exp[7]},
								{y: 8, expence:exp[8]},
								{y: 9, expence:exp[9]},
								{y: 10, expence:exp[10]},
								{y: 11, expence:exp[11]},
								{y: 12, expence:exp[12]},
								{y: 13, expence: exp[13]},
								{y: 14, expence:exp[14]},
								{y: 15, expence:exp[15]},
								{y: 16, expence:exp[16]},
								{y: 17, expence:exp[17]},
								{y: 18, expence:exp[18]},
								{y: 19, expence:exp[19]},
								{y: 20, expence:exp[20]},
								{y: 21, expence:exp[21]},
								{y: 22, expence:exp[22]},
								{y: 23, expence:exp[23]},
								{y: 24, expence:exp[24]},
								{y: 25, expence:exp[25]},
								{y: 26, expence:exp[26]},
								{y: 27, expence:exp[27]},
								{y: 28, expence:exp[28]},
								{y: 29, expence:exp[29]},
								{y: 30, expence:exp[30]},
								{y: 31, expence:exp[31]}
							],
							xkey: 'y',
							parseTime: false,
							ykeys: ['expence'],
							xLabelFormat: function (x) {
								var index = parseInt(x.src.y);
								return days[index];
							},
							xLabels: "days",
							labels: ['expence'],
							lineColors: ['#7dc9db'],
							hideHover: 'auto',
						});
					}	
			}
		}); 
		
		
	});
</script>	
	