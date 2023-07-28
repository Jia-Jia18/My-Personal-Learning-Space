<?php

class viewOneQuiz{
		public $quizid;
		public $courseid;
		public $quizname;
		public $description;
		public $timelimit;
		public $availabledate;
        public $enddate;

		
		
	public function showOneQuiz(){
        
        $change = "update";


			return "
        <div class='viewOneQuiz'>
       

                <label>Quiz Title: </label>
           
                <input type='text' name='quiztitle' id='quiztitle'  value='{$this->quizname}' required>
                <br>
                
                <label for='quizdescription'>Quiz Description:</label>
                <textarea id='quizdescription' name='quizdescription' required>{$this->description} </textarea>
                <br>

               <label for='availabletime'>Available Time:</label>
                <input type='datetime-local' name='availabletime' id='availabletime' value='{$this->availabledate}' required>
                <br>
                   
                   <label for='enddate'>Closed Time:</label>
                    <input type='datetime-local' name='enddate' id='enddate' value='{$this->enddate}' required>
                    <br>
                
                <label for='timelimit'>Time Limit (Minutes):</label>
                <input type='number' name='timelimit' id='timelimit' value='{$this->timelimit}' required>
                <br>


        </div>
        
        
        
        ";
		}
        
        
	
	
}
