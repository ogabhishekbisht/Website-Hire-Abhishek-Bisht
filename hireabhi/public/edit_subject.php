<?php require_once("../includes/session.php");?>
<?php require_once("../includes/dbconnection.php");?>
<?php require_once("../includes/functions.php");?>
<?php require_once ("../includes/validation_functions.php");?>
<?php find_selected_pages();?>
<?php  $result = find_all_subjects();?>

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
	
	
	if(empty($errors)) {
		
	$id = $current_subject["id"];
	$menu_name = mysql_prep($_POST["menu_name"]);
	$position = (int)$_POST["position"];
	$visible = (int)$_POST["visible"];
	

	//$count_query = "SELECT COUNT(id) FROM subjects;";
	//$count_set = mysqli_query($connection,$count_query);
	//confirm_query($count_set);
	//$new_count = mysqli_fetch_array($count_set);
	//$new_count_num = $new_count[0]+1;
	$query = "update subjects set menu_name = '{$menu_name}', position = {$position}, visible = {$visible} where id = {$id};";
	$result = mysqli_query($connection,$query);
	
	if($result){
		$_SESSION["message"] = "Subject Updated Sucessfully.";
		redirect_to("manage_content.php");
	}	
	else{
		$message = "Subject Updation failed. ";
		//redirect_to("new_subject.php");
	}
}

else{
	redirect_to("manage_content.php");
}
	
} 
?>

<?php
if(!$current_subject){
	redirect_to("manage_content.php");
}

?>

<?php include("../includes/layout/header.php"); ?>
<TITLE>
			MANAGE CONTENT
</TITLE>
	<div id = "main">
		<div id = "navigation">
		
		<ul class = "subjects">
		<?php
		while ($subject = mysqli_fetch_assoc($result)){
			
		?>
		<?php echo	"<li "; 
		if($subject["id"] == $selected_subject_id)
		{
		echo "  class = \"selected\" ";
		}
		echo " > " ?>
		
		<a href = "manage_content.php?subject=<?php echo $current_subject["id"];  ?>"><?php echo $subject["menu_name"]; ?> </a>
		<ul class = "pages">
	
		<?php $page_set = find_pages_for_subject($subject["id"]);?>
		<?php
		while ($pages = mysqli_fetch_assoc($page_set))
		{
			 
		?>
		<?php echo	"<li ";  
		if($pages["id"] == $selected_pages_id)
		{
		echo "  class = \"selected\" ";
		}
		echo " > " ?>
		
		<a href =  "manage_content.php?pages=<?php echo urldecode($pages["id"])  ?> "><?php echo $pages["menu_name"]; ?>  </a> </li>
		<?php
		} 
		?>
		
		
		</ul>
		</li>
		<?php
		}
		?>
		<?php mysqli_free_result($page_set);?>
		</ul>
	</div>
	<div id = "page">
	<?php if(!empty($message)){echo "<div class =\"message\">" .message(). "</div>"; } ?>
	<?php echo form_errors($errors);?>
	
	<h2>Edit Subject : <?php echo $current_subject["menu_name"];?></h2>
	<form action = "edit_subject.php?subject=<?php echo $current_subject["id"];  ?>" method = "post">
	<p> Subject Name: 
	<input type = "text" name = "menu_name" value = "<?php echo $current_subject["menu_name"];?>" />
	</p>
	<p> Position:
	<select name = "position">
	<?php 
	//$menu_name_query = $current_subject["menu_name"];
	//$query = "SELECT position FROM subjects where menu_name = {$menu_name_query} ;";
//	$count_set = mysqli_query($connection,$query);
//	confirm_query($count_set);
//	$new_count = mysqli_fetch_array($count_set);
//	$new_count_num = $new_count[0];
//	$limit_count = $new_count_num + 1;
	//for($count = $new_count_num+1; $count <= $limit_count; $count++ )
	echo "	<option value = \"{$current_subject["position"]}\">{$current_subject["position"]}</option>";
	?>
	
	</select>
	</p>
	<p> Visible:
	<input type = "radio" name = "visible" value = "0" <?php 
	if($current_subject["visible"] == 0){echo "checked" ;}?> /> No
	&nbsp;
	<input type = "radio" name = "visible" value = "1" <?php 
	if($current_subject["visible"] == 1){echo "checked" ;}?>/> Yes
	</p>
	<input type = "submit" name = "submit" value = "Edit Subject" />
	
	

	</form>
	<br/>
	<br/>
	<br/>
		<a href = "manage_content.php">	<input type = "button"  value = "Cancel"> </a>
	
	</div>
	</div>
<?php
mysqli_free_result($result);
?>
<?php include("../includes/layout/footer.php");?>

