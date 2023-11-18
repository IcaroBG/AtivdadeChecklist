<?php
session_start(); // Inicie a sessão
if (!isset($_SESSION["email"])) {
    header("Location: index.php"); // Redireciona para a página de login se o usuário não estiver logado
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
</head>
<script>
    function IrChecklist(id, nome) {
        if (confirm("Tem certeza de que deseja adicionar uma nova checklist?")) {
            window.location.href = 'cadastroChecklist.php?id=' + id + '&nome=' + nome;
        }
    }
</script>
<body>
            <nav>

            <li><a href="home.php">Inicio</a>/<a href="projeto.php">projeto</a> / <a href="checklist.php">checklist</a> / <a href="beck/logout.php">Sair</a></li>

            </nav>
             <br><br><br><br>
             <form method="post" action="projeto.php">
                <label for="nomes">Nome:</label>
                <input type="text" name="nome" required>
                <input type="submit" value="cadastrar">
            </form>
            <?php
                include("beck/inseri_projeto.php");
                echo"$id";
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    if (isset($_POST["nome"])) {
                        $descricaoMaterial = $_POST["nome"];
                        
                        // Verifique se o campo "nome" não está vazio e não é igual a "TESTE"
                        if (!empty($descricaoMaterial) && strtoupper($descricaoMaterial) !== "TESTE") {
                            $resultadoInsercao = inserirMaterial($conn, $descricaoMaterial);
                            
                            if ($resultadoInsercao === "Inserção bem-sucedida!") {
                                $mensagem = "Inserção bem-sucedida!";
                            } else {
                                $mensagem = $resultadoInsercao;
                            }
                        } else {
                            $mensagem = "O campo 'nome' não foi preenchido ou contém o valor 'TESTE'.";          
                        }
                        if (isset($mensagem)){
                            echo $mensagem;
                            
                        
                        }
                    }
                    
                }  
                

            // Conexão com o banco de dados MySQL (substitua com suas informações de conexão)
            include("beck/config.php");;
            // Consulta SQL para obter os dados da tabela "avaliacao" com nomes correspondentes
            $sqltabela = "SELECT * FROM projetos where usuario_id = $id ";

            // Exibe a consulta SQL para depuração


            $resulttabela = $conn->query($sqltabela);

            if ($resulttabela->num_rows > 0) {
                echo "<table border='1'>";
                echo "<tr><th>ID</th><th>Projeto</th></tr>";

                while ($row = $resulttabela->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["id"] . "</td>";
                    echo "<td>" . $row["nome"] . "</td>";
                    echo "<td><button onclick=\"IrChecklist(" . $row["id"] . ", '" . $row["nome"] . "')\">add checklist </button></td>";
                    echo "</tr>";
                }
                

                echo "</table>";
            } else {
                echo "<center><strong>Nenhum projeto cadastrado.<center></strong>";
            }

            // Feche a conexão com o banco de dados
            $conn->close();
            ?>

</body>
</html>