<?php
	require_once "MyUtils.class.php";
	$my = new MyUtils();
	$title = "logout page";
	$style = "style.css";
	echo $my->html_header($title,$style);
?> 

    <main>
	<h2 id="textAlign">You Log Out</h2><br>  
    
    <form method="post">
				<input type="submit" name="button1"
                class="button" value="Login" /> 
			</form>
   
     </main>


<?php
    	if(array_key_exists('button1', $_POST)) { 
            button1(); 
	}
	function button1() { 
		header("Location: ../login.php");
	} 
?>

<?php
	echo $my->html_footer1();
?>