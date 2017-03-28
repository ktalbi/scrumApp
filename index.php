
<!DOCTYPE html>
<html>
<head>
	<title>Scrum Manager</title>
	<link rel="stylesheet" type="text/css" href="css/style_login.css">
	<link href='http://fonts.googleapis.com/css?family=Comfortaa' rel='stylesheet' type='text/css'>
</head>
<body>


	<?php if( !empty($user) ): ?>

		<br />Bienvenue <?= $user['email']; ?>
		<br /><br />Vous etes connecté à Scrum Manager!
		<br /><br />
		<a href="login/logout.php">Se déconnecter?</a>

	<?php else: ?>

		<h1>Connexion</h1>
		<a href="login/login.php" class="logcolor">Connexion</a> Ou
		<a href="login/register.php" class="logcolor">Inscription</a>

	<?php endif; ?>

</body>
</html>

<?php

session_start();

//require 'login/database.php';
require 'config/boot.php';

if( isset($_SESSION['user_id']) ){

	$records = $pdo->prepare('SELECT * FROM users WHERE id = :id' );
	$records->bindParam(':id', $_SESSION['user_id']);
	$records->execute();
	$results = $records->fetch(PDO::FETCH_ASSOC);

	$user = NULL;

	if( count($results) > 0){
		$user = $results;
	}
}
?>
