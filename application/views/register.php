<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Welcome to CodeIgniter</title>

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
	#body input[type="submit"]{ margin:10px 0; }
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
	<h1>User Register Here !!</h1>

	<div id="body">
		<?= form_open_multipart("users/register", ['id' => 'frmUsers']); ?>
			<div class="row">
				<div class="col-lg-6">
					<label>Username</label>
					<input type="text" class="form-control" name="user_name">
				</div>
				<div class="col-lg-6">
					<label>User-email</label>				
					<input type="email" class="form-control" name="user_email">
				</div>
			</div>
			<div class="row">
				<div class="col-lg-6">
					<label>Mobile No</label>
					<input type="text" class="form-control" name="mobile">
				</div>
				<div class="col-lg-6">
					<label>Attach File</label>
					<input type="file" class="form-control view_file" name="file_attach" id="upload" onchange="loadFile(event)">
					
				</div>
				<div class="col-lg-6">
					<img id="output" style="display: none; margin: 10px 0;
    border: 1px solid #ccc;
    width: 200px;
    height: 200px;
    object-fit: scale-down;">
				</div>
				<div class="col-lg-6 text-right">
					<span class="preview_attachment">Preview</span>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-4">
					<input type="submit" name="submit" value="Submit">
				</div>				
			</div>
		<?= form_close(); ?>
	</div>


	
</div>
</div>
</body>
</html>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript">

	var loadFile = function(event) {
		event.preventDefault()
	    var reader = new FileReader();
	    reader.onload = function(){
	      var output = document.getElementById('output');
	      output.src = reader.result;
	    };
    reader.readAsDataURL(event.target.files[0]);
  };

  $('.preview_attachment').click(function(){
  	$('#output').toggle();
  });
</script>