<?php
session_start();

if (!isset($_SESSION["email"])) {
    header("Location: index.php"); // Redireciona para a página de login se o usuário não estiver logado
    exit();
}

// O código HTML da sua página restrita vai aqui
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Página restrita</title>
</head>
<body> 
	<nav>

			<li><a href="home.php">Inicio</a>/<a href="projeto.php">projeto</a> / <a href="checklist.php">checklist</a> / <a href="beck/logout.php">Sair</a></li>

	</nav>
</body>
</html>