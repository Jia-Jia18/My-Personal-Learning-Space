<?php

class Invite{
		public $discussionid;
		public $userid;
		public $email;
		public $fname;
		public $lname;
		public $role;
		public $action;
		
		
        public function showAllInvite($style = ""){
            $approve = "Approve";
	    	$deny = "Deny";


			return "<tr>
				<td>{$this->userid}</td>
				<td>{$this->email}</td>
				<td>{$this->fname}</td>
                <td>{$this->lname}</td>
                 <td>{$this->discussionid}</td>
                <td>{$this->role}</td>
                <td>{$this->action}</td>
			<td><a style = 'display:$style;' href='approveInvite.php?id={$this->discussionid}'>{$approve}</a>
	        <a style = 'display:$style;' href='denyInvite.php?id={$this->discussionid}'>{$deny}</a></td>
                 
					</tr>\n";
		}
        
	
	
}