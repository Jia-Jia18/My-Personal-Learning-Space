<?php
    session_start();
	require_once "MyUtils.class.php";
	$my = new MyUtils();
	$title = "feedback form";
	$style = "home_page.css";
	$page = "feedback form";
    $style1 = "professor.css";
    $url = "";
    $id = "";
    if(isset($_GET['id'])){
        $id = $_GET['id'];
        $url = $id;
    }
    $_SESSION['role'] = $id;
    //var_dump($id);
	echo $my->student_header($title,$style,$style1,$page,$url);
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
		$message = "";
		//make sure cat exists and other validation
		if (!isset($_POST['name']) || 
			strlen($_POST['name']) == 0 ||
            emailCheck($_POST['name']) ) {
			$message .= "<p>Invalid name!</p>";
		}
		
				if (!isset($_POST['comment']) || 
			strlen($_POST['comment']) == 0 ||
            emailCheck($_POST['comment']) ) {
			$message .= "<p>Invalid comment!</p>";
		}

		
       
	}


	if ($errorMsg) {
		echo '<script>alert("'.$errorTxt.'");</script>';
	}


if ($message != "")
		echo "<h2 class='msg'>$message</h2>";

	echo  '
	   <div class="feedbackform">
    <form method="POST">

        <label>Choose a Type:</label>
        <div class="radio">
            <input type="radio" name="type" value="Professor" checked />Professor<br />
            <input type="radio" name="type" value="Course" />Course<br />
            <input type="radio" name="type" value="Lesson" />Lesson<br />
            <input type="radio" name="type" value="Learner" />Learner<br />

        </div>

        <br>
        <label>Please enter the name: </label>
        <input type="text" name="name" id="name" required />
        <br>


        <div id="scrollbar">
            <br>Please rate<br>
            <p>0
                <input type="range" name="rating" min="0" max="10" step="1" list="set">
                <datalist id="set">
                    <option>0</option>
                    <option>1</option>
                    <option>2</option>
                    <option>3</option>
                    <option>4</option>
                    <option>5</option>
                    <option>6</option>
                    <option>7</option>
                    <option>8</option>
                    <option>9</option>
                    <option>10</option>
                </datalist>
                10
            </p>
        </div>


        <label for="comment">Comment:</label>
        <br>
        <textarea id="comment" name="comment" required> </textarea>

<br>
        <input type="submit" name="submit" class="button" value="Add" />
		<br>

    </form>
</div> ';
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
	$comment = isset($_POST['comment']) ? trim($_POST['comment']) : '';
	



  	if($name == ""  || strlen($name) <0) {
    	$errorText = $errorText.'You entered an invalid name.';
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

		if (isset($_POST['name']) && isset($_POST['rating']) && isset($_POST['comment']) && isset($_POST['type']) ) {
			if($_POST['name']!='' && $_POST['rating']!='' && $_POST['comment']!='' && $_POST['type']!='' ){
					$name = ($_POST['name']);
					$type = ($_POST['type']);	
					$rating = ($_POST['rating']);
					$comment = ($_POST['comment']);	 
					$db->addFeedback($name,$type,$rating,$comment);
					//var_dump($comment);
					echo "<script>if(confirm('Sucessfully added.')){document.location.href='viewAllRating.php?id=$id'};</script>";
				
			}
		}

    
			
	} //form was a success!
} //else check form
?>



<?php
	echo $my->html_footer();
?>




