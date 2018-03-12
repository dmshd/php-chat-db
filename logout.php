<!-- logout.php -->
<?php 
require('generalfunctions.php');
session_start();
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
			<h2>Déconnexion</h2>
			<h3>Aurevoir, <?php echo $_SESSION['nickname']; ?>... Reviens quand tu veux !</h3>
			 <?php logout(); ?>
		</section>
	</body>
</html>
