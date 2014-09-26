<?php 

class NewPagination{
	var $data;

	function paginate($values, $per_page){
		$total_values = count($values);
		
		if(isset($_GET['page'])){
			$current_page = $_GET['page'];
		}else{
			$current_page = 1;
		}
		// calculate how many pages
		$counts = ceil($total_values / $per_page);

		$param1 = ($current_page - 1) * $per_page;
		$this->data = array_slice($values, $param1,$per_page);

		for($x=1; $x<=$counts; $x++){
			$numbers[] = $x;
		}
		return $numbers;
	}

	function fetchResults(){
		$resultValues = $this->data;

		return $resultValues;
	}
}



// USAGE
// $pag = new NewPagination();

// $data = array("Hey", "Ronaldo", "How", "Are", "You");

// $pageNumbers = $pag->paginate($data, 2);

// foreach($pageNumbers as $num){
// 	echo '<a href="/folder/?page='.$num.'".</a>'
// }