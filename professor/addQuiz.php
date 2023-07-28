<?php
    session_start();
	require_once "MyUtils.class.php";
	$my = new MyUtils();
	$title = "Add Quiz";
	$style = "home_page.css";
	$page = "addQuiz";
    $role = "";
    $eventId = "";
    $style1 = "professor.css";
    $id = "";
    if(isset($_GET['id'])){
        $id = $_GET['id'];
    }
    $role = $_SESSION['role'];
	echo $my->professor_header($title,$style,$style1,$page,$role);
?>

<?php


function showForm($errorMsg=false, $errorTxt="") {

	echo  '
	 	   <div class="feedbackform">
    <form method="POST">

  
        <label>Quiz Title: </label>
   
        <input type="text" name="quiztitle" id="quiztitle" required>
        <br>
        
        <label for="quizdescription">Quiz Description:</label>
        <textarea id="quizdescription" name="quizdescription" required> </textarea>
        <br>

       <label for="availabletime">Available Time:</label>
        <input type="datetime-local" name="availabletime" id="availabletime" required>
        <br>
           
           <label for="enddate">End Time:</label>
            <input type="datetime-local" name="enddate" id="enddate" required>
            <br>
        
        <label for="timelimit">Time Limit (Minutes):</label>
        <input type="number" name="timelimit" id="timelimit" required>
        <br>

        <input type="submit" name="submit" class="button" value="Next">
		<br>

    </form>
</div> 

 ';
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
        	$_SESSION['courseid'] = $id;
    	}

		if (isset($_POST['quiztitle']) && isset($_POST['quizdescription']) && isset($_POST['availabletime']) && isset($_POST['timelimit']) ) {
			if($_POST['quiztitle']!='' && $_POST['quizdescription']!='' && $_POST['availabletime']!='' && $_POST['enddate']!='' && $_POST['timelimit']!='' ){
					$quiztitle = ($_POST['quiztitle']);
					$quizdescription = ($_POST['quizdescription']);	
					$availabletime = ($_POST['availabletime']);
                      $enddate = ($_POST['enddate']);

					$timelimit = ($_POST['timelimit']) ;	 
					$db->addQuiz($quiztitle,$quizdescription,$availabletime,$enddate,$timelimit,$id);

				
			}
		}

}
?>



<?php
	echo $my->html_footer();
?>




