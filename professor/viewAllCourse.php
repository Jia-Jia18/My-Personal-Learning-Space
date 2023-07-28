<?php
    session_start();
	require_once "MyUtils.class.php";
	$my = new MyUtils();
	$title = "View All Courses page";
	$style = "home_page.css";
	$page = "View All Courses";
    $style1 = "professor.css";
    $url = "";
    $id = "";
    if(isset($_GET['id'])){
        $id = $_GET['id'];
        $url = $id;
    }
    $_SESSION['role'] = $id;
    //var_dump($id);
	echo $my->professor_header($title,$style,$style1,$page,$url);
?>


<?php
	require_once "DB.class.php";
	$db = new DB();
    $id = "";
    if(isset($_GET['id'])){
        $id = $_GET['id'];
    }
                
    $data = $db->viewPublicCourses();
    echo "<h2>Total Course: ".count($data) ."</h2>";
    
    $bigString = "<table border='1'> \n
                <tr><th>ID</th><th>CourseName</th><th>Description</th><th>Pre require</th><th>Professor ID</th></tr>\n";
    
    if(isset($_GET['id'])){
        foreach($data as $course){
            $bigString .=$course->showPublicCourses();
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