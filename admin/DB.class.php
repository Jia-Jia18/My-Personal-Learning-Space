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

    //add attendee function
    public function addAttendee($discussionid, $userid){
        try{
            $conn = $this->dbconnect();
            $stmt1 = $conn->prepare("select discussionid, userid from attend_discussion 
            where discussionid = :discussionid and userid = :userid;");
            $stmt1->bindParam(":discussionid",$discussionid ,PDO::PARAM_INT);
            $stmt1->bindParam(":userid",$userid ,PDO::PARAM_INT);
            $stmt1->execute();
            $data = [];
            while($row=$stmt1->fetch(PDO::FETCH_ASSOC)){
                $data[] = $row;
            }
            if($data == null){
                $query = "INSERT INTO attend_discussion(discussionid, userid)VALUES (:discussionid, (SELECT userid FROM user WHERE userid = :userid));";
                //$password = hash("sha256", $password);
                $stmt = $conn->prepare($query);
                $stmt->bindParam(":discussionid",$discussionid ,PDO::PARAM_INT);
                $stmt->bindParam(":userid",$userid ,PDO::PARAM_INT);
                $stmt->execute();
            }
            else{
                echo "<script>if(confirm('User $userid Already attend this group discussion.')){document.location.href='addAttendee.php?id=$discussionid'} else{document.location.href='register.php'};</script>";
            }
        }
        catch(PDOException	$pe){
            echo $pe->getMessage();
        }
    }

    //view member function
    public function viewMember($discussionid){
        try{
            $conn = $this->dbconnect();
            $stmt = $conn->prepare("select user.email, discussionid, attend_discussion.userid, concat(fname,' ',lname ,' (',email,')') as name from attend_discussion join user
            on attend_discussion.userid = user.userid where discussionid = :discussionid;");
            $stmt->bindParam(":discussionid",$discussionid ,PDO::PARAM_INT);
            $stmt->execute();
            $data = [];
            while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
                    $data[] = $row;
            }
            
            return $data;
        }
        catch(PDOException	$pe){
            echo $pe->getMessage();
        }
    }

      //view member function
      public function viewMember1($discussionid){
        try{
            require_once ("Members.class.php");
            $conn = $this->dbconnect();
            $stmt = $conn->prepare("select user.email, discussionid, attend_discussion.userid, concat(fname,' ',lname ,' (',email,')') as name from attend_discussion join user
            on attend_discussion.userid = user.userid where discussionid = :discussionid;");
            $stmt->bindParam(":discussionid",$discussionid ,PDO::PARAM_INT);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_CLASS,"Members");

            while($event=$stmt->fetch()){
                    $data[] = $event;
            }
            return $data;
        }
        catch(PDOException	$pe){
            echo $pe->getMessage();
        }
    }

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
    
     //add course
     public function addCourse($coursename, $description, $preRequire, $userID){
        try{
            $id = "";
            $conn = $this->dbconnect();
            $query = "INSERT INTO course SET courseName = :n, description = :des, preRequire = :preq, userid = :id;";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(":n",$coursename ,PDO::PARAM_STR);
            $stmt->bindParam(":des",$description ,PDO::PARAM_STR);
            $stmt->bindParam(":preq",$preRequire ,PDO::PARAM_STR);
            $stmt->bindParam(":id", $userID ,PDO::PARAM_INT);
            $stmt->execute();
            
            $id = $conn->lastInsertId();
            $query1 = "INSERT INTO professor_course (courseid, userid) values (:courseid,:userid);";
            $stmt1 = $conn->prepare($query1);
            $stmt1->bindParam(":courseid",$id ,PDO::PARAM_STR);
            $stmt1->bindParam(":userid",$userID ,PDO::PARAM_STR);
            $stmt1->execute();

        }
        catch(PDOException	$pe){
            echo $pe->getMessage();
        }
    }

//add discussion
     public function addDiscussion($type,$dName,$description,$createdate,$userid){
        try{
        	$id = "";
            $conn = $this->dbconnect();
            $query = "INSERT INTO discussion SET type = :ty, dName = :n, description = :des, createdate = :date, userid = :id;";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(":ty",$type ,PDO::PARAM_STR);
            $stmt->bindParam(":n",$dName ,PDO::PARAM_STR);
            $stmt->bindParam(":des",$description ,PDO::PARAM_STR);
            $stmt->bindParam(":date",$createdate ,PDO::PARAM_STR);
            $stmt->bindParam(":id", $userid ,PDO::PARAM_INT);
            $stmt->execute();
            
            
            $id = $conn->lastInsertId();
            $query1 = "INSERT INTO attend_discussion (discussionid, userid) values (:di,:userid);";
            $stmt1 = $conn->prepare($query1);
            $stmt1->bindParam(":di",$id ,PDO::PARAM_STR);
            $stmt1->bindParam(":userid",$userid ,PDO::PARAM_STR);
            $stmt1->execute();

        }
        catch(PDOException	$pe){
            echo $pe->getMessage();
        }
    }


   


     


    //View courses
    public function viewAllCourses(){
        try{
            $data = [];
            include ("Courses.class.php");
            $conn = $this->dbconnect();
            $query = "select DISTINCT courseid, courseName, description, preRequire, userid from course";
            $stmt = $conn->prepare($query);
            //$stmt->bindParam(":id",$id ,PDO::PARAM_INT);
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
    //View discussion
    public function viewAllDiscussion(){
        try{
            $data = [];
            include ("Discussion.class.php");
            $conn = $this->dbconnect();
            $query = "select DISTINCT userid, discussionid, type, dName, description, createdate from discussion";
            $stmt = $conn->prepare($query);
            //$stmt->bindParam(":id",$id ,PDO::PARAM_INT);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_CLASS,"Discussion");

            while($event=$stmt->fetch()){
                    $data[] = $event;
            }
            
            return $data;
        }//end try
        catch(PDOException	$pe){
            echo $pe->getMessage();
            return [];
        }


    }//end discussion
    
    
    public function viewMyDiscussion($id){
        try{
            $data = [];
            include ("myDiscussion.class.php");
            $conn = $this->dbconnect();
            $query = "select DISTINCT userid, discussionid, type, dName, description, createdate, userid from discussion WHERE userid = :id;";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(":id",$id ,PDO::PARAM_INT);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_CLASS,"myDiscussion");

            while($event=$stmt->fetch()){
                    $data[] = $event;
            }
            
            return $data;
        }//end try
        catch(PDOException	$pe){
            echo $pe->getMessage();
            return [];
        }


    }//end discussion

    public function viewMyAttendDiscussion($ui){
        try{
            $data = [];
            include ("myAttendDiscussion.class.php");
            $conn = $this->dbconnect();
            $query = "select DISTINCT discussion.userid, discussion.discussionid, type, dName, description, createdate from discussion 
            join attend_discussion on discussion.discussionid = attend_discussion.discussionid
            where attend_discussion.userid = :ui and discussion.userid != :ui;";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(":ui",$ui ,PDO::PARAM_INT);
            $stmt->bindParam(":ui",$ui ,PDO::PARAM_INT);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_CLASS,"myAttendDiscussion");

            while($event=$stmt->fetch()){
                    $data[] = $event;
            }
            
            return $data;
        }//end try
        catch(PDOException	$pe){
            echo $pe->getMessage();
            return [];
        }


    }//end discussion
    
    
 //View discussion
    public function viewAllDisscussionContent($id){
        try{
            $data = [];
            include ("DiscussionContent.class.php");
            $conn = $this->dbconnect();
            $query = "select discussion_content.discussionid, concat(user.fname,' ',user.lname) as name, discussion_content.title, discussion_content.currentdate, discussion_content.comment from user join discussion_content on user.userid = discussion_content.userid where discussion_content.discussionid = :id;";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(":id",$id ,PDO::PARAM_INT);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_CLASS,"DiscussionContent");

            while($event=$stmt->fetch()){
                    $data[] = $event;
            }
            
            return $data;
        }//end try
        catch(PDOException	$pe){
            echo $pe->getMessage();
            return [];
        }


    }//end discussion

    
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



    
    

    //delete courses
    public function deleteCourses($id){
        try{
            $conn = $this->dbconnect();
            $query = "delete from course where courseid = :id;";
            $stmt = $conn->prepare($query);
            $stmt->execute(["id"=>$id]);
            

            if($stmt->fetch() != null){
                return "<script>alert('success')</script>";
            }
            
            
        }//end try
        catch(PDOException	$pe){
            echo $pe->getMessage();
            return [];
        }
    
    
    }//end delete

    //delete discussion
    public function deleteDiscussion($id){
        try{
            $conn = $this->dbconnect();
            $query = "delete from discussion where discussionid = :id;";
            $stmt = $conn->prepare($query);
            $stmt->execute(["id"=>$id]);
            

            if($stmt->fetch() != null){
                return "<script>alert('success')</script>";
            }
            
            
        }//end try
        catch(PDOException	$pe){
            echo $pe->getMessage();
            return [];
        }
    
    
    }//end delete

       //delete member
    public function deleteMember($id){
        try{
            $conn = $this->dbconnect();
            $query = "delete from attend_discussion where userid = :id;";
            $stmt = $conn->prepare($query);
            $stmt->execute(["id"=>$id]);
            

            if($stmt->fetch() != null){
                return "<script>alert('success')</script>";
            }
            
            
        }//end try
        catch(PDOException	$pe){
            echo $pe->getMessage();
            return [];
        }
    
    
    }//end delete

    //delete registered event
    public function deleteRegisteredEvent($id, $event){
        try{
            $conn = $this->dbconnect();
            $query = "delete from attendee_event where attendee = :id and event = :event;";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(":event",$event ,PDO::PARAM_INT);
            $stmt->bindParam(":id",$id ,PDO::PARAM_INT);
            $stmt->execute();
            
            
        }//end try
        catch(PDOException	$pe){
            echo $pe->getMessage();
            return [];
        }

    }//end delete

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
                    echo "<script>if(confirm('Sucessfully Login')){document.location.href='myPLS.php?id={$row['userid']}'}  else{document.location.href='login.php'};</script>";
                }
                else if($role == 2 && $active == "Y"){
                    $_SESSION['userRole'] = "professor";
                    echo "<script>if(confirm('Sucessfully Login')){document.location.href='professor.php?id={$row['userid']}'} else{document.location.href='login.php'};</script>";
                }
                else if($role == 3 && $active == "Y"){ 
                    $_SESSION['userRole'] = "student";
                    echo "<script>if(confirm('Sucessfully Login')){document.location.href='student.php?id={$row['userid']}'}  else{document.location.href='login.php'};</script>";
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

    //View user
    public function viewProfessor(){
        try{
            $data = [];
            include ("User.class.php");
            $conn = $this->dbconnect();
            $query = "SELECT userid, concat(fname,' ',lname) as name FROM user where role = 2;";
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
    
    
      //View user
    public function viewAllMember($id){
        try{
            $data = [];
            include ("User.class.php");
            $conn = $this->dbconnect();
            $query = "SELECT userid, concat('UserID ',userid,' - Name: ',fname,' ',lname ,' (',email,')') as name FROM user WHERE userid NOT IN(SELECT userid FROM attend_discussion where discussionid = :c);";
            
            $stmt = $conn->prepare($query);
            $stmt->bindParam(":c",$id ,PDO::PARAM_INT);
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



    //edit course
    public function editCourse($courseId, $courseName, $description, $preRequire, $userId){
        try{
            $conn = $this->dbconnect();
            $query = "UPDATE course SET courseName = :cName, description = :des, preRequire = :preR, userid = :id where courseid = :n;";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(":cName",$courseName ,PDO::PARAM_STR);
            $stmt->bindParam(":des",$description ,PDO::PARAM_STR);
            $stmt->bindParam(":preR",$preRequire ,PDO::PARAM_STR);
            $stmt->bindParam(":id",$userId ,PDO::PARAM_INT);
            $stmt->bindParam(":n",$courseId ,PDO::PARAM_INT);
            $stmt->execute();

	    $query1 = "UPDATE professor_course SET userid = :id where courseid = :n;";
            $stmt1 = $conn->prepare($query1);
            $stmt1->bindParam(":id",$userId ,PDO::PARAM_INT);
            $stmt1->bindParam(":n",$courseId ,PDO::PARAM_INT);
            $stmt1->execute();
        }
        catch(PDOException	$pe){
            echo $pe->getMessage();
        }
    
    }//end edit course

      //View attendee
      public function viewAssignedProfessor($courseId){
        try{
            include ("Users.class.php");
            $conn = $this->dbconnect();
            $query = "select user.userid, email, fname, lname, role from user join professor_course on user.userid = professor_course.userid 
            where user.userid = professor_course.userid and professor_course.courseid = :courseid;";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(":courseid",$courseId ,PDO::PARAM_INT);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_CLASS,"Users");
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

    //View attendee
    public function viewAttendee($courseId){
        try{
            include ("User.class.php");
            $conn = $this->dbconnect();
            $query = "select user.userid, email, fname, lname, role from user join student_course on user.userid = student_course.userid 
            where user.userid = student_course.userid and student_course.courseid = :courseid";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(":courseid",$courseId ,PDO::PARAM_INT);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_CLASS,"User");
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
    
 //send request function
 public function sendRequest($discussionid, $userid){
    try{
        $conn = $this->dbconnect();
        $stmt1 = $conn->prepare("select discussionid, userid, action from request 
        where discussionid = :discussionid and userid = :userid;");
        $stmt1->bindParam(":discussionid",$discussionid ,PDO::PARAM_INT);
        $stmt1->bindParam(":userid",$userid ,PDO::PARAM_INT);
        $stmt1->execute();
        $data = [];
        while($row=$stmt1->fetch(PDO::FETCH_ASSOC)){
            $data[] = $row;
        }
        if($data == null){
            $query = "INSERT INTO request SET discussionid = :di, userid = :ui, action = 'send';";
            //$password = hash("sha256", $password);
            $stmt = $conn->prepare($query);
            $stmt->bindParam(":di",$discussionid ,PDO::PARAM_INT);
            $stmt->bindParam(":ui",$userid ,PDO::PARAM_INT);
            $stmt->execute();
            echo "<script>if(confirm('request send!')){document.location.href='viewGroups.php?id=$userid'};</script>";
        }
        
        else if($data[0]['action'] == 'send'){
        
			echo "<script>if(confirm('Request already send, please wait for respond!')){document.location.href='viewGroups.php?id=$userid'} ;</script>";
        }
        
        else if($data[0]['action'] == 'deny'){
            $query = "UPDATE request SET action = 'send' where discussionid = :n and userid = :u";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(":n",$discussionid ,PDO::PARAM_INT);
            $stmt->bindParam(":u",$userid ,PDO::PARAM_INT);
            $stmt->execute();
        
			echo "<script>if(confirm('You request is been deny, resend the request again!')){document.location.href='viewGroups.php?id=$userid'} ;</script>";
        }
        
        else if($data[0]['action'] == 'approve'){
			echo "<script>if(confirm('You already in this discussion group!')){document.location.href='viewGroups.php?id=$userid'} ;</script>";
        }
        
    }
    catch(PDOException	$pe){
        echo $pe->getMessage();
    }
}
    

    public function addContent($id,$userid,$title,$content){
    	try{
            $conn = $this->dbconnect();
            $query = "INSERT INTO discussion_content SET discussionid = :di, userid = :ui, title = :title,  comment = :comment;";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(":di",$id ,PDO::PARAM_INT);
            $stmt->bindParam(":ui",$userid ,PDO::PARAM_INT);
            $stmt->bindParam(":title",$title ,PDO::PARAM_STR);
            $stmt->bindParam(":comment",$content ,PDO::PARAM_STR);
            $stmt->execute();
        }
        catch(PDOException	$pe){
            echo $pe->getMessage();
        }
    }//end addcontent

   
         // Join, insert user into group
	public function joinGroup($discussionid, $userid){
        try{
            $conn = $this->dbconnect();
            $stmt1 = $conn->prepare("select discussionid, userid from attend_discussion 
            where discussionid = :discussionid and userid = :userid;");
            $stmt1->bindParam(":discussionid",$discussionid ,PDO::PARAM_INT);
            $stmt1->bindParam(":userid",$userid ,PDO::PARAM_INT);
            $stmt1->execute();
            $data = [];
            while($row=$stmt1->fetch(PDO::FETCH_ASSOC)){
                $data[] = $row;
            }
            if($data == null){
                $query = "INSERT INTO attend_discussion(discussionid, userid)VALUES (:discussionid, (SELECT userid FROM user WHERE userid = :userid));";
                //$password = hash("sha256", $password);
                $stmt = $conn->prepare($query);
                $stmt->bindParam(":discussionid",$discussionid ,PDO::PARAM_INT);
                $stmt->bindParam(":userid",$userid ,PDO::PARAM_INT);
                $stmt->execute();
            }
            else{
                echo "<script>if(confirm('You Already attend this group discussion.')){document.location.href='viewGroups.php?id=$userid'};</script>";
                
            }
        }
        catch(PDOException	$pe){
            echo $pe->getMessage();
        }
    }
    
    
    

     //View attendee
     public function viewRequest($discussionid){
        try{
            include ("Request.class.php");
            $conn = $this->dbconnect();
            $query = "select user.userid, user.email, user.fname, user.lname, user.role, request.discussionid, request.action from user join request on user.userid = request.userid 
            where user.userid = request.userid and request.discussionid = :discussionid;";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(":discussionid",$discussionid ,PDO::PARAM_INT);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_CLASS,"Request");
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
    
       //send invite function
       public function sendInvite($discussionid, $userid, $senderid){
        try{
            $conn = $this->dbconnect();
            $stmt1 = $conn->prepare("select discussionid, userid, senderid action from invite 
            where discussionid = :discussionid and userid = :userid and senderid= :si;");
            $stmt1->bindParam(":discussionid",$discussionid ,PDO::PARAM_INT);
            $stmt1->bindParam(":userid",$userid ,PDO::PARAM_INT);
            $stmt1->bindParam(":si",$senderid ,PDO::PARAM_INT);
            $stmt1->execute();
            $data = [];
            while($row=$stmt1->fetch(PDO::FETCH_ASSOC)){
                $data[] = $row;
            }
            if($data == null){
                $query = "INSERT INTO invite SET discussionid = :di, userid = :ui, senderid= :si, action = 'send';";
                //$password = hash("sha256", $password);
                $stmt = $conn->prepare($query);
                $stmt->bindParam(":di",$discussionid ,PDO::PARAM_INT);
                $stmt->bindParam(":ui",$userid ,PDO::PARAM_INT);
                $stmt->bindParam(":si",$senderid ,PDO::PARAM_INT);
                $stmt->execute();
                echo "<script>if(confirm('invite send!')){document.location.href='viewMyGroups.php?id=$senderid'};</script>";
            }
            
            else{
            
                echo "<script>if(confirm('Invite already send, please wait for respond!')){document.location.href='viewMyGroups.php?id=$senderid'} ;</script>";
            }
            
        }
        catch(PDOException	$pe){
            echo $pe->getMessage();
        }
    }

//edit course
    public function approveGroupRequest($discussionid, $userid){
        try{
        	$conn = $this->dbconnect();
            $query = "UPDATE request SET action = 'approve' where discussionid = :n and userid = :u";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(":n",$discussionid ,PDO::PARAM_INT);
            $stmt->bindParam(":u",$userid ,PDO::PARAM_INT);
            $stmt->execute();


            $query1 = "INSERT INTO attend_discussion(discussionid, userid)VALUES (:discussionid, (SELECT userid FROM user WHERE userid = :userid));";
			$stmt1 = $conn->prepare($query1);
			$stmt1->bindParam(":discussionid",$discussionid ,PDO::PARAM_INT);
          	$stmt1->bindParam(":userid",$userid ,PDO::PARAM_INT);
    		$stmt1->execute();

   			echo "<script>if(confirm('approved')){document.location.href='viewRequest.php?id=$discussionid'};</script>";

        }
        catch(PDOException	$pe){
            echo $pe->getMessage();
        }
    
    }//end edit course


 public function denyGroupRequest($discussionid, $userid){
        try{
        	$conn = $this->dbconnect();
            $query = "UPDATE request SET action = 'deny' where discussionid = :n and userid = :u";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(":n",$discussionid ,PDO::PARAM_INT);
            $stmt->bindParam(":u",$userid ,PDO::PARAM_INT);
            $stmt->execute();


   			echo "<script>if(confirm('you deny this request')){document.location.href='viewRequest.php?id=$discussionid'};</script>";

        }
        catch(PDOException	$pe){
            echo $pe->getMessage();
        }
    
    }//end edit course
 
    
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

}//end class

?>