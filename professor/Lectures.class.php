<?php

class Lectures{
		public $lectureid;
		public $lectureName;
		public $description;
		public $filename;
		public $courseid;
		
		
        public function showAllLectures(){
            $addLecture = "Update Lecture";
			$deleteL = "Delete Lecture";
            $share = "Schedule Share Time";
            $detail = "View Detail";

			return "<tr>
				<td>{$this->lectureid}</td>
				<td>{$this->lectureName}</td>
				<td>{$this->description}</td>
                <td>{$this->filename}</td>
                <td>{$this->courseid}</td>
                <td>
                <a href='LectureDetail.php?id={$this->lectureid}'>{$detail}</a>
				<a href='updateLecture.php?id={$this->lectureid}&courseid={$this->courseid}'>{$addLecture}</a>
				<a href='deleteLecture.php?id={$this->lectureid}'>{$deleteL}</a>
                <a href='shareLecture.php?id={$this->lectureid}&courseid={$this->courseid}'>{$share}</a>
                </td>
					</tr>\n";
		}
        
	
	
}