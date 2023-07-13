<?php
	include_once('header.php');
	
	if(isset($_POST['btn_new']))
	{
		echo "<script>window.location = 'income.php';</script>";
	}	
?>
	
<div class="row">
	<div class="col-sm-12">			
		<div class="white-box">
			<div class="panel panel-info">
				<div class="panel-heading">Manage Income List</div>
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
						  <th>INCOME NAME</th>
						  <th>DATE</th>
						  <th>PAYMENT TYPE</th>
						  <th>TOTAL</th>
						</tr>
				  </thead>
				<tbody>
				  <?php                                        
					$sql = "SELECT inc.* , inc_type.income_type_name,pay.payment_type  FROM tbl_income inc
	LEFT JOIN tbl_company com ON com.company_id = inc.company_id
    LEFT JOIN tbl_income_type inc_type ON inc_type.income_type_id = inc.income_type_id
	LEFT JOIN tbl_payment_type pay ON pay.payment_type_id = inc.payment_type_id
    LEFT JOIN tbl_financial_master fi ON fi.financial_id = inc.financial_id
	WHERE com.is_default = 1 and fi.is_default=1;";
					$result = mysqli_query($con,$sql);
					$counter = 0;
					  while($row = mysqli_fetch_array($result))
					  {?>
						<tr>
						<td><?php echo  ++$counter ?></td>
						<td class="text-nowrap">
						  <a href="income.php?id=<?php echo base64_encode($row['income_id']);?>" class='btn_edit' data-toggle="tooltip" data-original-title="Edit"> <i class="fa fa-pencil text-inverse m-r-10"></i> </a>
						  <a href="" class='btn_delete' id='<?php echo $row['income_id'];?>' data-toggle="tooltip" data-original-title="Close"> <i class="fa fa-close text-danger"></i> </a>
						</td>
						<td><?php echo $row['income_type_name'];?></td>
						<td><?php echo date("d-m-Y", strtotime($row['date']))?></td>
						<td><?php echo $row['payment_type']; ?></td>
						<td><?php echo $row['total']; ?></td>
						
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
			var income_id = $(this).attr("id");
			
			if(confirm("Are you sure you want to delete this?"))
			{
				$.ajax({ url: 'income_ajax.php',
						 data: {'id': income_id, 'inv_delete': 1},
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