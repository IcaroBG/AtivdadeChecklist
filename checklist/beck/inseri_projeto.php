<?php
include("config.php");

function inserirMaterial($conn, $descricao) {
    $id = $_SESSION["id"];
    echo"$id";
    $descricaoMaiuscula = strtoupper($descricao);
    $resultadoExistente = null;

    $consultaExistente = $conn->prepare("SELECT * FROM projetos WHERE nome = ? AND usuario_id = $id");
    $consultaExistente->bind_param("s", $descricaoMaiuscula);
    $consultaExistente->execute();
    $resultadoExistente = $consultaExistente->get_result();

    if ($resultadoExistente->num_rows == 1) {
        return "usuario existente!";
    }

    $inserir = $conn->prepare("INSERT INTO projetos (nome, usuario_id) VALUES (?, $id)");
    $inserir->bind_param("s", $descricaoMaiuscula);
    
    if ($inserir->execute()) {
        return "Inserção bem-sucedida!";
    } else {
        return "Erro ao inserir dados: " . $conn->error;
    }
    
}
?>
