<?php
    session_start();
	require_once "MyUtils.class.php";
	$my = new MyUtils();
	$title = "View Quiz";
	$style = "home_page.css";
	$page = "View Quiz";
    $role = "";
    $eventId = "";
    $style1 = "professor.css";
    $id = "";
    if(isset($_GET['id'])){
        $id = $_GET['id'];
    }
    $role = $_SESSION['role'];
    
    $_SESSION['courseid'] = $id;
	echo $my->student_header($title,$style,$style1,$page,$role);
?>


<?php
	require_once "DB.class.php";
	$db = new DB();
    $id = "";
    if(isset($_GET['id'])){
        $id = $_GET['id'];
    }
                
    $data = $db->viewMyQuiz($id);
    
    $bigString = "<table border='1'> \n
                <tr><th>Quiz Id</th><th>Course Id</th><th>Quiz Name</th><th>Description</th><th>Time Limit</th><th>Available Date</th><th>Action</th></tr>\n";
    
    if(isset($_GET['id'])){
        foreach($data as $quiz){
            $_SESSION['userRole'] = $quiz->quizid;
            $bigString .=$quiz->showMyQuiz();
        }
    }

    echo $bigString;


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
