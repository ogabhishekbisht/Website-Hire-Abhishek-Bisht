<?php require_once("../includes/functions.php");?>
<?php $layout_context = "admin";?>
<?php include("../includes/layout/header.php");?>
<TITLE>
			ADMIN PAGE
</TITLE>
	<div id = "main">
		<div id = "navigation">
	</div>
	<div id = "page">
	<h2> ADMIN MENU</h2>
	<p> Welcome to the Admin area</p>
	<ul>
	<li><a href="manage_content.php"> Manage Website </a></li>
	<li><a href="manage_admins"> Manage Admins </a></li>
	<li><a href="logout.php"> Logout </a></li>
	</ul>
	</div>
	</div>
<?php include("../includes/layout/footer.php");?>