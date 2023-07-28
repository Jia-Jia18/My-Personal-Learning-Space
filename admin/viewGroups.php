<?php
    session_start();
	require_once "MyUtils.class.php";
	$my = new MyUtils();
	$title = "Search Discussion page";
	$style = "home_page.css";
	$page = "View Groups";
    $url = "";
    $id = "";
    if(isset($_GET['id'])){
        $id = $_GET['id'];
        $url = $id;
    }
    $_SESSION['role'] = $id;
    //var_dump($id);
    require_once "DB.class.php";
	$db = new DB();
	$r = "";

	$data = $db->viewUser();
	foreach($data as $user){     
		if($user->userid == $id){
			$r = $user->role;
		}
	}
	if($r == 1){
		echo $my->admin_header($title,$style,$page,$id);
	}
	else if($r == 2){
		echo $my->professor_header($title,$style,$page,$id);
	}
    else if($r == 3){
      echo $my->student_header($title,$style,$page,$id);
    }
?>
<?php
	require_once "DB.class.php";
	$db = new DB();
    $id = "";
    if(isset($_GET['id'])){
        $id = $_GET['id'];
    }
                
    $data = $db->viewAllDiscussion();
    echo "<h2>Total Discussion Group: ".count($data) ."</h2>";
    
    
    
    $bigString = "<table border='1'  id='myTable'> \n
    
    <input type='text' id='myInput' onkeyup='myFunction()' placeholder='Search for names..' title='Type in a name'>
    
                <tr><th>ID</th><th>Owner</th><th>Type</th><th>Group Name</th><th>Description</th><th>Create Date</th><th>Action</th></tr>\n";
    
    if(isset($_GET['id'])){
        foreach($data as $course){
            $_SESSION['userRole'] = $course->discussionid;
            $type = $course->type;
            $owner = $course->userid;
            if($owner == $id){
                $bigString .=$course->showAllDiscussion("none", "none");
		     
            }
            else{
                if($type == "public"){
                    $bigString .=$course->showAllDiscussion("none", "inline-block");
                
                }
                if($type === "private"){
                    $bigString .=$course->showAllDiscussion("inline-block","none");
                
                }
            }
            
        }
    }

    echo $bigString;


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
	echo '  <script>
function myFunction() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[3];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }       
  }
}
</script>'
?>
