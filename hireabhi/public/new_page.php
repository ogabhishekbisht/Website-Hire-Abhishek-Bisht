<?php require_once("../includes/session.php");?>
<?php require_once("../includes/dbconnection.php");?>
<?php require_once("../includes/functions.php");?>
<?php require_once ("../includes/validation_functions.php");?>
<?php find_selected_pages();?>
<?php $layout_context = "admin";?>
<?php include("../includes/layout/header.php");?>

<?php
if(!$current_subject){
	redirect_to("manage_content.php");
}
?>

<?php
if(isset($_POST['submit'])){
	//$required_fields = array("id","subject_id","menu_name","postition","context","visible");
//	validate_presences($required_fields);
	
	
//$fields_with_max_lengths = array("menu_name" => 30);
//validate_max_lengths($fields_with_max_lengths);
$errors = null;
if(empty($errors)){
	
	
	$pages_query = "SELECT COUNT(id) FROM pages;";
	$count_set = mysqli_query($connection,$pages_query);
	confirm_query($count_set);
	$new_count = mysqli_fetch_array($count_set);
	$new_count_num = $new_count[0]+1;
	$pages_id = $new_count_num;
	
	$subject_id = $current_subject["id"];
	$menu_name = mysql_prep($_POST["menu_name"]);
	$position = $_POST["position"];
	$visible = $_POST["visible"];
	
	
	
	
	$context = mysql_prep($_POST["context"]);
	
	$query = "Insert into pages values ({$pages_id},{$subject_id},'{$menu_name}',{$position},'{$context}',{$visible}) ;";
	$result = mysqli_query($connection,$query);
	
	if($result) {
		
		$_SESSION["message"] = "Page created";
		redirect_to("manage_content.php?subject=". $current_subject["id"]);
	}
	else {
		$_SESSION["message"] = "Page generation failed ";
	}
	}
	
	
	
}
else{
	
}








?>

<?php  $result = find_all_subjects();?>
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
		
		<a href = "manage_content.php?subject=<?php echo urlencode($subject["id"]);  ?> "><?php echo $subject["menu_name"]; ?> </a>
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
	<?php 
	echo message();
	echo form_errors($errors);
	?>
	<h2>Create Page</h2>
	<form action = "new_page.php?subject=<?php echo $current_subject["id"] ;?>" method = "post">
	<p> Menu Name :
	<input type = "text" name = "menu_name" value = "" />
	<p> Position :
	<select name = "position">
	<?php
	$page_set = find_pages_for_subject($current_subject["id"]);
	$page_count = mysqli_num_rows($page_set);
	$count = $page_count+1;
	echo "<option value =\"{$count}\">{$count}</option>";
	?>
	</select>
	</p>
	<p> Visible :
	<input type = "radio" name = "visible" value = "0" /> No
	&nbsp;
	<input type = "radio" name = "visible" value = "1" /> Yes
	</p>
	<p> Context : </br>
	<textarea name = "context" rows = "20" cols = "80" ></textarea>
	</p>
	<input type = "submit" name = "submit" value = "Create Page"/>
	</form>
	<br/>
	
	<a href = "manage_content.php?subject=<?php echo $current_subject["id"]; ?>"> Cancel </a>
	</div>
	</div>
	<?php include("../includes/layout/footer.php");?>