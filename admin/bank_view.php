<?php
	include_once('header.php');
	
	if(isset($_POST['btn_new']))
	{
		echo "<script>window.location = 'bank_account.php';</script>";
	}	
?>
	
<div class="row">
	<div class="col-sm-12">			
		<div class="white-box">
			<div class="panel panel-info">
				<div class="panel-heading">List of Bank Accounts</div>
			</div>	
				<div class="row">
					<div class="col-md-12">
						<div class="panel-body">
							<form name="add_new" id="add_new" method="post">
								<div class="form-actions">
									<p align="right">
										<label>Click Here To Add New Details...</label>
										<button type="submit" id="btn_new" name="btn_new" class="fcbtn btn btn-info btn-outline btn-1e"> <i class="fa fa-plus"> &nbsp; Add New</i></button>
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
						  <th>DISPLAY NAME</th>
						  <th>OPENING BALANCE</th>
						  <th>DATE</th>
						</tr>
				  </thead>
				<tbody>
				  <?php                                        
					$sql = "SELECT * FROM tbl_bank_account;";
					$result = mysqli_query($con,$sql);
					$counter = 0;
					  while($row = mysqli_fetch_array($result))
					  {?>
						<tr>
						<td><?php echo  ++$counter ?></td>
						<td class="text-nowrap">
						  <a href="bank_account.php?id=<?php echo base64_encode($row['bank_account_id']);?>" class='btn_edit' data-toggle="tooltip" data-original-title="Edit"> <i class="fa fa-pencil text-inverse m-r-10"></i> </a>
						  <a href="" class='btn_delete' id='<?php echo $row['bank_account_id'];?>' data-toggle="tooltip" data-original-title="Close"> <i class="fa fa-close text-danger"></i> </a>
						</td>
						<td><?php echo $row['account_name'];?></td>
						<td><?php echo $row['opening_balance'];?></td>
						<td><?php echo $row['as_of_date']; ?></td>
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
			var bank_account_id = $(this).attr("id");
			
			if(confirm("Are you sure you want to delete this?"))
			{
				$.ajax({ url: 'bank_ajax.php',
						 data: {'id': bank_account_id, 'inv_delete': 1},
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