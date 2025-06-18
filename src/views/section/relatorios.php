<!-- <style>
    div {
        cursor: pointer;
    }
</style> -->

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
                <th>CPF</th>
                <th>Telefone</th>
                <th>Endereço</th>
                <th>acao</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT 
                    n.*, 
                    c.nome AS nome_cliente, 
                    c.cpf, 
                    c.telefone, 
                CONCAT(c.rua, ', ', c.numero, ' - ', c.bairro, ', ', c.cidade, ' - ', c.uf) AS endereco
                FROM 
                    notinhas n
                LEFT JOIN 
                    clientes c ON n.idcliente = c.idcliente;";
            $result = mysqli_query($connect, $sql);

            if ($result && mysqli_num_rows($result) > 0) {
                while ($row2 = mysqli_fetch_assoc($result)) {
                    $row2['descricao'] = str_replace(array("\r", "\n"), array("\\r", "\\n"), $row2['descricao']);
                    $notinhaJson = htmlspecialchars(json_encode($row2), ENT_QUOTES, 'UTF-8');
                    // print_r($row2);
                    echo "<tr>";
                    echo "<td>{$row2['idnotinha']}</td>";
                    echo "<td>{$row2['nome_cliente']}</td>";
                    echo "<td>{$row2['data']}</td>";
                    echo "<td>R$ " . number_format($row2['valor'], 2, ',', '.') . "</td>";
                    echo "<td>" . ($row2['pago'] ? 'pago' : 'pendente') . "</td>";
                    echo "<td>{$row2['descricao']}</td>";
                    echo "<td>{$row2['cpf']}</td>";
                    echo "<td>{$row2['telefone']}</td>";
                    echo "<td>{$row2['endereco']}</td>";
                    echo "<td><i style='cursor: pointer;' onclick=\"UpNotinha('{$notinhaJson}')\" class=\"bi bi-pencil-square\"></i></td>";
                    echo "</tr>";
                }
            }

            ?>
        </tbody>
    </table>

    <div id="notinhas-cards" class="row g-6"></div>

    <script>
        function UpNotinha(notinhas) {
            const data = JSON.parse(notinhas);

            console.log(data);

            // Preenche os campos do modal
            document.getElementById('modalAddNotinhaLabel').innerHTML = 'Editar notinha';
            document.getElementById('notinha-idcliente').value = data.idcliente || '';
            document.getElementById('notinha-id').value = data.idnotinha || '';
            document.getElementById('notinha-nome').value = data.nome_cliente || '';
            document.getElementById('notinha-telefone').value = data.telefone || '';
            document.getElementById('notinha-cpf').value = data.cpf || '';
            document.getElementById('notinha-endereco').value = data.endereco || '';
            document.getElementById('data').value = data.data || new Date().toISOString().split('T')[0];
            document.querySelector('[name="valor"]').value = data.valor || '';
            document.getElementById('Descrição').value = data.descricao || '';

            // Corrigido: marcar o checkbox se data.pago for igual a 1
            document.getElementById('pago').checked = data.pago == 1;

            // Abre o modal (Bootstrap 5)
            const myModal = new bootstrap.Modal(document.getElementById('modalAddNotinha'));
            myModal.show();
        }
    </script>

    <script>
        $(document).ready(function() {
            const table = $('#notinhas-tabela').DataTable({
                pageLength: 9,
                lengthMenu: [9, 30, 100],
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
                    const table = this.api();
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
                            <div class="col-md-6 col-lg-4 mb-3">
                                <div class="card h-auto shadow-sm">
                                    <div class="card-body">
                                        <h5 class="card-title">${row[1]}</h5>
                                        <p class="card-text">
                                            <strong>Data:</strong> ${row[2]}<br>
                                            <strong>Valor:</strong> ${row[3]}<br>
                                            <strong>Status:</strong> ${pagoBadge}<br>
                                            <strong>Descrição:</strong>
                                            <div class="overflow-auto card shadow-sm p-1" style="max-height: 200px; min-height: 100px;">
                                                ${row[5]}
                                            </div>
                                            <br>
                                            <strong>CPF:</strong> ${row[6]}<br>
                                            <strong>Telefone:</strong> ${row[7]}<br>
                                            <strong>Endereço:</strong> ${row[8]}
                                        </p>
                                        <div class="text-end">
                                            ${row[9]}
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