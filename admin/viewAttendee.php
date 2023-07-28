
<?php
    session_start();
	require_once "MyUtils.class.php";
	$my = new MyUtils();
	$title = "view page";
	$style = "home_page.css";
	$page = "View Attendee";
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
        $data = $db->viewAttendee($id);
        $bigString = "";
        $bigString = "<table border='1'> \n
                    <tr><th>StudentID</th><th>Username</th><th>First Name</th><th>Last Name</th><th>Role</th></tr>\n";
        
        foreach($data as $user){
            $_SESSION['userRole'] = $user->role;
                $bigString .=$user->addAttendee();
        }
    
        echo $bigString;
    }

    if(isset($_GET['id'])){
        $id = $_GET['id'];
        $data1 = $db->viewAssignedProfessor($id);
        $bigString1 = "";

        $total = count($data)+count($data1);
        echo "<h2>Classlist: ".$total." </h2>";

        $bigString1 = "<table border='1'> \n
                    <tr><th>ProfessorID</th><th>Username</th><th>First Name</th><th>Last Name</th><th>Role</th></tr>\n";
        

        foreach($data1 as $user){
            $_SESSION['userRole'] = $user->role;
                $bigString1 .=$user->addAttendee();
        }
    
        echo $bigString1;
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
