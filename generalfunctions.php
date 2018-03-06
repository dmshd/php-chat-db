<!-- generalfunctions.php -->
<?php 
function sanitize($a) {
		$a = filter_var($a, FILTER_SANITIZE_STRING);
		$a = trim($a);
		return $a;
	}
 ?>
 