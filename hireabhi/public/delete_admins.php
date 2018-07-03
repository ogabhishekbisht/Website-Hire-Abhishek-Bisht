<?php require_once("../includes/session.php");?>
<?php require_once("../includes/dbconnection.php");?>

<?php require_once("../includes/functions.php");?>
<?php confirm_logged_in();?>

<?php
$admin = find_admin_by_id($_GET["id"]);
if(!$admin){
	redirect_to("manage_admins.php");
}

$id = $admin["id"];
$query = "Delete from admins where id = {$id} ;";
$result = mysqli_query($connection,$query);

if($result){
		$_SESSION["message"] = "Admin Deleted Sucessfully.";
		redirect_to("manage_admins.php");
	}	
	else{
		$_SESSION["message"] = "Admin Deletion failed. ";
		redirect_to("manage_admins.php");
	}

?>