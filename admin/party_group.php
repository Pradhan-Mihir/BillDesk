<?php
$title = "BILL DESK-Party Group";
	include_once('header.php');
	
	if(isset($_POST['btn_save']))
	{		
		if($_POST['party_group_id '] == '')
		{			
			//INSERT CODE_
			$sql_party_group_iu = "CALL insertParty_Group('".$_POST['txt_party_grp']."' ) ";
		}
		else
		{	
			//UPDATE CODE
			$sql_party_group_iu = "CALL updateParty_Group('".$_POST['party_group_id ']."' , '".$_POST['txt_party_grp']."' ) ";
			
		}
		
		$rs_party_group_iu = mysqli_query($con,$sql_party_group_iu);
		if(!$rs_party_group_iu)
		{
			die('User Data Not Inserted/Updated.'.mysqli_error($con));
		}
		else
		{
			echo "<script>window.location = 'party_group.php';</script>";
		}	
	}
?>
 <!--.row-->
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-info">
			<div class="panel-heading"> Add Party Group Details</div>
			<div class="panel-wrapper collapse in" aria-expanded="true">
				<div class="panel-body">
					<form action="" method="post" name="frm_size" enctype="multipart/form-data">
						<div class="form-body">								
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label class="control-label">Party Group</label>
										<input type="text" id="txt_party_grp" name="txt_party_grp" class="form-control" placeholder="Enter Party Group">										
									</div>
								</div>
							</div>			
						</div>
						<div class="form-actions">
							<input type="hidden" name="party_group_id" id="party_group_id" /> 
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
				<div class="panel-heading"> Party Group List</div>
			</div>																
		
			<div class="table-responsive">
				<table id="myTable" class="table table-striped">
					<thead>
						<tr>
							<th>SR NO.</th>
							<th>ACTION</th>
							<th>PARTY GROUP NAME</th>
							<th>ADDED DATE</th>
						</tr>
					</thead>
					<tbody>
					<?php					  					  								
						$sql = "CALL viewParty_group()";
						$result = mysqli_query($con,$sql);
						$counter = 0;
						
							while($row = mysqli_fetch_array($result))
							{?>
								<tr>
								
								<td><?php echo  ++$counter ?></td>
								<td class="text-nowrap">
									<a href="" class='btn_edit' id='<?php echo $row['party_group_id'];?>' data-toggle="tooltip" data-original-title="Edit"> <i class="fa fa-pencil text-inverse m-r-10"></i> </a>
									<a href="" class='btn_delete' id='<?php echo $row['party_group_id'];?>' data-toggle="tooltip" data-original-title="Close"> <i class="fa fa-close text-danger"></i> </a>
								</td>
								<td><?php echo $row['party_group_name']; ?></td>
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
			var party_group_id  = $(this).attr("id");
			
			if(confirm("Are you sure you want to delete this?"))
			{
				$.ajax({ url: 'party_group_ajax.php',
						 data: {'id': party_group_id , 'delete': 1},
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
			var party_group_id  = $(this).attr("id");
			console.log(party_group_id);
			if(confirm("Are you sure you want to edit this?"))
			{
				$.ajax({ url: 'party_group_ajax.php',
						 data: {'id': party_group_id , 'edit': 1},
						 type: 'post',
						 dataType :'json',
						 success: function(data) 
						 {
											console.log(data)
										document.getElementById("txt_party_grp").value = data.party_group_name;			
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