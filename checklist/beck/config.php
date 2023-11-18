<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "checklist";

    $conn = new mysqli($servername, $username, $password, $database);

    // Verifique a conexão
    if ($conn->connect_error) {
        die("Erro na conexão com o banco de dados: " . $conn->connect_error);
    }
?>