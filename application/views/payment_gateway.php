<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Payment</title>

	<style type="text/css">

	::selection { background-color: #E13300; color: white; }
	::-moz-selection { background-color: #E13300; color: white; }

	body {
		background-color: #fff;
		margin: 40px;
		font: 13px/20px normal Helvetica, Arial, sans-serif;
		color: #4F5155;
	}

	a {
		color: #003399;
		background-color: transparent;
		font-weight: normal;
	}

	h1 {
		color: #444;
		background-color: transparent;
		border-bottom: 1px solid #D0D0D0;
		font-size: 19px;
		font-weight: normal;
		margin: 0 0 14px 0;
		padding: 14px 15px 10px 15px;
	}

	code {
		font-family: Consolas, Monaco, Courier New, Courier, monospace;
		font-size: 12px;
		background-color: #f9f9f9;
		border: 1px solid #D0D0D0;
		color: #002166;
		display: block;
		margin: 14px 0 14px 0;
		padding: 12px 10px 12px 10px;
	}

	#body {
		margin: 0 15px 15px 15px;
	}

	p.footer {
		text-align: right;
		font-size: 11px;
		border-top: 1px solid #D0D0D0;
		line-height: 32px;
		padding: 0 10px 0 10px;
		margin: 20px 0 0 0;
	}

	#container {
		margin: 10px;
		border: 1px solid #D0D0D0;
		box-shadow: 0 0 8px #D0D0D0;
		    width: 100%;
	}
	.box-width{    max-width: 600px;
    margin: 0 auto;
    display: flex;
    align-items: center;
    justify-content: center;
    height: 100vh;}
	#body input[type="button"]{ margin:10px 0; }
	p {
    margin: 5px 0 5px  !important;
    width: 100%;
    overflow: hidden;
    text-align: right;
}
	</style>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" >
</head>
<body>

<div class="box-width">
<div id="container">
	<h1>Payment Gateway !!</h1>

	<div id="body">
		<?= form_open("users/payment", ['id' => 'frmUsers']); ?>
			<div class="row">
				<div class="col-lg-6">
					<label>Username</label>
					<input type="text" class="form-control" id="user_name" name="user_name" value="<?= $this->session->userdata('name');?>" readonly="true">
				</div>
				<div class="col-lg-6">
					<label>Amount (In Rupees)</label>				
					<input type="text" class="form-control" id="amount" name="amount" required="true">
				</div>
			</div>
			<div class="row">
				<div class="col-lg-4">
					<input type="button" name="submit" class="pay_amount" value="Pay" style="background: red;color: #fff">
				</div>				
			</div>
		<?= form_close(); ?>
	</div>
	
</div>
</div>
</body>
</html>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
	$('.pay_amount').click(function(){
		var amount = $('#amount').val();
		if(amount!=''){
			var result = confirm("Are you sure to pay !!");
			if(result == true){
				var email = "<?= $this->session->userdata('email');?>";

				$.ajax({
					method: "post",
					url:"<?php echo base_url('users/paid_amount');?>",
					data:{"amount":amount,"email": email},

					success:function(response){ //alert(response);
						if(response!=''){         
							window.location.href = "<?php echo base_url('users/successfull_page')?>";
						}
					}
				});
			}
		} else {
			alert("Please fill the amount !!");
			return false;
		}
		
	});
</script>