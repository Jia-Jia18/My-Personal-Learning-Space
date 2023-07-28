<?php
    session_start();
	require_once "MyUtils.class.php";
	$my = new MyUtils();
	$title = "View quiz page";
	$style = "home_page.css";

    require_once "DB.class.php";
	$db = new DB();
    $id = "";
    if(isset($_GET['id'])){
        $id = $_GET['id'];
    }
    $role1 = $_SESSION['role'];
     
    $data = $db->viewOneCourse($id);
    $count = count($data);

    $description = "";
    $pre = "";
    $page = "";
    foreach($data as $course){
        $page = $course->courseName;
        $description = $course->description;
        $pre =  $course->preRequire;
    }

    $style1 = "professor.css";
    $url = "";
    $id = "";
    $link = "";
    if(isset($_GET['id'])){
        $id = $_GET['id'];
        $url = $id;
    }
	
	require_once "DB.class.php";
	$db1 = new DB();
    $id = "";
    $owner = $_GET['owner'];
    if(isset($_GET['id'])){
        $id = $_GET['id'];
    }
    
    $owner = $_GET['owner'];
                
    $data = $db->viewOneLecture($id);
    $count = count($data);
    $name =""; 
    $page = $name;
    echo $my->quiz_header($title,$style,$style1,$page,$owner, $link, $role1);
    if(isset($_GET['id'])){
        foreach($data as $course){
            $_SESSION['userRole'] = $course->lectureid;
            $name = $course->lectureName;
            $time = $course->availabledate;
            $date = date("Y-m-d H:i:s");  

            $today = strtotime($date);
            $date1 = strtotime($time);
	//var_dump($date);
          // var_dump($date1);
            if($today >= $date1){
                echo '<h1>'.$name.'</h1>';
                echo '<iframe src="../professor/uploaded_files/'.$course->filename.'" title="W3Schools Free Online Web Tutorials" width="80%" height="70%" style="background-color: #FFFFFF"></iframe></br>';
                echo $course->description;
            }
            else{
                echo '<h1>Not Avaliable Yet</h1>';
                echo '<h1>Avaliable at '.$time.'<h1>';
            }
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