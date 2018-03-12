<!-- conversation.php -->
<?php 

	require('generalfunctions.php');
	require('dbcon.php');
	session_start();



 ?>
 <!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width">
		 <meta name="description" content="Réaliser un chat via PHP/MySQL - Formation en développement web Becode Charleroi - web developpeur bruxelles, belgique. Muyshond Daniel 2018">
		 <META http-equiv="refresh" content="10">
		<link rel="stylesheet" type="text/css" href="./css/style.css">
		<title> PHP/MySQL chat - Becode Charleroi - web developpeur bruxelles, belgique. Muyshond Daniel 2018</title>
	</head>

	<body class="frame">
		<div class="conversation">
			<?php getConversation($db); ?>
		</div>
	</body>
</html>