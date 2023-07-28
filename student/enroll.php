<?php
    session_start();
	require_once "MyUtils.class.php";
	$my = new MyUtils();
	$title = "Enroll course page";
	$style = "home_page.css";
	$page = "Enroll Courses";
    $style1 = "professor.css";
    $url = "";
    $id = "";
    if(isset($_GET['id'])){
        $id = $_GET['id'];
        $url = $id;
    }
    $userid = $_SESSION['role'];
    $_SESSION['role'] = $id;
    //var_dump($id);
	echo $my->student_header($title,$style,$style1,$page,$url);
?>

        
<?php	
	//check if user login to admin
	if (!isset($_SESSION['event']) && !isset($_GET['id'])) {
        echo "<script>document.location.href='login.php?success=1';</script>";
			exit();
	} 

?>	

<?php
	require_once "DB.class.php";
		$db = new DB();
		
	if(isset($_GET['id'])){
		$id = $_GET['id'];
	}
	
	$db->enroll($id,$userid);
?>

<?php
	echo $my->html_footer();
?>
