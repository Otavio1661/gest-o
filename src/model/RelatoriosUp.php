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

// Validação básica
if (empty($idcliente) || empty($data) || empty($valor)) {
    $msgErro = urlencode("Campos obrigatórios não foram preenchidos.");
    header("Location: /../../../projeto_01/index.php?ErroCampos=$msgErro");
    exit;
}

// Função para registrar log de alterações
function logAlteracao($connect, $idnotinha, $campo, $antigo, $novo) {
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
    $stmt->bind_param("issis", $idcliente, $data, $valor, $pago, $descricao);

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
    logAlteracao($connect, $idnotinha, 'valor', $oldData['valor'], $valorRestante); // <-- aqui compara valor antigo com valor restante novo
    logAlteracao($connect, $idnotinha, 'pago', $oldData['pago'], $pago);
    logAlteracao($connect, $idnotinha, 'descricao', $oldData['descricao'], $descricao);

    // Atualiza no banco
    $stmt = $connect->prepare("UPDATE notinhas SET idcliente = ?, data = ?, valor = ?, pago = ?, descricao = ? WHERE idnotinha = ?");
    $stmt->bind_param("issisi", $idcliente, $data, $valorRestante, $pago, $descricao, $idnotinha);

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
