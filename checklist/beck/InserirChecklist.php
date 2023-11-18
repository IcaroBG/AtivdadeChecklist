<?php
include("config.php");

function inserirMaterial($conn, $descricao) {
    $id_projeto = $_GET["id"];
    echo"$id_projeto";
    $descricaoMaiuscula = strtoupper($descricao);
    $resultadoExistente = null;
    $consultaExistente = $conn->prepare("SELECT * FROM checklists WHERE nome = ? AND projeto_id = $id_projeto");
    $consultaExistente->bind_param("s", $descricaoMaiuscula);
    $consultaExistente->execute();
    $resultadoExistente = $consultaExistente->get_result();

    if ($resultadoExistente->num_rows == 1) {
        return "usuario existente!";
    }

    $inserir = $conn->prepare("INSERT INTO checklists (nome, projeto_id) VALUES (?, $id_projeto)");
    $inserir->bind_param("s", $descricaoMaiuscula);
    
    if ($inserir->execute()) {
        return "Inserção bem-sucedida!";
    } else {
        return "Erro ao inserir dados: " . $conn->error;
    }
    
}
?>