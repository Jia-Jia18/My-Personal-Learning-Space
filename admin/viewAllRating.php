<?php
    session_start();
	require_once "MyUtils.class.php";
	$my = new MyUtils();
	$title = "View All Rating page";
	$style = "home_page.css";
	$page = "View Feedback";
    $url = "";
    $id = "";
    if(isset($_GET['id'])){
        $id = $_GET['id'];
        $url = $id;
    }
    $_SESSION['role'] = $id;
    //var_dump($id);
	echo $my->admin_header($title,$style,$page,$url);
?>
<?php
	require_once "DB.class.php";
	$db = new DB();
    $id = "";
    if(isset($_GET['id'])){
        $id = $_GET['id'];
    }
                
    $data = $db->viewAllRating();
    echo "<h2>Total Feedback: ".count($data) ."</h2>";
    
    $bigString = "<table border='1'> \n
                <tr><th>Type</th><th>Name</th><th>Rating</th><th>Comment</th></tr>\n";
    
    if(isset($_GET['id'])){
        foreach($data as $course){
            $_SESSION['userRole'] = $course->rateid;
            $bigString .=$course->showAllRatings();
        }
    }

    echo $bigString;


?>
<?php	
	//check if user login to admin
	if (!isset($_SESSION['userRole']) && !isset($_GET['id'])) {
			header("Location: login.php?success=1");
			exit();
		} 
?>

<?php
	echo $my->html_footer();
?>