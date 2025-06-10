<section id="relatorios" class="bg-white">
    <h2>Relatórios</h2>
    <!-- Tabela oculta apenas para DataTables controlar os dados -->
    <table id="notinhas-tabela" class="table d-none">
        <thead>
            <tr>
                <th>idnotinha</th>
                <th>cliente</th>
                <th>data</th>
                <th>valor</th>
                <th>pago</th>
                <th>descricao</th>
                <th>acao</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT n.*, c.nome as nome_cliente FROM notinhas n
            LEFT JOIN clientes c ON n.idcliente = c.idcliente";
            $result = mysqli_query($connect, $sql);

            if ($result && mysqli_num_rows($result) > 0) {
                while ($row2 = mysqli_fetch_assoc($result)) {
                    $notinhaJson = htmlspecialchars(json_encode($row2), ENT_QUOTES, 'UTF-8');
                    echo "<tr>";
                    echo "<td>{$row2['idnotinha']}</td>";
                    echo "<td>{$row2['nome_cliente']}</td>";
                    echo "<td>{$row2['data']}</td>";
                    echo "<td>R$ " . number_format($row2['valor'], 2, ',', '.') . "</td>";
                    echo "<td>" . ($row2['pago'] ? 'pago' : 'pendente') . "</td>";
                    echo "<td>{$row2['decricao']}</td>";
                    echo "<td><i onclick=\"UpNotinha('{$notinhaJson}')\" class=\"bi bi-pencil-square\"></i></td>";
                    echo "</tr>";
                }
            }
            ?>
        </tbody>
    </table>

        <!-- Container onde os cards serão inseridos -->
        <div id="notinhas-cards" class="row g-6"></div>

    <!-- DataTables + renderização customizada -->
    <script>
        $(document).ready(function() {
            const table = $('#notinhas-tabela').DataTable({
                pageLength: 10,
                lengthMenu: [10, 30, 100],
                language: {
                    search: "Buscar:",
                    lengthMenu: "Mostrar _MENU_ registros por página",
                    zeroRecords: "Nenhum resultado encontrado",
                    info: "Mostrando página _PAGE_ de _PAGES_",
                    infoEmpty: "Nenhum registro disponível",
                    infoFiltered: "(filtrado de _MAX_ registros no total)",
                    paginate: {
                        first: "Primeira",
                        last: "Última",
                        next: "Próxima",
                        previous: "Anterior"
                    }
                },
                drawCallback: function() {
                    const table = this.api(); // Corrigido aqui
                    const data = table.rows({
                        page: 'current'
                    }).data();
                    const container = $('#notinhas-cards');
                    container.empty();

                    data.each(function(row) {
                        const pagoBadge = row[4] === 'pago' ?
                            '<span class="badge bg-success">Pago</span>' :
                            '<span class="badge bg-warning text-dark">Pendente</span>';

                        const card = `
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">${row[1]}</h5>
                                <p class="card-text">
                                    <strong>Data:</strong> ${row[2]}<br>
                                    <strong>Valor:</strong> ${row[3]}<br>
                                    <strong>Status:</strong> ${pagoBadge}<br>
                                    <strong>Descrição:</strong> ${row[5]}
                                </p>
                                <div class="text-end">
                                    ${row[6]}
                                </div>
                            </div>
                        </div>
                    </div>`;
                        container.append(card);
                    });
                }
            });
        });
    </script>
</section>