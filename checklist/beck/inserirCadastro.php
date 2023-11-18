<?php
    include("config.php");
    
    $email = $_POST["email"]; 
    $senha = $_POST["senha"];
    $nome = $_POST["nome"];
    // Consulta SQL para verificar as credenciais do usuário
    $sql = "SELECT * FROM usuarios WHERE email = '$email';";
    $resultado = $conn->query($sql);

    if ($resultado->num_rows == 1) {
        $row = $resultado->fetch_assoc();
        echo "<script>alert('Usuario existente!');</script>";
        echo "<script>window.location.href = '../cadastro.php';</script>"; // Redireciona para a página restrita após o login
 
    }    
    $sql = "INSERT INTO usuarios (nome, email, senha) VALUES ('$nome', '$email', '$senha');";


    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Inserção bem-sucedida!');</script>";
        echo "<script>window.location.href = '../cadastro.php';</script>";
    } else {
        echo "Erro ao inserir dados: " . $conn->error;
    }

    //$conn.close();  
    ?>