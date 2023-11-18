<?php
session_start();
if (!isset($_SESSION["email"])) {
    header("Location: index.php");
    exit();
}

$id = $_SESSION["id"];
$id_checklist = isset($_GET["id"]) ? $_GET["id"] : null;
$nome_check = isset($_GET["nome"]) ? $_GET["nome"] : null;

include("beck/config.php");

// Consulta SQL para buscar os dados da tabela
$sqltabela = "SELECT * FROM itens_checklist WHERE checklist_id = $id_checklist";
$resulttabela = $conn->query($sqltabela);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualizar Itens de Checklist</title>
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

        /* Desabilita os checkboxes */
        input[type="checkbox"] {
            pointer-events: none;
        }
    </style>
</head>
<body>

<nav>
    <ul>
        <li><a href="home.php">Inicio</a>/<a href="#" onclick="goBack()">Voltar</a></li>
    </ul>
</nav>

<br><br><br><br>
<h2>Visualizar Itens de Checklist</h2>

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
        if ($resulttabela->num_rows > 0) {
            while ($row = $resulttabela->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["id"] . "</td>";
                echo "<td>" . $row["pergunta"] . "</td>";
                echo "<td><input type='checkbox' " . ($row["sim"] ? "checked" : "") . " disabled></td>";
                echo "<td><input type='checkbox' " . ($row["nao"] ? "checked" : "") . " disabled></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4'>Nenhum item encontrado.</td></tr>";
        }
        ?>
    </tbody>
</table>

<script>
    function goBack() {
        location.replace(document.referrer);
    }
</script>

</body>
</html>
