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

     //View courses
     public function viewAllCourses($id){
        try{
            $data = [];
            include ("Courses.class.php");
            $conn = $this->dbconnect();
            $query = "select course.courseid, course.courseName, course.description, course.preRequire, course.userid from course 
join student_course on student_course.courseid = course.courseid 
where student_course.userid = :id;";
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
   

public function viewMyQuiz($id){
    try{
        $data = [];
        require_once ("viewMyQuiz.class.php");
        $conn = $this->dbconnect();
        $query = "select quizid, courseid, quizname, description, timelimit, availabledate from quiz WHERE courseid = :id;";
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

public function viewMyQuiz1($id){
    try{
        $data = [];
        require_once ("viewMyQuiz.class.php");
        $conn = $this->dbconnect();
        $query = "select quizid, courseid, quizname, description, timelimit, availabledate from quiz WHERE quizid = :id;";
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
           }

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
            CONCAT((cast(availabledate as DATE)),'T',cast(availabledate as TIME)) as availabledate,
            CONCAT((cast(enddate as DATE)),'T',cast(enddate as TIME)) as enddate from quiz WHERE quizid = :id;";
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

    
   public function enroll($courseid, $userid){
        try{

            $conn = $this->dbconnect();
            $query1 = "SELECT * FROM student_course where courseid = :t and userid = :n;";
            $stmt1 = $conn->prepare($query1);
            $stmt1->bindParam(":t",$courseid,PDO::PARAM_INT);
            $stmt1->bindParam(":n",$userid ,PDO::PARAM_INT);
            $stmt1->execute();
            $data = [];
            while($row=$stmt1->fetch(PDO::FETCH_ASSOC)){
                $data[] = $row;
            }
            if($data == null){

                $conn = $this->dbconnect();
                $query = "INSERT INTO student_course SET courseid = :t, userid = :n;";
                $stmt = $conn->prepare($query);
                $stmt->bindParam(":t",$courseid,PDO::PARAM_INT);
                $stmt->bindParam(":n",$userid ,PDO::PARAM_INT);
                $stmt->execute();
                
                echo "<script>if(confirm('Enroll Success')){document.location.href='viewAllCourse.php?id=$userid'};</script>";
            }
            else{
                echo "<script>if(confirm('You already enroll this course!')){document.location.href='viewAllCourse.php?id=$userid'};</script>";
            }
        }
        catch(PDOException	$pe){
            echo $pe->getMessage();
        }
    }

    //View Rating 
    public function viewAllRating(){
        try{
            $data = [];
            include ("Rating.class.php");
            $conn = $this->dbconnect();
            $query = "select DISTINCT rateid, type, name, rating, comment from rating";
            $stmt = $conn->prepare($query);
            //$stmt->bindParam(":id",$id ,PDO::PARAM_INT);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_CLASS,"Rating");

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

 //add feedback
    public function addFeedback($name, $type, $rate, $comment){
        try{
            $conn = $this->dbconnect();
            $query = "INSERT INTO rating SET type = :t, name = :n, rating = :r, comment = :c;";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(":t",$type,PDO::PARAM_STR);
            $stmt->bindParam(":n",$name ,PDO::PARAM_STR);
            $stmt->bindParam(":r",$rate ,PDO::PARAM_STR);
            $stmt->bindParam(":c", $comment ,PDO::PARAM_STR);
            $stmt->execute();

        }
        catch(PDOException	$pe){
            echo $pe->getMessage();
        }
    }


public function insertEachQuiz($quizid, $userid, $studentchose, $take, $answer, $grade){
        try{
            $conn = $this->dbconnect();
            $query = "INSERT INTO quiz_take SET quizid = :q, userid = :i, studentchose = :s, take = :t, answer = :a, grade = :g;";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(":q",$quizid,PDO::PARAM_INT);
            $stmt->bindParam(":i",$userid ,PDO::PARAM_INT);	
            $stmt->bindParam(":s",$studentchose,PDO::PARAM_STR);
            $stmt->bindParam(":t",$take,PDO::PARAM_STR);
        	$stmt->bindParam(":a",$answer,PDO::PARAM_STR);
            $stmt->bindParam(":g",$grade ,PDO::PARAM_STR);
            $stmt->execute();

        }
        catch(PDOException	$pe){
            echo $pe->getMessage();
        }
    }
    
 public function viewMyResult($qid,$userid){
        try{
            $data = [];
            include ("QuizResult.class.php");
            $conn = $this->dbconnect();
            $query = "SELECT quizid,userid,studentchose, answer, grade from quiz_take WHERE quizid =:q AND userid = :u;";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(":q",$qid ,PDO::PARAM_INT);
            $stmt->bindParam(":u",$userid ,PDO::PARAM_INT);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_CLASS,"QuizResult");

            while($event=$stmt->fetch()){
                    $data[] = $event;
            }
            
            return $data;
        }//end try
        catch(PDOException    $pe){
            echo $pe->getMessage();
        }
    }




}//end class

?>
