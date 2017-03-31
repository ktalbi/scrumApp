<?php

session_start();

if( isset($_SESSION['user_id']) ){

	$_SESSION['user_id'] = $results['id'];

}

//require 'database.php';

require '../config/boot.php';

if(!empty($_POST['email']) && !empty($_POST['password'])):

	$records = $pdo->prepare('SELECT id,email,password,role FROM users WHERE email = :email');
	$records->bindParam(':email', $_POST['email']);
	$records->execute();
	$results = $records->fetch(PDO::FETCH_ASSOC);

	$message = '';

	if(count($results) > 0 && password_verify($_POST['password'], $results['password']) && ($results['role'] == "admin")) {



		header("Location: ../admin/page4.php");

	} else if (($results['role'] == "user")) {
		header("Location: ../user/page4.php");


	} else if (($results['role'] == "NULL")) {
	  $message = 'Privilèges non définis';

	} else {
		$message = 'Mauvais identifiants';
	}
    $credentials = json_encode($results['role']);
endif;

?>

<!DOCTYPE html>
<html>
<head>
	<title>Login Scrum Manager</title>
	<link rel="stylesheet" type="text/css" href="../css/style_login.css">
	<link href='http://fonts.googleapis.com/css?family=Comfortaa' rel='stylesheet' type='text/css'>
</head>
<body>

	<?php if(!empty($message)): ?>
		<p><?= $message ?></p>
	<?php endif; ?>

	<h1>Connexion</h1>


	<form action="login.php" method="POST">

		<input type="text" placeholder="Identifiant" name="email">
		<input type="password" placeholder="Mot de passe" name="password">

		<input type="submit">

	</form>

</body>
</html>
