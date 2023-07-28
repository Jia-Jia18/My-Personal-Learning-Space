<?php
    session_start();
	require_once "MyUtils.class.php";
	$my = new MyUtils();
	$title = "course page";
	$style = "home_page.css";
	$page = "Add Course";
    $role = "";
    $eventId = "";
    if(isset( $_SESSION['role'])){
    	$role =  $_SESSION['role'];
    }
    $_SESSION['admin'] = $role;
	$id = $_GET['id'];
	echo $my->admin_header($title,$style,$page,$id);
?>

<?php
include ("validations.php");

function showForm($errorMsg=false, $errorTxt="") {
    	//sanitize input
	function sanitizeString($var){
		$var = trim($var);
		$var = stripslashes($var);
		$var = htmlentities($var);
		$var = strip_tags($var);
		return $var;
	}
	
	$message = ""; //used for displaying messages on form
	
	//is the form being submitted or displayed for the first time
	if (isset($_POST['submit']))
	{
		$description = isset($_POST['description']) ? trim($_POST['description']) : '';
		$requirement = isset($_POST['requirement']) ? trim($_POST['requirement']) : '';
		//make sure cat exists and other validation
		if (!isset($_POST['name']) || 
			strlen($_POST['name']) == 0 ) {
			$message .= "Invalid Name!<br>";
		}
		
		if (!isset($_POST['description']) || 
			strlen($_POST['description']) == 0 ) {
			$message .= "Invalid Description!<br>";
		}
		
		if (!isset($_POST['requirement']) || 
			strlen($_POST['requirement']) == 0 ) {
			$message .= "Invalid Requirement!<br>";
		}
			
	}


	if ($errorMsg) {
		echo '<script>alert("'.$errorTxt.'");</script>';
	}
	echo '
    <div class="addCourse">    
        <form method="POST">';
        if ($message != "")
               echo "<h2 class='msg'>$message</h2>";

   echo  '
   			<label for="name">Course Name: </label>
            <br>
            <input type="text" name="name" id="name" required />
            <br>
                        
            <label for="description">Description:</label>
            <br>
            <textarea id="description" name="description" required> </textarea>
            <br>
 
            <label for="requirement">Requirement:</label>
            <br>
            <textarea id="requirement" name="requirement" required> </textarea>
 
           
            <br>

            
			';
			require_once "DB.class.php";
			$db = new DB();
			$data = $db->viewProfessor();
		
			echo '
				<!-- from venue table -->
				<label>Assign professor: </label>       
				<select name="professor">
			';
			//<option value="0" selected hidden>birthday</option>
			foreach($data as $professor){
				echo "<option value='$professor->userid'>$professor->name</option>";
			}
				
			echo '
			</select>
            
            <br><br>
            <input type="submit" name="submit"  class="button"  value="Add" />
            
        </form>
	</div>';
        } //showForm

?>
        
<?php	
	//check if user login to admin
	if (!isset($_SESSION['event']) && !isset($_GET['id'])) {
        echo "<script>document.location.href='login.php?success=1';</script>";
			exit();
	} 

?>	

<?php

if (!isset($_POST['submit'])) {
	showForm();
} else {
	//Init error variables
	$errorMsg = false;
	$errorText = "ERRORS: ";
 
	$name = isset($_POST['name']) ? trim($_POST['name']) : '';
	$description = isset($_POST['description']) ? trim($_POST['description']) : '';
	$requirement = isset($_POST['requirement']) ? trim($_POST['requirement']) : '';
	
  	if($name == "" || strlen($name) > 30 ) {
    	$errorText = $errorText.'You must enter a valid name.\n';
    	$errorMsg = true;
  	}
  	
  	if($description == "" || strlen($description) < 0 ) {
    	$errorText = $errorText.'You must enter a valid description.\n';
    	$errorMsg = true;
  	}
  	
  	if($requirement == "" || strlen($requirement) < 0 ) {
    	$errorText = $errorText.'You must enter a valid requirement.\n';
    	$errorMsg = true;
  	}
  	
  	


    $errorText = $errorText.'\nPlease try again.';
 
	// Display the form again as there was an error
	if ($errorMsg) {

		showForm($errorMsg,$errorText);
	} 
    else {
		require_once "DB.class.php";
		$db = new DB();

		if (isset($_POST['name']) && isset($_POST['description']) && isset($_POST['requirement']) && isset($_POST['professor']) ) {
			if($_POST['name']!='' && $_POST['description']!='' && $_POST['requirement']!='' && $_POST['professor']!=''){
					$name = ($_POST['name']);
					$description = ($_POST['description']);		
					$requirement = ($_POST['requirement']);
					$professor = ($_POST['professor']);
					$id = "";					
					if(isset($_GET['id'])){
						$id = $_GET['id'];
						$_SESSION['event'] = $name;
						$_SESSION['id'] = $id; 
					}
					$db->addCourse($name,$description,$requirement,$professor);
					echo "<script>if(confirm('Sucessfully added.')){document.location.href='viewAllCourse.php?id=$role'};</script>";
				
			}
		}
			
	} //form was a success!
} //else check form
?>

<?php
	echo $my->html_footer();
?>


