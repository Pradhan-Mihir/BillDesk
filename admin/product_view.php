<?php
	$title = "BILL DESK-Product View";
	include_once('header.php');
	
	if(isset($_POST['btn_new']))
	{
		echo "<script>window.location = 'product.php';</script>";
	}	
?>			
<div class="row">
	<div class="col-sm-12">			
		<div class="white-box">
			<div class="panel panel-info">
				<div class="panel-heading"> Product List</div>
			</div>																
			<div class="row">
				<div class="col-md-12">
					<div class="panel-body">
						<form name="add_new" id="add_new" method="post">
							<div class="form-actions">
								<p align="right">
									<button type="submit" id="btn_new" name="btn_new" class="fcbtn btn btn-info btn-outline btn-1e"> <i class="fa fa-plus"> &nbsp; Create new</i></button>
								</p>
							</div>
						</form>
					</div>	
				</div>	
			</div>	
			<div class="table-responsive">
				<table id="myTable" class="table table-striped">
					<thead>
						<tr>
							<th>SR NO.</th>
							<th>ACTION</th>
							<th>PRODUCT IMAGE</th>
							<th>COMPANY Name</th>
							<th>CATEGORY Name</th>
							<th>BARCODE</th>
							<th>PRODUCT CODE</th>
							<th>PRODUCT NAME</th>
							<th>GSTSLAB Name</th>
							<th>HSN CODE</th>
							<th>UNIT</th>
							<th>PURCHASE RATE</th>
							<th>PURCHASE TAX TYPE</th>
							<th>SALES RATE</th>
							<th>SALES TAX TYPE</th>
							<th>OPENING STOCK</th>
							<th>UNIT PER PRICE</th>
							<th>DESCRIPTION</th>
							<th>MINIMUM STOCK QTY.</th>
							<th>PRODUCT LOCATION</th>
							<th>PRODUCT DATE</th>
						</tr>
					</thead>
					<tbody>
					<?php					  					  								
						$sql = "CALL viewProduct_master()";
						$result = mysqli_query($con,$sql);
						$counter = 0;
						
							while($row = mysqli_fetch_array($result))
							{?>
								<tr>
								
								<td><?php echo  ++$counter ?></td>
								<td class="text-nowrap">
									<a href="product.php?id=<?php echo base64_encode($row['product_id']);?>" class='btn_edit' data-toggle="tooltip" data-original-title="Edit"> <i class="fa fa-pencil text-inverse m-r-10"></i> </a>
									<a href="" class='btn_delete' id='<?php echo $row['product_id']?>' data-toggle="tooltip" data-original-title="Close"> <i class="fa fa-close text-danger"></i> </a>
								</td>
								<td><img src="../images/product_images/<?php if($row['product_image'] != ''){ echo $row['product_image']; } else { echo 'default.png'; } ?>" height = "50px" width = "50px"></td>					
								<td><?php echo $row['company_name']; ?></td>
								<td><?php echo $row['category_name']; ?></td>
								<td><?php echo $row['barcode']; ?></td>
								<td><?php echo $row['product_code']; ?></td>
								<td><?php echo $row['product_name']; ?></td>												
								<td><?php echo $row['gstslab_id']; ?></td>
								<td><?php echo $row['hsn_code']; ?></td>
								<td><?php echo $row['unit_id']; ?></td>
								<td><?php echo $row['purchase_rate']; ?></td>
								<td><?php echo $row['purchase_tax_type']; ?></td>
								<td><?php echo $row['sales_rate']; ?></td>
								<td><?php echo $row['sales_tax_type']; ?></td>
								<td><?php echo $row['opening_stock']; ?></td>
								<td><?php echo $row['unit_per_price']; ?></td>
								<td><?php echo $row['description']; ?></td>
								<td><?php echo $row['min_stock_qty']; ?></td>
								<td><?php echo $row['product_location']; ?></td>
								<td><?php echo $row['product_date']; ?></td>
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
<!-- /.row -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>	
<script>
	$(document).ready(function()
	{				
		$('.btn_delete').click(function(e)
		{
			e.preventDefault();	
			var product_id = $(this).attr("id");
			
			if(confirm("Are you sure you want to delete this?"))
			{
				$.ajax({ url: 'product_ajax.php',
						 data: {'id': product_id, 'delete': 1},
						 type: 'post',
						 success: function(output) {					 			
									  //window.location.reload();
									  window.location.reload();
								  }
				});				
			}
			else
			{
				return false;
			}
			e.preventDefault();	
		});
		
	}); 
	 
</script>
<?php
	include_once('footer.php');
?>