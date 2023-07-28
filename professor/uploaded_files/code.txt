
<?php
	require_once "MyUtils.class.php";
	$my = new MyUtils();
	$title = "login page";
	$style = "login.css";
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
		if (!isset($_POST['username']) || 
			strlen($_POST['username']) == 0 ||
            !emailcheck($_POST['username']) ) {
			$message .= "<p>Invalid Name!</p>";
		}
        else{

			$name = sanitizeString($_POST['username']);
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
		<main>
		
    	
        <div class="container">
            <div id = "login">

			<form method="POST">
			<h1><img class="logo" src="assets/images/logo.png">myPLS</h1>
			<h2>Login</h2>
				<label>Username</label>
				<br>
				<input type="text" name="username" id="username" required />
				<br>
				<label>Password</label>
				<br>
				<input type="password" name="password" id="pass" required />
				<br>
			    <br>

				<input type="submit" name="submit" class="button" value="Login" />
				<br>
				


			</form>
			<form method="post">
				<br><br>
				<input type="submit" name="button1" 
                class="button" value="Register" /> 
			</form>
			
		</div>
		
		<div class="slideshow-container">

<div class="mySlides fade">
  <img src="assets/images/myPLS.png" style="width:100%">
</div>

<div class="mySlides fade">
  <img src="assets/images/admin.png" style="width:100%">
</div>

<div class="mySlides fade">
  <img src="assets/images/professor.png" style="width:100%">
</div>

<div class="mySlides fade">
  <img src="assets/images/learner.png" style="width:100%">
</div>

<a class="prev" onclick="plusSlides(-1)">&#10094;</a>
<a class="next" onclick="plusSlides(1)">&#10095;</a>

</div>


        
            
		
		</div>
		
		 </main>
    
<script>
var slideIndex = 1;
showSlides(slideIndex);

function plusSlides(n) {
  showSlides(slideIndex += n);
}

function currentSlide(n) {
  showSlides(slideIndex = n);
}

function showSlides(n) {
  var i;
  var slides = document.getElementsByClassName("mySlides");
  var dots = document.getElementsByClassName("dot");
  if (n > slides.length) {slideIndex = 1}    
  if (n < 1) {slideIndex = slides.length}
  for (i = 0; i < slides.length; i++) {
      slides[i].style.display = "none";  
  }
  for (i = 0; i < dots.length; i++) {
      dots[i].className = dots[i].className.replace(" active", "");
  }
  slides[slideIndex-1].style.display = "block";  
  dots[slideIndex-1].className += " active";
}
</script>'
		
		
		
		
		;
	} //showForm
	
?>
<?php
	if(array_key_exists('button1', $_POST)) { 
            button1(); 
	}
	function button1() { 
		header("Location: register.php");
	} 


?>
<?php

if (!isset($_POST['submit'])) {
	showForm();
} else {
	//Init error variables
	$errorMsg = false;
	$errorText = "ERRORS: ";
 
	$name = isset($_POST['username']) ? trim($_POST['username']) : '';
	$pass = isset($_POST['password']) ? trim($_POST['password']) : '';
	
  	if($name == "" || !emailcheck($name) || strlen($name) > 30 || $name == "Enter a name") {
    	$errorText = $errorText.'You must enter a valid name.\n';
    	$errorMsg = true;
  	}


  	if($pass == ""  || strlen($pass) > 30) {
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

		session_start();
		$message = null;
		

		if ( isset($_GET['success']) && $_GET['success'] == 1 )
		{
			//back to login page 
			echo "<script>if(confirm('You need to login!')){document.location.href='login.php'};</script>";
		}

		if (isset($_POST['username']) && isset($_POST['password'])) {
			if($_POST['username']!='' && $_POST['password']!='' ){
				$username = ($_POST['username']);
				$password = ($_POST['password']);
				$db->login($username, $password);

		}
	}


    
			
	} //form was a success!
} //else check form
?>

<?php
	echo $my->html_footer1();
?>
	
	