<?php
	$title="BILL DESK-Gstslab";
	include_once('header.php');
	
	$company_id="SELECT * FROM tbl_company WHERE is_default=1";
	$rs_company_id=mysqli_query($con,$company_id);
	
	$row_company_id=mysqli_fetch_array($rs_company_id);
	
	if(isset($_POST['btn_save']))
	{		
		if($_POST['gstslab_id'] == '')
		{			
			//INSERT CODE
			$sql_gstslab_iu = "CALL insertGstslab('".$_POST['txt_gstslab_name']."' , '".$_POST['txt_cgst']."' , '".$_POST['txt_sgst']."' , '".$_POST['txt_igst']."' ,'".$row_company_id['company_id']."') ";
		}
		else
		{	
			//UPDATE CODE
			$sql_gstslab_iu = "CALL updateGstslab('".$_POST['gstslab_id']."' , '".$_POST['txt_gstslab_name']."' , '".$_POST['txt_cgst']."' , '".$_POST['txt_sgst']."' , '".$_POST['txt_igst']."' ) ";
			
		}
		
		$rs_gstslab_iu = mysqli_query($con,$sql_gstslab_iu);
		if(!$rs_gstslab_iu)
		{
			die('User Data Not Inserted/Updated.'.mysqli_error($con));
		}
		else
		{
			echo "<script>window.location = 'gstslab.php';</script>";
		}	
	}
?>
 <!--.row-->
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-info">
			<div class="panel-heading"> Add GST Details</div>
			<div class="panel-wrapper collapse in" aria-expanded="true">
				<div class="panel-body">
					<form action="" method="post" name="frm_gstslab" enctype="multipart/form-data">
						<div class="form-body">								
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label class="control-label">GSTSLAB name</label>
										<input type="text" id="txt_gstslab_name" name="txt_gstslab_name" class="form-control" placeholder="Enter gstslab name">										
									</div>
								</div>
								<!--/span-->
								<div class="col-md-6">
									<div class="form-group">
										<label class="control-label">CGST</label>
										<input type="text" id="txt_cgst" name="txt_cgst" class="form-control" placeholder="Enter CGST">										
									</div>
								<!--/span-->
								</div>
							</div>	
							<!--/row-->
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label class="control-label">SGST</label>
										<input type="text" id="txt_sgst" name="txt_sgst" class="form-control" placeholder="Enter SGST">										
									</div>
								</div>
								<!--/span-->
								<div class="col-md-6">
									<div class="form-group">
										<label class="control-label">IGST</label>
										<input type="text" id="txt_igst" name="txt_igst" class="form-control" placeholder="Enter IGST">										
									</div>
								<!--/span-->
								</div>
							</div>		
						</div>
						<div class="form-actions">
							<input type="hidden" name="gstslab_id" id="gstslab_id" /> 
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
				<div class="panel-heading"> Manage GSTSLAB List</div>
			</div>																
		
			<div class="table-responsive">
				<table id="myTable" class="table table-striped">
					<thead>
						<tr>
							<th>SR NO.</th>
							<th>ACTION</th>
							<th>GSTSLAB NAME</th>
							<th>CGST</th>
							<th>SGST</th>
							<th>IGST</th>
							<th>ADDED DATE</th>
							<th>COMPANY NAME</th>
						</tr>
					</thead>
					<tbody>
					<?php					  					  								
						$sql = "CALL viewGstslab()";
						$result = mysqli_query($con,$sql);
						$counter = 0;
						
							while($row = mysqli_fetch_array($result))
							{?>
								<tr>
								
								<td><?php echo  ++$counter ?></td>
								<td class="text-nowrap">
									<a href="" class='btn_edit' id='<?php echo $row['gstslab_id']?>' data-toggle="tooltip" data-original-title="Edit"> <i class="fa fa-pencil text-inverse m-r-10"></i> </a>
									<a href="" class='btn_delete' id='<?php echo $row['gstslab_id']?>' data-toggle="tooltip" data-original-title="Close"> <i class="fa fa-close text-danger"></i> </a>
								</td>
								<td><?php echo $row['gstslab_name']; ?></td>
								<td><?php echo $row['cgst']; ?></td>
								<td><?php echo $row['sgst']; ?></td>
								<td><?php echo $row['igst']; ?></td>
								<td><?php echo date("d-m-Y h:i:sa", strtotime($row['added_date']))?></td>	
								<td><?php echo $row['company_name']; ?></td>					
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
		$('#txt_cgst').keyup(function(){
			var cgst = $('#txt_cgst').val();

			document.getElementById('txt_sgst').value = cgst;

			document.getElementById('txt_igst').value = cgst * 2;
			
		})
		
		$('.btn_delete').click(function(e)
		{
			e.preventDefault();	
			var gstslab_id = $(this).attr("id");
			
			if(confirm("Are you sure you want to delete this?"))
			{
				$.ajax({ url: 'gstslab_ajax.php',
						 data: {'id': gstslab_id, 'delete': 1},
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
			var gstslab_id = $(this).attr("id");
			if(confirm("Are you sure you want to edit this?"))
			{
				$.ajax({ url: 'gstslab_ajax.php',
						 data: {'id': gstslab_id, 'edit': 1},
						 type: 'post',
						 dataType :'json',
						 success: function(data) 
						 {
											//console.log(data.txt_gstslab_name)
										document.getElementById("gstslab_id").value = gstslab_id;
										document.getElementById("txt_gstslab_name").value = data.gstslab_name;
										document.getElementById("txt_cgst").value = data.cgst;				
										document.getElementById("txt_sgst").value = data.sgst;				
										document.getElementById("txt_igst").value = data.igst;				
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