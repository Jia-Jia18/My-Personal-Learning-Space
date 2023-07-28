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
		$role = "Manager";
	}
	else{
		$role = "Attendee";
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
	$title = "Admin page";
	$style = "home_page.css";
	$page = "My Personal Learning Space";
	$url = $id;
	echo $my->admin_header($title,$style,$page,$url);
?>
<div class="flex-container">
  <div>
	<p id = "ppp" >My Personal Learning Space (myPLS)is a  web-based application that allows  RIT  life-long learners  (students,  alumni,  faculty, and staff)  to engage in an active learning process. myPLSallows professors to build adaptable and engaging lesson plans that can be consumed in In-class and out-of-class environments with anywhere/anytime reach. myPLS enables  Learners to maximize engaging learning experience with convenient collaborative learning anywhere, anytime,   and on any channel. It also provides personalized learning and teaching space with information sources and working/peer groups. </p>
  </div>  
</div>

		
<?php
	echo $my->html_footer();
?>
