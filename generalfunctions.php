<!-- generalfunctions.php -->
<?php

// Display errors
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

//Debugging tools
function sanitize($a) {
		$a = filter_var($a, FILTER_SANITIZE_STRING);
		$a = trim($a);
		return $a;
	}

function printr($a) {
		echo '<pre>';
		print_r($a);
		echo '</pre>';
	}

//Chat functions
function getLoginSession($db) {
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
	}
}
function getConversation($db) {
    $sql_conversation =  'SELECT messages.dateheure, users.nickname, messages.message FROM `messages` LEFT JOIN users ON messages.utilisateur = users.userid ORDER BY messages.dateheure ASC;';
    foreach  ($db->query($sql_conversation) as $conversation) {
        echo '<p class="chatMsg">(' . $conversation['dateheure'] .') ' . $conversation['nickname'] . ' : <span class="msg">' . $conversation['message'] . '</span></p>' ;
  }
}

function getThreeLastMessages($db) {
    $sql_conversation =  'SELECT messages.dateheure, users.nickname, messages.message FROM `messages` LEFT JOIN users ON messages.utilisateur = users.userid ORDER BY messages.dateheure DESC LIMIT 3;';
    foreach  ($db->query($sql_conversation) as $conversation) {
        echo '<p>(' . $conversation['dateheure'] .') ' . $conversation['nickname'] . ' : ' . $conversation['message'] . '</p>' ;
  }
}
function getLastRegisteredUser($db) {
	$sql_lastRegisteredUser =  'SELECT users.nickname FROM users ORDER BY users.date_created DESC LIMIT 1;';
	$lastRegisteredUser = $db->query($sql_lastRegisteredUser);
	$lastRegisteredUser = $lastRegisteredUser->fetch();
	echo $lastRegisteredUser['nickname'];
}
function logout() {
	session_destroy();
	sleep(1);
	header('Refresh:4; url=index.php');
}
?>

