    <?php
    include 'config.php';

    $sql = "SELECT l.*, c.nome AS nome_cliente
        FROM log_alteracoes_notinhas l
        LEFT JOIN notinhas n ON l.idnotinha = n.idnotinha
        LEFT JOIN clientes c ON n.idcliente = c.idcliente
        ORDER BY l.data_alteracao DESC";

    $result = mysqli_query($connect, $sql);
    ?>
    <section id="pagamentos" class="bg-light">
        <h2>Pagamentos</h2>
        <p>Área para gerenciar os pagamentos.</p>


        <table id="logAlteracoes" class="table table-striped">
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
                <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                    <tr>
                        <td><?= $row['idnotinha'] ?></td>
                        <td><?= htmlspecialchars($row['nome_cliente']) ?></td>
                        <td><?= htmlspecialchars($row['campo_alterado'])?></td>
                        <td><?= htmlspecialchars($row['valor_antigo']) ?></td>
                        <td><?= htmlspecialchars(floatval($row['valor_antigo']) - floatval($row['valor_novo'])) ?></td>
                        <td><?= empty($row['valor_novo']) ? 'Pago' : htmlspecialchars($row['valor_novo']) ?></td>
                        <td><?= $row['data_alteracao'] ?></td>
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