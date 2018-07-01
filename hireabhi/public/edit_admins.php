<?php require_once("../includes/dbconnection.php");?>
<?php require_once("../includes/session.php");?>
<?php confirm_logged_in();?>
<?php require_once("../includes/functions.php");?>
<?php require_once("../includes/validation_functions.php")?>

<?php 
	$admin = find_admin_by_id($_GET["id"]);
	
	if(!$admin){
		redirect_to("manage_admins.php");
	}
?>

<?php 
if(isset($_POST['submit'])){
	
	$required_fields = array("username","password");
	validate_presences($required_fields);
	
	$fields_with_max_lengths = array("username" => 30);
	validate_max_lengths($fields_with_max_lengths);
	
	if(empty($errors)){
		$id = $admin["id"];
		$username = mysql_prep($_POST["username"]);
		$hashed_password = password_encrypt($_POST["password"]);
		
		$query = "Update admins set username = '{$username}', hashed_password = '{$hashed_password}' where id = {$id} ;";
		$result = mysqli_query($connection,$query);
	if($result) {
		
		$_SESSION["message"] = "Admin updated successfully ";
		redirect_to("manage_admins.php");
	}
	else {
		$_SESSION["message"] = "Admin updation failed ";
	}
	}
	
	
}

?>

<?php $layout_context = "admin";?>
<?php include("../includes/layout/header.php"); ?>


<div id = "main">
		<div id = "navigation">
		&nbsp;
		</div>
		<div  id = "page">
		<?php echo message(); ?>
	<?php echo form_errors($errors); ?>
	<h2> Edit Admin : <?php echo htmlentities($admin["username"]);?></h2>
	<form action = "edit_admins.php?id=<?php echo urlencode($admin["id"]);?>" method = "post">
	<p>Username :
	<input type = "text" name = "username" value = "<?php echo htmlentities($admin["username"]);?>" />
	</p>
	<p> Password :
	<input type = "password" name = "password" value = "" />
	</p>
	<input type = "submit" name = "submit" value = "Edit Admin" />
	</form>
	<br/>
	<a href = "manage_admins.php"> <input type = "button" value = "Cancel"> </a>
	</div>
</div>
	


<?php include("../includes/layout/footer.php");?>
