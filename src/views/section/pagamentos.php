<?php
include 'config.php';

$sql = "SELECT 
l.*, 
c.nome AS nome_cliente
FROM 
log_alteracoes_notinhas l
LEFT JOIN 
notinhas n ON l.idnotinha = n.idnotinha
LEFT JOIN 
clientes c ON n.idcliente = c.idcliente
WHERE 
l.campo_alterado = 'valor'
ORDER BY
l.idnotinha,
l.data_alteracao DESC;";

$result = mysqli_query($connect, $sql);
?>
<section id="pagamentos" class="bg-light">
    <h2>Alterações de Notinhas</h2>

    <table id="logAlteracoes" class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>ID Notinha</th>
                <th>Cliente</th>
                <th>Campo Alterado</th>
                <th>Valor Antigo</th>
                <th>Valor Debitado</th>
                <th>Valor Novo</th>
                <th>Data da Alteração</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)) :
                $campo = $row['campo_alterado'];
                $valorAntigo = $row['valor_antigo'];
                $valorNovo = $row['valor_novo'];
                $isNumeroAntigo = is_numeric($valorAntigo);
                $isNumeroNovo = is_numeric($valorNovo);

                // Valor debitado
                if ($campo === 'pago' && $valorNovo == 1) {
                    $valorDebitado = number_format($valorAntigo, 2, ',', '.');
                    $valorNovoFormatado = 'Pago';
                } elseif ($isNumeroAntigo && $isNumeroNovo) {
                    $valorDebitado = number_format($valorAntigo - $valorNovo, 2, ',', '.');

                    // Se for campo 'valor' e valor novo == 0, exibe 'Pago'
                    if ($campo === 'valor' && floatval($valorNovo) == 0) {
                        $valorNovoFormatado = 'Pago';
                    } else {
                        $valorNovoFormatado = number_format($valorNovo, 2, ',', '.');
                    }
                } else {
                    $valorDebitado = '-';
                    if ($campo === 'pago' && ($valorNovo == 0 || $valorNovo === null || $valorNovo === '')) {
                        $valorNovoFormatado = 'Não Pago';
                    } else {
                        $valorNovoFormatado = htmlspecialchars($valorNovo);
                    }
                }

                $valorAntigoFormatado = $isNumeroAntigo ? number_format($valorAntigo, 2, ',', '.') : htmlspecialchars($valorAntigo);
            ?>
                <tr>
                    <td><?= $row['idnotinha'] ?></td>
                    <td><?= htmlspecialchars($row['nome_cliente']) ?></td>
                    <td><?= htmlspecialchars($campo) ?></td>
                    <td><?= $valorAntigoFormatado ?></td>
                    <td><?= $valorDebitado ?></td>
                    <td><?= $valorNovoFormatado ?></td>
                    <td><?= date('d/m/Y H:i', strtotime($row['data_alteracao'])) ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <script>
        $(document).ready(function() {
            $('#logAlteracoes').DataTable({
                "pageLength": 10,
                "lengthMenu": [10, 30, 100],
                "language": {
                    "search": "Buscar:",
                    "lengthMenu": "Mostrar _MENU_ registros por página",
                    "zeroRecords": "Nenhum resultado encontrado",
                    "info": "Mostrando página _PAGE_ de _PAGES_",
                    "infoEmpty": "Nenhum registro disponível",
                    "infoFiltered": "(filtrado de _MAX_ registros no total)",
                    "paginate": {
                        "first": "Primeira",
                        "last": "Última",
                        "next": "Próxima",
                        "previous": "Anterior"
                    }
                }
            });
        });
    </script>
</section>