<?php
	require_once('../connection.php');
	$response = array();
	
	if(isset($_POST['graph']))
	{
		if(isset($_POST['id']))
		{
			
			$fin_year = explode('-',$_POST['id']); 
			$sql_sales = "SELECT sum(pay) 'total_sales', MONTH(sales_invoice_date) 'month' FROM tbl_sales_invoice where sales_invoice_date between '$fin_year[0]-04-01'  and '$fin_year[1]-03-31' GROUP BY month(sales_invoice_date)";
			$result_sales = mysqli_query($con,$sql_sales);
			
			
			while($row_sales = mysqli_fetch_array($result_sales))
			{
				$sales[$row_sales['month']] = $row_sales['total_sales'];
				
			}
			
			for($i=1;$i<=12;$i++)
			{
				if(!isset($sales[$i]))
				  $sales[$i] = 0;
			  
				$response[$i] = $sales[$i];
			}
    
		}
	}
	else if(isset($_POST['exp_graph']))
	{
		$month = date("m");
		$year = date("Y");
		$day = date("d");
		$target = '';
		$yearQuarter = ceil($month / 3);
		
		if(isset($_POST['id']))
		{
			$sql = "select sum(total) 'total_expence',MONTH(date) 'month',day(date) 'day' from tbl_expence 
					left join tbl_financial_master on tbl_expence.financial_id = tbl_financial_master.financial_id
					where 1=1 and  tbl_financial_master.is_default = 1";
			
			
			if($_POST['id'] == 'This Month')
			{
				$sql .= "   and MONTH(date)  = '".$month."' group by date(date) and YEAR(date) = '".$year."' ";
				$target = "day";
			}
			else if($_POST['id'] == 'This Quarter')
			{
				$sql .= "   and  MONTH(date) between ".($yearQuarter*3)-2 ." and   ".$yearQuarter*3 ." group by month(date) ";
				$target = "month";
			}
			
			$result = mysqli_query($con,$sql);
			while($row = mysqli_fetch_array($result))
			{
				$expence[$row[$target]] = $row['total_expence'];	
			}
			
			if($target == "month")
				$len = 12;
			else
				$len = 31;
			
			for($i=1;$i<=$len;$i++)
			{
				if(!isset($expence[$i]))
				  $expence[$i] = 0;
			  
				$response[$i] = $expence[$i];
			}
    
		}
	}
	else
	{
		$response = '';
	}
	echo json_encode($response);

?>