<?php
session_start();
if (!isset($_SESSION["email"])) {
    header("Location: index.php");
    exit();
}

$id = $_SESSION["id"];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- Add any necessary CSS or external scripts here -->
    <script>
        function IrChecklist(id, nome) {
            if (confirm("Are you sure you want to add a new checklist?")) {
                window.location.href = 'fazerChecklist.php?id=' + id + '&nome=' + nome;
            }
        }
        function VerChecklist(id, nome) {
            if (confirm("Are you sure you want to view a new checklist?")) {
                window.location.href = 'verChecklist.php?id=' + id + '&nome=' + nome;
            }
        }
    </script>
</head>
<body>

<nav>
    <ul>
        <li><a href="home.php">Inicio</a>/<a href="projeto.php">projeto</a> / <a href="checklist.php">checklist</a> / <a href="logout.php">Sair</a></li>
    </ul>
</nav>

<br><br><br><br>

<?php
include("beck/config.php");

$sqltabela = "SELECT c.nome AS checklist_nome, p.nome AS projeto_nome, p.id AS projeto_id, c.id AS checklist_id 
FROM checklists c, projetos p 
WHERE p.usuario_id = $id and c.projeto_id = p.id ;";

$resulttabela = $conn->query($sqltabela);

if ($resulttabela->num_rows > 0) {
    echo "<table border='1'>";
    echo "<tr><th>ID Projeto</th><th>Projeto</th><th>ID Checklist</th><th>Checklist</th></tr>";

    while ($row = $resulttabela->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["projeto_id"] . "</td>";
        echo "<td>" . $row["projeto_nome"] . "</td>";
        echo "<td>" . $row["checklist_id"] . "</td>";
        echo "<td>" . $row["checklist_nome"] . "</td>";
        echo "<td><button onclick=\"IrChecklist(" . $row["checklist_id"] . ", '" . $row["checklist_nome"] . "')\">Fazer Checklist</button></td>";
        echo "<td><button onclick=\"VerChecklist(" . $row["checklist_id"] . ", '" . $row["checklist_nome"] . "')\">Ver Checklist</button></td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "<center><strong>No projects registered.</center></strong>";
}

$conn->close();
?>
</body>
</html>
