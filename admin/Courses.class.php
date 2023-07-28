<?php

class Courses{
		public $courseid;
		public $courseName;
		public $description;
		public $preRequire;
		public $userid;
		
		
        public function showAllCourses(){
            $edit = "Edit";
            $delete = "Delete";
            $viewAttendee = "View Attendee";

			return "<tr>
				<td>{$this->courseid}</td>
				<td>{$this->courseName}</td>
				<td>{$this->description}</td>
                <td>{$this->preRequire}</td>
                <td>{$this->userid}</td>
                <td><a href='editCourse.php?id={$this->courseid}'>{$edit}</a>
                <a href='deleteCourse.php?id={$this->courseid}'>{$delete}</a>
                <a href='viewAttendee.php?id={$this->courseid}'>{$viewAttendee}</a>
                </td>
					</tr>\n";
		}
        
	
	
}