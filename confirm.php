<?php
	require_once "MyUtils.class.php";
	$my = new MyUtils();
	$title = "login page";
	$style = "style.css";
	echo $my->html_header($title,$style);
?>

<?php
	
	$check = '';
	  if (isset($_GET['username']) && isset($_GET['confimCode'])  ) {
	  if( $_GET['username']!='' && $_GET['confimCode']!='' ){
		  $username = ($_GET['username']);
		  $conf = ($_GET['confimCode']);
          require_once "DB.class.php";
          $db = new DB();

          $db->confirm($username,$conf);
		  

	  }
      }


?>

<h2 id="noAuth">Confirmation Page</h2>
	
		<div class="login" style="width: 300px; margin:auto;">

			<form method="get">
				<label for="username">Username</label>
				<input type="text" name="username" id="Uname"/>
				
				<br><br>
				<label for="confimCode">Confirmation Code</label>
				<input type="text" name="confimCode" id="Pass" />
				<br><br>
				<input type="submit" name="confirm" id="log" value="Confirm" />
				
				<br>
				
				<p>We just send the confirmation code and username to your email. Please check your email</p>
				
			</form>
		
		</div>
		
    
    </body>
</html>