<?php
    session_start();
	require_once "MyUtils.class.php";
	$my = new MyUtils();
	$title = "Join page";
	$style = "home_page.css";
	$page = "Join";
    $role = "";
    $eventId = "";
    if(isset( $_SESSION['role'])){
		$role =  $_SESSION['role'];
    }
    $_SESSION['admin'] =  $role;
	echo $my->admin_header($title,$style,$page,$role);
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

			
                if(isset($_GET['id'])){
                    $id = $_GET['id'];
                    $_SESSION['discussion'] = $role;
                    $_SESSION['id'] = $id; 
                }

				$db->joinGroup($id, $role);
				echo "<script>if(confirm('Join Group.')){document.location.href='viewGroups.php?id=$role'};</script>";                
    

?>

<?php
	echo $my->html_footer();
?>


