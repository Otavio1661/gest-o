<?php
include __DIR__ . '/../../core/config.php';

// Pega os dados do POST e trata (exemplo simples, pode melhorar com validação e sanitização)
$idcliente = $_POST['idcliente'] ?? '';
$nome = $_POST['nome'] ?? '';
$telefone = $_POST['telefone'] ?? '';
$cpf = $_POST['cpf'] ?? '';
$uf = $_POST['uf'] ?? '';
$cidade = $_POST['cidade'] ?? '';
$bairro = $_POST['bairro'] ?? '';
$rua = $_POST['rua'] ?? '';
$numero = $_POST['numero'] ?? '';
$ativo = isset($_POST['ativo']) ? 1 : 0;

if (empty($idcliente)) {
    // Inserção cliente
    $stmt = $connect->prepare("INSERT INTO clientes (nome, telefone, cpf, uf, cidade, bairro, rua, numero, ativo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssss", $nome, $telefone, $cpf, $uf, $cidade, $bairro, $rua, $numero, $ativo);

    if ($stmt->execute()) {
        $clienteAddSucesso = urlencode("Sucesso ao adicionar cliente! :)");
        header("Location: /../../../projeto_01/index.php?SucessoAddC=$clienteAddSucesso");
        exit;
    } else {
        $clienteAddErro = urlencode("Erro ao adicionar cliente! :/");
        header("Location: /../../../projeto_01/index.php?ErroAddC=$clienteAddErro");
        exit;
    }
} else {
    // Atualização cliente
    $stmt = $connect->prepare("UPDATE clientes SET nome = ?, telefone = ?, cpf = ?, uf = ?, cidade = ?, bairro = ?, rua = ?, numero = ?, ativo = ? WHERE idcliente = ?");
    $stmt->bind_param("sssssssssi", $nome, $telefone, $cpf, $uf, $cidade, $bairro, $rua, $numero, $ativo, $idcliente);
    
    if ($stmt->execute()) {
        $clienteUpSucesso = urlencode("Sucesso ao atualizar cliente! :)");
        header("Location: /../../../projeto_01/index.php?SucessoUpC=$clienteUpSucesso");
        exit;
    } else {
        $clienteUpErro = urlencode("Erro ao atualizar cliente! :/");
        header("Location: /../../../projeto_01/index.php?ErroUpC=$clienteUpErro");
        exit;
    }
}

$stmt->close();
$connect->close();
?>