
<?php
	require_once "MyUtils.class.php";
	$my = new MyUtils();
	$title = "register page";
	$style = "style.css";
	echo $my->html_header($title,$style);
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
		if (!isset($_POST['Email']) || 
			strlen($_POST['Email']) == 0 ||
            emailCheck($_POST['Email']) ) {
			$message .= "<p>Invalid Email!</p>";
		}
		if (!isset($_POST['Fname']) || 
			strlen($_POST['Fname']) == 0 ||
            !alphabeticSpace($_POST['Fname']) ) {
			$message .= "<p>Invalid First Name!</p>";
		}
		
		if (!isset($_POST['Lname']) || 
			strlen($_POST['Lname']) == 0 ||
            !alphabeticSpace($_POST['Lname']) ) {
			$message .= "<p>Invalid Last Name!</p>";
		}
		
        else{

			$name = sanitizeString($_POST['Email']);
            //password hashed
			$message .= "<p>Successfully Added</blockquote></p>";
		}
	}


	if ($errorMsg) {
		echo '<script>alert("'.$errorTxt.'");</script>';
	}
	if ($message != "")
                echo "<h2 class='msg'>$message</h2>";
	echo '
    <div class="login">    
	<h2>Register</h2><br>   
		<form method="post">
			
			<label>Email Address: </label>
			<input type="email" name="Email" id="Email" required  />
			<br>
			
			<label>First Name: </label>
			<input type="text" name="Fname" id="Fname" required />
			<br>
					    
			<label>Last Name: </label>
			<input type="text" name="Lname" id="Lname" required />
			<br>
			
			<label>Password: </label>
			<input type="password" name="password" id="pass" required  />
			<br>
			
			<div class="r">
			<label>Which role are you?</label>
				<div class="radio">
					<input type="radio" name="Role" value="1" checked />Admin<br />
					<input type="radio" name="Role" value="2" />Professor<br />
					<input type="radio" name="Role" value="3" />Student<br />
				</div>
			</div>
			
			<br><br>
			<input type="submit" name="submit"  class="button"  value="register" />
			


		</form>
		

			<hr class = "line">
			
			<form method="post">
				<input type="submit" name="buttonback"
                class="button" value="back" /> 
			</form>
		
		
	</div>';
} //showForm

?>

<?php
	if(array_key_exists('buttonback', $_POST)) { 
		buttonback(); 
	}
	function buttonback() { 
		header("Location: login.php");
	}
?>
	
<?php

if (!isset($_POST['submit'])) {
	showForm();
} else {
	//Init error variables
	$errorMsg = false;
	$errorText = "ERRORS: ";
 
	$name = isset($_POST['Email']) ? trim($_POST['Email']) : '';
	$pass = isset($_POST['password']) ? trim($_POST['password']) : '';
	
  	if($name == "" || !emailcheck($name) || strlen($name) > 30 ) {
    	$errorText = $errorText.'You must enter a valid email.\n';
    	$errorMsg = true;
  	}


  	if($pass == ""  || strlen($pass) > 30 || $pass == "Set Password") {
    	$errorText = $errorText.'You entered an invalid password.';
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

		if (isset($_POST['Email']) && isset($_POST['Fname']) && isset($_POST['Lname']) && isset($_POST['password']) && isset($_POST['Role']) ) {
			if($_POST['Email']!='' && $_POST['password']!='' && $_POST['Fname']!='' && $_POST['Lname']!='' && $_POST['Role']!='' ){
					$name = ($_POST['Email']);
					$role = ($_POST['Role']);	
					$fname = ($_POST['Fname']);
					$lname = ($_POST['Lname']);	 
					$password = ($_POST['password']);
					$code = intval( "0" . rand(1,9) . rand(0,9) . rand(0,9) . rand(0,9) . rand(0,9) ); // random(ish) 5 digit int
					$db->addUser($name,$fname,$lname,$password,$role,$code);
					//go to login page after registered
					echo "<script>if(confirm('Sucessfully Registered.')){document.location.href='confirm.php'};</script>";
				
			}
		}

    
			
	} //form was a success!
} //else check form
?>

<?php
	echo $my->html_footer1();
?>
	