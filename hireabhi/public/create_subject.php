<?php require_once("../includes/session.php");?>
<?php require_once("../includes/dbconnection.php");?>
<?php require_once("../includes/functions.php");?>
<?php require_once("../includes/validation_functions.php");?>
<?php confirm_logged_in();?>


<?php
if(isset($_POST['submit'])){
	//Process the form
	$menu_name = mysql_prep($_POST["menu_name"]);
	$position = (int)$_POST["position"];
	$visible = (int)$_POST["visible"];
	
	$required_fields = array("menu_name", "position", "visible");
	validate_presences($required_fields);
	
	$fields_with_max_lengths = array("menu_name" => 30 );
	validate_max_lengths($fields_with_max_lengths);
	
	if(!empty($errors)) {
		$_SESSION["errors"] = $errors;
		redirect_to("new_subject.php");
	}
	else {
	$count_query = "SELECT COUNT(id) FROM subjects;";
	$count_set = mysqli_query($connection,$count_query);
	confirm_query($count_set);
	$new_count = mysqli_fetch_array($count_set);
	$new_count_num = $new_count[0]+1;
	$query = "Insert into subjects values ({$new_count_num},'{$menu_name}', {$position}, {$visible});";
	$result = mysqli_query($connection,$query);
	
	if($result){
		$_SESSION["message"] = "Subject Created Sucessfully.";
		redirect_to("manage_content.php");
	}	
	else{
		$_SESSION["message"] = "Subject Creation failed. ";
		redirect_to("new_subject.php");
	}
	}
} 
else{
	redirect_to("new_subject.php");
}

?>





<?php
if(isset($connection)){
	mysqli_close($connection);
}?>