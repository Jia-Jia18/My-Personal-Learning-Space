<?php
    session_start();
	require_once "MyUtils.class.php";
	$my = new MyUtils();
	$title = "Add Quiz";
	$style = "home_page.css";
	$page = "add Question";
    $role = "";
    $eventId = "";
    $style1 = "professor.css";
    $id = "";
    if(isset($_GET['id'])){
        $id = $_GET['id'];
    }
    $role = $_SESSION['role'];
    $courseid = $_SESSION['courseid'];

    
	echo $my->professor_header($title,$style,$style1,$page,$role);
?>
<script>
	var count = 1;

function createQuestion() {
	
	count += 1;
	
	var divQuest = document.createElement("div");
	divQuest.setAttribute("class",  "eachQues");

	
    var label = document.createElement("label");
    var nametitle = document.createTextNode("Question");

    label.appendChild(nametitle);
    var input = document.createElement("TEXTAREA");
    input.required = true;
    
    var name = "questionAsk" + count;
    input.setAttribute("name", name );
    divQuest.appendChild(label);
    divQuest.appendChild(input);
    document.getElementById("questions").appendChild(divQuest);

    
    var nameA = "selectionsA" + count;
    var labelSelectionA = document.createElement("label");
    var nameSelectionA = document.createTextNode("A");
    labelSelectionA.appendChild(nameSelectionA);
    var inputSelectionA = document.createElement("TEXTAREA");
    inputSelectionA.required = true;

        inputSelectionA.setAttribute("name", nameA);

    divQuest.appendChild(labelSelectionA);
    divQuest.appendChild(inputSelectionA);
    document.getElementById("questions").appendChild(divQuest);

    
    var nameB = "selectionsB" + count;
   var labelSelectionB = document.createElement("label");
    var nameSelectionB = document.createTextNode("B");
    labelSelectionB.appendChild(nameSelectionB);
    var inputSelectionB = document.createElement("TEXTAREA");
    inputSelectionB.required = true;

    inputSelectionB.setAttribute("name", nameB);

    divQuest.appendChild(labelSelectionB);
    divQuest.appendChild(inputSelectionB);
   document.getElementById("questions").appendChild(divQuest);

    
    var nameC = "selectionsC" + count;
    var labelSelectionC = document.createElement("label");
    var nameSelectionC = document.createTextNode("C");
    labelSelectionC.appendChild(nameSelectionC);
    var inputSelectionC = document.createElement("TEXTAREA");
    inputSelectionC.required = true;

                inputSelectionC.setAttribute("name", nameC);

    divQuest.appendChild(labelSelectionC);
    divQuest.appendChild(inputSelectionC);
            document.getElementById("questions").appendChild(divQuest);

    
    var nameD = "selectionsD" + count;
    var labelSelectionD = document.createElement("label");
    var nameSelectionD = document.createTextNode("D");
    labelSelectionD.appendChild(nameSelectionD);
    var inputSelectionD = document.createElement("TEXTAREA");
    inputSelectionD.required = true;

                inputSelectionD.setAttribute("name", nameD);

    divQuest.appendChild(labelSelectionD);
    divQuest.appendChild(inputSelectionD);
    
    
    var nameAn = "answer" + count;
    var labelAnswer = document.createElement("label");
    var nameAnswer = document.createTextNode("The Answer is:");
    labelAnswer.appendChild(nameAnswer);
    var selectList = document.createElement("select");
                selectList.setAttribute("name", nameAn);

     
		
		 // Creates option 1
		var newOption1 = document.createElement("option");
		newOption1.value = "A";
		newOption1.text = "A";
		selectList.appendChild(newOption1);
		
		// Creates option 2
		var newOption2 = document.createElement("option");
		newOption2.value = "B";
		newOption2.text = "B";
		selectList.appendChild(newOption2);
		
		// Creates option 3
		var newOption3 = document.createElement("option");
		newOption3.value = "C";
		newOption3.text = "C";
		selectList.appendChild(newOption3);
		
		// Creates option 4
		var newOption4 = document.createElement("option");
		newOption4.value = "D";
		newOption4.text = "D";
		selectList.appendChild(newOption4);
                 
                
                            
    divQuest.appendChild(labelAnswer);
    divQuest.appendChild(selectList);
            
                
                
    document.getElementById("questions").appendChild(divQuest);
	
	document.getElementById("count").innerHTML= count;
	document.getElementById("count").setAttribute("value", count);

    }
    
    function getCount(){
    	return count;
    
    }

</script>


<?php


function showForm($errorMsg=false, $errorTxt="") {

	echo  '

	 	   <div class="questionform">
    <br>
    <form method="POST">
	
	<h2 id= "count" name="count"></h2>
	<div class ="questions" id="questions">
    	<div class="eachQues">
		<label> Question</label>
	
		<textarea name="questionAsk1" required></textarea>
		<label>A</label>
		<textarea name="selectionsA1" required></textarea>
		<label>B</label>
		<textarea name="selectionsB1" required></textarea>
		<label>C</label>
		<textarea name="selectionsC1" required></textarea>
  		<label>D</label>
  		<textarea name="selectionsD1" required></textarea>
  		
  		<label>The Answer is:</label>

  	<select name="answer1">

    <option value="A"selected>A</option>
    <option value="B">B</option>
    <option value="C">C</option> 
    <option value="D">D</option>
  </select>
  		</div>
  		

    </div>
    
    <button onclick="createQuestion()">Add more</button>
    <br>
    <input type="submit" name="submit" class="button" value="sumbit">
		<br>

    </form>

</div> 

 ';
}
?>

<?php

if (!isset($_POST['submit'])) {
	showForm();
} else {
	
        require_once "DB.class.php";
		$db = new DB();
		


		for ($x = 1; $x < 30; $x++){

			$question = 'questionAsk' . $x;
			$opti1= 'selectionsA' . $x;
			$opti2 = 'selectionsB' . $x;
			$opti3 = 'selectionsC' . $x;
			$opti4 = 'selectionsD' . $x;
			$answer = 'answer' . $x;
			
			if (isset($_POST[$question]) && isset($_POST[$opti1]) && isset($_POST[$opti2]) && isset($_POST[$opti3]) && isset($_POST[$opti4]) && isset($_POST[$answer]) ) {
			if($_POST[$question]!='' && $_POST[$opti1]!='' && $_POST[$opti2]!='' && $_POST[$opti3]!='' && $_POST[$opti4]!=''&& $_POST[$answer]!=''){
			
					
					$questionname = ($_POST[$question]);
					
					$selectionA = ($_POST[$opti1]);
					$selectionB = ($_POST[$opti2]);
					$selectionC = ($_POST[$opti3]);
					$selectionD = ($_POST[$opti4]);
					
					$answer1 = ($_POST[$answer]);	
					
					
					$db->addQuizQuestion($id, $questionname, $selectionA,$selectionB,$selectionC,$selectionD, $answer1);

				
			}
		}
		
		}
    
    echo "<script> document.location.href='viewMyQuiz.php?id=$courseid'</script>";

}
?>



<?php
	echo $my->html_footer();

?>




