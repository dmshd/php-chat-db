<!-- signin.php -->
<?php 
	//Functions utilitaires
	require('generalfunctions.php');
	require('dbcon.php');
	
	session_start();
	
	// Initialisation de(s) variable(s)
	$emailValidationAlert = $emptyLoginAlert = $login = $password = $email = $validEmail = $name = $lastname = $nickname = $signInSuccessalert = "";
	

	if (isset($_POST['submit'])) {
	
		//On récupère les données entrée et on sanitize
		$login = sanitize($_POST['login']);	
		$password = sanitize($_POST['password']);
		$email = sanitize($_POST['email']);
		$name = sanitize($_POST['name']);
		$lastname = sanitize($_POST['lastname']);
		$nickname = sanitize($_POST['nickname']);
		$currentdate = date("Y-m-d");
		if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
	    	$validEmail = filter_var($email, FILTER_VALIDATE_EMAIL);
		} 
		else {
		    $emailValidationAlert = "<p>Veuillez entrer une adresse email valide s.v.p. </p>";
		}

		//On prépare la requête en bindant les données et on l'exécute
		$sql_newUser = $db->prepare("INSERT INTO users(name, lastname, nickname, login, password, mail, date_created) VALUES(:name, :lastname, :nickname, :login, :password, :mail, :currentdate);");

		$newUserArray = array(
			'name' => $name,
			'lastname' => $lastname,
			'nickname' => $nickname,
			'login' => $login,
			'password' => $password,
			'mail' => $validEmail,
			'currentdate' => $currentdate
		);

		if ($sql_newUser->execute($newUserArray)) {
			$signInSuccessalert = "<p> Votre inscription a été validée, " . $newUserArray['lastname'] . " !<br> Vous serez redirigé dans quelques instants...";
			header('Refresh:3; url=index.php');
		}
	}
 ?>

<!DOCTYPE html>
<html lang="fr">
	<head>
			<meta charset="UTF-8">
			<meta name="viewport" content="width=device-width">
			 <meta name="description" content="Réaliser un chat via PHP/MySQL - Formation en développement web Becode Charleroi - web developpeur bruxelles, belgique. Muyshond Daniel 2018">
			<link rel="stylesheet" type="text/css" href="./css/style.css">
			<title> PHP/MySQL chat - Becode Charleroi - web developpeur bruxelles, belgique. Muyshond Daniel 2018</title>
	</head>
	<body class="index">
		<header>
			<div class="logo">
				<h1>php-chat-db</h1>
			</div>
		</header>

		<section class="container">
			<h2>Inscription</h2>
    	
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">

			<label for="id">Login :</label><br>
			<input type="text" name="login" id="login" placeholder="Entrez un login" required><br>
			<!-- Ux alert -->
			<?= $emptyLoginAlert ?>

			<label for="id">Mot de passe :</label><br>
			<input type="password" name="password" id="mdp" placeholder="Entrez un mot de passe" required><br>


			<label for="email">Email :</label><br>
			<input type="text" name="email" id="email" placeholder="Entrez un email" required><br>
			<!-- UX email alert -->
			<?= $emailValidationAlert ?>

			<label for="name">Nom :</label><br>
			<input type="text" name="name" placeholder="Entrez votre name" id="name" required><br>

			<label for="lastname">Prénom :</label><br>
			<input type="text" name="lastname" placeholder="Entrez votre préname" id="lastname" required><br>

			<label for="nickname">Pseudo : </label><br>
			<input type="text" name="nickname" id="nickname" placeholder="Entrez un pseudo" required><br><br>

			<input type="submit" name="submit" value="Inscription">

			<!-- UX Alert -->
			<?= $signInSuccessalert ?>
		</form>
		</section>
	</body>
</html>