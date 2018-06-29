<?php require_once("../includes/session.php");?>
<?php require_once("../includes/dbconnection.php");?>
<?php require_once("../includes/functions.php");?>
<?php require_once ("../includes/validation_functions.php");?>

<?php
$current_page = find_page_by_id($_GET["pages"]);
if(!$current_page){
	redirect_to("manage_content.php");
}

$id = $current_page["id"];
$query = "Delete from pages where id = {$id}";
$result = mysqli_query($connection,$query);

if($result){
		$_SESSION["message"] = "Page Deleted Sucessfully.";
		redirect_to("manage_content.php");
	}	
	else{
		$_SESSION["message"] = "Page Deletion failed. ";
		redirect_to("new_subject.php?pages={$id}");
	}

?>