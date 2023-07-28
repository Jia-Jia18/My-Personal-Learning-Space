<?php
    session_start();
	require_once "MyUtils.class.php";
	$my = new MyUtils();
	$title = "View All lecture page";
	$style = "home_page.css";
    $style1 = "professor.css";
    $url = "";
    $id = "";
    if(isset($_GET['id'])){
        $id = $_GET['id'];
    }
    $_SESSION['role'] = $id;
    $url = $_SESSION['role1'];
    //var_dump($id);

?>
<?php
	require_once "DB.class.php";
	$db = new DB();
    $id = "";
    if(isset($_GET['id'])){
        $id = $_GET['id'];
    }
                
    $data = $db->viewOneLecture($id);
    $count = count($data);
    $name =""; 
    $page = $name;
    echo $my->professor_header($title,$style,$style1,$page,$url);
    if(isset($_GET['id'])){
        foreach($data as $course){
            $_SESSION['userRole'] = $course->lectureid;
            $name = $course->lectureName;
            echo '<h1>'.$name.'</h1>';
            echo '<iframe src="uploaded_files/'.$course->filename.'" title="W3Schools Free Online Web Tutorials"></iframe></br>';
            echo $course->description;
        }
    }



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