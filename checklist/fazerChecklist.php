<?php
session_start();
if (!isset($_SESSION["email"])) {
    header("Location: index.php");
    exit();
}

$id = $_SESSION["id"];
$id_checklist = isset($_GET["id"]) ? $_GET["id"] : null;
$nome_check = isset($_GET["nome"]) ? $_GET["nome"] : null;

// Inclua o arquivo de configuração do banco de dados
include("beck/config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Certifique-se de validar e escapar os dados adequadamente

    foreach ($_POST['resposta'] as $perguntaId => $resposta) {
        $sim = isset($resposta['opcao']) && $resposta['opcao'] === 'sim' ? 1 : 0;
        $nao = isset($resposta['opcao']) && $resposta['opcao'] === 'nao' ? 1 : 0;

        // Use declarações preparadas para evitar SQL injection
        $stmt = $conn->prepare("UPDATE itens_checklist SET sim = ?, nao = ? WHERE id = ?");
        $stmt->bind_param("iii", $sim, $nao, $perguntaId);

        if ($stmt->execute()) {
            // Atualização bem-sucedida
            echo "Checklist atualizado com sucesso!";
        } else {
            // Erro na atualização
            echo "Erro ao atualizar dados: " . $stmt->error;
        }

        // Feche a declaração
        $stmt->close();
    }

    // Feche a conexão com o banco de dados
    $conn->close();
}
?>

<!-- O restante do seu código HTML permanece o mesmo -->


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Itens de Checklist</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }
    </style>
    <!-- Add any necessary CSS or external scripts here -->
    <script>
        function IrChecklist(id, nome) {
            if (confirm("Are you sure you want to add a new checklist?")) {
                window.location.href = 'fazerChecklist.php?id=' + id + '&nome=' + nome;
            }
        }
        function goBack() {
        location.replace(document.referrer);
    }
    document.addEventListener("DOMContentLoaded", function () {
        var checkboxes = document.querySelectorAll('input[name^="resposta"]');
        checkboxes.forEach(function (checkbox) {
            checkbox.addEventListener('change', function () {
                if (this.checked) {
                    checkboxes.forEach(function (otherCheckbox) {
                        if (otherCheckbox !== checkbox && otherCheckbox.name === checkbox.name) {
                            otherCheckbox.checked = false;
                        }
                    });
                }
            });
        });
    });
</script>
</head>
<body>

<nav>
    <ul>
        <li><a href="home.php">Inicio</a>/<a href="#" onclick="goBack()">Voltar</a></li>
    </ul>
</nav>

<br><br><br><br>
<h2>Itens de Checklist</h2>

<form method="post" action="">
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Pergunta</th>
                <th>Sim</th>
                <th>Não</th>
            </tr>
        </thead>
        <tbody>
        <?php
        include("beck/config.php");

        $sqltabela = "SELECT * FROM itens_checklist WHERE checklist_id = $id_checklist";
        $resulttabela = $conn->query($sqltabela);

        if ($resulttabela->num_rows > 0) {
            while ($row = $resulttabela->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["id"] . "</td>";
                echo "<td>" . $row["pergunta"] . "</td>";
                echo "<td><input type='checkbox' name='resposta[{$row["id"]}][opcao]' value='sim' " . ($row["sim"] ? "checked" : "") . "></td>";
                echo "<td><input type='checkbox' name='resposta[{$row["id"]}][opcao]' value='nao' " . ($row["nao"] ? "checked" : "") . "></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4'>Nenhum item encontrado.</td></tr>";
        }
        ?>
        </tbody>
    </table>
    <input type="submit" value="Atualizar Checklist">
</form>

<script>
    function goBack() {
        location.replace(document.referrer);
    }
</script>

</body>
</html>
