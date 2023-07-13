<?php
$title = "BILL DESK-Income Type";
	include_once('header.php');
	
	if(isset($_POST['btn_save']))
	{		
		if($_POST['income_type_id'] == '')
		{			
			//INSERT CODE_
			$sql_expense_type_iu = "insert into tbl_income_type(income_type_name) values('".$_POST['txt_income_type']."' ) ";
		}
		else
		{	
			//UPDATE CODE
			$sql_expense_type_iu = "update tbl_income_type set  income_type_name = '".$_POST['txt_income_type']."' where income_type_id = '".$_POST['income_type_id']."' ";
			
		}
		
		$rs_expense_type_iu = mysqli_query($con,$sql_expense_type_iu);
		if(!$rs_expense_type_iu)
		{
			die('User Data Not Inserted/Updated.'.mysqli_error($con));
		}
		else
		{
			echo "<script>window.location = 'income_type.php';</script>";
		}	
	}
?>

 <!--.row-->
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-info">
			<div class="panel-heading"> Add Your Income Details</div>
			<div class="panel-wrapper collapse in" aria-expanded="true">
				<div class="panel-body">
					<form action="" method="post" name="frm_expense_type" enctype="multipart/form-data">
						<div class="form-body">								
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label class="control-label">Income Type</label>
										<input type="text" id="txt_income_type" name="txt_income_type" class="form-control" placeholder="Enter Income Type">										
									</div>
								</div>
							</div>			
						</div>
						<div class="form-actions">
							<input type="hidden" name="income_type_id" id="income_type_id" /> 
							<button type="submit" id="btn_save" name="btn_save" class="btn btn-success"> <i class="fa fa-check"></i> Save</button>
							<button type="reset" name="btn_reset" id="btn_reset" class="btn btn-default">Cancel</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<!--./row-->

<!-- /row -->
<div class="row">
	
	<div class="col-sm-12">			
		<div class="white-box">
			<div class="panel panel-info">
				<div class="panel-heading"> Manage Income Type List</div>
			</div>																
		
			<div class="table-responsive">
				<table id="myTable" class="table table-striped">
					<thead>
						<tr>
							<th>SR NO.</th>
							<th>ACTION</th>
							<th>INCOME TYPE</th>
							<th>ADDED DATE</th>
						</tr>
					</thead>
					<tbody>
					<?php					  					  								
						$sql = "select * from tbl_income_type";
						$result = mysqli_query($con,$sql);
						$counter = 0;
						
							while($row = mysqli_fetch_array($result))
							{?>
								<tr>
								
								<td><?php echo  ++$counter ?></td>
								<td class="text-nowrap">
									<a href="" class='btn_edit' id='<?php echo $row['income_type_id']?>' data-toggle="tooltip" data-original-title="Edit"> <i class="fa fa-pencil text-inverse m-r-10"></i> </a>
									<a href="" class='btn_delete' id='<?php echo $row['income_type_id']?>' data-toggle="tooltip" data-original-title="Close"> <i class="fa fa-close text-danger"></i> </a>
								</td>
								<td><?php echo $row['income_type_name']; ?></td>
								<td><?php echo date("d-m-Y h:i:sa", strtotime($row['added_date']))?></td>																													
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
			var income_type_id = $(this).attr("id");
			
			if(confirm("Are you sure you want to delete this?"))
			{
				$.ajax({ url: 'income_type_ajax.php',
						 data: {'id': income_type_id, 'delete': 1},
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
		
		$('.btn_edit').click(function(e)
		{
			e.preventDefault();	
			var income_type_id = $(this).attr("id");
			if(confirm("Are you sure you want to edit this?"))
			{
				$.ajax({ url: 'income_type_ajax.php',
						 data: {'id': income_type_id, 'edit': 1},
						 type: 'post',
						 dataType :'json',
						 success: function(data) 
						 {				
										document.getElementById("income_type_id").value = income_type_id;			
										document.getElementById("txt_income_type").value = data.income_type_name;			
								  },
						error: function(data) {
						 					console.log('my ERROR' + data.d);								
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