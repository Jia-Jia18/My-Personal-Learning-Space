<?php

class myDiscussion{
		public $discussionid;
		public $userid;
		public $type;
		public $dName;
		public $description;
		public $createdate;
		
		
	public function showMyDiscussion($display = "", $display1 = ""){
        
      	$add = "Add Member";
	    $invite = "Invite Member";
	    $post = "Post";
		$view = "View Member";
		$request = "View Request";
		$delete = "Disband";
		$deleteM = "Delete Member";


			return "<tr>
				<td>{$this->discussionid}</td>
				<td>User: {$this->userid}</td>
				<td>{$this->type}</td>
				<td>{$this->dName}</td>
                <td>{$this->description}</td>
                <td>{$this->createdate}</td>
	     	<td>
	     	<div class = 'dropdownSelect'>
	     	
	     	<select name = 'action' onchange = 'location = this.value;'>
	     	
	     	<option>Select Action</option>

	     	 <option style='display: $display;' value = 'addAttendee.php?id={$this->discussionid}'>{$add} </option>
			  <option value = 'viewMember1.php?id={$this->discussionid}&owner={$this->userid}'>{$deleteM} </option>
	     	<option value = 'viewMember.php?id={$this->discussionid}&owner={$this->userid}'>{$view} </option>
	        <option value = 'post.php?id={$this->discussionid}'>{$post} </option>
	        <option value = 'viewRequest.php?id={$this->discussionid}'>{$request} </option>
	        <option value = 'deleteDiscussion.php?id={$this->discussionid}'>{$delete} </option>
       </select>
</div>




	     
			</td>

                 
					</tr>\n";
		}
        
        
	
	
}