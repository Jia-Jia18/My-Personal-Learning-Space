<?php

class viewMyQuestion
{
	public $questionid;
	public $quizid;
	public $question;
	public $selectionA;
	public $selectionB;
	public $selectionC;
	public $selectionD;
	public $answer;


	public function showMyQuestion($count)
	{

		$questionidnum = 'questionId' . $count;
		$questionAsk = 'questionAsk' . $count;
		$selectionsANum = 'selectionsA' . $count;
		$selectionsBNum  = 'selectionsB' . $count;
		$selectionsCNum  = 'selectionsC' . $count;
		$selectionsDNum  = 'selectionsD' . $count;
		$answerNum  = 'answer' . $count;

		if ($this->answer == 'A') {
			return "
			<div class= 'eachQues'>
			<textarea style='display:none' name = $questionidnum required disabled>{$this->questionid}</textarea>
			<label>Question</label>
			<textarea name = $questionAsk required disabled>{$this->question}</textarea>
			<label>A</label>
			<textarea name=$selectionsANum required disabled>{$this->selectionA}</textarea>
			<label>B</label>
			<textarea name=$selectionsBNum required disabled>{$this->selectionB}</textarea>
			<label>C</label>
			<textarea name=$selectionsCNum required disabled>{$this->selectionC}</textarea>
			<label>D</label>
			<textarea name=$selectionsDNum required disabled>{$this->selectionD}</textarea>
			<label>The Answer is:</label>

			<select name=$answerNum disabled>
    		<option value='A' selected>A</option>
   			<option value='B' >B</option>
    		<option value='C' >C</option> 
    		<option value='D' >D</option>
  			</select>
			<br>
			 
            </div>";
		} else if ($this->answer == 'B') {
			return "
			<div class= 'eachQues'>
			<textarea style='display:none' name = $questionidnum required disabled>{$this->questionid}</textarea>
			<label>Question</label>
			<textarea name = $questionAsk required disabled>{$this->question}</textarea>
			<label>A</label>
			<textarea name=$selectionsANum required disabled>{$this->selectionA}</textarea>
			<label>B</label>
			<textarea name=$selectionsBNum required disabled>{$this->selectionB}</textarea>
			<label>C</label>
			<textarea name=$selectionsCNum required disabled>{$this->selectionC}</textarea>
			<label>D</label>
			<textarea name=$selectionsDNum required disabled>{$this->selectionD}</textarea>
			<label>The Answer is:</label>

			<select name=$answerNum disabled>
    		<option value='A' >A</option>
   			<option value='B' selected>B</option>
    		<option value='C' >C</option> 
    		<option value='D' >D</option>
  			</select>
			<br>
			 
            </div>";
		} else if ($this->answer == 'C') {
			return "
			<div class= 'eachQues'>
			<textarea  style='display:none' name = $questionidnum required disabled>{$this->questionid}</textarea>
			<label>Question</label>
			<textarea name = $questionAsk required disabled>{$this->question}</textarea>
			<label>A</label>
			<textarea name=$selectionsANum required disabled>{$this->selectionA}</textarea>
			<label>B</label>
			<textarea name=$selectionsBNum required disabled>{$this->selectionB}</textarea>
			<label>C</label>
			<textarea name=$selectionsCNum required disabled>{$this->selectionC}</textarea>
			<label>D</label>
			<textarea name=$selectionsDNum required disabled>{$this->selectionD}</textarea>
			<label>The Answer is:</label>

			<select name=$answerNum disabled>
    		<option value='A' >A</option>
   			<option value='B' >B</option>
    		<option value='C' selected>C</option> 
    		<option value='D' >D</option>
  			</select>
			<br>
			 
            </div>";
		} else if ($this->answer == 'D') {
			return "
			<div class= 'eachQues'>
			<textarea style='display:none' name = $questionidnum required disabled>{$this->questionid}</textarea>
			<label>Question</label>
			<textarea name = $questionAsk required disabled>{$this->question}</textarea>
			<label>A</label>
			<textarea name=$selectionsANum required disabled>{$this->selectionA}</textarea>
			<label>B</label>
			<textarea name=$selectionsBNum required disabled>{$this->selectionB}</textarea>
			<label>C</label>
			<textarea name=$selectionsCNum required disabled>{$this->selectionC}</textarea>
			<label>D</label>
			<textarea name=$selectionsDNum required disabled>{$this->selectionD}</textarea>
			<label>The Answer is:</label>

			<select name=$answerNum disabled>
    		<option value='A' >A</option>
   			<option value='B' >B</option>
    		<option value='C' >C</option> 
    		<option value='D' selected>D</option>
  			</select>
			<br>
			 
            </div>";
		}
	}



	public function takeQuiz($count)
	{
		$questionidnum = 'questionId' . $count;
		$questionAsk = 'questionAsk' . $count;
		$selectionsANum = 'selectionsA' . $count;
		$selectionsBNum  = 'selectionsB' . $count;
		$selectionsCNum  = 'selectionsC' . $count;
		$selectionsDNum  = 'selectionsD' . $count;
		$questionNumber = 'Question' . $count;
		$answerNum  = 'answer' . $count;

		return "
		
		<div class= 'eachQues'>
		<p>
		<hr>
		$questionNumber
			<br> {$this->question} </br>
			<blockquote>
		<input class = 'timerset' type='radio' name=$answerNum value='A'>{$this->selectionA}<br>
			<input class = 'timerset' type='radio' name=$answerNum value='B'>{$this->selectionB}<br>
			<input class = 'timerset' type='radio' name=$answerNum value='C'>{$this->selectionC}<br>
			<input class = 'timerset' type='radio' name=$answerNum value='D'>{$this->selectionD}<br>


			</blockquote>
			<p>

			<hr>

			


			 
            </div>";
		}
	
	}