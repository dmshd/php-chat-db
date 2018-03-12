<?php 
	require('generalfunctions.php');
	require('dbcon.php');
	session_start();
	
	
	$logError = $alreadySentAlert = "";

	if ( isset($_POST['loginButton']) AND !empty($_POST['login']) AND !empty($_POST['password']) ) {
		$inputLogin = sanitize($_POST['login']);
		$inputPwd = sanitize($_POST['password']);
		$sql_getLoginQuery = "SELECT userid, login, password, name, lastname, nickname from users where login = :login and password = :password";
		$sql_getLogin = $db->prepare($sql_getLoginQuery);
		$sql_getLogin->bindParam('login', $inputLogin, PDO::PARAM_STR);
		$sql_getLogin->bindParam('password', $inputPwd, PDO::PARAM_STR);
		$sql_getLogin->execute();
		$sql_getLoginArray = $sql_getLogin->fetch(PDO::FETCH_ASSOC);
		if ($sql_getLoginArray != false) {
			$_SESSION['user_id'] = $sql_getLoginArray['userid'];
			$_SESSION['user_login'] = $sql_getLoginArray['login'];
			$_SESSION['name'] = $sql_getLoginArray['name'];
			$_SESSION['lastname'] = $sql_getLoginArray['lastname'];
			$_SESSION['nickname'] = $sql_getLoginArray['nickname'];
			// printr($_SESSION);
		}
		else {
			$logError = '<p>Login ou mot de passe incorrect</p>';
		}
	}	

	if ( isset($_POST['msg_submit']) AND !empty($_POST['chat_msg']) ) {
		$msg = sanitize($_POST['chat_msg']);
		//Générer une chaîne md5 unique du message posté
		$messageIdent = md5($msg);
		//and check it against the stored value:
    	$sessionMessageIdent = isset($_SESSION['messageIdent'])?$_SESSION['messageIdent']:'';

    	if ( $messageIdent!=$sessionMessageIdent ) { //Si le message est différent 
            $_SESSION['messageIdent'] = $messageIdent; //On stocke sa clé unique pour vérification prochaine
	        $datetime = date("Y-m-d H:i:s");
			$chatMsgUser = $_SESSION['user_id'];
			$sql_AddChatMsgInsert = "INSERT INTO messages (message, dateheure, utilisateur) VALUES (?, ?, ?)";
			$sql_AddChatMsg = $db->prepare($sql_AddChatMsgInsert);
			$sql_AddChatMsg->bindParam(1, $msg);
			$sql_AddChatMsg->bindParam(2, $datetime);
			$sql_AddChatMsg->bindParam(3, $chatMsgUser);
			$sql_AddChatMsg->execute();
	    } else {
	       $alreadySentAlert = "<p>Vous avez déjà envoyé ceci ! <br> Vous ne pouvez pas envoyer deux fois le même message :-)</p>";
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
		
		<!-- If the user is logged in-->
		<?php if (isset($_SESSION['user_id']) AND !empty($_SESSION['user_id'])): ?>

		<!-- Welcome msg -->
		<section class="container">
			<h2> Bienvenue sur le chat, <?= $_SESSION['nickname'] ?> !</h2>
    	</section>

		<!-- displaying chat -->
		<section class="responsive-iframe">
			<iframe class="chat_frame" src="conversation.php" width="100%"></iframe>
		</section>

		<!-- chat submit form -->
			<!-- <form action="" method="POST">
				<div class="stretch">
					<input type="text" width="100px" name="chat_msg" placeholder="Ecris ici ton message..." required>
				</div>
				<div class="normal">
					<input type="submit" name="msg_submit">
				</div> -->
		<form action="" method="POST">
		<section class="container">
			<div class="flexbox">
				<div class="stretch">
                	<input type="text" name="chat_msg" placeholder="Ecris ton message ici..." required>
                </div>
                <div class="normal">
                	<button type="submit" name="msg_submit">Envoyer</button>
            	</div>
			</div>
            <!-- Already sent UX Alert -->
			<?= $alreadySentAlert ?>
    	</section>
    	</form>


		<!-- if the user isn't logged in -->
		<?php else : ?>

		<!-- Three last messages posted -->
		<section class="container">
			<h3>Les trois derniers messages postés sur le chat :</h3>
				<?php getThreeLastMessages($db); ?>
			<hr>
		</section>

		<!-- Last registered user -->
		<section class="container">
			<p>Dernier utilisateur inscrit : <strong><?php getLastRegisteredUser($db); ?></strong></p>
		</section>

		<!-- Login form -->
		<section class="container">
			<h3>Connexion</h3>
			<form action="index.php" method="POST">
				<label for="login">Login</label><br>
				<input type="text" name="login" placeholder="Entrez votre login" id="login" required><br>

				<label for="mdp">Mot de passe</label><br>
				<input type="text" name="password" placeholder="Entrez votre mot de passe" id="mdp" required><br>

				<input type="submit" name="loginButton" value="Login"> 
				<!-- UX Alert -->
				<?= $logError ?>
			</form>
			<p>Pas encore inscrit ? <br> <a href="signin.php">Crée un compte</a></p>
		</section>
		
		<?php endif; ?>

		<footer>
			<span class="center">
				<p><a href="https://github.com/dmshd/php-chat-db" target="_blank" alt="github php mysql chat Daniel Muyshond web developer brussels belgium" title="php-chat-db Github repository">php-chat-db</a>  - <a href="https://www.linkedin.com/in/danielmuyshond/" target="_blank" alt="php web developer seo growth hacker profile Muyshond Daniel belgium brussels" title="Muyshond Daniel profil LinkedIn">Muyshond Daniel</a> 2018</p>
				<?php if (isset($_SESSION['user_id']) AND !empty($_SESSION['user_id'])): ?>
				<div class="centerflex">
					<form action="logout.php">
						<input type="submit" name="Logout" value="Déconnexion">
					</form>
				</div>
				<?php endif; ?>
		</footer>

	</body>
</html>