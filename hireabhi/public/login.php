<?php require_once("../includes/dbconnection.php");?>
<?php require_once("../includes/session.php");?>
<?php require_once("../includes/functions.php");?>
<?php require_once("../includes/validation_functions.php")?>


<?php
$username = "";
if(isset($_POST['submit'])){
	
	
	$required_fields = array("username", "password");
	validate_presences($required_fields);
	
	
//$fields_with_max_lengths = array("username" => 30);
//validate_max_lengths($fields_with_max_lengths);


if(empty($errors)){
	$username = $_POST["username"];
	$password = $_POST["password"];
	$found_admin = attempt_login($username, $password);
	if($found_admin) {
		
		$_SESSION["admin_id"] = $found_admin["id"];
		$_SESSION["username"] = $found_admin["username"];
		redirect_to("admins.php");
	}
		
		else {
			$_SESSION["message"] = "Details did not match";
		}
}

else{
		
}
}

?>


<?php $layout_context = "admin";?>
<?php include("../includes/layout/header.php"); ?>
<div id = "main">
<div id = "navigation">
 &nbsp;
 </div>
 <div id = "page">
 <?php 
	echo message();
	echo form_errors($errors);
	?>
	<h2>Login</h2>
	<form action = "login.php" method = "post">
	<p> Username :
	<input type = "text" name = "username" value = "<?php echo htmlentities($username)?>" placeholder = "Username" /> </p>
	<p> Password :
	<input type = "password" name = "password" value = "*****" placeholder = "Password"/> </p>
	<input type = "submit" name = "submit" value = "Submit" />
	</form>
	
	<br/>
	
	</div>
	</div>

	
	<?php include("../includes/layout/footer.php");?>



