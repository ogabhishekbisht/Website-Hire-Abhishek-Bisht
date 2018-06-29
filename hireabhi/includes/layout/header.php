<?php if(!isset($layout_context)){$layout_context = "public";}?>
<!DOCTYPE HTML>
<HTML>
	<HEAD>
		
		<link href = "css/publicnew.css" rel = "stylesheet" type = "text/css">
		<Title> Abhishek Bisht <?php if($layout_context == "admin") {
			echo "ADMIN";
		}?></Title>
	</HEAD>
	<BODY>
	<div id = "header">
		<h1>Hire Abhishek Bisht<?php if($layout_context == "admin") {
			echo " (Admin Page)";
		}?></h1><br/>
	</div>