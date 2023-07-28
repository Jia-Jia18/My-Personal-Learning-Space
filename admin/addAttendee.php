<?php
    session_start();
	require_once "MyUtils.class.php";
	$my = new MyUtils();
	$title = "discussion page";
	$style = "home_page.css";
	$page = "Assign Members";
    $role = "";
    $eventId = "";
    if(isset( $_SESSION['role'])){
    	$role =  $_SESSION['role'];
    }
    $_SESSION['admin'] = $role;
	echo $my->admin_header($title,$style,$page,$role);
?>  
<?php	
	//check if user login to admin
	if (!isset($_SESSION['discussion']) && !isset($_GET['id'])) {
        echo "<script>document.location.href='login.php?success=1';</script>";
			exit();
	} 

?>	

<?php

    require_once "DB.class.php";
    $db = new DB();

    if (isset($_POST['user']) ) {
        if($_POST['user']!=''){
                $user = ($_POST['user']);
                $id = "";					
                if(isset($_GET['id'])){
                    $id = $_GET['id'];
                    $_SESSION['discussion'] = $role;
                    $_SESSION['id'] = $id; 
                }

                foreach ($user as $u){ 
                    //echo $u."<br />";
                    $db->addAttendee($id, $u);
                }
                
                echo "<script>if(confirm('successful add.')){document.location.href='viewMyGroups.php?id=$role'};</script>";
                

                //$eventId = $db->getEventId($name);
                //event id and manager id
                //$db->addManagerEvent($eventId,$id);
                //success
        }
    }
			
?>
<?php
	echo '
    <div class="assignMembers">    
        <form method="POST">';
   echo  '
            <br>

			';
			require_once "DB.class.php";
			$id = "";					
					if(isset($_GET['id'])){
						$id = $_GET['id'];
						$_SESSION['id'] = $id; 
					}
			$db = new DB();
			$data = $db->viewAllMember($id);

			foreach($data as $member){
                echo "<input type='checkbox' name='user[]' value='$member->userid'>
                <label>$member->name</label><br>";
			}
			
			
			
	echo'
                        
    <br><br>
    <div class ="addMemberButton">
    <input type="submit" name="submit"  class="button"  value="Add" />
    </div>
            
        </form>
	';

?>
      
<?php
	echo $my->html_footer();
?>


