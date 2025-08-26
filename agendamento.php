<?php
include('db.php');

$mensagem = '';
$redirecionar = false; // Flag para controlar o redirecionamento

if (isset($_POST['cadastrar'])) {
    $nome_cliente = $_POST['nome_cliente'];

    // Depuração: Verificar se o nome do cliente foi passado corretamente
    var_dump($nome_cliente); // Isso vai mostrar o que foi enviado pelo formulário, remova depois de testar!

    // Consulta para buscar o cliente
    $stmtCliente = $pdo->prepare("SELECT id_cliente FROM clientes WHERE nome LIKE ?");
    $stmtCliente->execute([ "%$nome_cliente%" ]); // Utiliza o LIKE para permitir uma busca mais flexível
    $cliente = $stmtCliente->fetch();

    // Verificar se o cliente foi encontrado
    if ($cliente) {
        $id_cliente = $cliente['id_cliente'];
        $id_barbeiro = $_POST['id_barbeiro'];
        $id_servico = $_POST['id_servico'];
        $data = $_POST['data_agendamento'];
        $hora = $_POST['hora_agendamento'];
        $observacoes = $_POST['observacoes'];

        // Evitar agendamento no passado
        $dataHoraInicio = strtotime("$data $hora");
        $agora = time();
        if ($dataHoraInicio < $agora) {
            $mensagem = 'Não é possível agendar para um horário passado.';
        } else {
            // Obter duração do serviço
            $stmtDuracao = $pdo->prepare("SELECT duracao_minutos FROM servicos WHERE id_servico = ?");
            $stmtDuracao->execute([$id_servico]);
            $duracao = $stmtDuracao->fetchColumn();

            if (!$duracao) {
                $mensagem = 'Serviço inválido.';
                return;
            }

            $hora_fim_novo = strtotime("+$duracao minutes", $dataHoraInicio);

            // Verificar conflitos com agendamentos existentes do barbeiro
            $stmtConflito = $pdo->prepare("SELECT a.hora_agendamento, s.duracao_minutos
                                            FROM agendamentos a
                                            JOIN servicos s ON a.id_servico = s.id_servico
                                            WHERE a.id_barbeiro = ? AND a.data_agendamento = ?");
            $stmtConflito->execute([$id_barbeiro, $data]);
            $conflito = false;

            while ($row = $stmtConflito->fetch()) {
                $inicio_existente = strtotime("$data {$row['hora_agendamento']}");
                $fim_existente = strtotime("+{$row['duracao_minutos']} minutes", $inicio_existente);

                if ($dataHoraInicio < $fim_existente && $hora_fim_novo > $inicio_existente) {
                    $conflito = true;
                    break;
                }
            }

            if ($conflito) {
                $mensagem = 'Conflito: o barbeiro já tem um agendamento nesse horário.';
            } else {
                try {
                    $stmt = $pdo->prepare("INSERT INTO agendamentos (id_cliente, id_barbeiro, id_servico, data_agendamento, hora_agendamento, observacoes) 
                                           VALUES (?, ?, ?, ?, ?, ?)");
                    $stmt->execute([$id_cliente, $id_barbeiro, $id_servico, $data, $hora, $observacoes]);

                    $mensagem = 'Agendamento realizado com sucesso!';
                    $redirecionar = true; // Setar para redirecionar após o sucesso
                } catch (PDOException $e) {
                    $mensagem = 'Erro ao agendar: ' . $e->getMessage();
                }
            }
        }
    } else {
        $mensagem = 'Nome de cliente não encontrado. Por favor, insira um nome válido.';
    }
}

// Consulta para exibir agendamentos
$stmt = $pdo->query("SELECT a.*, c.nome AS cliente, b.nome AS barbeiro, s.descricao AS servico 
                     FROM agendamentos a 
                     JOIN clientes c ON a.id_cliente = c.id_cliente 
                     JOIN barbeiros b ON a.id_barbeiro = b.id_barbeiro 
                     JOIN servicos s ON a.id_servico = s.id_servico");
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>L&M - Agendamento</title>
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
 
    <?php include_once('navbar3.html'); ?>

    <br>

    <section class="box">
    <form action="agendamento.php" method="post">
        <br>
        <label for="nome_cliente">Nome do Cliente:</label>
        <input class="cax form-control w-75 mx-auto" type="text" maxlength="80" name="nome_cliente" required>

        <label for="id_barbeiro">Barbeiro:</label>
        <select class="cax form-control w-75 mx-auto" name="id_barbeiro" required>
            <?php
            $stmtBarbeiros = $pdo->query("SELECT id_barbeiro, nome FROM barbeiros");
            while ($barbeiro = $stmtBarbeiros->fetch()) {
                echo "<option value='{$barbeiro['id_barbeiro']}'>{$barbeiro['nome']}</option>";
            }
            ?>
        </select>

        <label for="id_servico">Serviço:</label>
        <select class="cax form-control w-75 mx-auto" name="id_servico" required>
            <?php
            $stmtServicos = $pdo->query("SELECT id_servico, descricao FROM servicos");
            while ($servico = $stmtServicos->fetch()) {
                echo "<option value='{$servico['id_servico']}'>{$servico['descricao']}</option>";
            }
            ?>
        </select>

        <label for="data_agendamento">Data:</label>
        <input class="cax form-control w-75 mx-auto" type="date" name="data_agendamento" required>

        <label for="hora_agendamento">Hora:</label>
        <input class="cax form-control w-75 mx-auto" type="time" name="hora_agendamento" required>

        <label for="observacoes">Observações:</label>
        <textarea class="form-control w-75 mx-auto" name="observacoes"></textarea>

        <br>

        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary custom-btn botao mx-auto" name="cadastrar">Agendar</button>
        </div>

        <br>
    </form>
</section>

<?php if ($mensagem): ?>
    <div class="alert <?php echo (strpos($mensagem, 'sucesso') !== false) ? 'alert-success' : 'alert-danger'; ?> text-center" style="margin-top: 20px;" role="alert" id="mensagem">
        <?php echo $mensagem; ?>
    </div>

    <script>
        window.onload = function() {
            var mensagemElement = document.getElementById('mensagem');
            if (mensagemElement) {
                mensagemElement.scrollIntoView({ behavior: 'smooth' });
            }
        };
    </script>
<?php endif; ?>


    <hr class="featurette-divider">
    
    <br>

    <?php include_once('footer.html'); ?>

    <?php if ($redirecionar): ?>
        <script>
            setTimeout(function() {
                window.location.href = 'index.php';
            }, 3000);
        </script>
    <?php endif; ?>

    <script src="script.js"></script>

</body>
</html>
