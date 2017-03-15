<?php

session_start();

if( isset($_SESSION['user_id']) ){
	header("Location: /");
}

require '../config/boot.php';

$message = '';

if(!empty($_POST['email']) && !empty($_POST['password'])):

	// Enter the new user in the database
	$sql = "INSERT INTO users (email, password) VALUES (:email, :password)";
	$stmt = $conn->prepare($sql);

	$stmt->bindParam(':email', $_POST['email']);
	$stmt->bindParam(':password', password_hash($_POST['password'], PASSWORD_BCRYPT));

	if( $stmt->execute() ):
		$message = 'Utilisateur crée';
	else:
		$message = 'Une erreur est survenue, veuillez essayer de nouveau';
	endif;

endif;

?>

<!DOCTYPE html>
<html>
<head>
	<title>Inscription</title>
	<link rel="stylesheet" type="text/css" href="../css/style_login.css">
	<link href='http://fonts.googleapis.com/css?family=Comfortaa' rel='stylesheet' type='text/css'>
</head>
<body>


	<?php if(!empty($message)): ?>
		<p><?= $message ?></p>
	<?php endif; ?>

	<h1>Inscription</h1>
	<span>ou <a href="login.php">Connexion</a></span>

	<form action="register.php" method="POST">

		<input type="text" placeholder="Identifiant" name="email">
		<input type="password" placeholder="Mot de passe" name="password">
		<input type="password" placeholder="Confirmer" name="confirm_password">
		<input type="submit">

	</form>

</body>
</html>
