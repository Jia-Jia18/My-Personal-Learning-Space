<?php
    session_start();
	require_once "MyUtils.class.php";
	$my = new MyUtils();
	$title = "View All lecture page";
	$style = "home_page.css";
	$page = "View Lecture";
    $style1 = "professor.css";
    $url = "";
    $id = "";
    if(isset($_GET['id'])){
        $id = $_GET['id'];
        $url = $id;
    }
    $role = $_SESSION['role'];
    $_SESSION['role1'] = $role;
    //var_dump($id);
	echo $my->professor_header($title,$style,$style1,$page,$role);
?>
<?php
	require_once "DB.class.php";
	$db = new DB();
    $id = "";
    if(isset($_GET['id'])){
        $id = $_GET['id'];
    }
                
    $data = $db->viewAllLecture($id);
    echo "<h2>Total Lecture: ".count($data) ."</h2>";
    
    $bigString = "<table border='1'> \n
                <tr><th>ID</th><th>Lecture Name</th><th>Description</th><th>File Name</th><th>Course ID</th><th>Action</th></tr>\n";
    
    if(isset($_GET['id'])){
        foreach($data as $course){
            $_SESSION['userRole'] = $course->courseid;
            $bigString .=$course->showAllLectures();
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