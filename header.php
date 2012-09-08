<?php 
session_start();
?><!DOCTYPE html>
<html>
	<head>	
		<meta name="viewport" content="width=320,user-scalable=false" />
		
		<link rel="stylesheet" href="bootstrap/css/bootstrap.css" type="text/css" />
		<link rel="stylesheet" href="bootstrap/css/bootstrap-responsive.css" type="text/css" />
	<!--	<link rel="stylesheet" href="bootstrap/css/darkstrap.css" type="text/css" />-->
		<style>
			footer p{
				font-size:11px;
				font-family: "Tahoma";  
				color: #888888;
			}
			.btn-group {
				width:100%;
			}
			.btn {
				padding:20px;
			}/*
			img {
				box-shadow: 1px 1px 3px #333333;
				-webkit-box-shadow: 1px 1px 3px #333333;
			}
			hr {
				border: none;
				border-top: 1px solid #000000;
			}
			a {
				color: #FFFFFF;
			}
			td:hover {
				background-color: #FF7700;
			}*/
		</style>
		<script type="text/javascript" src="swfobject.js"></script>    
	  

		<script src="bootstrap/js/jquery-1.7.2.min.js" type="text/javascript"></script>
		 <script type="text/javascript">

		

	  </script>
		
	
		<title>Retube</title>
	</head>
	<body>
		<div style="display: none" pub-key="pub-fa40dacf-fd0d-441c-8d29-6a6a66521f59" sub-key="sub-c36cdb0f-8dfa-11e1-bf47-83ad1c27622b" ssl="off" origin="pubsub.pubnub.com" id="pubnub"></div>
		<script src="http://cdn.pubnub.com/pubnub-3.1.min.js"></script>
		<script>
			var first_time = true;
var paused = false;
			
			function forward(id, sess_id) {
				play(":forward", sess_id);
			}
			function rewind(id, sess_id) {
				play(":rewind", sess_id);
			}
			
			var firstTime = true;
			function pap(id, sess_id) {	
				$("#btn_play").html("<span id=\"throbber\">T</span>");
				if(firstTime) {
					firstTime = false;
					play(id, sess_id);
				} else{
					play(":pause", sess_id);
				}
			}
			function play(id, sess_id) {
			
				PUBNUB.publish({
					channel: "remote_" + sess_id,
					message: id
				});
				
			}
			$(window).resize(function() {
				var object = document.getElementsByTagName("object")[0];
				if(object)
					object.setAttribute("height", window.innerHeight);
			});
		</script>
		<div class="navbar">
		  <div class="navbar-inner">
			<div class="container">
				<a href="unset.php">Unset</a>
				<a class="brand" href="#">
					Youtube Remote
				</a>
				<?php if(isset($_GET['sess_id'])) {?>
				<form class="navbar-search pull-left" method="GET" action="controller.php">
					<input style="float: left" type="hidden" name="sess_id" value="<?php echo $_GET['sess_id']?>" />
				  <input type="text" class="search-query" name="q" value="<?php echo isset($_GET['q']) ? $_GET['q'] : ""?>" placeholder="Search">
				</form>
				<?php } ?>
			</div>
			
		  </div>
		</div>
		<div class="container">
		
