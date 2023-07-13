<?php
	include_once('header.php');
?>
<script>
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
            url: 'invoice_setting_ajax.php',
            data: {'id': id, 'update_chk': 1 , 'data': val },
            type: 'post'  ,
            async: false,
            success: function(output) {
                const out = JSON.parse(output);
                if(out.Fail == 0)
                {
                    console.log('done');
                    $.toast({
                        heading: 'You Have New Message',
                        text: 'Updated Successfully.',
                        position: 'top-right',
                        loaderBg: '#404040',
                        icon: 'success',
                        hideAfter: 3500,
                        stack: 6
                    });
                }
                else
                {
                    console.log('not done');
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
    function fnc_btn_appear(e)
    {
        console.log('inside btn');
        let id = e.getAttribute('id');
        let data = e.value;
        $.ajax({
            url: 'invoice_setting_ajax.php',
            data: {'id': id, 'check': 1 , 'data': data },
            type: 'post'  ,
            async: false,
            success: function(output) {
                const out = JSON.parse(output);
                if(out.Fail == 0)
                {
                    console.log(document.getElementById('btn_'+id));
                    $('#btn_div'+id).hide();
                }
                else {
                    document.getElementById('btn_' + id).hidden = false;
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
            url: 'invoice_setting_ajax.php',
            data: {'id': id[1], 'update': 1 , 'data': data },
            type: 'post'  ,
            async: false,
            success: function(output) {
                const out = JSON.parse(output);
                if(out.Fail == 0)
                {
                    $('#btn_'+id[1]).hide();
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
			<div class="panel-heading">Invoice Setting</div>
			<div class="panel-wrapper collapse in" aria-expanded="true">
				<div class="panel-body">
					<form action="" method="post" name="frm_product_setting" >
						<div class="form-body">		
							<div class="row">
								<div class="col-md-3">
									<div class="form-group">
										<input type="checkbox" id="is_show_serial" name="is_show_serial" onchange="fnc_chk_update(this)" >
										<label for="is_show_serial" class="control-label"> Show Serial / IMEl No.</label>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<input type="checkbox" id="is_show_batch" name="is_show_batch" onchange="fnc_chk_update(this)">
										<label for="is_show_batch" class="control-label">Show Batch</label>
									</div>
								</div>
                                <div class="col-md-3">
									<div class="form-group">
										<input type="checkbox" id="is_show_party" name="is_show_party" onchange="fnc_chk_update(this)">
										<label for="is_show_party" class="control-label">Party Details</label>
									</div>
								</div>
							</div>	
							<hr style="border-color:black;" >
							<center>
								<h2>Terms & Conditions</h2>
							</center>
							<div class="row">
								<div class="col-md-5">
									<div class="form-group">
                                        <label class="control-label">Condition 1</label>
										<textarea id="condition_1" name="condition_1" class="form-control" oninput="fnc_btn_appear(this)"></textarea>
									</div>
								</div>
                                <div class="col-md-1" id="btn_divcondition_1"  style="margin-top: auto;">
                                    <div class="form-group">
                                        <button type="button" hidden id="btn_condition_1" style="background: #03a9f3;" name="btn_condition_1" class="btn btn-success" onclick="fnc_txt_update(this)"> <i class="fa fa-check"></i>Save</button>
                                    </div>
                                </div>
                                <div class="col-md-5">
									<div class="form-group">
                                        <label class="control-label">Condition 2</label>
                                        <textarea id="condition_2" name="condition_2" class="form-control" oninput="fnc_btn_appear(this)"></textarea>
									</div>
								</div>
                                <div class="col-md-1" id="btn_divcondition_2"  style="margin-top: auto;">
                                    <div class="form-group">
                                        <button type="button" hidden id="btn_condition_2" style="background: #03a9f3;" name="btn_condition_2" class="btn btn-success" onclick="fnc_txt_update(this)"> <i class="fa fa-check"></i>Save</button>
                                    </div>
                                </div>
							</div>
							<div class="row">
								<div class="col-md-5">
									<div class="form-group">
                                        <label class="control-label">Condition 3</label>
                                        <textarea id="condition_3" name="condition_3" class="form-control" oninput="fnc_btn_appear(this)"></textarea>
									</div>
								</div>
                                <div class="col-md-1" id="btn_divcondition_3"  style="margin-top: auto;">
                                    <div class="form-group">
                                        <button type="button" hidden id="btn_condition_3" style="background: #03a9f3;" name="btn_condition_3" class="btn btn-success" onclick="fnc_txt_update(this)"> <i class="fa fa-check"></i>Save</button>
                                    </div>
                                </div>
                                <div class="col-md-5">
									<div class="form-group">
                                        <label class="control-label">Condition 4</label>
                                        <textarea id="condition_4" name="condition_4" class="form-control" oninput="fnc_btn_appear(this)"></textarea>
									</div>
								</div>
                                <div class="col-md-1" id="btn_divcondition_4"  style="margin-top: auto;">
                                    <div class="form-group">
                                        <button type="button" hidden id="btn_condition_4" style="background: #03a9f3;" name="btn_condition_4" class="btn btn-success" onclick="fnc_txt_update(this)"> <i class="fa fa-check"></i>Save</button>
                                    </div>
                                </div>
							</div>
							<div class="row">
                                <div class="col-md-5">
									<div class="form-group">
                                        <label class="control-label">Condition 5</label>
                                        <textarea id="condition_5" name="condition_5" class="form-control" oninput="fnc_btn_appear(this)"></textarea>
									</div>
								</div>
                                <div class="col-md-1" id="btn_divcondition_5"  style="margin-top: auto;">
                                    <div class="form-group">
                                        <button type="button" hidden id="btn_condition_5" style="background: #03a9f3;" name="btn_condition_5" class="btn btn-success" onclick="fnc_txt_update(this)"> <i class="fa fa-check"></i>Save</button>
                                    </div>
                                </div>
								<div class="col-md-5">
									<div class="form-group">
                                        <label class="control-label">Condition 6</label>
                                        <textarea id="condition_6" name="condition_6" class="form-control" oninput="fnc_btn_appear(this)"></textarea>
									</div>
								</div>
                                <div class="col-md-1" id="btn_divcondition_6"  style="margin-top: auto;">
                                    <div class="form-group">
                                        <button type="button" hidden id="btn_condition_6" style="background: #03a9f3;" name="btn_condition_6" class="btn btn-success" onclick="fnc_txt_update(this)"> <i class="fa fa-check"></i>Save</button>
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

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>	
<script>
	$(document).ready(function()
	{
        //fetch ajax
        $.ajax({
            url: 'invoice_setting_ajax.php',
            data: {'fetch': 1 },
            type: 'post'  ,
            success: function(output) {
                const out = JSON.parse(output);
                if(out.is_show_serial == 1)
                    document.getElementById('is_show_serial').checked = true;

                if(out.is_show_batch == 1)
                    document.getElementById('is_show_batch').checked = true;

                if(out.is_show_party == 1)
                    document.getElementById('is_show_party').checked = true;

                document.getElementById('condition_1').value = out.condition_1;
                document.getElementById('condition_2').value = out.condition_2;
                document.getElementById('condition_3').value = out.condition_3;
                document.getElementById('condition_4').value = out.condition_4;
                document.getElementById('condition_5').value = out.condition_5;
                document.getElementById('condition_6').value = out.condition_6;

            }
        });
	});	
</script>	
<?php
	include_once('footer.php');
?>