<?php

class Discussion{
		public $discussionid;
		public $type;
		public $dName;
		public $description;
		public $createdate;
		public $userid;
		
		
        public function showAllDiscussion($display = "", $display1 = ""){
            $request = "Request";
	    $join = "Join";


			return "<tr>
				<td>{$this->discussionid}</td>
				<td>User: {$this->userid}</td>
				<td>{$this->type}</td>
				<td>{$this->dName}</td>
                <td>{$this->description}</td>
                <td>{$this->createdate}</td>
		<td><a style='display: $display; ' href='request.php?id={$this->discussionid}'>{$request}</a>
	        <a style='display: $display1; '  href='join.php?id={$this->discussionid}'>{$join}</a></td>
                 
					</tr>\n";
		}
        
	
	
}