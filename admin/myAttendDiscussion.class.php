<?php

class myAttendDiscussion
{
	public $discussionid;
	public $userid;
	public $type;
	public $dName;
	public $description;
	public $createdate;


	public function showMyDiscussion($display = "", $display1 = "")
	{

		$add = "Add";
		$invite = "Invite";
		$post = "Post";
		$view = "View Member";
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
	     	<option value = 'post.php?id={$this->discussionid}'>{$post} </option>
	     <option style='display: $display1;' value = 'invite.php?id={$this->discussionid}'>{$invite} </option>

	     	<option value = 'viewMember.php?id={$this->discussionid}&owner={$this->userid}'>{$view} </option>



	</select>  </div></td>

                 
					</tr>  \n";
	}
}
