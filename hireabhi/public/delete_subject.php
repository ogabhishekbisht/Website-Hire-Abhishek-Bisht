<?php require_once("../includes/session.php");?>
<?php require_once("../includes/dbconnection.php");?>
<?php require_once("../includes/functions.php");?>
<?php require_once ("../includes/validation_functions.php");?>
<?php confirm_logged_in();?>

<?php
$current_subject = find_subject_by_id($_GET["subject"]);
if(!$current_subject){
	redirect_to("manage_content.php");
}

$pages_set = find_pages_for_subject($current_subject["id"]);
if(mysqli_num_rows($pages_set) > 0)
{
	$_SESSION["message"] = "Can't Delete a Subject with pages.";
	redirect_to("manage_content.php?subject={$current_subject["id"]}");
}

$id = $current_subject["id"];
$query = "Delete from subjects where id = {$id}";
$result = mysqli_query($connection,$query);
	
	if($result){
		$_SESSION["message"] = "Subject Deleted Sucessfully.";
		redirect_to("manage_content.php");
	}	
	else{
		$_SESSION["message"] = "Subject Deletion failed. ";
		redirect_to("new_subject.php?subject={$id}");
	}

?>