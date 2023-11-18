
<?php 
session_start(); // Inicie a sessão
if (!isset($_SESSION["email"])) {
    header("Location: index.php"); // Redireciona para a página de login se o usuário não estiver logado
    exit();

}
// Verifique se as chaves "id" e "nome" estão definidas em $_GET
$id_projeto = isset($_GET["id"]) ? $_GET["id"] : null;
$nome_proj = isset($_GET["nome"]) ? $_GET["nome"] : null;

// Restante do seu código...
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>cadastrando checklist</title>
    <script>
    function IrPerguntas(id, nome) {
        if (confirm("Tem certeza de que deseja adicionar perguntas ao checklist?")) {
            window.location.href = 'cadastroPerguntas.php?id=' + id + '&nome=' + nome;
        }
    }
</script>
</head>
<body>
   
<nav>

<li><a href="home.php">Inicio</a>/<a href="projeto.php">Voltar</a> 
</nav>
 <br><br><br>
 <h3>Projeto: <?php echo $nome_proj ; ?></h3>
 <br>
 <h4>Nome do checklist</h2>
 <form method="post" action="">
    <label for="nomes">Nome:</label>
    <input type="text" name="nome" required>
    <input type="submit" value="cadastrar">
 
</form> 
    <br>
   <?php 

      include("beck/InserirChecklist.php");
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
    $sqltabela = "SELECT * FROM checklists where projeto_id= $id_projeto ";

    // Exibe a consulta SQL para depuração


    $resulttabela = $conn->query($sqltabela);

    if ($resulttabela->num_rows > 0) {
        echo "<table border='1'>";
        echo "<tr><th>ID</th><th>Projeto</th></tr>";

        while ($row = $resulttabela->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["id"] . "</td>";
            echo "<td>" . $row["nome"] . "</td>";
            echo "<td><button onclick=\"IrPerguntas(" . $row["id"] . ", '" . $row["nome"] . "')\">add perguntas </button></td>";
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