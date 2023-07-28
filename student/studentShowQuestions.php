
<?php
    session_start();
    require_once "MyUtils.class.php";
    $my = new MyUtils();
    $title = "View Question";
    $style = "home_page.css";
    $page = "View Question";
    $role = "";
    $eventId = "";
    $style1 = "professor.css";
    $id = "";
    if(isset($_GET['id'])){
        $id = $_GET['id'];
    }

    $role = "";
    $role = $_SESSION['role'];

    require_once "DB.class.php";
	$db1 = new DB();
    $id = "";
    if(isset($_GET['id'])){
        $id = $_GET['id'];
    }
    if(isset($_GET['owner'])){
         $owner = $_GET['owner'];
         $_SESSION['owner'] = $owner;
    }else{
    	 $owner = $_SESSION['owner'];
    	 $_SESSION['owner'] = $owner;
    }
    
   
    $role1 = $_SESSION['role'];
    $link = "";
    $data1 = $db1->viewMyQuiz($role);

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

	echo $my->quiz_header($title,$style,$style1,$page,$owner, $link, $role1);
?>

<?php

require_once "DB.class.php";
$db = new DB();
$id = "";
if (isset($_GET['id'])) {
    $id = $_GET['id'];
}

$data = $db->viewOneQuiz($id);




if (isset($_GET['id'])) {
    foreach ($data as $quiz) {
        $name = $quiz->quizname;
        $time = $quiz->availabledate;
        $enddate = $quiz->enddate;

        $date = date("Y-m-d H:i:s");
        $today = strtotime($date);
        $date1 = strtotime($time);
        $date2 = strtotime($enddate);



        echo '   <div class="viewOneQuiz">
       

                <label>Quiz Title: </label>
           
                <input type="text" name="quiztitle" id="quiztitle"  value="' . $quiz->quizname . '" disabled>
                <br>
                
                <label for="quizdescription">Quiz Description:</label>
                <textarea id="quizdescription" name="quizdescription" disabled> ' . $quiz->description . ' </textarea>
                <br>

               <label for="availabletime">Available Time:</label>
                <input type="datetime-local" name="availabletime" id="availabletime" value="' . $quiz->availabledate . '" disabled>
                <br>

                <label for="enddate">Close Time:</label>
                <input type="datetime-local" name="enddate" id="enddate" value="' . $quiz->enddate . '" disabled>
                <br>
                
                <label for="timelimit">Time Limit (Minutes):</label>
                <input type="number" name="timelimit" id="timelimit" value="' . $quiz->timelimit . '" disabled>
                <br>
            ';
		$data = $db->viewMyResult($id,$owner);
		
		$choice = "";
        if (($today >= $date1) && ($today <= $date2)) {
        	if(count($data) != 0){
    			echo '  <a class="button" href=' . '"viewResult.php?id=' . $id . '&owner=' . $owner . '">View Result</a>';
    		}
    		else{
           	 	echo'  <a class="button" href='.'"takeQuiz.php?id='.$id.'&owner='.$owner.'">Take</a>';
           	 }
        } 
   
        
        else {
        	if(count($data) != 0){
    			echo '  <a class="button" href=' . '"viewResult.php?id=' . $id . '&owner=' . $owner . '">View Result</a>';
    		}
    		else{
           	 	echo '<br><h1>Not Avaliable</h1>';
           	 }
            

        }

        echo '  </div>
        
        
        
       ';
    }
}

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
