<?php
$title = "BILL DESK-Category";
	include_once('header.php');
	
	$company_id="SELECT * FROM tbl_company WHERE is_default=1";
	$rs_company_id=mysqli_query($con,$company_id);
	
	$row_company_id=mysqli_fetch_array($rs_company_id);
	
	if(isset($_POST['btn_save']))
	{		
		if($_POST['category_id'] == '')
		{			
			//INSERT CODE
			$sql_category_iu = "CALL insertCategory('".$_POST['txt_category_code']."' , '".$_POST['txt_category_name']."' ,'".$row_company_id['company_id']."' ) ";
		}
		else
		{	
			//UPDATE CODE
			$sql_category_iu = "CALL updateCategory('".$_POST['category_id']."' , '".$_POST['txt_category_code']."' , '".$_POST['txt_category_name']."'  ) ";
			
		}
		
		$rs_category_iu = mysqli_query($con,$sql_category_iu);
		if(!$rs_category_iu)
		{
			die('User Data Not Inserted/Updated.'.mysqli_error($con));
		}
		else
		{
			echo "<script>window.location = 'category.php';</script>";
		}	
	}
?>

 <!--.row-->
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-info">
			<div class="panel-heading"> Add New Category</div>
			<div class="panel-wrapper collapse in" aria-expanded="true">
				<div class="panel-body">
					<form action="" method="post" name="frm_categoy" enctype="multipart/form-data">
						<div class="form-body">								
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label class="control-label">Category Code</label>
										<input type="text" id="txt_category_code" name="txt_category_code" class="form-control" placeholder="Enter Category Code">										
									</div>
								</div>
								<!--/span-->
								<div class="col-md-6">
									<div class="form-group">
										<label class="control-label">Category Name</label>
										<input type="text" id="txt_category_name" name="txt_category_name" class="form-control" placeholder="Enter Category Name">										
									</div>
								<!--/span-->
								</div>
							</div>					
						</div>
						<div class="form-actions">
							<input type="hidden" name="category_id" id="category_id" /> 
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
				<div class="panel-heading"> Manage Category List</div>
			</div>																
		
			<div class="table-responsive">
				<table id="myTable" class="table table-striped">
					<thead>
						<tr>
							<th>SR NO.</th>
							<th>ACTION</th>
							<th>CATEGORY CODE</th>
							<th>CATEGORY NAME</th>
							<th>CATEGORY DATE</th>
							<th>COMPANY NAME</th>
						</tr>
					</thead>
					<tbody>
					<?php					  					  								
						$sql = "CALL viewCategory()";
						$result = mysqli_query($con,$sql);
						$counter = 0;
						
							while($row = mysqli_fetch_array($result))
							{?>
								<tr>
								
								<td><?php echo  ++$counter ?></td>
								<td class="text-nowrap">
									<a href="" class='btn_edit' id='<?php echo $row['category_id']?>' data-toggle="tooltip" data-original-title="Edit"> <i class="fa fa-pencil text-inverse m-r-10"></i> </a>
									<a href="" class='btn_delete' id='<?php echo $row['category_id']?>' data-toggle="tooltip" data-original-title="Close"> <i class="fa fa-close text-danger"></i> </a>
								</td>
								<td><?php echo $row['category_code']; ?></td>
								<td><?php echo $row['category_name']; ?></td>	
								<td><?php echo date("d-m-Y h:i:sa", strtotime($row['category_date'])) ?></td>	
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
		$('.btn_delete').click(function(e)
		{
			e.preventDefault();	
			var category_id = $(this).attr("id");
			
			if(confirm("Are you sure you want to delete this?"))
			{
				$.ajax({ url: 'category_ajax.php',
						 data: {'id': category_id, 'delete': 1},
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
			var category_id = $(this).attr("id");
			if(confirm("Are you sure you want to edit this?"))
			{
				$.ajax({ url: 'category_ajax.php',
						 data: {'id': category_id, 'edit': 1},
						 type: 'post',
						 dataType :'json',
						 success: function(data) {
						 					console.log(data.category_id);
										document.getElementById("category_id").value = category_id;
										document.getElementById("txt_category_code").value = data.category_code;
										document.getElementById("txt_category_name").value = data.category_name;								
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