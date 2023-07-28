<?php
class DB{
	
	function dbconnect(){
        return new PDO("mysql:host={$_SERVER['DB_SERVER']};dbname={$_SERVER['DB']}",
        $_SERVER['DB_USER'],$_SERVER['DB_PASSWORD']);
		
		if($this->sql->connect_errno){
			echo "connect failed: ".mysqli_connect_error();
			die();
		}
	}
	//register function
    public function addUser($email, $fname, $lname, $password, $role, $confirm){
        try{
            $conn = $this->dbconnect();
            $stmt1 = $conn->prepare("select email from user where email = :n");
            $stmt1->bindParam(":n",$email ,PDO::PARAM_STR);
            $stmt1->execute();
            $data = [];
            while($row=$stmt1->fetch(PDO::FETCH_ASSOC)){
                $data[] = $row;
            }
            if($data == null){
                $query = "INSERT INTO user SET email = :email, fname = :fname, lname = :lname, password = :pass, role = :r, confirmation = :c, active = 'N';";
                //$password = hash("sha256", $password);
                $stmt = $conn->prepare($query);
                $stmt->bindParam(":email",$email ,PDO::PARAM_STR);
                $stmt->bindParam(":fname",$fname ,PDO::PARAM_STR);
                $stmt->bindParam(":lname",$lname ,PDO::PARAM_STR);
                $stmt->bindParam(":pass",$password ,PDO::PARAM_STR);
                $stmt->bindParam(":r",$role ,PDO::PARAM_INT);
                $stmt->bindParam(":c",$confirm ,PDO::PARAM_INT);
                $stmt->execute();
                
                
            }
            else{
                echo "<script>if(confirm('email already been registered.')){document.location.href='register.php'} else{document.location.href='register.php'};</script>";
            }
        }
        catch(PDOException	$pe){
            echo $pe->getMessage();
        }
    }
    //check name and password
    public function login($name, $password){
        try{
            $conn = $this->dbconnect();
            $stmt = $conn->prepare("SELECT * FROM user WHERE email = :n AND password = :pass;");
            //$password = hash("sha256", $password);
            $stmt->bindParam(":n",$name ,PDO::PARAM_STR);
            $stmt->bindParam(":pass",$password ,PDO::PARAM_STR);
            $stmt->execute();
            $data = [];
            while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
                $data[] = $row;
            }
            if($data != null){
                //use session
                //var_dump($data);
                foreach($data as $row){
                    $role = $row['role'];
                    $active = $row['active'];
                }
                if($role == 1 && $active == "Y"){
                    $_SESSION['userRole'] = "admin";
                    echo "<script>if(confirm('Sucessfully Login')){document.location.href='admin/myPLS.php?id={$row['userid']}'}  else{document.location.href='login.php'};</script>";
                }
                else if($role == 2 && $active == "Y"){
                    $_SESSION['userRole'] = "professor";
                    echo "<script>if(confirm('Sucessfully Login')){document.location.href='professor/professor.php?id={$row['userid']}'} else{document.location.href='login.php'};</script>";
                }
                else if($role == 3 && $active == "Y"){ 
                    $_SESSION['userRole'] = "student";
                    echo "<script>if(confirm('Sucessfully Login')){document.location.href='student/student.php?id={$row['userid']}'}  else{document.location.href='login.php'};</script>";
                }
            }//end if
            else{
                echo "<script>if(confirm('Login Failed')){document.location.href='notauthorized.php'} else{document.location.href='notauthorized.php'};</script>";
            }
        }//end try
        catch(PDOException	$pe){
            echo $pe->getMessage();
        }
    }
    //View user
    public function confirm($email, $confirm){
        try{
            $data = [];
            $conn = $this->dbconnect();
            $query = "select email, confirmation from user where email = :email and confirmation = :c;";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(":email",$email ,PDO::PARAM_STR);
            $stmt->bindParam(":c",$confirm ,PDO::PARAM_INT);
    
            $stmt->execute();
            while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
                $data[] = $row;
            }
            if($data != null){
                $stmt1 = $conn->prepare("Update user set active = 'Y' where email = :email");
                $stmt1->bindParam(":email",$email ,PDO::PARAM_STR);
                $stmt1->execute();
                echo "<script>if(confirm('Sucessfully confirm')){document.location.href='login.php'};</script>";
            }
            else{
                echo "<script>if(confirm('Username or confirm code incorrect')){document.location.href='confirm.php'};</script>";
            }
                
            
            }//end try
            catch(PDOException	$pe){
                echo $pe->getMessage();
            }
    
    
        }//end view
    
    

}//end class

?>