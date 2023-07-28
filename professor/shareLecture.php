<?php
    session_start();
	require_once "MyUtils.class.php";
	$my = new MyUtils();
	$title = "Lecture page";
	$style = "home_page.css";
	$page = "Share Lecture";
	$style1 = "professor.css";
    $role = "";
    $eventId = "";
    if(isset( $_SESSION['role'])){
    	$role =  $_SESSION['role'];
    }
    $role = $_SESSION['role'];
	$id = $_GET['id'];
	echo $my->professor_header($title,$style,$style1,$page,$role);
?>

 <div class="feedbackform">
    <form method="POST">
            <label for="availabletime">Available Time:</label>
            <input type="datetime-local" name="availabletime" id="availabletime" required>
            <br>

            <br><br>

            <input type="submit" name="submit" class="button" value="Schedule">
		<br>
	</form>
</div>

<?php

    require_once "DB.class.php";
    $db = new DB();

    if (isset($_POST['availabletime']) ) {
        if($_POST['availabletime']!=''){
            $time = ($_POST['availabletime']);
                $id = "";	
                $courseid = "";				
                if(isset($_GET['id'])){
                    $id = $_GET['id'];
                    $courseid = $_GET['courseid'];
                }
                $db->shareLecture($time,$id);
                echo "<script>if(confirm('Sucessfully added.')){document.location.href='viewLecture.php?id=$courseid'};</script>";
        }
    }
?>

<?php
	echo $my->html_footer();
?>


