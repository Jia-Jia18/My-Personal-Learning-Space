<?php
    session_start();
	require_once "MyUtils.class.php";
	$my = new MyUtils();
	$title = "Delete Quiz";
	$style = "home_page.css";
	$page = "Delete Quiz";
    $role = "";
    $eventId = "";
    $style1 = "professor.css";
    $id = "";
    if(isset($_GET['id'])){
        $id = $_GET['id'];
    }
    $role = $_SESSION['role'];
    $courseid = $_SESSION['courseid'];
	echo $my->professor_header($title,$style,$style1,$page,$role);
?>

<?php
	require_once "DB.class.php";
	$db = new DB();
    //delete courses
    $id = "";
    if(isset($_GET['id'])){
        $id = $_GET['id'];
	    $db->deleteQuiz($id);
        echo "<script>if(confirm('Successfully Deleted')){document.location.href='viewMyQuiz.php?id=$courseid'};</script>";

    }



?>
<?php	
	//check if user login to admin
	if (!isset($_SESSION['userRole']) && !isset($_GET['id'])) {
			header("Location: login.php?success=2");
			exit();
		} 
?>

<?php
	echo $my->html_footer();
?>
