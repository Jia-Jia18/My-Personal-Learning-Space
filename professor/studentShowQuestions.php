
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
    $owner = $_GET['owner'];
    $role1 = $_SESSION['role'];
    $link = "";
    $data1 = $db1->viewMyQuiz($role);

    if(isset($_GET['id'])){

        foreach($data1 as $quiz){
            $quizname = $quiz->quizname;
            $qid = $quiz->quizid;
            $link .= '<li>
            <a href="showMyQuestions.php?id='.$qid.'&owner='.$owner.'">
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
    if(isset($_GET['id'])){
        $id = $_GET['id'];
    }
                
    $data = $db->viewOneQuiz($id);
    

    if(isset($_GET['id'])){
        foreach($data as $quiz){
          echo'   <div class="viewOneQuiz">
       

                <label>Quiz Title: </label>
           
                <input type="text" name="quiztitle" id="quiztitle"  value="'. $quiz->quizname.'" disabled>
                <br>
                
                <label for="quizdescription">Quiz Description:</label>
                <textarea id="quizdescription" name="quizdescription" disabled> '.$quiz->description.' </textarea>
                <br>

               <label for="availabletime">Available Time:</label>
                <input type="datetime-local" name="availabletime" id="availabletime" value="'.$quiz->availabledate .'" disabled>
                <br>
                
                <label for="timelimit">Time Limit (Minutes):</label>
                <input type="number" name="timelimit" id="timelimit" value="'. $quiz->timelimit. '" disabled>
                <br>
            
                <a href='.'"takeQuiz.php?id='.$id.'&owner='.$owner.'">Take</a>


        </div>
        
        
        
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
