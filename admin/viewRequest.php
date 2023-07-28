
<?php
    session_start();
	require_once "MyUtils.class.php";
	$my = new MyUtils();
	$title = "view page";
	$style = "home_page.css";
	$page = "View Request";
    $url = "";
    $role = "";
    $data = [];
    $name = "";
    $attendeeid = "";


    if(isset($_GET['id'])){
        $id = $_GET['id'];
        $url = $id;
    }

    if(isset($_SESSION['role'])){
        $role =  $_SESSION['role'];
    }
    //var_dump($role);
	echo $my->admin_header($title,$style,$page,$role);
?>
<?php
	require_once "DB.class.php";
	$db = new DB();
    //delete user
    $id = "";
    $data = [];
    $data1 = [];
    
    if(isset($_GET['id'])){
        $id = $_GET['id'];
        $data = $db->viewRequest($id);
        echo "<h2>Total Request for Disscussion Group ID ".$id ."</h2>";
        $bigString = "";
        $bigString = "<table border='1'> \n
                    <tr><th>StudentID</th><th>Username</th><th>First Name</th><th>Last Name</th><th>DiscussionID</th><th>Role</th><th>Status</th><th>Action</th></tr>\n";
        $_SESSION['discussion'] = $id;
        foreach($data as $course){
            $action = $course->action;
            if($action == "approve" || $action == "deny"){
                $bigString .= $course->showAllRequest("none");
            }
            else{
                $bigString .= $course->showAllRequest("inline-block");
            }
        }
    
        echo $bigString;
    }


    
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
