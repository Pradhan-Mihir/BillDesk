<?php
	session_start();
    $today = date("Y/m/d");
	include_once('../connection.php');
	
	if(!isset($_SESSION['uname']))
	{
		header("location:index.php");
	}
	else
	{
		$sql_login_select="select * from manage_user_tbl where username='".$_SESSION['uname']."' ";
		$rs_login_select=mysqli_query($con,$sql_login_select);
		
		if(!$rs_login_select)
		{
			die('No record found.'.mysqli_error($con));
		}
		$row_login_select=mysqli_fetch_array($rs_login_select);
	}
	
	$sum = "select sum(credit)  -  sum(debit) 'cash_in_hand' from tbl_company_ledger ";
	$rs_sum = mysqli_query($con,$sum);
	$row_sum = mysqli_fetch_array($rs_sum);
	
	$row_financial_year = mysqli_fetch_array(mysqli_query($con,"select financial_name 'active_year' from tbl_financial_master where is_default = 1"));
?>
<!DOCTYPE html>
<html lang="en">

<head>
		<link href="plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
	<!-- Daterange picker plugins css -->
    <link href="plugins/bower_components/timepicker/bootstrap-timepicker.min.css" rel="stylesheet">
    <link href="plugins/bower_components/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
	<!-- script for barcode-->
	<script type="text/javascript" src="https://cdn.jsdelivr.net/jsbarcode/3.6.0/JsBarcode.all.min.js"></script>
	
    <link href="plugins/bower_components/custom-select/custom-select.css" rel="stylesheet" type="text/css" />
    <link href="plugins/bower_components/switchery/dist/switchery.min.css" rel="stylesheet" />
    <link href="plugins/bower_components/bootstrap-select/bootstrap-select.min.css" rel="stylesheet" />
    <link href="plugins/bower_components/bootstrap-tagsinput/dist/bootstrap-tagsinput.css" rel="stylesheet" />
    <link href="plugins/bower_components/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.css" rel="stylesheet" />
    <link href="plugins/bower_components/multiselect/css/multi-select.css" rel="stylesheet" type="text/css" />
    
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="plugins/images/favicon.png">
    <title><?php if(isset($title)) echo $title; else echo "BILL DESK";  ?></title>
    <!-- Bootstrap Core CSS -->
    <link href="eliteadmin-ecommerce/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="plugins/bower_components/bootstrap-extension/css/bootstrap-extension.css" rel="stylesheet">
	 <link href="plugins/bower_components/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
   <!-- <link href="../../../cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />-->
    <!-- Menu CSS -->
    <link href="plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.css" rel="stylesheet">
	<link href="plugins/bower_components/sweetalert/sweetalert.css" rel="stylesheet" type="text/css">
	 <link rel="stylesheet" href="plugins/bower_components/dropify/dist/css/dropify.min.css">
    <!-- toast CSS -->
    <link href="plugins/bower_components/toast-master/css/jquery.toast.css" rel="stylesheet">
    <!-- morris CSS -->
    <!--<link href="plugins/bower_components/morrisjs/morris.css" rel="stylesheet">-->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
    <!-- animation CSS -->
    <link href="eliteadmin-ecommerce/css/animate.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="eliteadmin-ecommerce/css/style.css" rel="stylesheet">
    <!-- color CSS -->
    <link href="eliteadmin-ecommerce/css/colors/default.css" id="theme" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chartist/0.11.4/chartist.min.css" integrity="sha512-V0+DPzYyLzIiMiWCg3nNdY+NyIiK9bED/T1xNBj08CaIUyK3sXRpB26OUCIzujMevxY9TRJFHQIxTwgzb0jVLg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond./1.4.2/respond.min.js"></script>
<![endif]-->
    <script>
	
    (function(i, s, o, g, r, a, m) {
        i['GoogleAnalyticsObject'] = r;
        i[r] = i[r] || function() {
            (i[r].q = i[r].q || []).push(arguments)
        }, i[r].l = 1 * new Date();
        a = s.createElement(o),
            m = s.getElementsByTagName(o)[0];
        a.async = 1;
        a.src = g;
        m.parentNode.insertBefore(a, m)
    })(window, document, 'script', '../../../www.google-analytics.com/analytics.js', 'ga');

    ga('create', 'UA-19175540-9', 'auto');
    ga('send', 'pageview');

    </script>
    <style>
        .li-searched-item :hover
        {
            color: #08dbf3;
        }
    </style>
</head>

<body>
    <!-- Preloader -->
    <div class="preloader">
        <div class="cssload-speeding-wheel"></div>
    </div>
    <div id="wrapper">
        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top m-b-0">
            <div class="navbar-header" style="position:fixed;"> <a class="navbar-toggle hidden-sm hidden-md hidden-lg " href="javascript:void(0)" data-toggle="collapse" data-target=".navbar-collapse"><i class="ti-menu"></i></a>
                <div class="top-left-part"><a class="logo" href="dashboard.php"><b><!--This is dark logo icon--><img src="plugins/images/eliteadmin-logo.png" alt="home" class="dark-logo" /><!--This is light logo icon--><img src="plugins/images/eliteadmin-logo-dark.png" alt="home" class="light-logo" /></b><span class="hidden-xs"><!--This is dark logo text--><img src="plugins/images/eliteadmin-text.png" alt="home" class="dark-logo" /><!--This is light logo text--><img src="plugins/images/eliteadmin-text-dark.png" alt="home" class="light-logo" /></span></a></div>
                <ul class="nav navbar-top-links navbar-left hidden-xs" >
                    <li><a href="javascript:void(0)" id="closer" class="open-close hidden-xs waves-effect waves-light"><i class="icon-arrow-left-circle ti-menu"></i></a></li>
                    <li>
                        <form role="search" class="app-search hidden-xs" >
                            <input type="search" oninput="fnc_search_bar(this);"  onfocus="fnc_search_bar(this);" onblur=""  id="main_search" name="main_search" placeholder="Search..." class="form-control">

                        </form>

                    </li>
                </ul>
                <ul class="nav navbar-top-links navbar-right pull-right">
                    <li class="dropdown"> <a class="dropdown-toggle waves-effect waves-light" data-toggle="dropdown" href="#"><i class="icon-envelope"></i>
          <div class="notify"><span class="heartbit"></span><span class="point"></span></div>
          </a>
                        <ul class="dropdown-menu mailbox animated bounceInDown">
                            <li>
                                <div class="drop-title">Expired Products</div>
                            </li>
                            <li>
                                <div class="message-center">
                                    <?php 
                                        $sql="SELECT bt.*,pm.product_name,pm.product_image FROM `tbl_batch_tracking` bt
                                                LEFT JOIN tbl_product_master pm ON pm.product_id = bt.product_id
                                                WHERE exp_date  < '".$today."' and is_sold = 0 Group by pm.product_name ";
                                        $result = mysqli_query($con,$sql);
                                        $count = mysqli_num_rows($result);
                                        if($count > 0)
                                        {
                                            while($row = mysqli_fetch_array($result))
                                            {
                                    ?>
                                    <a href="#">
                                        <div class="user-img"> <img src="../images/product_images/<?php echo $row['product_image']; ?>" alt="user" class="img-circle" style="height: 45px;width: 45px;"> <span class="profile-status online pull-right"></span> </div>
                                        <div class="mail-contnet">
                                            <h5><?php echo $row['product_name'];?></h5>
                                            <span class="mail-desc" style="color:red";>Product Expired</span>
                                        </div>
                                    </a>
                                    <?php
                                            }                                     
                                        }
                                    ?>
                                </div>
                            </li>
                            <li>
                                <a class="text-center" href="javascript:void(0);"> <strong>See all notifications</strong> <i class="fa fa-angle-right"></i> </a>
                            </li>
                        </ul>
                        <!-- /.dropdown-messages -->
                    </li>
                    <!-- /.dropdown -->
                    <li class="dropdown"> <a class="dropdown-toggle waves-effect waves-light" data-toggle="dropdown" href="#"><i class="ti-shopping-cart"></i>
          <div class="notify"><span class="heartbit"></span><span class="point"></span></div>
          </a>
                        <ul class="dropdown-menu dropdown-cart dropdown-tasks animated slideInUp">
                            <?php 
                                $sql_purchase = "SELECT pid.*,pi.pay,pi.purchase_invoice_date,pm.product_name,pm.product_image FROM tbl_purchase_invoice_detail pid
                                LEFT JOIN tbl_product_master pm ON pm.product_id = pid.product_id
                                LEFT JOIN tbl_purchase_invoice pi ON pi.purchase_invoice_id = pid.purchase_invoice_id
                                WHERE pi.purchase_invoice_date = '".$today."' "; 
                                $result_purchase = mysqli_query($con,$sql_purchase);
                                
                                $count = mysqli_num_rows($result_purchase);
                                if($count > 0)
                                {
                                    while($row = mysqli_fetch_array($result_purchase))
                                    {
                            ?>
                            <li>
                                <div class="cart-img"><img src="../images/product_images/<?php echo $row['product_image']; ?>" /></div>
                                <div class="cart-content">
                                    <h5><?php echo $row['product_name']; ?></h5><small><?php echo $row['qty']; ?></small>
                                </div>
                            </li>
                            <li class="divider"></li>
                            <?php 
                                    }
                                }    
                                else 
                                {
                                ?>
                                    <li>
                                        <div class="cart-content">
                                            <h5><?php echo "0 Items Purchase Today"; ?></h5>
                                        </div>
                                    </li>
                                    <li class="divider"></li>
                            <?php
                                }
                            ?>
                        </ul>
                        <!-- /.dropdown-tasks -->
                    </li>
                    <!-- /.dropdown -->
                    <!-- .Megamenu -->
                   
                    <!-- /.Megamenu -->
                    <li class="right-side-toggle"> <a class="waves-effect waves-light" href="javascript:void(0)"><i class="ti-settings"></i></a></li>
                    <!-- /.dropdown -->
                </ul>
            </div>
            <!-- /.navbar-header -->
            <!-- /.navbar-top-links -->
            <!-- /.navbar-static-side -->
        </nav>
        <!-- Left navbar-header -->
        <div class="navbar-default sidebar" role="navigation" style="position:fixed;">
            <div class="sidebar-nav navbar-collapse slimscrollsidebar">
                <div class="user-profile">
                    <div class="dropdown user-pro-body">
                        <div><img src="../images/user_images/<?php if($row_login_select['user_image'] == ''){ echo 'default.png'; } else { echo $row_login_select['user_image']; } ?>" alt="user-img" class="img-circle" style="
    width: 50px;
    height: 50px;
"></div>
                        <a href="#" class="dropdown-toggle u-dropdown" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" ><?php echo $_SESSION['uname'];?><span class="caret"></span></a>
                        <ul class="dropdown-menu animated flipInY">
                            <li><a href="my_profile.php"><i class="ti-user"></i> My Profile</a></li>
                            <li><a href="#"><i class="ti-wallet"></i> My Balance</a></li>
                            <li><a href="#"><i class="ti-email"></i> Inbox</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="change_password.php"><i class="ti-settings"></i> Change Password</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="logout.php"><i class="fa fa-power-off"></i> Logout</a></li>
                        </ul>
                    </div>
                </div>
                <ul class="nav" id="side-menu">
                    <li class="sidebar-search hidden-sm hidden-md hidden-lg">
                        <!-- input-group -->
                        <div class="input-group custom-search-form">
                            <input type="text" class="form-control" placeholder="Search...">
                            <span class="input-group-btn">
            <button class="btn btn-default" type="button"> <i class="fa fa-search"></i> </button>
            </span> </div>
                        <!-- /input-group -->
                    </li>
                    <li>
                        <div class="hide-menu t-earning">
                            <div id="sparkline2dash" class="m-b-10"></div><small class="db">TOTAL EARNINGS Of <?php echo $row_financial_year['active_year'];?></small>
                            <h3 class="m-t-0 m-b-0">&#8377;<?php echo $row_sum['cash_in_hand'];?></h3></div>
                    </li>
                    <li class="nav-small-cap m-t-10">--- Main Menu</li>
                    <li> <a href="dashboard.php" class="waves-effect "><i class="linea-icon linea-basic fa-fw" data-icon="v"></i> <span class="hide-menu"> Dashboard</span></a>
                        <!--<ul class="nav nav-second-level">
                            <li> <a href="index.html">Dashboard</a> </li>
                            <li> <a href="products.html">Products</a> </li>
                            <li> <a href="product-detail.html">Product Detail</a> </li>
                            <li> <a href="product-edit.html">Product Edit</a> </li>
                            <li> <a href="product-orders.html">Product Orders</a> </li>
                            <li> <a href="product-cart.html">Product Cart</a> </li>
                            <li> <a href="product-checkout.html">Product Checkout</a> </li>
                        </ul>-->
                    </li>
					<?php
						if($row_login_select['is_admin'] == 1 )
						{
					?>		
						<li> <a href="manage_user.php" class="waves-effect"><i class="fa fa-users fa-fw " data-icon="7"></i> <span class="hide-menu">Manage Users</span></a>
						</li>
					<?php
						}
					?>	
					<li> <a href="product_view.php" class="waves-effect"><i data-icon="&#xe00b;" class="fa fa-product-hunt"></i> <span class="hide-menu">Product Master</span></a>
                    </li>
					<li> <a href="#" class="waves-effect"><i data-icon="&#xe00b;" class="fa fa-shopping-cart"></i> <span class="hide-menu">Purchase Master<span class="fa arrow"></span></span></a>
						<ul class="nav nav-second-level">
							<li> <a href="purchase_view.php" class="waves-effect"><i data-icon="&#xe00b;" class="fa fa-shopping-cart"></i> <span class="hide-menu">Purchase</span></a></li>
							<li> <a href="purchase_return_view.php" class="waves-effect"><i data-icon="&#xe00b;" class="linea-icon linea-basic fa-fw"></i> <span class="hide-menu">Purchase Return</span></a></li>
							<li> <a href="payment_out_view.php" class="waves-effect"><i data-icon="&#xe00b;" class="linea-icon linea-basic fa-fw"></i> <span class="hide-menu">Payment Out</span></a></li>
						</ul>
					</li>
					<li> <a href="#" class="waves-effect"><i data-icon="&#xe00b;" class="linea-icon linea-basic fa-fw"></i> <span class="hide-menu">Sales Master<span class="fa arrow"></span></span></a>
						<ul class="nav nav-second-level">
							<li> <a href="sales_view.php" class="waves-effect"><i data-icon="&#xe00b;" class="linea-icon linea-basic fa-fw"></i> <span class="hide-menu">Sales</span></a></li>
							<li> <a href="sales_return_view.php" class="waves-effect"><i data-icon="&#xe00b;" class="linea-icon linea-basic fa-fw"></i> <span class="hide-menu">Sales Return</span></a></li>
							<li> <a href="payment_in_view.php" class="waves-effect"><i data-icon="&#xe00b;" class="linea-icon linea-basic fa-fw"></i> <span class="hide-menu">Payment In</span></a></li>
						</ul>
					</li>
					<li> <a href="#" class="waves-effect"><i data-icon="&#xe00b;" class="linea-icon linea-basic fa-fw"></i> <span class="hide-menu">Cashmemo Master<span class="fa arrow"></span></span></a>
						<ul class="nav nav-second-level">
							<li> <a href="cashmemo_view.php" class="waves-effect"><i data-icon="&#xe00b;" class="linea-icon linea-basic fa-fw"></i> <span class="hide-menu">Cashmemo</span></a></li>
							<li> <a href="cashmemo_return_view.php" class="waves-effect"><i data-icon="&#xe00b;" class="linea-icon linea-basic fa-fw"></i> <span class="hide-menu">Cashmemo Return</span></a></li>
						</ul>
					</li>
					<li> <a href="#" class="waves-effect"><i data-icon="&#xe00b;" class="linea-icon linea-basic fa-fw"></i> <span class="hide-menu">Quotation<span class="fa arrow"></span></span></a>
						<ul class="nav nav-second-level">
							<li> <a href="quotation_view.php" class="waves-effect"><i data-icon="&#xe00b;" class="linea-icon linea-basic fa-fw"></i> <span class="hide-menu">Quotation</span></a></li>
						</ul>
					</li>
					<li> <a href="#" class="waves-effect"><i data-icon="F" class="fa fa-files-o"></i> <span class="hide-menu">Reports<span class="fa arrow"></span></span></a>
                        <ul class="nav nav-second-level">
                            <li> <a href="javascript:void(0)" class="waves-effect">Stock/Item Reports<span class="fa arrow"></span></a>
                                <ul class="nav nav-third-level">		
                                    <li> <a href="stock_summary_report.php">Stock Summary Reports</a> </li>
									<li> <a href="max_sell_product_report.php">Max Sell Product Reports</a> </li>
									<li> <a href="item_wise_batch_report.php">Item Wise Batch Report</a> </li>
									<li> <a href="item_wise_serial_report.php">Item Serial Report</a> </li>
									<li> <a href="item_report_by_party.php">Item Report By Party</a> </li>
									<li> <a href="item_wise_profit_loss_report.php">Item Wise Profit And Loss</a> </li>
                                </ul>
                            </li>
							<li> <a href="javascript:void(0)" class="waves-effect">Invoice Reports<span class="fa arrow"></span></a>
                                <ul class="nav nav-third-level">		
                                    <li> <a href="sales_report.php">Sales Report</a> </li>
									 <li> <a href="purchase_report.php">Purchase Report</a> </li>
                                </ul>
                            </li>
							<li> <a href="javascript:void(0)" class="waves-effect">Return Reports<span class="fa arrow"></span></a>
                                <ul class="nav nav-third-level">		
                                    <li> <a href="sales_return_report.php">Sales Return</a> </li>
									 <li> <a href="purchase_return_report.php">Purchase Return Report</a> </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li><a href="company.php" class="waves-effect"><i data-icon=")" class="fa fa-industry"></i> <span class="hide-menu">Company</span></a>
                    </li>
                    <li> <a href="category.php" class="waves-effect" ><i data-icon="/" class="fa fa-list-ol"></i> <span class="hide-menu">Category</span></a>
                    </li>
                    <li> <a href="gstslab.php" class="waves-effect"><i data-icon="&#xe00b;" class="fa fa-percent"></i> <span class="hide-menu">GSTSLAB</span></a>
                    </li>
					<li> <a href="#" class="waves-effect"><i data-icon="&#xe00b;" class="fa fa-bank"></i> <span class="hide-menu">Cash & Bank<span class="fa arrow"></span></span></a>
						<ul class="nav nav-second-level">
							<li><a href="payment_type.php" class="waves-effect"><i data-icon="&#xe00b;" class="fa fa-credit-card-alt"></i> <span class="hide-menu">Payment Type</span></a></li>
							<li><a href="bank_view.php" class="waves-effect"><i data-icon="&#xe00b;" class="fa fa-bank"></i> <span class="hide-menu">Bank</span></a></li>
							<li><a href="cash_in_hand.php" class="waves-effect"><i data-icon="&#xe00b;" class="fa fa-bank"></i> <span class="hide-menu">Cash In Hand</span></a></li>
						</ul>
					</li>
					<li> <a href="#" class="waves-effect"><i data-icon="&#xe00b;" class="linea-icon linea-basic fa-fw"></i> <span class="hide-menu">Types<span class="fa arrow"></span></span></a>
						<ul class="nav nav-second-level">
							<li><a href="unit.php" class="waves-effect"><i data-icon="&#xe00b;" class="linea-icon linea-basic fa-fw"></i> <span class="hide-menu">Unit</span></a></li>
							<li><a href="size.php" class="waves-effect"><i data-icon="&#xe00b;" class="linea-icon linea-basic fa-fw"></i> <span class="hide-menu">Size</span></a></li>
							<li><a href="color.php" class="waves-effect"><i data-icon="&#xe00b;" class="linea-icon linea-basic fa-fw"></i> <span class="hide-menu">Color</span></a></li>
						</ul>
					</li>
					<li> <a href="#" class="waves-effect"><i data-icon="&#xe00b;" class="linea-icon linea-basic fa-fw"></i> <span class="hide-menu">Party Master<span class="fa arrow"></span></span></a>
						<ul class="nav nav-second-level">
							<li><a href="party.php" class="waves-effect"><i data-icon="&#xe00b;" class="icon-people"></i> <span class="hide-menu">Party</span></a></li>
							<li><a href="party_group.php" class="waves-effect"><i data-icon="&#xe00b;" class="linea-icon linea-basic fa-fw"></i> <span class="hide-menu">Party Group</span></a></li>
						</ul>
					</li>
					<li> <a href="#" class="waves-effect"><i data-icon="&#xe00b;" class="linea-icon linea-basic fa-fw"></i> <span class="hide-menu">Expence Master<span class="fa arrow"></span></span></a>
						<ul class="nav nav-second-level">
							<li> <a href="expence_view.php" class="waves-effect"><i data-icon="&#xe00b;" class="linea-icon linea-basic fa-fw"></i> <span class="hide-menu">Expence</span></a></li>
							<li> <a href="expense_type.php" class="waves-effect"><i data-icon="&#xe00b;" class="linea-icon linea-basic fa-fw"></i> <span class="hide-menu">Expense Type</span></a></li>
						</ul>
					</li>
					<li> <a href="#" class="waves-effect"><i data-icon="&#xe00b;" class="linea-icon linea-basic fa-fw"></i> <span class="hide-menu">Income Master<span class="fa arrow"></span></span></a>
						<ul class="nav nav-second-level">
							<li> <a href="income_view.php" class="waves-effect"><i data-icon="&#xe00b;" class="linea-icon linea-basic fa-fw"></i><span class="hide-menu">Income</span></a></li>
							<li> <a href="income_type.php" class="waves-effect"><i data-icon="&#xe00b;" class="linea-icon linea-basic fa-fw"></i> <span class="hide-menu">Income Type</span></a></li>
						</ul>
					</li>
					<li> <a href="financial.php" class="waves-effect"><i data-icon="&#xe00b;" class="fa fa-calendar"></i> <span class="hide-menu">Financial Year</span></a>
                    </li>
					<li> <a href="barcode.php" class="waves-effect"><i data-icon="&#xe00b;" class="fa fa-barcode"></i> <span class="hide-menu">Barcode</span></a>
                    </li>
                    <li class="nav-small-cap">--- Support</li>
					<li><a href="index.php" class="waves-effect"><i class="icon-logout fa-fw"></i> <span class="hide-menu">Log out</span></a></li>
                </ul>
            </div>
        </div>
		<!--./right sidebar-->
		<div class="right-sidebar">
			<div class="slimscrollright">
				<div class="rpanel-title"> Setting Options <span><i class="ti-close right-side-toggle"></i></span> </div>
				<div class="r-panel-body">
					<ul>
						<li><a href="general_setting.php" class="waves-effect"><span class="hide-menu"><b>General Setting</b></span></a>
						</li>
						<li><a href="party_setting.php" class="waves-effect"><span class="hide-menu"><b>Party Setting</b></span></a>
						</li>
						<li><a href="invoice_setting.php" class="waves-effect"><span class="hide-menu"><b>Invoice Setting</b></span></a>
						</li>
					</ul>     
				</div>
			</div>
		</div>
		<div id="page-wrapper">
        <ul id="search_list_items" style="width:400px; position:fixed; overflow-y:auto; z-index:1000;">
            
        </ul>
		 	<div class="container-fluid">
                
				<script>
                    function fnc_search_bar(e)
                    {
                        let txt = e.value;
                        $('#search_list_items').empty();

                        if(txt == '')
                            return;
                        const page_names = [ "sales report" , "bank account","income type","my profile","product view","expence","profit and loss report","sales return"," bank view","income view","barcode","expence view","party","purchase","sales return report","expense type","cash in hand","invoice setting","party group","purchase report","sales return view"," cashmemo","financial","item report by party","party setting","purchase return","sales view","cashmemo return","item wise batch report","purchase return report","size","cashmemo return view","payment in","cashmemo view","general setting","item wise profit loss report","purchase return view","stock summary report ","category","payment in view","purchase view","item wise serial report","payment out","gstslab","color","payment out view","quotation","unit","payment type","company","manage user","quotation view","sales","dashboard","income","max sell product report","product" ];
                        let page  = [ "sales_report.php","bank_account.php","income_type.php","my_profile.php","product_view.php","expence.php","profit_and_loss_report.php","sales_return.php","bank_view.php","income_view.php","barcode.php","expence_view.php","party.php","purchase.php","sales_return_report.php","expense_type.php","cash_in_hand.php","invoice_setting.php","party_group.php","purchase_report.php","sales_return_view.php","cashmemo.php","financial.php","item_report_by_party.php","party_setting.php","purchase_return.php","sales_view.php","cashmemo_return.php","item_wise_batch_report.php","purchase_return_report.php","size.php","cashmemo_return_view.php","payment_in.php","cashmemo_view.php","general_setting.php","item_wise_profit_loss_report.php","purchase_return_view.php","stock_summary_report.php","category.php","payment_in_view.php","purchase_view.php","item_wise_serial_report.php","payment_out.php","gstslab.php","color.php","payment_out_view.php","quotation.php","unit.php","payment_type.php","company.php","manage_user.php","quotation_view.php","sales.php","dashboard.php","income.php","max_sell_product_report.php","product.php"];

                        //console.log(e.value);
                        let counter = 0;

                        for(let p = 0 ; p< page_names.length ; p ++)
                        {
                            if(page_names[p].includes(txt) )
                            {
                                /* console.log(p);
                                console.log(page[p]);
                                console.log(page_names[p]); */

                                    counter ++;
                                    if(counter > 5)
                                        return;
                                $('#search_list_items').append('<li class="form-control li-searched-item"> <a href="'+page[p]+'" class="waves-effect active"> <span id="li-item" class="hide-menu">'+page_names[p]+'</span></a></li>')

                            }
                        }

                    }
                    document.addEventListener("click", function(evnt){
                        //hide code here
						if(evnt.target.id != 'main_search' && evnt.target.id != 'li-item')
						{
							$('#search_list_items').empty();
						}
						if(evnt.target.id == 'main_search')
						{
							window.scroll({
							 top: 0, 
							 left: 0,
							 behavior: 'smooth' 
							}); 
						}
                    });
                </script>