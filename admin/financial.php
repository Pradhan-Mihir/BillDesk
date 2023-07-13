<?php
$title = "BILL DESK-Financial Year";
	include_once('header.php');
	
	if(isset($_POST['btn_save']))
	{		
		if($_POST['financial_id'] == '')
		{			
			//INSERT CODE_
			$sql_financial_iu = "CALL insertFinancial_master('".$_POST['txt_financial_year']."' , '".$_POST['txt_financial_name']."'  , '".$_POST['txt_start_date']."' ,'".$_POST['txt_end_date']."' ,'".$_POST['chk_is_default']."' ,'".$row_login_select['user_id']."') ";
		}
		else
		{	
			//UPDATE CODE
			$sql_financial_iu = "CALL updateFinancial_master('".$_POST['financial_id']."' ,'".$_POST['txt_financial_year']."' , '".$_POST['txt_financial_name']."'  , '".$_POST['txt_start_date']."' ,'".$_POST['txt_end_date']."' ,'".$_POST['chk_is_default']."') ";
		}
		
		$rs_financial_iu = mysqli_query($con,$sql_financial_iu);
		if(!$rs_financial_iu)
		{
			die('User Data Not Inserted/Updated.'.mysqli_error($con));
		}
		else
		{
			echo "<script>window.location = 'financial.php';</script>";
		}	
	}
?>
<script>
  
  function fnc_date()
  {
	let data1 = $('#txt_financial_year').val();
	let data2 = data1++;
	let data3 = "".concat(data2 , "-");
	let data4 = "".concat(data3 , data1);
	$("#txt_financial_name").val(data4);
	$("#txt_start_date").val(data2+"-04-01");
	$("#txt_end_date").val(data1+"-03-31");
  }
</script>


 <!--.row-->
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-info">
			<div class="panel-heading"> Add Your Financial Year  Details</div>
			<div class="panel-wrapper collapse in" aria-expanded="true">
				<div class="panel-body">
					<form action="" method="post" name="frm_expence" enctype="multipart/form-data">
						<div class="form-body">								
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label class="control-label">Financial Year</label>
										<input type="number" id="txt_financial_year" name="txt_financial_year" class="form-control" placeholder="Enter Financial Year" >										
									</div>
								</div>
								<!-- /span---->
								<div class="col-md-6">
									<div class="form-group">
										<label class="control-label">Financial Name</label>
										<input type="text" id="txt_financial_name" name="txt_financial_name" class="form-control" placeholder="Enter Financial Name" >										
									</div>
								</div>
							</div>
							<!-- /row-->
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label class="control-label">Start Date</label>
										<input type="text" id="txt_start_date" name="txt_start_date" class="form-control" placeholder="Enter Start Date" >										
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label class="control-label">End Date</label>
										<input type="text" id="txt_end_date" name="txt_end_date" class="form-control" placeholder="Enter End Date" >										
									</div>
								</div>
							</div>
							<!-- /row-->
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<input type="checkbox" id="chk_is_default" name="chk_is_default" placeholder="Enter Start Date" value="1" >	
										<label class="control-label">Is Default</label>
									</div>
								</div>
							</div>
						</div>
						<div class="form-actions">
							<input type="hidden" name="financial_id" id="financial_id" /> 
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
				<div class="panel-heading"> Manage Financial Year List</div>
			</div>																
		
			<div class="table-responsive">
				<table id="myTable" class="table table-striped">
					<thead>
						<tr>
							<th>SR NO.</th>
							<th>ACTION</th>
							<th>STATUS</th>
							<th>FINANCIAL YEAR</th>
							<th>FINACIAL NAME </th>
							<th>START DATE</th>
							<th>END DATE</th>
						</tr>
					</thead>
					<tbody>
					<?php					  					  								
						$sql = "CALL viewFinancial_master()";
						$result = mysqli_query($con,$sql);
						$counter = 0;
						
							while($row = mysqli_fetch_array($result))
							{?>
								<tr>
								
								<td><?php echo  ++$counter ?></td>
								<td class="text-nowrap">
									<a href="" class='btn_edit' id='<?php echo $row['financial_id']?>' data-toggle="tooltip" data-original-title="Edit"> <i class="fa fa-pencil text-inverse m-r-10"></i> </a>
									<a href="" class='btn_delete' id='<?php echo $row['financial_id']?>' data-toggle="tooltip" data-original-title="Close"> <i class="fa fa-close text-danger"></i> </a>
								</td>
								<td><span class="label label-success"><?php if($row['is_default']==1){echo "Active";} ?></span>
									<span class="label label-danger"><?php if($row['is_default']!=1){echo "Not Active";} ?></span>
								</td>
								<td><?php echo $row['financial_year']; ?></td>
								<td><?php echo $row['financial_name']; ?></td>
								<td><?php echo $row['start_date']; ?></td>
								<td><?php echo $row['end_date']; ?></td>					
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
		const d = new Date();
		let year = d.getFullYear();
		$('#txt_financial_year').val(year);
		fnc_date();


		$('.btn_delete').click(function(e)
		{
			e.preventDefault();	
			var financial_id  = $(this).attr("id");
			
			if(confirm("Are you sure you want to delete this?"))
			{
				$.ajax({ url: 'financial_ajax.php',
						 data: {'id': financial_id , 'delete': 1},
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
			var financial_id  = $(this).attr("id");
			if(confirm("Are you sure you want to edit this?"))
			{
				$.ajax({ url: 'financial_ajax.php',
						 data: {'id': financial_id , 'edit': 1},
						 type: 'post',
						 dataType :'json',
						 success: function(data) 
						 {
											console.log("data.financial_id")
										document.getElementById("financial_id").value = financial_id ;
										document.getElementById("txt_financial_year").value = data.financial_year;
										document.getElementById("txt_financial_name").value = data.financial_name;
										document.getElementById("txt_start_date").value = data.start_date;
										document.getElementById("txt_end_date").value = data.end_date;
										document.getElementById("chk_is_default").checked = data.is_default;
										if(data.is_default==1)
										{
											document.getElementById("chk_is_default").checked = data.is_default;
										}
										else
										{
											document.getElementById("chk_is_default").checked = false;
										}
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
	 
	$('#txt_financial_year').on("change keyup input",function(e)
	{
		fnc_date();
	});
</script>


<?php
	include_once('footer.php');
?>
