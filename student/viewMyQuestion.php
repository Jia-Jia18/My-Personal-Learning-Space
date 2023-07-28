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
    $courseid = $_SESSION['courseid'];
	echo $my->professor_header($title,$style,$style1,$page,$role);
?>



<?php
function showForm($errorMsg=false, $errorTxt=""){
    require_once "DB.class.php";
    $db = new DB();
    $id = "";
    if(isset($_GET['id'])){
        $id = $_GET['id'];
    }
                
    $data = $db->viewMyQuestion($id);
    
    $bigString = "";
    
    $count = 0;
    if(isset($_GET['id'])){
        foreach($data as $quiz){
        	$count += 1;
            $_SESSION['userRole'] = $quiz->quizid;
            $bigString .= $quiz-> showMyQuestion($count);
        }
    }
	echo '<button onclick="myFunction()">Change</button>
	<script>
function myFunction() {
 var inputs=document.getElementsByTagName("textarea");
 for(i=0;i<inputs.length;i++){
    inputs[i].disabled=false;
 }  
 
  var options=document.getElementsByTagName("select");
 for(x=0;x<options.length;x++){
    options[x].disabled=false;
 } 
}
</script>';

	echo ' <div class="questionform">
	<form method="POST">'.
	$bigString. '<input type="submit" name="submit" class="button" value="sumbit">
		<br>

    </form>
    </div>';
	
	}

?>

<?php

if (!isset($_POST['submit'])) {
	showForm();
} else {
	
        require_once "DB.class.php";
		$db = new DB();
		


		for ($x = 1; $x < 30; $x++){
			
			$questionid = 'questionId' . $x;
			$question = 'questionAsk' . $x;
			$opti1= 'selectionsA' . $x;
			$opti2 = 'selectionsB' . $x;
			$opti3 = 'selectionsC' . $x;
			$opti4 = 'selectionsD' . $x;
			$answer = 'answer' . $x;
			
			if (isset($_POST[$questionid]) && isset($_POST[$question]) && isset($_POST[$opti1]) && isset($_POST[$opti2]) && isset($_POST[$opti3]) && isset($_POST[$opti4]) && isset($_POST[$answer]) ) {
			if($_POST[$questionid]!='' && $_POST[$question]!='' && $_POST[$opti1]!='' && $_POST[$opti2]!='' && $_POST[$opti3]!='' && $_POST[$opti4]!=''&& $_POST[$answer]!=''){
			
					$questionidnum = ($_POST[$questionid]);
					
					$questionname = ($_POST[$question]);
					
					$selectionA = ($_POST[$opti1]);
					$selectionB = ($_POST[$opti2]);
					$selectionC = ($_POST[$opti3]);
					$selectionD = ($_POST[$opti4]);
					
					$answer1 = ($_POST[$answer]);	
					
					$db->updateQuizQuestion($questionidnum, $questionname, $selectionA,$selectionB,$selectionC,$selectionD, $answer1);

				
			}
		}
		
		}
    
    echo "<script> document.location.href='viewMyQuiz.php?id=$courseid'</script>";

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
