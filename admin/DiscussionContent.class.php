<?php

class DiscussionContent{
		public $discussionid;
		public $userid;
		public $name;
		public $currentdate;
		public $comment;
		public $title;
		
		
		
        public function showAllDisscussionContent(){
            $edit = "Edit";
            $delete = "Delete";
            $viewAttendee = "View Attendee";

			return "<div class='container'>
				<span class='id'>{$this->name}</span>
				<span class ='title'>{$this->title}</span>
				<span class ='currentdata'>{$this->currentdate}</span>
								<hr>

                <p>{$this->comment}</p>
					</div>\n";
		}
        
	
	
}