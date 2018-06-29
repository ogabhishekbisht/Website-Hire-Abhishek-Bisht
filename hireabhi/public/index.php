<?php require_once("../includes/dbconnection.php");?>
<?php require_once("../includes/session.php");?>
<?php require_once("../includes/functions.php");?>
<?php find_selected_pages();?>
<?php  $result = find_all_subjects(false);?>
<?php $layout_context = "public";?>
<?php include("../includes/layout/header.php"); ?>
<TITLE>
CONTENT
</TITLE>
	<div id = "main">
		<div id = "navigation">
		
		<br/>
		
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
		
		<a href = "index.php?subject=<?php echo urlencode($subject["id"]);  ?> "><?php echo htmlentities($subject["menu_name"]); ?> </a>
		<ul class = "pages">
	
		<?php $page_set = find_pages_for_subject($subject["id"], false);?>
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
		
		<a href =  "index.php?pages=<?php echo urldecode($pages["id"])  ?> "><?php echo $pages["menu_name"]; ?>  </a> </li>
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
	
	<h2> Content</h2>
	<?php if($selected_pages_id) { ?>
	
		<br/>
		<div class = "view-content">
		<?php echo $current_page["context"];?>
		</div>
	
	<br/><br/>
		<br/><br/>
		
	
		
	
	<?php } elseif($selected_subject_id) { ?>
		<h2> Subject</h2>
<?php //$selected_subject_query = "select menu_name from subjects where id = {$selected_subject_id}" ;?>
	<?php// $selected_subject_result = mysqli_query($connection,$selected_subject_query); ?>
	<?php
		//while ($subject_result = mysqli_fetch_assoc($selected_subject_result)){
		
		echo "This page contains information about my:- "; 
		//echo $subject_result["menu_name"]	; 
		echo htmlentities($current_subject["menu_name"]);?>
		<br/>
		
		<?php
		echo "Please click on links further presented in the navigation bar" ; 
	?>
	
	</br>
	
	</br>
	</br>
	</br>
		<?php }  else { ?>
	Please select a subject or a page
	<?php } ?>
	
	</div>
<?php
mysqli_free_result($result);
?>
<?php include("../includes/layout/footer.php");?>

