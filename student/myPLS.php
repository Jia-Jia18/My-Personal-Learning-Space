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
	$title = "Student page";
	$style = "home_page.css";
	$style1 = "professor.css";
	$page = "My Personal Learning Space";
	$url = $id;
	echo $my->student_header($title,$style,$style1,$page,$url);

	$image = array("http://media-s3-us-east-1.ceros.com/gumgum/images/2018/08/30/a4ef384f2a79aeee4847721ec28d8720/machine-training-animation-1.gif", 
	"https://blog.commlabindia.com/wp-content/uploads/2015/01/using-videos-in-elearning-featured.gif", 
	"https://i.pinimg.com/originals/a6/04/2b/a6042b210187ca8e27743477723998a6.gif",
    "https://assets.sutori.com/user-uploads/image/e469e6ba-fe3b-40c7-85a3-ce68c9f152ea/712d50f190d8b8ddfed7d54049782720.gif",
    "https://i.pinimg.com/originals/5c/cf/d1/5ccfd16e5c933b0a69f4d1c84d642014.gif",
	"https://i.pinimg.com/originals/ae/4f/42/ae4f42b169638e0ce903312d5523233e.gif",
	"https://media3.giphy.com/media/TojgBqhSL19GcuNhd2/source.gif",
	"https://i.pinimg.com/originals/de/8a/ed/de8aed317d38613e79a2221e47864224.gif",
	"https://i.pinimg.com/originals/74/eb/d6/74ebd64980993dcda61fb766dcb12453.gif",
	"https://i.pinimg.com/originals/f0/12/e3/f012e388a7a74441228bb106de1c471d.gif"); 
?>

<?php
		require_once "DB.class.php";
		$db = new DB();
		$id = "";
		if(isset($_GET['id'])){
			$id = $_GET['id'];
		}
		
		echo '<div class="cards-list">';
		$data = $db->viewAllCourses($id);
		$count = count($data);

		

		foreach($data as $course){
			$ran = (rand(0,9));
			echo  ' <div class="card 1" onclick="myFunction' .$course->courseid.'()">
				<div class="card_image"> <img src="'.$image[$ran] .'" /> </div>
				<div class="card_title title-white">
				<p class = "name">'.$course->courseName .'</p>
				</div>
		  	</div>';
			  echo '<script>
			  function myFunction' .$course->courseid.'() {
				  document.location.href="viewContent.php?id='.$course->courseid .'&owner='.$id.'";
			  }
			  </script>';

		}
		echo '</div>';
  


?>	
<?php
	echo $my->html_footer();
?>
