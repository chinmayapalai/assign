<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Dashboard</title>

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
	.box-width{        max-width: 1200px;
    margin: 0 auto;
    display: flex;
    align-items: center;
    justify-content: center;
    height: 100vh;}
	#body input.add{ margin:10px 0; }
	#body input[type="button"]{ margin:10px 0; }
	.error-validation{border-color: red !important;}
	</style>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" >
</head>
<body>
<div class="box-width">
<div id="container">	
	<h1>User Lists</h1>
<div class="col-lg-12">
	<table class="table table-responsive table-bordered" style="    width: 100%;
    margin: 10px 0;
    height: 400px;
    overflow-y: auto;
    display: block;
    border-collapse: collapse;">
		<tr>
			<th>Sl No</th>
        	<th>Name</th>
			<th>Email</th>
            <th>Phone</th>
            <th>Attachment</th>
            <th>QR</th>
            <th>Amount</th>
            <th>Action</th>
        </tr>
        <?php $i=1;
        foreach($details as $detail) { ?> 
        <tr>  
        	<td><?= $i++; ?></td>                                                            
        	<td> <?= $detail->username; ?> </td>
            <td> <?= $detail->email; ?> </td>
            <td> <?= $detail->phone; ?> </td>
             <td> <img src="<?= base_url("assets/attachments/").$detail->file; ?>" height="100px"> </td>
             <td> <img src="<?= base_url("assets/qrcodes/").$detail->qrcode; ?>" height="100px"> </td>
            <td>₹<?= !empty($detail->amount) ? $detail->amount : '0'; ?> </td>
			<td> <button data-order_id="<?= $detail->id; ?>" data-toggle="modal" data-target="#customer_details-<?= $detail->id; ?>">Edit</button> || <button class="delete" data-del_id="<?= $detail->id; ?>">Delete</button> || <a href="<?= base_url('admin/download/').$detail->id;?>"><button class="download">Download</button></a></td>
        </tr>

        <div class="modal fade" id="customer_details-<?= $detail->id; ?>" data-backdrop="static">
							<div class="modal-dialog modal-lg width-400">
								<div class="modal-content">
									<!-- Modal Header -->
									<div class="modal-header" style="background-color:#2cabe3;">
										<h4 class="modal-title">Customer Details</h4>
										<button type="button" class="close" data-dismiss="modal">×</button>
									</div>
									<!-- Modal body -->
									<div class="modal-body">
										<div class="weight-box edit_cus_details">
											<form>
												<label>Customer Name:</label>							 
												<input type="text" id="name-<?= $detail->id; ?>" required placeholder="Name of customer" value = "<?= $detail->username;?>" class="form-control">
												<label>Email:</label>							 
												<input type="text" id="email-<?= $detail->id; ?>" required placeholder="Email of customer" value = "<?= $detail->email;?>" class="form-control">
												<label>Phone:</label>							 
												<input type="text" id="phone-<?= $detail->id; ?>" required value = "<?= $detail->phone;?>" class="form-control">
												
												<div class="subt">
												<button class="btn" data-user_id="<?= $detail->id; ?>" id="edit_details" type="button" style="margin: 10px 0;">Submit</button>
												</div>
												
											</form>   
										</div>    
										<div class="clearfix"></div>
									</div>
								</div>
							</div>
						</div>
						<!---End--->
    <?php } ?>
	</table>
</div>
	
</div>
</div>
</body>
</html>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script type="text/javascript">
	$('.delete').click(function(){
		var id = $(this).data('del_id');
		$.ajax({
			method : 'post',
			url:"<?= base_url('admin/delete_id');?>",
			data:{"user_id":id},
			success:function(response){ 
				alert(response);
				if(response!= ''){
					window.location.href = "<?= base_url('admin/dashboard')?>";
				}
				
			}
		});
	});

	//for edit customer details..
	$('body').on('click','#edit_details',function(){
		var id =$(this).data('user_id');
		var name = $('#name-'+id).val();
		var email = $('#email-'+id).val();
		var phone = $('#phone-'+id).val();

		if(name==''){
			$('#name-'+id).addClass('error-validation');
			return false;
		}else{
			$('#name-'+id).removeClass('error-validation');
		}
		if(email==''){
			$('#email-'+id).addClass('error-validation');
			return false;
		}else{
			$('#email-'+id).removeClass('error-validation');
		}
		if(phone==''){
			$('#phone-'+id).addClass('error-validation');
			return false;
		}else{
			$('#phone-'+id).removeClass('error-validation');
		}
		
		$.ajax({
			method: "post",
			url:"<?php echo base_url('admin/customer_details_edit');?>",
			data:{"name":name, 
				  "email":email, 
				  "phone":phone,
				  "id":id
				 },
			success:function(response){ alert(response); 
				if(response!=''){         
					window.location.href = "<?= base_url('admin/dashboard')?>";
				}
			}
		});
	});
</script>