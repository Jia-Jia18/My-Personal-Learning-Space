
<?php
    session_start();
	require_once "MyUtils.class.php";
	$my = new MyUtils();
	$title = "Event page";
	$style = "home_page.css";
	$page = "Delete courses";
    $url = "";
    $role = "";

    if(isset($_GET['id'])){
        $id = $_GET['id'];
        $url = $id;
    }
    $di = $_SESSION['admin'];
    $role =  $_SESSION['owner'];
	echo $my->admin_header($title,$style,$page,$url);
?>
<?php
	require_once "DB.class.php";
	$db = new DB();
    //delete courses
    $id = "";
    if(isset($_GET['id'])){
        $owner = $_GET['owner'];
	    $db->deleteMember($owner);
        echo "<script>if(confirm('Successfully Deleted')){document.location.href='viewMember1.php?id=$di&owner=$role'};</script>";

    }



    




?>

<?php	
	//check if user login to admin
	if (!isset($_SESSION['userRole']) && !isset($_GET['id'])) {
			header("Location: login.php?success=1");
			exit();
		} 
	else {
			unset($_SESSION['userRole']);
			session_unset();
			session_destroy();
	}
?>
<?php
	echo $my->html_footer();
?>
