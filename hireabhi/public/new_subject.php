<?php require_once("../includes/session.php");?>
<?php require_once("../includes/dbconnection.php");?>
<?php require_once("../includes/functions.php");?>
<?php require_once ("../includes/validation_functions.php");?>
<?php confirm_logged_in();?>
<?php find_selected_pages();?>
<?php  $result = find_all_subjects();?>
<?php $layout_context = "admin";?>
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
	<?php echo message(); ?>
	<?php $errors = errors(); ?>
	<?php echo form_errors($errors);?>
	
	<h2>Create Subject</h2>
	<form action = "create_subject.php" method = "post">
	<p> Subject Name: 
	<input type = "text" name = "menu_name" value = "" />
	</p>
	<p> Position:
	<select name = "position">
	<?php 
	$query = "SELECT COUNT(id) FROM subjects;";
	$count_set = mysqli_query($connection,$query);
	confirm_query($count_set);
	$new_count = mysqli_fetch_array($count_set);
	$new_count_num = $new_count[0];
	$limit_count = $new_count_num +5;
	for($count = $new_count_num+1; $count <= $limit_count; $count++ )
	echo "	<option value = \"{$count}\">{$count}</option>";
	?>
	
	</select>
	</p>
	<p> Visible:
	<input type = "radio" name = "visible" value = "0" /> No
	&nbsp;
	<input type = "radio" name = "visible" value = "1" /> Yes
	</p>
	<input type = "submit" name = "submit" value = "Create Subject" />
	
	

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

