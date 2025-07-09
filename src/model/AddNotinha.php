<?php
include __DIR__ . '/../../core/config.php';

// Pega os dados do POST
$idnotinha = $_POST['idnotinha'] ?? '';
$idcliente = $_POST['idcliente'] ?? '';
$data = $_POST['data'] ?? '';
$valor = $_POST['valor'] ?? ''; 
$valorRestante = $_POST['valor-restante'] ?? ''; 
$descricao = $_POST['descricao'] ?? '';
$pago = isset($_POST['pago']) ? 1 : 0;

// Tratamento do valor restante
if ($pago == 0 && $valorRestante == null) {
    $valorRestante = $valor;
}

// Se pago, força valorRestante para 0
if ($pago == 1) {
    $valorRestante = 0;
}

$valorAtualizado = $valorRestante; // valor que será salvo e usado no log

// Validação básica
if (empty($idcliente) || empty($data) || empty($valor)) {
    $msgErro = urlencode("Campos obrigatórios não foram preenchidos.");
    header("Location: /../../../projeto_01/index.php?ErroCampos=$msgErro");
    exit;
}

function logAlteracao($connect, $idnotinha, $campo, $antigo, $novo) {
    // Se for o campo "pago", força 0 se novo valor estiver vazio
    if ($campo === 'pago') {
        $novo = ($novo === '' || $novo === null) ? 0 : (int) $novo;
    }

    // Só registra se houve alteração
    if ($antigo != $novo) {
        $campo = mysqli_real_escape_string($connect, $campo);
        $antigo = mysqli_real_escape_string($connect, $antigo);
        $novo = mysqli_real_escape_string($connect, $novo);

        $sqlLog = "INSERT INTO log_alteracoes_notinhas 
                   (idnotinha, campo_alterado, valor_antigo, valor_novo, data_alteracao) 
                   VALUES ($idnotinha, '$campo', '$antigo', '$novo', NOW())";
        mysqli_query($connect, $sqlLog);
    }
}

if (empty($idnotinha)) {
    // INSERÇÃO
    $stmt = $connect->prepare("INSERT INTO notinhas (idcliente, data, valor, pago, descricao) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("issis", $idcliente, $data, $valorAtualizado, $pago, $descricao);

    if ($stmt->execute()) {
        $msgSucesso = urlencode("Sucesso ao adicionar notinha! :)");
        header("Location: /../../../projeto_01/index.php?SucessoAddN=$msgSucesso");
    } else {
        $msgErro = urlencode("Erro ao adicionar notinha! :/");
        header("Location: /../../../projeto_01/index.php?ErroAddN=$msgErro");
    }
    $stmt->close();

} else {
    // ATUALIZAÇÃO

    // Busca dados antigos
    $sqlOld = "SELECT * FROM notinhas WHERE idnotinha = ?";
    $stmtOld = $connect->prepare($sqlOld);
    $stmtOld->bind_param("i", $idnotinha);
    $stmtOld->execute();
    $resultOld = $stmtOld->get_result();
    $oldData = $resultOld->fetch_assoc();
    $stmtOld->close();

    // Log de alterações
    logAlteracao($connect, $idnotinha, 'idcliente', $oldData['idcliente'], $idcliente);
    logAlteracao($connect, $idnotinha, 'data', $oldData['data'], $data);
    logAlteracao($connect, $idnotinha, 'valor', $oldData['valor'], $valorAtualizado);
    logAlteracao($connect, $idnotinha, 'pago', $oldData['pago'], $pago);
    logAlteracao($connect, $idnotinha, 'descricao', $oldData['descricao'], $descricao);

    // Atualiza no banco
    $stmt = $connect->prepare("UPDATE notinhas SET idcliente = ?, data = ?, valor = ?, pago = ?, descricao = ? WHERE idnotinha = ?");
    $stmt->bind_param("issisi", $idcliente, $data, $valorAtualizado, $pago, $descricao, $idnotinha);

    if ($stmt->execute()) {
        $msgSucesso = urlencode("Sucesso ao atualizar notinha! :)");
        header("Location: /../../../projeto_01/index.php?SucessoUpN=$msgSucesso");
    } else {
        $msgErro = urlencode("Erro ao atualizar notinha! :/");
        header("Location: /../../../projeto_01/index.php?ErroUpN=$msgErro");
    }
    $stmt->close();
}

$connect->close();
?>
