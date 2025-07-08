<?php

// Consulta as movimentações do caixa, ordenando pela data mais recente
$sql_caixa = "SELECT * FROM caixa ORDER BY data DESC";
$result_caixa = mysqli_query($connect, $sql_caixa);

// Inicializa os totais
$total_entrada = 0;
$total_saida = 0;
?>

<section id="caixa" class="bg-white">
    <h2>Caixa</h2>
    <p>Área de controle do caixa.</p>

    <table id="controleCaixa" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Data</th>
                <th>Tipo</th>
                <th>Descrição</th>
                <th>Valor</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result_caixa)) : ?>
                <?php
                // Soma os valores conforme o tipo
                if ($row['tipo'] == 'entrada') {
                    $total_entrada += floatval($row['valor']);
                } elseif ($row['tipo'] == 'saida') {
                    $total_saida += floatval($row['valor']);
                }
                ?>
                <tr>
                    <td><?= $row['idcaixa'] ?></td>
                    <td><?= date('d/m/Y H:i', strtotime($row['data'])) ?></td>
                    <td><?= ucfirst($row['tipo']) ?></td>
                    <td><?= htmlspecialchars($row['descricao']) ?></td>
                    <td style="color: <?= $row['tipo'] == 'entrada' ? 'green' : 'red' ?>;">
                        R$ <?= number_format($row['valor'], 2, ',', '.') ?>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <hr>
    <div>
        <p><strong>Total de Entradas:</strong> R$ <?= number_format($total_entrada, 2, ',', '.') ?></p>
        <p><strong>Total de Saídas:</strong> R$ <?= number_format($total_saida, 2, ',', '.') ?></p>
        <p><strong>Saldo Atual:</strong> R$ <?= number_format($total_entrada - $total_saida, 2, ',', '.') ?></p>
    </div>

    <script>
        $(document).ready(function () {
            $('#controleCaixa').DataTable({
                "pageLength": 9,
                "lengthMenu": [9, 30, 100],
                "order": [[1, "desc"]],
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