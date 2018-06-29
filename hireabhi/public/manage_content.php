<?php require_once("../includes/dbconnection.php");?>
<?php require_once("../includes/session.php");?>
<?php require_once("../includes/functions.php");?>
<?php find_selected_pages();?>
<?php  $result = find_all_subjects();?>
<?php $layout_context = "admin";?>
<?php include("../includes/layout/header.php"); ?>
<TITLE>
			MANAGE CONTENT
</TITLE>
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
		?>
		Content : <br/>
		<div class = "view-content">
		<?php echo $current_page["context"];?>
		</div>
	
	<br/><br/>
		<br/><br/>
		
		<a href = "edit_page.php?pages=<?php echo $current_page["id"] ;?>">Edit Page </a>
		
		
		<br/><br/><br/><br/>Position : <?php echo $current_page["position"];?>
		<br/>
		Visible : <?php echo $current_page["visible"] == 1? 'Yes' : 'No';?>
	 <br/> 
	
	<?php } elseif($selected_subject_id) { ?>
		<h2>Manage Subject</h2>
<?php //$selected_subject_query = "select menu_name from subjects where id = {$selected_subject_id}" ;?>
	<?php// $selected_subject_result = mysqli_query($connection,$selected_subject_query); ?>
	<?php
		//while ($subject_result = mysqli_fetch_assoc($selected_subject_result)){
		
		echo "This page contains information about my:- "; 
		//echo $subject_result["menu_name"]	; 
		echo htmlentities($current_subject["menu_name"]);?>
		<br/>
		Position : <?php echo $current_subject["position"];?>
		<br/>
		Visible : <?php echo $current_subject["visible"] == 1? 'Yes' : 'No';?>
	 <br/> 
		
		<?php
		echo "Please click on links further presented in the navigation bar" ; 
	?>
	<div style = "margin-top : 2em; border-top : 1px solid #000000;">
	<h3>Pages in the subject :</h3>
	<ul>
	<?php 
	$subject_pages = find_pages_for_subject($current_subject["id"]);
	while($page = mysqli_fetch_assoc($subject_pages)){
		echo "<li>";
		$safe_page_id = urldecode($page["id"]);
		echo "<a href = \" manage_content.php?pages={$safe_page_id}\">";
		echo htmlentities($page["menu_name"]);
		echo "</a>";
		echo "</li>";
		}
	
	?>
	</ul>
	</br></br></br>
	+ <a href = "new_page.php?subject=<?php echo $current_subject["id"];?>"> Add a new page to the subject </a>
	</div>
	</br>
	</br>
	
	</br>
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

