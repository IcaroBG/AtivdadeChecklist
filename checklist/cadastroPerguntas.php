
<?php 
session_start(); // Inicie a sessão
if (!isset($_SESSION["email"])) {
    header("Location: index.php"); // Redireciona para a página de login se o usuário não estiver logado
    exit();

}
// Verifique se as chaves "id" e "nome" estão definidas em $_GET
$id_checklist = isset($_GET["id"]) ? $_GET["id"] : null;
$nome_check = isset($_GET["nome"]) ? $_GET["nome"] : null;

// Restante do seu código...
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perguntas</title>
    <script>
    function goBack() {
        location.replace(document.referrer);
    }
</script>
</head>
<body>
<nav>

<li><a href="home.php">Inicio</a>/<button onclick="goBack()">Voltar</button> 
</nav>
 <br><br><br>
 <h3>checklist: <?php echo $nome_check ; ?></h3>
 <br>
 <h4>Perguntas</h2>
 <form method="post" action="">
    <label for="nomes">Descrição:</label>
    <input type="text" name="nome" required>
    <input type="submit" value="cadastrar">
 
</form> 
  <?php
        include("beck/InserirPErguntas.php");
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
    $sqltabela = "SELECT * FROM itens_checklist where checklist_id= $id_checklist ";

    // Exibe a consulta SQL para depuração


    $resulttabela = $conn->query($sqltabela);

    if ($resulttabela->num_rows > 0) {
        echo "<table border='1'>";
        echo "<tr><th>ID</th><th>Projeto</th></tr>";

        while ($row = $resulttabela->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["id"] . "</td>";
            echo "<td>" . $row["pergunta"] . "</td>";
            echo "<td><button onclick=\"IrPerguntas(" . $row["id"] . ", '" . $row["pergunta"] . "')\">add perguntas </button></td>";
            echo "</tr>";
        }
        

        echo "</table>";
    } else {
        echo "<strong>Nenhum checklist cadastrado.</strong>";
    }

    // Feche a conexão com o banco de dados
    $conn->close();
    ?>
</body>
</html>