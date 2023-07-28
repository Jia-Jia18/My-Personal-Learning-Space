<?php

class QuizResult{

	public $quizid;
	public $userid;
	public $studentchose;
	public $answer;
	public $grade;
	
			
        public function showAllQuizResult(){


			return "<div class= 'eachQues'>
			
			
			<p>The chose you make: {$this->studentchose}</p>
			
			
						
			<p>Answer: {$this->answer}</p>
			
			<p>Your Grade: {$this->grade}</p>

			<br>
			 
            </div>";
		}
        
	
	
}