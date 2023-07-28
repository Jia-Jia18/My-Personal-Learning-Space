<?php
    session_start();
	require_once "MyUtils.class.php";
	$my = new MyUtils();
	$title = "Lecture page";
	$style = "home_page.css";
	$page = "Update Lecture";
	$style1 = "professor.css";
    $role = "";
    $eventId = "";
    $courseid = "";
    if(isset( $_SESSION['role'])){
    	$role =  $_SESSION['role'];
    }
    $role = $_SESSION['role1'];
	$id = $_GET['id'];
    $courseid = $_GET['courseid'];
	echo $my->professor_header($title,$style,$style1,$page,$role);
?>

<?php
include ("../validations.php");

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
		
			
	}


	if ($errorMsg) {
		echo '<script>alert("'.$errorTxt.'");</script>';
	}
    $id = $_GET['id'];
    $db = new DB();
    $data = $db->viewOneLecture($id);
    $name = "";
    $des = "";
    foreach($data as $course){
        $name = $course->lectureName;
        $des = $course->description;
    }
	echo '
    <div class="addCourse">    
	<form name="frmImage" enctype="multipart/form-data" action="" method="post" class="frmImageUpload">';
        if ($message != "")
               echo "<h2 class='msg'>$message</h2>";

   echo  '
   			<label for="name">Lecture title: </label>
            <br>
            <input type="text" name="name" id="name" value = "'.$name.  '" required />
            <br>
                        
            <label for="description">Description:</label>
            <br>
            <textarea id="description" name="description" required>'.$des.' </textarea>
            <br>

            <br><br>
            
			<div class="upload-wrapper">
			<span class="file-name">Choose a file...</span>
			<label for="file-upload">Browse<input type="file" id="file-upload" name="uploadedFile"></label>
		  </div>
			

		<input type="submit" name="submit"  class="button"  value="Add" />
		</div>
	</form>';
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
	
  	if($name == "" || strlen($name) > 30 ) {
    	$errorText = $errorText.'You must enter a valid name.\n';
    	$errorMsg = true;
  	}
  	
  	if($description == "" || strlen($description) < 0 ) {
    	$errorText = $errorText.'You must enter a valid description.\n';
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

		if (isset($_POST['name']) && isset($_POST['description']) ) {
			if($_POST['name']!='' && $_POST['description']!='' ){
					$name = ($_POST['name']);
					$description = ($_POST['description']);		
					$id = "";					
					if(isset($_GET['id'])){
						$id = $_GET['id'];
						$_SESSION['event'] = $name;
						$_SESSION['id'] = $id; 
					}
					$message = ''; 
					if (isset($_POST['submit']) && $_POST['submit'] == 'Add')
					{
					  if (isset($_FILES['uploadedFile']) && $_FILES['uploadedFile']['error'] === UPLOAD_ERR_OK)
					  {
						// get details of the uploaded file
						$fileTmpPath = $_FILES['uploadedFile']['tmp_name'];
						$fileName = $_FILES['uploadedFile']['name'];
						$fileSize = $_FILES['uploadedFile']['size'];
						$fileType = $_FILES['uploadedFile']['type'];
						$fileNameCmps = explode(".", $fileName);
						$fileExtension = strtolower(end($fileNameCmps));
					 
						// sanitize file-name
						$newFileName = $fileName;
						
						
					 
						// check if file has one of the following extensions
						$allowedfileExtensions = array('jpg', 'gif', 'png', 'zip', 'txt', 'xls', 'doc','docx','mp4','pdf','pptx');
						
						if (in_array($fileExtension, $allowedfileExtensions))
						{
						  // directory in which the uploaded file will be moved
						  $uploadFileDir = './uploaded_files/';
						  $dest_path = $uploadFileDir . $newFileName;
					 
						  if(move_uploaded_file($fileTmpPath, $dest_path)) 
						  {
							$message ='File is successfully uploaded.';
                            //id is lecture id
                            $db->updateLecture($name,$description,$courseid ,$newFileName,$id);
     
							echo "<script>if(confirm('Sucessfully added.')){document.location.href='viewLecture.php?id=$courseid'};</script>";

						  }
						  else
						  {
							$message = 'There was some error moving the file to upload directory. Please make sure the upload directory is writable by web server.';
						  }
						}
						else
						{
						  $message = 'Upload failed. Allowed file types: ' . implode(',', $allowedfileExtensions);
						}
					  }
					  else
					  {
						$message = 'There is some error in the file upload. Please check the following error.<br>';
						$message .= 'Error:' . $_FILES['uploadedFile']['error'];
					  }

					}
			}
		}
			
	} //form was a success!
} //else check form
?>

<?php
	echo $my->html_footer();
?>


