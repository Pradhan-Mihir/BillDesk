<?php
	include_once('header.php');

	if(isset($_POST['btn_new']))
	{
		echo "<script>window.location = 'cashmemo.php';</script>";
	}	
?>
	
<div class="row">
	<div class="col-sm-12">			
		<div class="white-box">
			<div class="panel panel-info">
				<div class="panel-heading">cashmemo List</div>
			</div>	
				<div class="row">
					<div class="col-md-12">
						<div class="panel-body">
							<form name="add_new" id="add_new" method="post">
								<div class="form-actions">
									<p align="right">
										<button type="submit" id="btn_new" name="btn_new" class="fcbtn btn btn-info btn-outline btn-1e"><i class="fa fa-plus"> &nbsp; Create new</i>
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
						  <th>ACTION</th>
						  <th>SR NO.</th>
						  <th>INVOICE NO</th>
						  <th>CASHMEMO INVOICE DATE</th>
						  <th>PARTY NAME</th>
						  <th>TOTAL</th>
						  <th>PAY</th>
						</tr>
				  </thead>
				<tbody>
				  <?php                                        
					$sql = "CALL viewCashmemo()";
					$result = mysqli_query($con,$sql);
					$counter = 0;
					  while($row = mysqli_fetch_array($result))
					  {?>
						<tr>
						<td class="text-nowrap">
						  <a href="cashmemo.php?id=<?php echo base64_encode($row['cashmemo_id']);?>" class='btn_edit' data-toggle="tooltip" data-original-title="Edit"> <i class="fa fa-pencil text-inverse m-r-10"></i> </a>
						  <a href="" class='btn_delete' id='<?php echo $row['cashmemo_id'];?>' data-toggle="tooltip" data-original-title="Close"> <i class="fa fa-close text-danger"></i> </a>
						</td>
						<td><?php echo  ++$counter ?></td>
						<td><?php echo $row['new_invoice_no'].'-'.$row['invoice_no'];?></td>
						<td><?php echo date("d-m-Y", strtotime($row['cashmemo_date']))?></td>
						<td><?php echo $row['customer_name']; ?></td>
						<td><?php echo $row['total']; ?></td>
						<td><?php echo $row['pay']; ?></td>
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
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>	
<script>
	$(document).ready(function()
	{				
		$('.btn_delete').click(function(e)
		{
			e.preventDefault();	
			var cashmemo_id = $(this).attr("id");
			
			if(confirm("Are you sure you want to delete this?"))
			{
				$.ajax({ url: 'cashmemo_ajax.php',
						 data: {'id': cashmemo_id, 'inv_delete': 1},
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
		});
	}); 
	 
</script>
<?php
	include_once('footer.php');
?>