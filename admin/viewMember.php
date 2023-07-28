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

    $data = $db->viewMember($id);
    echo "<h2>Total Member: ".count($data) ."</h2>";
    $owner = "";
    if(isset($_GET['owner'])){
        $owner = $_GET['owner'];
    }
    
    if(isset($_GET['id'])){
        foreach($data as $mem){
            $_SESSION['userRole'] = $mem['userid'];
            $username = $mem['email'];
        
            if($owner == $mem['userid']){
                echo '<li> UserID '.$mem['userid'] .' - ' .$mem['name'] .' (Owner) </li>';
            }
            else{
                echo '<li>UserID '.$mem['userid'] .' - ' .$mem['name'] .' </li>';
            }
        }
    }



?>

        
<?php	
	//check if user login to admin
	if (!isset($_SESSION['event']) && !isset($_GET['id'])) {
        echo "<script>document.location.href='login.php?success=1';</script>";
			exit();
	} 

?>	



<?php
	echo $my->html_footer();
?>


