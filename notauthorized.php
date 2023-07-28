<?php
	require_once "MyUtils.class.php";
	$my = new MyUtils();
	$title = "login page";
	$style = "style.css";
	echo $my->html_header($title,$style);
?>
 
	<h2 id="noAuth">Not Authorized Page</h2>
	
	<main>
	<h3 style="font-size: 30px; text-align: center; ">Possible reason for login failed:</h3> 
	<p> 1. User not exists, please register.</p>
	<form action='register.php'>
    <input  type="submit" class="button" value="Registration" />
	</form>
	<br>
	<p> 2. Wrong username and password, please try again.</p> 
	<form action='login.php'>
    <input type="submit" class="button" value="Login" />
	</form>
	<br>
	<p> 3. You didn't confirm after registered.</p> 
	<form action="confirm.php">
    <input type="submit" class="button" value="Confirmation" />
	</form>
	<br>
	</main>

<?php
	echo $my->html_footer1();
?>
	