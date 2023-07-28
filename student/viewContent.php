<?php
    session_start();
	require_once "MyUtils.class.php";
	$my = new MyUtils();
	$title = "View All Courses page";
	$style = "home_page.css";

    require_once "DB.class.php";
	$db = new DB();
    $id = "";
    if(isset($_GET['id'])){
        $id = $_GET['id'];
    }
                
    $data = $db->viewOneCourse($id);
    $count = count($data);

    $description = "";
    $pre = "";
    foreach($data as $course){
        $page = $course->courseName;
        $description = $course->description;
        $pre =  $course->preRequire;
    }

    $style1 = "professor.css";
    $url = "";
    $id = "";
    if(isset($_GET['id'])){
        $id = $_GET['id'];
        $url = $id;
    }
    $role = $_GET['owner'];
	echo $my->content_header($title,$style,$style1,$page,$role, $description,$pre,$url);
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