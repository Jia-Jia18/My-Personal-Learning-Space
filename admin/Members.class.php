<?php

class Members{
		public $discussionid;
		public $email;
		public $userid;
		
	public function showMyMembers($style = ""){
        
		$delete = "Delete";


			return "<tr>
				<td>{$this->discussionid}</td>
				<td>UserID: {$this->userid}</td>
                <td>{$this->email}</td>
	     	<td>
			<a style = 'display:$style;' href='deleteMember.php?id={$this->discussionid}&owner={$this->userid}'>{$delete}</a>
			</td>

                 
					</tr>\n";
		}
        
        
	
	
}