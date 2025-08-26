<?php
include('db.php'); 

if (isset($_POST['cadastrar'])) {
    // Recebe os dados do formulário
    $nome = $_POST['nome'];
    $cpf = $_POST['cpf'];
    $fone = $_POST['fone'];
    $email = $_POST['email'];
    $data_nascimento = $_POST['data_nascimento'];

    // Verifica se o CPF ou o email já existem no banco de dados
    $sqlVerificar = "SELECT * FROM clientes WHERE cpf = :cpf OR email = :email";
    $stmtVerificar = $pdo->prepare($sqlVerificar);
    $stmtVerificar->bindParam(':cpf', $cpf);
    $stmtVerificar->bindParam(':email', $email);
    $stmtVerificar->execute();

    // Se já existir um usuário com o CPF ou email, redireciona para agendamento.php
    if ($stmtVerificar->rowCount() > 0) {
        header("Location: agendamento.php");
        exit; // Interrompe o script para evitar execução adicional
    }

    // Se o CPF e o email não existirem, prossegue com o cadastro
    $sql = "INSERT INTO clientes (nome, cpf, fone, email, data_nascimento) 
            VALUES (:nome, :cpf, :fone, :email, :data_nascimento)";
    
    $stmt = $pdo->prepare($sql);

    // Vincula os parâmetros à consulta
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':cpf', $cpf);
    $stmt->bindParam(':fone', $fone);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':data_nascimento', $data_nascimento);

    // Executa a consulta e verifica se foi bem-sucedida
    try {
        $stmt->execute();
        
        // Se o cadastro foi bem-sucedido, redireciona para agendamento.php
        header("Location: agendamento.php"); // Redireciona para agendamento.php
        exit; // Encerra a execução do script
    } catch (PDOException $e) {
        echo "Erro ao cadastrar: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>L&M - Cadastro</title>
    <link rel="stylesheet" href="estilos.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:ital,opsz,wght@0,18..144,300..900;1,18..144,300..900&family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Raleway:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    
    <!-- Link para utilizar pela Internet -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- Link para utilizar no computador -->
    <link href="bootstrap533/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

</head>
<body style="background-color: var(--background);">
      
    <!-- Link para utilizar pela Internet -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        
    <!-- Link para utilizar no computador -->
    <script src="bootstrap533/js/bootstrap.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  
    <?php include_once('navbar2.html'); ?>

    <br>

    <section class="box">
    <form action="cadastro.php" method="post">
        <br>
        <label for="nome">Nome:</label>
        <input class="cax form-control w-75 mx-auto"  type="text" name="nome" required>

        <label for="cpf">CPF:</label>
        <input class="cax form-control w-75 mx-auto"  type="text" name="cpf" required>

        <label for="fone">Telefone:</label>
        <input class="cax form-control w-75 mx-auto"  type="text" name="fone">

        <label for="email">Email:</label>
        <input class="cax form-control w-75 mx-auto"  type="email" name="email">

        <label for="data_nascimento">Data de Nascimento:</label>
        <input class="cax form-control w-75 mx-auto"  type="date" name="data_nascimento" required>

        <br>

        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary custom-btn botao mx-auto" name="cadastrar">Cadastrar</button>
        </div>

        <br>

    </form>
    </section>
    
    <br>

    <?php include_once('footer.html'); ?>

    <script src="script.js"></script>

</body>
</html>
