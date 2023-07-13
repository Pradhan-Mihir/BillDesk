<?php
	include_once('header.php');
?>
<script>
    function fnc_update_data(e)
    {
        let id = e.getAttribute('id');
        $.ajax({
            url: 'general_setting_ajax.php',
            data: {'id': id, 'update': 1 , 'data': e.value },
            type: 'post'  ,
            async: false,
            success: function(output) {

            }
        });
    }
    function fnc_chk_update(e)
    {
        let val;
        let id = e.getAttribute('id');
        if(e.checked == true)
             val = 1;
        else
            val = 0;
        //console.log('hello');
        $.ajax({
            url: 'general_setting_ajax.php',
            data: {'id': id, 'update_chk': 1 , 'data': val },
            type: 'post'  ,
            async: false,
            success: function(output) {
                const out = JSON.parse(output);
                    if(out.Fail == 0)
                    {
                        $.toast({
                            heading: 'You Have New Message',
                            text: 'Updated Successfully.',
                            position: 'top-right',
                            loaderBg:'#ff6849',
                            icon: 'success',
                            hideAfter: 3500, 
                            stack: 6
                        });
                    }   
                    else
                    {
                        $.toast({
                            heading: 'You Have New Message',
                            text: 'Update Fail.',
                            position: 'top-right',
                            loaderBg:'#ff6849',
                            icon: 'error',
                            hideAfter: 3500
                        });
                    }
            }
        });
    }

    function fnc_no_blur(e)
    {
        console.log('entered');
        let id = e.getAttribute('id');
        let p = id.split('chk_');

        if(e.checked == true)
            document.getElementById(p[1]).readOnly = false;
        else
        {
            document.getElementById(p[1]).readOnly = true;
            document.getElementById(p[1]).value = '';

            $.ajax({
                url: 'general_setting_ajax.php',
                data: {'id': p[1], 'update': 1 , 'data': '' },
                type: 'post'  ,
                async: false,
                success: function(output) {
                    const out = JSON.parse(output);
                    if(out.Fail == 0)
                    {
                        $.toast({
                            heading: p[1],
                            text: 'Updated Successfully.',
                            position: 'top-right',
                            loaderBg:'#ff6849',
                            icon: 'success',
                            hideAfter: 3500, 
                            stack: 6
                        });
                    } 
                    else
                    {
                        $.toast({
                            heading: p[1],
                            text: 'Update Fail.',
                            position: 'top-right',
                            loaderBg:'#ff6849',
                            icon: 'error',
                            hideAfter: 3500
                        });
                    }
                       
                }
            });
        }
    }
    function fnc_btn_appear(e)
    {
        console.log('inside btn');
        let id = e.getAttribute('id');
        let data = e.value;
        $.ajax({
            url: 'general_setting_ajax.php',
            data: {'id': id, 'check': 1 , 'data': data },
            type: 'post'  ,
            async: false,
            success: function(output) {
                const out = JSON.parse(output);
                if(out.Fail == 0)
                {
                    console.log(document.getElementById('btn_div'+id));
                    $('#btn_div'+id).hide();
                }
                else {
                    document.getElementById('btn_div' + id).hidden = false;
                    $('#btn_div' + id).show();
                }
            }
        });


    }
    function fnc_txt_update(e)
    {
        let bt = e.getAttribute('id');
        let id = bt.split('btn_');
        let data = document.getElementById(id[1]).value;

        $.ajax({
            url: 'general_setting_ajax.php',
            data: {'id': id[1], 'update': 1 , 'data': data },
            type: 'post'  ,
            async: false,
            success: function(output) {
                const out = JSON.parse(output);
                if(out.Fail == 0)
                {
                    $('#btn_div'+id[1]).hide();
                    $.toast({
                            heading: id[1],
                            text: 'Updated Successfully.',
                            position: 'top-right',
                            loaderBg:'#ff6849',
                            icon: 'success',
                            hideAfter: 3500, 
                            stack: 6
                        });
                }
                else
                {
                    $.toast({
                        heading: id[1],
                        text: 'Update Fail.',
                        position: 'top-right',
                        loaderBg:'#ff6849',
                        icon: 'error',
                        hideAfter: 3500
                        
                    });
                }
                    
            }
        });
        if(data == '')
        {
            $('#chk_'+id[1]).click();
        }
    }
</script>	
<!--./row--->
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-info">
			<div class="panel-heading">General Setting</div>
			<div class="panel-wrapper collapse in" aria-expanded="true">
				<div class="panel-body">
					<form action="" method="post" name="frm_product_setting" >
						<div class="form-body">		
							<div class="row">
								<div class="col-md-3">
									<div class="form-group">
										<input type="checkbox" id="is_show_serial" name="is_show_serial" onchange="fnc_chk_update(this)">
										<label for="is_show_serial" class="control-label"> Show Serial / IMEl No.</label>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<input  type="checkbox" id="is_show_barcode" name="is_show_barcode" onchange="fnc_chk_update(this)">
										<label class="control-label"> &nbsp;Show Barcode Scan </label>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<input  type="checkbox" id="is_show_low_stock" name="is_show_low_stock" onchange="fnc_chk_update(this)">
										<label class="control-label"> &nbsp;Show Low Stock Dialog </label>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<input type="checkbox" id="is_show_batch" name="is_show_batch" onchange="fnc_chk_update(this)">
										<label for="is_show_batch" class="control-label">Show Batch</label>
									</div>
								</div>
							</div>	
							<div class="row">
								<div class="col-md-3">
									<div class="form-group">
										<input type="checkbox" id="is_gst_bill" name="is_gst_bill" onchange="fnc_chk_update(this)">
										<label for="is_gst_bill" class="control-label">Gst Bill</label>
									</div>
								</div>
							</div>
							<hr style="border-color:black;" >
								<h2 style="text-align: center;">Invoice Prefix</h2>
							<div class="row">
								<div class="col-md-2">
									<div class="form-group">
										<input  type="checkbox" id="chk_purchase" name="chk_purchase" onchange="fnc_no_blur(this)">
										<label class="control-label"> &nbsp;Purchase</label>
										
									</div>
								</div>
								<div class="col-md-4" id="txt_purchase">
									<div class="form-group">
										<input  type="text" id="purchase" name="purchase" class="form-control" oninput="fnc_btn_appear(this)">
									</div>
								</div>
                                <div class="col-md-4" id="btn_divpurchase" hidden>
                                    <div class="form-group">
                                        <button type="button" id="btn_purchase" style="background: #03a9f3;" name="btn_purchase" class="btn btn-success" onclick="fnc_txt_update(this)"> <i class="fa fa-check"></i>Save</button>
                                    </div>
                                </div>
							</div>
							<div class="row">
								<div class="col-md-2">
									<div class="form-group">
										<input  type="checkbox" id="chk_sales" name="chk_sales" onchange="fnc_no_blur(this)" >
										<label class="control-label"> &nbsp;Sales</label>
									</div>
								</div>
								<div class="col-md-4" id="txt_sales">
									<div class="form-group">
										<input  type="text" id="sales" name="sales" class="form-control" oninput="fnc_btn_appear(this)">
									</div>
								</div>
                                <div class="col-md-4" id="btn_divsales" hidden>
                                    <div class="form-group">
                                        <button type="button" id="btn_sales" style="background: #03a9f3;" name="btn_sales" class="btn btn-success" onclick="fnc_txt_update(this)"> <i class="fa fa-check"></i>Save</button>
                                    </div>
                                </div>
							</div>
							<div class="row">
								<div class="col-md-2">
									<div class="form-group">
										<input  type="checkbox" id="chk_sales_return" name="chk_sales_return" onchange="fnc_no_blur(this)" >
										<label class="control-label"> &nbsp;Sales Return</label>
									</div>
								</div>
								<div class="col-md-4" id="txt_sales_return">
									<div class="form-group">
										<input  type="text" id="sales_return" name="sales_return" class="form-control" oninput="fnc_btn_appear(this)">
									</div>
								</div>
                                <div class="col-md-4" id="btn_divsales_return" hidden>
                                    <div class="form-group"><button type="button" id="btn_sales_return" style="background: #03a9f3;" name="btn_sales_return" class="btn btn-success" onclick="fnc_txt_update(this)"> <i class="fa fa-check"></i>Save</button>
                                    </div>
                                </div>
							</div>
							<div class="row">
								<div class="col-md-2">
									<div class="form-group">
										<input  type="checkbox" id="chk_purchase_return" name="chk_purchase_return"  onchange="fnc_no_blur(this)">
										<label class="control-label"> &nbsp;Purchase Return</label>
									</div>
								</div>
								<div class="col-md-4" id="txt_purchase_return">
									<div class="form-group">
										<input  type="text" id="purchase_return" name="purchase_return" class="form-control" oninput="fnc_btn_appear(this)">
									</div>
								</div>
                                <div class="col-md-4" id="btn_divpurchase_return" hidden>
                                    <div class="form-group"><button type="button" id="btn_purchase_return" style="background: #03a9f3;" name="btn_purchase_return" class="btn btn-success" onclick="fnc_txt_update(this)"> <i class="fa fa-check"></i>Save</button>
                                    </div>
                                </div>
							</div>
							<div class="row">
								<div class="col-md-2">
									<div class="form-group">
										<input  type="checkbox" id="chk_cashmemo" name="chk_cashmemo" onchange="fnc_no_blur(this)" >
										<label class="control-label"> &nbsp;Cashmemo</label>
									</div>
								</div>
								<div class="col-md-4" id="txt_cashmemo">
									<div class="form-group">
										<input  type="text" id="cashmemo" name="cashmemo" class="form-control" oninput="fnc_btn_appear(this)">
									</div>
								</div>
                                <div class="col-md-4" id="btn_divcashmemo" hidden>
                                    <div class="form-group">
                                        <button type="button" id="btn_cashmemo" style="background: #03a9f3;" name="btn_cashmemo" class="btn btn-success" onclick="fnc_txt_update(this)"> <i class="fa fa-check"></i>Save</button>
                                    </div>
                                </div>
							</div>
							<div class="row">
								<div class="col-md-2">
									<div class="form-group">
										<input  type="checkbox" id="chk_cashmemo_return" name="chk_cashmemo_return" onchange="fnc_no_blur(this)" >
										<label class="control-label"> &nbsp;Cash-memo Return</label>
									</div>
								</div>
								<div class="col-md-4" id="txt_cashmemo_return" >
									<div class="form-group">
										<input  type="text" id="cashmemo_return" name="cashmemo_return" class="form-control" oninput="fnc_btn_appear(this)">
									</div>
								</div>
                                <div class="col-md-4" id="btn_divcashmemo_return" hidden>
                                    <div class="form-group">
                                        <button type="button" id="btn_cashmemo_return" style="background: #03a9f3;" name="btn_cashmemo_return" class="btn btn-success" onclick="fnc_txt_update(this)"> <i class="fa fa-check"></i>Save</button>
                                    </div>
                                </div>
							</div>	
						</div>
					</form>	
				</div>
			</div>
		</div>
	</div>
</div>
<!--./for success alert-->
<div id="success_alerttopright" class="myadmin-alert myadmin-alert-img alert-success myadmin-alert-top-right"> <img src="../images/user_images/<?php if($row_login_select['user_image'] == ''){ echo 'default.png'; } else { echo $row_login_select['user_image']; } ?>" class="img" alt="img"><a href="#" class="closed" id="close">&times;</a>
<h4 id="success_popup_h4"><?php echo $row_login_select['username'];?></h4>
Updated Successfull.</div>

<!--./for danger alert-->
<div id="danger_alerttopright" class="myadmin-alert myadmin-alert-img alert-danger myadmin-alert-top-right"> <img src="../images/user_images/<?php if($row_login_select['user_image'] == ''){ echo 'default.png'; } else { echo $row_login_select['user_image']; } ?>" class="img" alt="img"><a href="#" class="closed" id="close">&times;</a>
    <h4 id="fail_popup_h4">Updated Failed</h4>
    </div>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>	
<script>
	$(document).ready(function()
	{
        //popup close
		$(".myadmin-alert .closed").click(function(event) {
			$(this).parents(".myadmin-alert").fadeToggle(350);

			return false;
		});
        
        $.ajax({
            url: 'general_setting_ajax.php',
            data: {'fetch': 1 },
            type: 'post'  ,
            success: function(output) {
                const out = JSON.parse(output);
                if(out.is_show_serial == 1)
                    document.getElementById('is_show_serial').checked = true;

                if(out.is_show_barcode == 1)
                    document.getElementById('is_show_barcode').checked = true;

                if(out.is_show_low_stock == 1)
                    document.getElementById('is_show_low_stock').checked = true;

                if(out.is_show_batch == 1)
                    document.getElementById('is_show_batch').checked = true;

                if(out.is_gst_bill == 1)
                    document.getElementById('is_gst_bill').checked = true;

                if(out.purchase != '')
                {
                    document.getElementById('chk_purchase').checked = true;
                    document.getElementById('purchase').value = out.purchase;
                }
                else
                {
                    document.getElementById('chk_purchase').checked = false;
                    document.getElementById('purchase').readOnly = true;
                }

                if(out.purchase_return != '' )
                {
                    document.getElementById('chk_purchase_return').checked = true;
                    document.getElementById('purchase_return').value = out.purchase_return;
                }
                else
                {
                    document.getElementById('chk_purchase_return').checked = false;
                    document.getElementById('purchase_return').readOnly = true;
                }

                if(out.sales != '')
                {
                    document.getElementById('chk_sales').checked = true;
                    document.getElementById('sales').value = out.sales;
                }
                else
                {
                    document.getElementById('chk_sales').checked = false;
                    document.getElementById('sales').readOnly = true;
                }

                if(out.sales_return != '')
                {
                    document.getElementById('chk_sales_return').checked = true;
                    document.getElementById('sales_return').value = out.sales_return;
                }
                else
                {
                    document.getElementById('chk_sales_return').checked = false;
                    document.getElementById('sales_return').readOnly = true;
                }

                if(out.cashmemo != '')
                {
                    document.getElementById('chk_cashmemo').checked = true;
                    document.getElementById('cashmemo').value = out.cashmemo;
                }
                else
                {
                    document.getElementById('chk_cashmemo').checked = false;
                    document.getElementById('cashmemo').readOnly = true;
                }

                if(out.cashmemo_return != '')
                {
                    document.getElementById('chk_cashmemo_return').checked = true;
                    document.getElementById('cashmemo_return').value = out.cashmemo_return;
                }
                else
                {
                    document.getElementById('chk_cashmemo_return').checked = false;
                    document.getElementById('cashmemo_return').readOnly = true;
                }

            }
        });
	});	
</script>	
<?php
	include_once('footer.php');
?>