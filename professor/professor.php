<?php	
	session_start();
	require_once "DB.class.php";
	$db = new DB();

    $id = $_GET['id'];
    $name = "";
    $role = "";
	$role1 = "";
	$r = "";
	$pass = "";

	$data = $db->viewUser();
	foreach($data as $user){     
		if($user->userid == $id){
			$n = $user->email;
			$r = $user->role;
			$pass = $user->password;
		}
	}

	if($r == 1){
		$role = "Admin";
	}
	else if($r == 2){
		$role = "Professor";
	}
	else{
		$role = "Student";
	}

    if($id == 0){
      echo "<script>if(confirm('Please login')){document.location.href='login.php'};</script>";
    }
    else{
		$_SESSION['userRole'] = $role;
		$_SESSION['id'] = $id; 
    }


					 
?>

<?php	
	
	//check if user login to admin
	if (!isset($_SESSION['userRole']) || !isset($_SESSION['id'])) {
			header("Location: login.php?success=1");
			exit();
		} 
	else {
			unset($_SESSION['userRole']);
			unset($_SESSION['id']);
			session_unset();
			session_destroy();
	}
?>

<?php
	require_once "MyUtils.class.php";
	$my = new MyUtils();
	$title = "Professor page";
	$style = "home_page.css";
	$page = "My details";
	$style1 = "professor.css";
	$url = $id;
	echo $my->professor_header($title,$style,$style1,$page,$url);
?>
    <div class="login">    
        <form method="POST">
            <label>User ID: </label>
            <input type="text" name="id" id="id" placeholder = "<?php echo $id; ?>" disabled="disabled"/>
            <br>

            <label>Username: </label>
            <input type="text" name="name" id="name" placeholder = "<?php echo $n; ?>" disabled="disabled" />
            <br>
						
			<label>Password: </label>
			<input type="text" name="password" id="pass"  placeholder = "<?php echo $pass; ?>" disabled="disabled" />
			<br>

			<label>Your Role: </label>       
			<input type="text" name="Role" id="Role"  placeholder = "<?php echo $role; ?>" disabled="disabled" />
			
            
            <br><br>

        </form>
	</div>

		
<?php
	echo $my->html_footer();
?>
