<?php

class Courses{
		public $courseid;
		public $courseName;
		public $description;
		public $preRequire;
		public $userid;
		
		
        public function showAllCourses(){
            $addQuiz = "Add Quiz";
			$viewQuiz = "View Quiz";
			$addL = "Add Lecture";
			$viewL = "View Lecture";

			return "<tr>
				<td>{$this->courseid}</td>
				<td>{$this->courseName}</td>
				<td>{$this->description}</td>
                <td>{$this->preRequire}</td>
                <td>{$this->userid}</td>
                <td>
				<a href='addLecture.php?id={$this->courseid}'>{$addL}</a>
				<a href='viewLecture.php?id={$this->courseid}'>{$viewL}</a>
				<a href='addQuiz.php?id={$this->courseid}'>{$addQuiz}</a>
                <a href='viewMyQuiz.php?id={$this->courseid}'>{$viewQuiz}</a>
                </td>
					</tr>\n";
		}
        
	
	
}