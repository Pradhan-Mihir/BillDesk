<?php
	include_once('header.php');
	
	if(isset($_POST['btn_new']))
	{
		echo "<script>window.location = 'payment_out.php';</script>";
	}	
?>
	
<div class="row">
	<div class="col-sm-12">			
		<div class="white-box">
			<div class="panel panel-info">
				<div class="panel-heading">Payment Out List</div>
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
							<th>IMAGE</th>
							<th>COMPANY NAME</th> 
							<th>PARTY NAME</th>
							<th>RECEIPT NO</th>
							<th>PAYMENT TYPE</th>
							<th>CHEQUE NO</th>
							<th>DATE</th>
							<th>DESCRIPTION</th>
							<th>PAID</th>
						</tr>
				  </thead>
				<tbody>
				  <?php                                        
					$sql = "SELECT po.* , par.party_name ,pay.payment_type,com.company_name FROM tbl_payment_out po
	LEFT JOIN tbl_company com ON com.company_id = po.company_id
    LEFT JOIN tbl_party_master par ON par.party_id = po.party_id
    LEFT JOIN tbl_payment_type pay ON pay.payment_type_id = po.payment_type_id
    LEFT JOIN tbl_financial_master fi ON fi.financial_id = po.financial_id
	WHERE com.is_default = 1 and fi.is_default=1";
					$result = mysqli_query($con,$sql);
					$counter = 0;
					  while($row = mysqli_fetch_array($result))
					  {?>
						<tr>
							<td><?php echo  ++$counter ?></td>
							<td class="text-nowrap">
							  <a href="payment_out.php?id=<?php echo base64_encode($row['payment_out_id']);?>" class='btn_edit' data-toggle="tooltip" data-original-title="Edit"> <i class="fa fa-pencil text-inverse m-r-10"></i> </a>
							  <a href="" class='btn_delete' id='<?php echo $row['payment_out_id'];?>' data-toggle="tooltip" data-original-title="Close"> <i class="fa fa-close text-danger"></i> </a>
							</td>
							<td><img src="../images/payment_out_images/<?php if($row['image'] != ''){ echo $row['image']; } else { echo 'default.png'; } ?>" height ="50px" width = "50px"></td>		
							<td><?php echo $row['company_name'];?></td>
							<td><?php echo $row['party_name']; ?></td>
							<td><?php echo $row['receipt_no']; ?></td>
							<td><?php echo $row['payment_type']; ?></td>
							<td><?php echo $row['cheque_ref_no']; ?></td>
							<td><?php echo date("d-m-Y", strtotime($row['date']))?></td>
							<td><?php echo $row['description']; ?></td>
							<td><?php echo $row['paid']; ?></td>
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
			var payment_out_id = $(this).attr("id");
			
			if(confirm("Are you sure you want to delete this?"))
			{
				$.ajax({ url: 'payment_out_ajax.php',
						 data: {'id': payment_out_id, 'delete': 1},
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