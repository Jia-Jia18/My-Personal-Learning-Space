<?php

class Request{
		public $discussionid;
		public $userid;
		public $email;
		public $fname;
		public $lname;
		public $role;
		public $action;
		
		
        public function showAllRequest($style = ""){
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
			<td><a style = 'display:$style;' href='approve.php?id={$this->userid}'>{$approve}</a>
	        <a style = 'display:$style;' href='deny.php?id={$this->userid}'>{$deny}</a></td>
                 
					</tr>\n";
		}
        
	
	
}