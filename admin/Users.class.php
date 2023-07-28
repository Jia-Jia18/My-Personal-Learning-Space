<?php

class Users{
		public $userid;
		public $email;
        public $fname;
        public $lname;
		public $role;
        public $password;
		
		public function whoAmI($style = "", $style1 = ""){
            $edit = "edit";
            $delete = "Delete";
            $master = "Master";

            if($this->role == "1"){
                $r = "Admin";
            }
            else if($this->role == "2"){
                $r = "Professor";
            }
            else {
                $r = "Student";
            }  
			return "<tr>
				<td>{$this->userid}</td>
				<td>{$this->email}</td>
                <td>{$this->fname}</td>
                <td>{$this->lname}</td>
				<td>{$r}</td>
                <td><p class = '$style1' >$master</p><a class = '$style' href='editUser.php?id={$this->userid}'>{$edit}</a>
                <a class = '$style' href='deleteUser.php?id={$this->userid}'>{$delete}</a></td>
					</tr>\n";
		}

        public function addAttendee(){
            $edit = "edit";
            $delete = "Delete";
            $add = "Add";

            if($this->role == "1"){
                $r = "Admin";
            }
            else if($this->role == "2"){
                $r = "Professor";
            }
            else {
                $r = "Student";
            }   
			return "<tr>
            <td>{$this->userid}</td>
            <td>{$this->email}</td>
            <td>{$this->fname}</td>
            <td>{$this->lname}</td>
            <td>{$r}</td>
                </tr>\n";
		}


	
}