<?php

class PublicCourses{
		public $courseid;
		public $courseName;
		public $description;
		public $preRequire;
		public $userid;
		
		
        public function showPublicCourses(){


			return "<tr>
				<td>{$this->courseid}</td>
				<td>{$this->courseName}</td>
				<td>{$this->description}</td>
                <td>{$this->preRequire}</td>
                <td>{$this->userid}</td>
                
					</tr>\n";
		}
        
	
	
}
