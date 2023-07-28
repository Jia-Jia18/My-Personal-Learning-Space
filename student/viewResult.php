
<?php
session_start();
require_once "MyUtils.class.php";
$my = new MyUtils();
$title = "Take Quiz";
$style = "home_page.css";
$page = "Take Quiz";
$role = "";
$eventId = "";
$style1 = "professor.css";
$id = "";
if (isset($_GET['id'])) {
    $id = $_GET['id'];
}

$role = "";
$role = $_SESSION['role'];

require_once "DB.class.php";
$db1 = new DB();
$id = "";
if (isset($_GET['id'])) {
    $id = $_GET['id'];
}
$owner = $_GET['owner'];
$_SESSION['owner'] = $owner;
$role1 = $_SESSION['role'];
$link = "";
$data1 = $db1->viewMyQuiz($role);

if (isset($_GET['id'])) {

    foreach ($data1 as $quiz) {
        $quizname = $quiz->quizname;
        $qid = $quiz->quizid;
        $link .= '<li>
            <a href="studentShowQuestions.php?id=' . $qid . '&owner=' . $owner . '">
            <span><img src="../assets/images/quiz.png" alt="icon" /></span>  
            <span>' . $quizname . '</span>
            </a>
            </li>';
    }
}

echo $my->quiz_header($title, $style, $style1, $page, $owner, $link, $role1);
?>




<?php


require_once "DB.class.php";
$db = new DB();
$id = "";
if (isset($_GET['id'])) {
    $id = $_GET['id'];
}


$data = $db->viewMyResult($id,$owner);
$data1 = $db->viewMyQuestion($id);

$question = "<div class= 'whole'>";
$answer = "";
$list = [];
if (isset($_GET['id'])) {
    foreach ($data as $quiz) {
        $_SESSION['userRole'] = $quiz->quizid;
        $question .= "<h1> Your grade for this quiz is ". $quiz->grade ."</h1>";
        $answer = $quiz->studentchose;
        $list = $answer;
        $list = preg_replace('/[ ,]+/', '', $list);
        $count = 0;
        $qnum = 1;
        foreach ($data1 as $quiz1) {
        	if ($list[$count] == "N"){
        		$question .= "<h1>your choice for question #". $qnum.": <span style='color:red;'> None </span></h1>";
        		$count += 1;
        		$qnum += 1;
        		$question .= $quiz1-> showMyQuestion($count);
        	
        	}
        	else{
        		$question .= "<h1>your choice for question #". $qnum.": <span style='color:red;'>".$list[$count]. "</span></h1>";
        		$count += 1;
        		$qnum += 1;
        		$question .= $quiz1-> showMyQuestion($count);
        	
        	
        	}
        	
        
        
        }
        
        $question .= "</div>";
        
        }
        	

}
echo  $question;


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
