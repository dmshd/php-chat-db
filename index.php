<?php 
	require('generalfunctions.php');
	$loginForm = $loginMdp = "";

	if ($_SERVER['REQUEST_METHOD'] == 'POST' AND isset($_POST['login_submit'])) {
	$getLogin = sanitize($_POST['login']);
	$getPwd = sanitize($_POST['mdp']);
		echo $getLogin . '<br>';
		echo $getPwd;
	}

 ?>
<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<title>php-chat-db - login</title>
</head>
<body>
	<?php 
	
	 ?>
	<h1>php-chat-db</h1>
	<h2>Connexion</h2>
	<div class="loginbox">
		<form action="index.php" method="POST">
			<label for="login">Login</label><br>
			<input type="text" name="login" placeholder="Entrez votre login" id="login"><br>
			<label for="mdp">Mot de passe</label><br>
			<input type="text" name="mdp" placeholder="Entrez votre mot de passe" id="mdp"><br>
			<input type="submit" name="login_submit" value="Login"> 
		</form>
		<p>Pas encore inscrit ? <br> <a href="signin.php">Crée un compte</a></p>
	</div>

</body>
</html>