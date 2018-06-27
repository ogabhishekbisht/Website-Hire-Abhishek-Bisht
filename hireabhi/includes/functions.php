<?php

 function redirect_to($new_location){
	 header("Location: ". $new_location);
	 exit;
	
}

	function mysql_prep($string){
		global $connection;
		$escaped_string = mysqli_real_escape_string($connection,$string);
		return $escaped_string;
	}

 function confirm_query($result_set)
 {
	 if(!$result_set)
	 {
		 die("Database query failed" );
	 }
 }
 
 function form_errors($errors = array()){
	$output = "";
	if(!empty($errors)){
		$output .= "<div class = \"error\" >";
		$output .= "Please fix the following errors :";
		$output .= "<ul>";
		foreach($errors as $key => $error){
			$output .= "<li> {$error} </li>";
		
		}
		$output .= "</ul>";
		$output .= "</div>";
	}
	return $output;
}
 
 function find_all_subjects()
 {
	 global $connection;
	$query = "select * from subjects where visible = 1 order by position ASC";
	$result = mysqli_query($connection,$query);
	confirm_query($result);
	return $result;
 }
 
 function find_pages_for_subject($subject_id)
 {
	 global $connection;
	$query = "select * from pages where visible = 1 and subject_id = {$subject_id} order by position ASC"; 
	$page_set = mysqli_query($connection,$query);
	return $page_set;
 }
 

 function find_subject_by_id($subject_id)
 {
	// $safe_subject_id = mysqli_real_escape_string($connection,$subject_id);
	 global $connection;
	 $query = "  select * from subjects where id = {$subject_id}" ;
	 $subject_set = mysqli_query($connection,$query);
	 confirm_query($subject_set);
	 if($subject = mysqli_fetch_assoc($subject_set)) {
	 return $subject;	}
 else {
	 return null;
 }
 }
 
  function find_page_by_id($page_id)
 {
	// $safe_subject_id = mysqli_real_escape_string($connection,$subject_id);
	 global $connection;
	 $query = "  select * from pages where id = {$page_id}" ;
	 $page_set = mysqli_query($connection,$query);
	 confirm_query($page_set);
	 if($page = mysqli_fetch_assoc($page_set)) {
	 return $page;	}
 else {
	 return null;
 }
 }

	function find_selected_pages(){
		
	global $selected_pages_id;
	global $selected_subject_id;
	global $current_page;
	global $current_subject;
		if(isset($_GET["subject"])){
	$selected_subject_id = $_GET["subject"];
	$selected_pages_id = null;
	$current_subject = find_subject_by_id($selected_subject_id);
}

elseif(isset($_GET["pages"])){
	$selected_pages_id = $_GET["pages"];
	$selected_subject_id = null;
	$current_page = find_page_by_id($selected_pages_id);	
}  
else
{
	$selected_subject_id = null;
	$selected_pages_id = null;
}
	}
 ?>