<?php
    session_start();
	require_once "MyUtils.class.php";
	$my = new MyUtils();
	$title = "Discussion";
	$style = "home_page.css";
	$page = "Discussion Page";
    $role = "";
    $eventId = "";
    if(isset( $_SESSION['role'])){
    	$role =  $_SESSION['role'];
    }
    $_SESSION['admin'] = $role;
	echo $my->admin_header($title,$style,$page,$role);
?>

<?php
	require_once "DB.class.php";
	$db = new DB();
    $id = "";
    if(isset($_GET['id'])){
        $id = $_GET['id'];
    }
                
    $data = $db->viewAllDisscussionContent($id);
    
    $bigString = "<div class='allContent'> \n";
    
    if(isset($_GET['id'])){
        foreach($data as $course){
            $_SESSION['userRole'] = $course->discussionid;
            $bigString .=$course->showAllDisscussionContent();
        }
    }

    echo $bigString;
    	echo'</div> 

    	';


?>


<?php
	echo '

    <div class="MyDiscussionGroup">    
    <h2>Post Discussion</h2>
        <form method="POST">
   			<label for="name">Title: </label>
            <input type="text" name="name" id="name" required />
            <br>
                        
            <label for="content">Content:</label>
            <textarea id="content" name="content" required> </textarea>

 
            <br><br>
            <input type="submit" name="submit"  class="button"  value="Add" />
            
        </form>
	</div>';

?>
        
<?php	
	//check if user login to admin
	if (!isset($_SESSION['event']) && !isset($_GET['id'])) {
        echo "<script>document.location.href='login.php?success=1';</script>";
			exit();
	} 

?>	

<?php
	require_once "DB.class.php";
	$db = new DB();

	if (isset($_POST['name']) && isset($_POST['content'])  ) {
		if($_POST['name']!='' && $_POST['content']!='' ){
				$name = ($_POST['name']);
				$description = ($_POST['content']);		
				$id = "";		
				if(isset($_GET['id'])){
					$id = $_GET['id'];
					$_SESSION['event'] = $name;
					$_SESSION['id'] = $id; 
				}
				$db->addContent($id,$role,$name,$description);
				echo "<script>if(confirm('Sucessfully posted.')){document.location.href='post.php?id=$id'};</script>";
				
		}
	}

?>

<?php
	echo $my->html_footer();
	

?>


