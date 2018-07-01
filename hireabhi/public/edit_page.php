<?php require_once("../includes/session.php");?>
<?php require_once("../includes/dbconnection.php");?>
<?php confirm_logged_in();?>
<?php require_once("../includes/functions.php");?>
<?php require_once ("../includes/validation_functions.php");?>
<?php find_selected_pages();?>

<?php
if(!$current_page){
	redirect_to("manage_content.php");
}
?>

<?php 
if(isset($_POST['submit'])){
	
	$id = $current_page["id"];
	$menu_name = mysql_prep($_POST["menu_name"]);
	$position = $_POST["position"];
	$visible = $_POST["visible"];
	$context = mysql_prep($_POST["context"]);
	
	
	
//$required_fields = array("id","subject_id","menu_name","postition","context","visible");
//	validate_presences($required_fields);
	
	
//$fields_with_max_lengths = array("menu_name" => 30);
//validate_max_lengths($fields_with_max_lengths);
$errors = null;
if(empty($errors)){
	$query = "Update pages set menu_name = '{$menu_name}', visible = {$visible}, context = '{$context}' where id = {$id};";
		$result = mysqli_query($connection,$query);
		if($result) {
		
		$_SESSION["message"] = "Page edited successfully ";
		redirect_to("manage_content.php?page=". $current_page["id"]);
	}
	else {
		$_SESSION["message"] = "Page updation failed ";
	}
	}
	
	
}

?>
<?php  $result = find_all_subjects();?>
<?php $layout_context = "admin";?>
<?php include("../includes/layout/header.php"); ?>
<div id = "main">
		<div id = "navigation">
		
		<br/>
		<a href = "admins.php">&laquo; Main Menu</a><br/>
		
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
		
		<a href = "manage_content.php?subject=<?php echo urlencode($subject["id"]);  ?> "><?php echo htmlentities($subject["menu_name"]); ?> </a>
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
		<a href = "new_subject.php"> + ADD A SUBJECT </a>
	</div>
	<div id = "page">
	<?php echo message(); ?>
	<?php echo form_errors($errors); ?>
	<h2> Edit Page : <?php $current_page["menu_name"];?></h2>
	<form action = "edit_page.php?pages=<?php echo $current_page["id"];?>" method = "post">
	<p> Menu Name :
	<input type = "text" name = "menu_name" value = "<?php echo $current_page["menu_name"];?>" />
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
	echo "	<option value = \"{$current_page["position"]}\">{$current_page["position"]}</option>";
	?>
	
	</select>
	</p>
	<p> Visible:
	<input type = "radio" name = "visible" value = "0" <?php 
	if($current_page["visible"] == 0){echo "checked" ;}?> /> No
	&nbsp;
	<input type = "radio" name = "visible" value = "1" <?php 
	if($current_page["visible"] == 1){echo "checked" ;}?>/> Yes
	</p>
	<p> Context : <br/>
	<textarea name = "context" rows = "20" cols = "80" ><?php echo $current_page["context"]?></textarea>
	</p>
	<input type = "submit" name = "submit" value = "Edit Page" />
	</form>
	<br/>
	
	<a href = "delete_page.php?pages=<?php echo $current_page["id"]?>" onclick = "return confirm ('ARE YOU SURE?');"><input type = "button"  value = "Delete"></a>
	
	<br/><br/><br/>
	<a href = "manage_content.php?pages=<?php echo $current_page["id"];?>"> <input type = "button" value = "Cancel"> </a>
	</div>
	</div>
<?php
mysqli_free_result($result);
?>
<?php include("../includes/layout/footer.php");?>

	
	
	
	
	
	