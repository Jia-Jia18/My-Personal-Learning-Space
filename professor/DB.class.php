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

    //View user
    public function viewUser(){
        try{
            $data = [];
            include ("User.class.php");
            $conn = $this->dbconnect();
            $query = "SELECT userid, email, role, password FROM user;";
            $stmt = $conn->prepare($query);
            // $password = hash("sha256", $password);
            // $stmt->execute(["n"=>$username , "pass"=>$password]);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_CLASS,"User");

            while($user=$stmt->fetch()){
                    $data[] = $user;
            }
            
            return $data;
        }//end try
        catch(PDOException	$pe){
            echo $pe->getMessage();
            return [];
        }
    }//end view

      //View invite
      public function viewInvite($id){
        try{
            require_once ("Invite.class.php");
            $conn = $this->dbconnect();
            $query = "select user.userid, user.email, user.fname, user.lname, user.role, invite.discussionid, invite.action from user join invite on user.userid = invite.senderid 
            where invite.userid = :id;";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(":id",$id ,PDO::PARAM_INT);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_CLASS,"Invite");
            $data = [];
            while($user=$stmt->fetch()){
                    $data[] = $user;
            }
            
            return $data;


        }
        catch(PDOException	$pe){
            echo $pe->getMessage();
            return -1;
        }


    }//end view
    
    //deny invite
    public function denyGroupInvite($discussionid, $userid){
        try{
        	$conn = $this->dbconnect();
            $query = "UPDATE invite SET action = 'deny' where discussionid = :n and userid = :u";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(":n",$discussionid ,PDO::PARAM_INT);
            $stmt->bindParam(":u",$userid ,PDO::PARAM_INT);
            $stmt->execute();

			

            $query2 = "delete from invite where discussionid = :n and userid = :u;";
			$stmt2 = $conn->prepare($query2);
			$stmt2->bindParam(":n",$discussionid ,PDO::PARAM_INT);
          	$stmt2->bindParam(":u",$userid ,PDO::PARAM_INT);
    		$stmt2->execute();
    		
   			echo "<script>if(confirm('you deny this invite')){document.location.href='viewMyGroups.php?id=$userid'};</script>";

        }
        catch(PDOException	$pe){
            echo $pe->getMessage();
        }
    
    }//end edit course

public function approveGroupInvite($discussionid, $userid){
        try{
        	$conn = $this->dbconnect();
            $query = "UPDATE invite SET action = 'approve' where discussionid = :n and userid = :u";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(":n",$discussionid ,PDO::PARAM_INT);
            $stmt->bindParam(":u",$userid ,PDO::PARAM_INT);
            $stmt->execute();
            
            
            $query1 = "INSERT INTO attend_discussion(discussionid, userid)VALUES (:discussionid, (SELECT userid FROM user WHERE userid = :userid));";
			$stmt1 = $conn->prepare($query1);
			$stmt1->bindParam(":discussionid",$discussionid ,PDO::PARAM_INT);
          	$stmt1->bindParam(":userid",$userid ,PDO::PARAM_INT);
    		$stmt1->execute();
    		


            $query2 = "delete from invite where discussionid = :n and userid = :u;";
			$stmt2 = $conn->prepare($query2);
			$stmt2->bindParam(":n",$discussionid ,PDO::PARAM_INT);
          	$stmt2->bindParam(":u",$userid ,PDO::PARAM_INT);
    		$stmt2->execute();

   			echo "<script>if(confirm('approved')){document.location.href='viewMyGroups.php?id=$userid'};</script>";

        }
        catch(PDOException	$pe){
            echo $pe->getMessage();
        }
    
    }//end edit course

     //View courses
     public function viewAllCourses($id){
        try{
            $data = [];
            include ("Courses.class.php");
            $conn = $this->dbconnect();
            $query = "select DISTINCT courseid, courseName, description, preRequire, userid from course where userid = :id";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(":id",$id ,PDO::PARAM_INT);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_CLASS,"Courses");

            while($event=$stmt->fetch()){
                    $data[] = $event;
            }
            
            return $data;
        }//end try
        catch(PDOException	$pe){
            echo $pe->getMessage();
            return [];
        }


    }//end view

    //View courses
    public function viewOneCourse($id){
            try{
                $data = [];
                require_once ("Courses.class.php");
                $conn = $this->dbconnect();
                $query = "select DISTINCT courseid, courseName, description, preRequire, userid from course where courseid = :id";
                $stmt = $conn->prepare($query);
                $stmt->bindParam(":id",$id ,PDO::PARAM_INT);
                $stmt->execute();
                $stmt->setFetchMode(PDO::FETCH_CLASS,"Courses");
    
                while($event=$stmt->fetch()){
                        $data[] = $event;
                }
                
                return $data;
            }//end try
            catch(PDOException	$pe){
                echo $pe->getMessage();
                return [];
            }
    
    
        }//end view
    //add course
    public function addLecture($coursename, $description, $courseID,$filename){
        try{
            $id = "";
            $conn = $this->dbconnect();
            $query = "INSERT INTO lecture SET lectureName = :n, description = :des, courseid = :id, filename=:f;";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(":n",$coursename ,PDO::PARAM_STR);
            $stmt->bindParam(":des",$description ,PDO::PARAM_STR);
            $stmt->bindParam(":f",$filename ,PDO::PARAM_STR);
            $stmt->bindParam(":id", $courseID ,PDO::PARAM_INT);
            $stmt->execute();
    
        }
        catch(PDOException	$pe){
            echo $pe->getMessage();
        }
    }

public function addQuiz($quiztitle,$quizdescription,$availabletime, $enddate ,$timelimit,$courseid){
    try{
      $conn = $this->dbconnect();
      $query = "INSERT INTO quiz SET quizname = :q, description = :d, timelimit = :t, availabledate = :a,  enddate = :e, courseid = :id;";
      $stmt = $conn->prepare($query);
      $stmt->bindParam(":q",$quiztitle,PDO::PARAM_STR);
      $stmt->bindParam(":d",$quizdescription ,PDO::PARAM_STR);
      $stmt->bindParam(":t",$timelimit ,PDO::PARAM_STR);
      $stmt->bindParam(":a", $availabletime ,PDO::PARAM_STR);
      $stmt->bindParam(":e", $enddate ,PDO::PARAM_STR);
      $stmt->bindParam(":id", $courseid ,PDO::PARAM_STR);
      $stmt->execute();
      
      $id = $conn->lastInsertId();
      
      echo "<script> document.location.href='questions.php?id=$id'</script>";

  }
  catch(PDOException	$pe){
      echo $pe->getMessage();
  }
}


public function viewMyQuiz($id){
    try{
        $data = [];
        require_once ("viewMyQuiz.class.php");
        $conn = $this->dbconnect();
        $query = "select quizid, courseid, quizname, description, timelimit, availabledate, enddate from quiz WHERE courseid = :id;";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(":id",$id ,PDO::PARAM_INT);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS,"viewMyQuiz");

        while($event=$stmt->fetch()){
                $data[] = $event;
        }
        
        return $data;
    }//end try
    catch(PDOException	$pe){
        echo $pe->getMessage();
    }
}

//deleteQuiz
    public function deleteQuiz($id){
        try{
            $conn = $this->dbconnect();
            $query = "delete from quiz where quizid = :id;";
            $stmt = $conn->prepare($query);
            $stmt->execute(["id"=>$id]);
            


            $query2 = "delete from quiz_question where quizid = :id;";
			$stmt2 = $conn->prepare($query2);
			$stmt2->bindParam(":id",$id,PDO::PARAM_INT);
    		$stmt2->execute();
            
            
        }//end try
        catch(PDOException	$pe){
            echo $pe->getMessage();
            return [];
        }
    
    
    }//end delete
    
    public function addQuizQuestion($quizid, $question, $selectionA,$selectionB,$selectionC,$selectionD, $answer){
        try{
            $conn = $this->dbconnect();
            $query = "INSERT INTO quiz_question SET quizid = :t, question = :n, selectionA = :a, selectionB = :b, selectionC = :c , selectionD = :d,answer = :ans;";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(":t",$quizid,PDO::PARAM_INT);
            $stmt->bindParam(":n",$question ,PDO::PARAM_STR);
            $stmt->bindParam(":a",$selectionA ,PDO::PARAM_STR);
            $stmt->bindParam(":b",$selectionB ,PDO::PARAM_STR);
            $stmt->bindParam(":c",$selectionC ,PDO::PARAM_STR);
            $stmt->bindParam(":d",$selectionD ,PDO::PARAM_STR);
            $stmt->bindParam(":ans", $answer ,PDO::PARAM_STR);
            $stmt->execute();
            
    

        }
        catch(PDOException	$pe){
            echo $pe->getMessage();
        }
    }
    
    public function viewMyQuestion($id){
        try{
            $data = [];
            require_once ("viewMyQuestion.class.php");
            $conn = $this->dbconnect();
            $query = "select questionid, quizid, question, selectionA, selectionB, selectionC, selectionD, answer from quiz_question WHERE quizid = :id;";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(":id",$id ,PDO::PARAM_INT);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_CLASS,"viewMyQuestion");

            while($event=$stmt->fetch()){
                    $data[] = $event;
            }
            
            return $data;
        }//end try
        catch(PDOException    $pe){
            echo $pe->getMessage();
        }
    }

       //View courses
       public function viewAllLecture($id){
        try{
            $data = [];
            include ("Lectures.class.php");
            $conn = $this->dbconnect();
            $query = "select * from lecture where courseid = :id";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(":id",$id ,PDO::PARAM_INT);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_CLASS,"Lectures");

            while($event=$stmt->fetch()){
                    $data[] = $event;
            }
            
            return $data;
        }//end try
        catch(PDOException	$pe){
            echo $pe->getMessage();
            return [];
        }


    }//end view

    public function deleteLecture($id){
        try{
            $conn = $this->dbconnect();
            $query = "delete from lecture where lectureid = :id;";
            $stmt = $conn->prepare($query);
            $stmt->execute(["id"=>$id]);
            

            
            
        }//end try
        catch(PDOException	$pe){
            echo $pe->getMessage();
            return [];
        }
    
    
    }//end delete

     //View courses
     public function viewPublicCourses(){
        try{
            $data = [];
            include ("PublicCourses.class.php");
            $conn = $this->dbconnect();
            $query = "select DISTINCT courseid, courseName, description, preRequire, userid from course";
            $stmt = $conn->prepare($query);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_CLASS,"PublicCourses");

            while($event=$stmt->fetch()){
                    $data[] = $event;
            }
            
            return $data;
        }//end try
        catch(PDOException	$pe){
            echo $pe->getMessage();
            return [];
        }


    }//end view

    //View courses
    public function viewOneLecture($id){
    try{
        $data = [];
        include ("Lectures.class.php");
        $conn = $this->dbconnect();
        $query = "select * from lecture where lectureid = :id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(":id",$id ,PDO::PARAM_INT);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS,"Lectures");

        while($event=$stmt->fetch()){
                $data[] = $event;
        }
        
        return $data;
    }//end try
    catch(PDOException	$pe){
        echo $pe->getMessage();
        return [];
    }


}//end view

    public function viewOneQuiz($id){
        try{
            $data = [];
            include ("viewOneQuiz.class.php");
            $conn = $this->dbconnect();
            $query = "select quizid, courseid, quizname, description, timelimit, 

            CONCAT((cast(availabledate as DATE)),'T',cast(availabledate as TIME)) as availabledate, CONCAT((cast(enddate as DATE)),'T',cast(enddate as TIME)) as enddate from quiz WHERE quizid = :id;";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(":id",$id ,PDO::PARAM_INT);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_CLASS,"viewOneQuiz");

            while($event=$stmt->fetch()){
                    $data[] = $event;
            }
            
            return $data;
        }//end try
        catch(PDOException    $pe){
            echo $pe->getMessage();
        }
    }

    public function updateQuizQuestion($questionid, $question, $selectionA,$selectionB,$selectionC,$selectionD, $answer){
        try{
            $conn = $this->dbconnect();
            $query = "UPDATE quiz_question SET question = :n, selectionA = :a, selectionB = :b, selectionC = :c , selectionD = :d,answer = :ans where questionid = :id;";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(":id",$questionid,PDO::PARAM_INT);
            $stmt->bindParam(":n",$question ,PDO::PARAM_STR);
            $stmt->bindParam(":a",$selectionA ,PDO::PARAM_STR);
            $stmt->bindParam(":b",$selectionB ,PDO::PARAM_STR);
            $stmt->bindParam(":c",$selectionC ,PDO::PARAM_STR);
            $stmt->bindParam(":d",$selectionD ,PDO::PARAM_STR);
            $stmt->bindParam(":ans", $answer ,PDO::PARAM_STR);
            $stmt->execute();
            
    

        }
        catch(PDOException	$pe){
            echo $pe->getMessage();
        }
    }
    
    
    public function updateQuiz($quizid,$quiztitle,$quizdescription,$availabletime,$enddate,$timelimit){
        try{
            $conn = $this->dbconnect();
            $query = "UPDATE quiz SET quizname = :q, description = :d, timelimit = :t, availabledate = :a, enddate = :e where quizid = :id;";
            $stmt = $conn->prepare($query);
            $stmt = $conn->prepare($query);
      		$stmt->bindParam(":q",$quiztitle,PDO::PARAM_STR);
      		$stmt->bindParam(":d",$quizdescription ,PDO::PARAM_STR);
      		$stmt->bindParam(":t",$timelimit ,PDO::PARAM_STR);
      		$stmt->bindParam(":a", $availabletime ,PDO::PARAM_STR);
            $stmt->bindParam(":e", $enddate ,PDO::PARAM_STR);
      		$stmt->bindParam(":id", $quizid ,PDO::PARAM_INT);
      		$stmt->execute();
            
    

        }
        catch(PDOException	$pe){
            echo $pe->getMessage();
        }
    }

//update lecture
    public function updateLecture($coursename, $description, $courseID,$filename, $id){
        try{
            $conn = $this->dbconnect();
            $query = "update lecture SET lectureName = :n, description = :des,filename = :f,courseid = :courseID where lectureid = :id;";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(":n",$coursename ,PDO::PARAM_STR);
            $stmt->bindParam(":des",$description ,PDO::PARAM_STR);
            $stmt->bindParam(":f",$filename ,PDO::PARAM_STR);
            $stmt->bindParam(":courseID", $courseID ,PDO::PARAM_INT);
            $stmt->bindParam(":id", $id ,PDO::PARAM_INT);
            $stmt->execute();
    
        }
        catch(PDOException	$pe){
            echo $pe->getMessage();
        }
    }


//add share lecture
    public function shareLecture($time,$id){
        try{
            $conn = $this->dbconnect();
            $query = "update lecture SET availabledate = :time where lectureid = :id;";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(":time",$time ,PDO::PARAM_STR);
            $stmt->bindParam(":id", $id ,PDO::PARAM_INT);
            $stmt->execute();
    
        }
        catch(PDOException	$pe){
            echo $pe->getMessage();
        }
    }


}//end class

?>
