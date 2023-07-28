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
    $_SESSION['role'] = $id;
     
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
    
    $data1 = $db1->viewMyQuiz($id);

    if(isset($_GET['id'])){

        foreach($data1 as $quiz){
            $quizname = $quiz->quizname;
            $qid = $quiz->quizid;
            $link .= '<li>
            <a href="studentShowQuestions.php?id='.$qid.'&owner='.$owner.'">
            <span><img src="../assets/images/quiz.png" alt="icon" /></span>  
            <span>'.$quizname.'</span>
            </a>
            </li>';
        }
    }

	echo $my->quiz_header($title,$style,$style1,$page,$owner, $link, $id);


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