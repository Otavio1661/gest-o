<?php
include __DIR__ . '/../../core/config.php'; // substitua pelo seu arquivo de conexão

if (isset($_POST['id'])) {
  $id = intval($_POST['id']);

  $sql = "DELETE FROM clientes WHERE idcliente = $id";

  if (mysqli_query($connect, $sql)) {
    echo "success";
  } else {
    echo "error";
  }
} else {
  echo "invalid";
}
?>
