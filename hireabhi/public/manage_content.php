<?php require_once("../includes/dbconnection.php");?>
<?php require_once("../includes/session.php");?>
<?php require_once("../includes/functions.php");?>
<?php find_selected_pages();?>
<?php  $result = find_all_subjects();?>
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
		<a href = "new_subject.php"> + ADD A SUBJECT </a>
	</div>
	<div id = "page">
	<?php 
	echo message();
	?>
	<h2> Content Manage</h2>
	<?php if($selected_pages_id) { ?>
	<h2>Manage Page</h2>
	<?php// $selected_page_query = "select context from pages where id = {$selected_pages_id}" ;?>
	<?php// $selected_page_result = mysqli_query($connection,$selected_page_query); ?>
	<?php
		//while ($pages_result = mysqli_fetch_assoc($selected_page_result)){
		
		//echo $pages_result["context"]	; 
		echo $current_page["context"];
	?>
	
	<?php } elseif($selected_subject_id) { ?>
		<h2>Manage Subject</h2>
<?php //$selected_subject_query = "select menu_name from subjects where id = {$selected_subject_id}" ;?>
	<?php// $selected_subject_result = mysqli_query($connection,$selected_subject_query); ?>
	<?php
		//while ($subject_result = mysqli_fetch_assoc($selected_subject_result)){
		
		echo "This page contains information about my:- "; 
		//echo $subject_result["menu_name"]	; 
		echo $current_subject["menu_name"];
		
		?> <br/> 
		
		<?php
		echo "Please click on links further presented in the navigation bar" ; 
	?>
	</br>
	</br>
	<a href = "edit_subject.php?subject=<?php echo $current_subject["id"]?>"> <input type = "button" value = "EDIT SUBJECT"></a>
		<?php }  else { ?>
	Please select a subject or a page
	<?php } ?>
	</div>
	</div>
<?php
mysqli_free_result($result);
?>
<?php include("../includes/layout/footer.php");?>

