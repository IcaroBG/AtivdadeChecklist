<?php
include("config.php");;
session_start(); // Inicie a sessão
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $senha = $_POST["senha"];

    // Consulta SQL para verificar as credenciais do usuário
    $sql = "SELECT * FROM usuarios WHERE email = '$email'AND senha = '$senha';";
    $resultado = $conn->query($sql);

    if ($resultado->num_rows == 1) {
        $row = $resultado->fetch_assoc();
        $_SESSION["email"] = $row["email"];
        $_SESSION["id"]  = $row["id"];
        header("Location: home.php"); // Redireciona para a página restrita após o login
        exit();
    } else {
        $erro = "Credenciais inválidas. Tente novamente.";
    }
}
?>