<?php
include __DIR__ . '/../../core/config.php';

// Pega os dados do POST
$idnotinha = $_POST['idnotinha'] ?? '';
$idcliente = $_POST['idcliente'] ?? '';
$data = $_POST['data'] ?? '';
$valor = $_POST['valor'] ?? '';
$descricao = $_POST['descricao'] ?? '';
$pago = isset($_POST['pago']) ? 1 : 0;

if (empty($idnotinha)) {
    // Inserção de notinha
    $stmt = $connect->prepare("INSERT INTO notinhas (idcliente, data, valor, pago, decricao) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("issis", $idcliente, $data, $valor, $pago, $descricao);

    if ($stmt->execute()) {
        $msgSucesso = urlencode("Sucesso ao adicionar notinha! :)");
        header("Location: /../../../projeto_01/index.php?SucessoAddN=$msgSucesso");
        exit;
    } else {
        $msgErro = urlencode("Erro ao adicionar notinha! :/");
        header("Location: /../../../projeto_01/index.php?ErroAddN=$msgErro");
        exit;
    }
} else {
    // Atualização de notinha
    $stmt = $connect->prepare("UPDATE notinhas SET idcliente = ?, data = ?, valor = ?, pago = ?, decricao = ? WHERE idnotinha = ?");
    $stmt->bind_param("issisi", $idcliente, $data, $valor, $pago, $descricao, $idnotinha);

    if ($stmt->execute()) {
        $msgSucesso = urlencode("Sucesso ao atualizar notinha! :)");
        header("Location: /../../../projeto_01/index.php?SucessoUpN=$msgSucesso");
        exit;
    } else {
        $msgErro = urlencode("Erro ao atualizar notinha! :/");
        header("Location: /../../../projeto_01/index.php?ErroUpN=$msgErro");
        exit;
    }
}

$stmt->close();
$connect->close();
?>
