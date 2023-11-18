<?php
include("config.php");

function inserirMaterial($conn, $descricao) {
    $id_checklist = $_GET["id"];
    echo"$id_checklist";
    $descricaoMaiuscula = strtoupper($descricao);
    $resultadoExistente = null;
    $consultaExistente = $conn->prepare("SELECT * FROM itens_checklist WHERE pergunta = ? AND checklist_id = $id_checklist");
    $consultaExistente->bind_param("s", $descricaoMaiuscula);
    $consultaExistente->execute();
    $resultadoExistente = $consultaExistente->get_result();

    if ($resultadoExistente->num_rows == 1) {
        return "usuario existente!";
    }

    $inserir = $conn->prepare("INSERT INTO itens_checklist (pergunta, checklist_id) VALUES (?, $id_checklist)");
    $inserir->bind_param("s", $descricaoMaiuscula);
    
    if ($inserir->execute()) {
        return "Inserção bem-sucedida!";
    } else {
        return "Erro ao inserir dados: " . $conn->error;
    }
    
}
?>