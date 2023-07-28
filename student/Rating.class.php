<?php

class Rating{
		public $rateid;
		public $type;
		public $name;
		public $rating;
		public $comment;
		
		
        public function showAllRatings(){

			return "<tr>
				<td>{$this->type}</td>
				<td>{$this->name}</td>
				<td>{$this->rating}</td>
                <td>{$this->comment}</td>
					</tr>\n";
		}
        
	
	
}