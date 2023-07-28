<?php
    session_start();
	require_once "MyUtils.class.php";
	$my = new MyUtils();
	$title = "Modify Quiz";
	$style = "home_page.css";
	$page = "Modify Quiz";
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
                
    $data = $db->viewOneQuiz($id);
    
    $bigString = "";
    
    if(isset($_GET['id'])){
        foreach($data as $quiz){
            $_SESSION['userRole'] = $quiz->quizid;
            $bigString .=$quiz->showOneQuiz();
        }
    }

    echo ' <div class="quizform">
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
		if(isset($_GET['id'])){
        $id = $_GET['id'];
    	}
		
	if (isset($_POST['quiztitle']) && isset($_POST['quizdescription']) && isset($_POST['availabletime']) && isset($_POST['timelimit']) ) {
		if($_POST['quiztitle']!='' && $_POST['quizdescription']!='' && $_POST['availabletime']!='' && $_POST['timelimit']!=''){
			$quiztitle = ($_POST['quiztitle']);
					
			$quizdescription = ($_POST['quizdescription']);
					
					$availabletime = ($_POST['availabletime']);
					$timelimit= ($_POST['timelimit']);

					
					$db->updateQuiz($id,$quiztitle,$quizdescription,$availabletime,$timelimit);

				
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
