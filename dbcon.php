<!-- dbcon.php -->
<?php 
//Connexion à la BD 
	try {
		$db = new PDO('mysql:host=localhost;dbname=php-chat-db;charset=utf8', 'root', 'password');
	}
	catch (Exception $e) {
		die('Erreur :' . $e->getMessage());
	}
 ?>