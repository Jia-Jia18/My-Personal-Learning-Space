<?php

class viewMyQuiz{
		public $quizid;
		public $courseid;
		public $quizname;
		public $description;
		public $timelimit;
		public $availabledate;
		
		
	public function showMyQuiz(){
        
      	$add = "Modify Quiz";
		$update = "View Question";
		$delete = "Delete Quiz";


			return "<tr>
				<td>{$this->quizid}</td>
				<td>{$this->courseid}</td>
				<td>{$this->quizname}</td>
				<td>{$this->description}</td>
                <td>{$this->timelimit}</td>
                <td>{$this->availabledate}</td>
	     	<td>
	     	<div class = 'dropdownSelect'>
	     	
	     	<select name = 'action' onchange = 'location = this.value;'>
	     	
	     	<option>Select Action</option>

	     	
	        <option value = 'modifyQuiz.php?id={$this->quizid}'>{$add} </option>
	        <option value = 'viewMyQuestion.php?id={$this->quizid}'>{$update} </option>
	        <option value = 'deleteQuiz.php?id={$this->quizid}'>{$delete} </option>
       </select>
</div>




	     
			</td>

                 
					</tr>\n";
		}
        
        
	
	
}
