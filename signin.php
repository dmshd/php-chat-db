<!-- signin.php -->
<?php 
	require('generalfunctions.php');

	// Initialisation de(s) variable(s)
	$emailValidationAlert = "";

	if ($_SERVER['REQUEST_METHOD'] == 'POST' and isset($_POST['submit'])) {
		
		$login = sanitize($_POST['login']);
		$mdp = sanitize($_POST['mdp']);
		$email = sanitize($_POST['email']);

		// testing
		echo $login . '<br>';
		echo $mdp . '<br>';
	
		if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
	    	echo $email . '<br>';
		} 
		else {
		    $emailValidationAlert = "<p>Veuillez entrer une adresse email valide s.v.p. </p>";
		}
	}
 ?>
<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<title>php-chat-db - login</title>
</head>
<body>
	<h1>php-chat-db</h1>
	<h2>Inscription</h2>
	<form action="" method="POST">
		<label for="id">Login :</label><br>
		<input type="text" name="login" id="login"><br>
		<label for="id">Mot de passe :</label><br>
		<input type="text" name="mdp" id="mdp"><br>
		<label for="email">Email :</label><br>
		<input type="text" name="email" id="email"><br>
		<?= $emailValidationAlert ?>
		<input type="submit" name="submit" value="Inscription">
	</form>
</body>
</html>