<?php
$title = "BILL DESK-Unit";
	include_once('header.php');
	
	if(isset($_POST['btn_save']))
	{		
		if($_POST['unit_id'] == '')
		{			
			//INSERT CODE_
			$sql_unit_iu = "CALL insertUnit('".$_POST['txt_unit_name']."' ) ";
		}
		else
		{	
			//UPDATE CODE
			$sql_unit_iu = "CALL updateUnit('".$_POST['unit_id']."' , '".$_POST['txt_unit_name']."' ) ";
			
		}
		
		$rs_unit_iu = mysqli_query($con,$sql_unit_iu);
		if(!$rs_unit_iu)
		{
			die('User Data Not Inserted/Updated.'.mysqli_error($con));
		}
		else
		{
			echo "<script>window.location = 'unit.php';</script>";
		}	
	}
?>

 <!--.row-->
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-info">
			<div class="panel-heading"> Add Your Unit Details</div>
			<div class="panel-wrapper collapse in" aria-expanded="true">
				<div class="panel-body">
					<form action="" method="post" name="frm_unit" enctype="multipart/form-data">
						<div class="form-body">								
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label class="control-label">Unit Name</label>
										<input type="text" id="txt_unit_name" name="txt_unit_name" class="form-control" placeholder="Enter Unit Name">										
									</div>
								</div>
							</div>			
						</div>
						<div class="form-actions">
							<input type="hidden" name="unit_id" id="unit_id" /> 
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
				<div class="panel-heading"> Manage Unit List</div>
			</div>																
		
			<div class="table-responsive">
				<table id="myTable" class="table table-striped">
					<thead>
						<tr>
							<th>SR NO.</th>
							<th>ACTION</th>
							<th>UNIT NAME</th>
							<th>ADDED DATE</th>
						</tr>
					</thead>
					<tbody>
					<?php					  					  								
						$sql = "CALL viewUnit()";
						$result = mysqli_query($con,$sql);
						$counter = 0;
						
							while($row = mysqli_fetch_array($result))
							{?>
								<tr>
								
								<td><?php echo  ++$counter ?></td>
								<td class="text-nowrap">
									<a href="" class='btn_edit' id='<?php echo $row['unit_id']?>' data-toggle="tooltip" data-original-title="Edit"> <i class="fa fa-pencil text-inverse m-r-10"></i> </a>
									<a href="" class='btn_delete' id='<?php echo $row['unit_id']?>' data-toggle="tooltip" data-original-title="Close"> <i class="fa fa-close text-danger"></i> </a>
								</td>
								<td><?php echo $row['unit_name']; ?></td>
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
			var unit_id = $(this).attr("id");
			
			if(confirm("Are you sure you want to delete this?"))
			{
				$.ajax({ url: 'unit_ajax.php',
						 data: {'id': unit_id, 'delete': 1},
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
			var unit_id = $(this).attr("id");
			if(confirm("Are you sure you want to edit this?"))
			{
				$.ajax({ url: 'unit_ajax.php',
						 data: {'id': unit_id, 'edit': 1},
						 type: 'post',
						 dataType :'json',
						 success: function(data) 
						 {
											//console.log(data.txt_gstslab_name)
										document.getElementById("unit_id").value = unit_id;
										document.getElementById("txt_unit_name").value = data.unit_name;			
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