<!-- <style>
    div {
        cursor: pointer;
    }
</style> -->

<section id="relatorios" class="bg-white">
    <h2>Relatórios</h2>
    <div class="row mb-4">
        <div class="col-md-3">
            <label for="dataInicio" class="form-label">Data Início</label>
            <input type="date" id="dataInicio" class="form-control">
        </div>
        <div class="col-md-3">
            <label for="dataFim" class="form-label">Data Fim</label>
            <input type="date" id="dataFim" class="form-control">
        </div>
        <div class="col-md-5 align-self-end">
            <button id="filtrarDatas" class="btn btn-primary mt-2">Filtrar por data</button>
            <button id="limparDatas" class="btn btn-secondary mt-2 ms-2">Limpar Filtro</button>
            <button id="filtrarPago" class="btn btn-success mt-2 ms-2">Filtrar por Pago</button>
        </div>
    </div>
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
                        clientes c ON n.idcliente = c.idcliente
                    ORDER BY 
                        n.pago ASC,
                        n.data DESC";
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








    <!-- Modal de Adicionar Notinha -->
    <div class="modal fade" id="modalAddNotinha" tabindex="-1" aria-labelledby="modalAddNotinhaLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content shadow">
                <form id="formAddNotinha" method="POST" action="<?php echo $base ?>src/model/AddNotinha.php"> <!-- Ajuste conforme seu backend -->
                    <div class="modal-header bg-warning">
                        <h5 class="modal-title text-light" id="modalAddNotinhaLabel">Adicionar Notinha</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="idnotinha" id="notinha-id">
                        <input type="hidden" name="idcliente" id="notinha-idcliente">

                        <div class="row mb-2">
                            <div class="col-md-6">
                                <label class="form-label">Nome:</label>
                                <input type="text" class="form-control" id="notinha-nome" disabled>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Telefone:</label>
                                <input type="text" class="form-control" id="notinha-telefone" disabled>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-md-6">
                                <label class="form-label">CPF:</label>
                                <input type="text" class="form-control" id="notinha-cpf" disabled>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Endereço:</label>
                                <input type="text" class="form-control" id="notinha-endereco" disabled>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-md-6">
                                <label for="data" class="form-label">Data</label>
                                <input type="date" class="form-control" id="data" name="data" required>
                            </div>
                            <script>
                                // Define a data atual no input
                                const hoje = new Date().toISOString().split('T')[0];
                                document.getElementById('data').value = hoje;
                            </script>
                            <div class="col-md-6">
                                <!-- Campo Valor Total -->
                                <label for="valor-total" class="form-label">Valor</label>
                                <input type="number" step="0.01" class="form-control" name="valor" id="valor-total" required>

                                <!-- Bloco condicional -->
                                <div id="parcelado-campos" style="display: none; margin-top: 10px;">
                                    <label for="valor-debitado" class="form-label">Valor Debitado</label>
                                    <input type="number" step="0.01" class="form-control" name="valor-debitado" id="valor-debitado">

                                    <label for="valor-restante" class="form-label">Valor Restante</label>
                                    <input type="number" step="0.01" class="form-control" name="valor-restante" id="valor-restante" readonly>
                                </div>
                            </div>

                            <script>
                                function calcularValorRestante() {
                                    const valorTotal = parseFloat(document.getElementById("valor-total").value) || 0;
                                    const valorDebitado = parseFloat(document.getElementById("valor-debitado").value) || 0;
                                    let valorRestante = valorTotal - valorDebitado;

                                    if (valorRestante < 0) valorRestante = 0;

                                    document.getElementById("valor-restante").value = valorRestante.toFixed(2);
                                }

                                // Atualiza automaticamente ao digitar
                                document.getElementById("valor-total").addEventListener("input", calcularValorRestante);
                                document.getElementById("valor-debitado").addEventListener("input", calcularValorRestante);
                            </script>

                            <div class="mb-2">
                                <label for="valor" class="form-label">Descrição</label>
                                <textarea style="height: 80px; max-height: 150px;" class="form-control" name="descricao" id="Descrição" cols="30" rows="10"></textarea>
                            </div>

                            <div class="col-md-6">
                                <label class="form-check-label pg-parcelado" style="display:block;" for="pagamentoP">Pagamento Parcelado</label>
                                <div class="form-check form-switch mt-1 pg-parcelado" style="display:block;">
                                    <input class="form-check-input" type="checkbox" id="pagamentoP" name="pagamentoP">
                                </div>

                                <label class="form-check-label" for="pago">Pago</label>
                                <div class="form-check form-switch mt-1">
                                    <input class="form-check-input" type="checkbox" id="pago" name="pago">
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <!-- Botão Cancelar alinhado à esquerda -->
                            <button type="button" class="btn btn-secondary me-auto" data-bs-dismiss="modal">Cancelar</button>

                            <!-- Botões alinhados à direita -->
                            <button type="submit" class="btn btn-success">Salvar Notinha e Imprimir</button>
                            <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">Salvar Notinha</button>
                        </div>
                </form>
            </div>
        </div>
    </div>


    <script>
        // Função para mostrar ou esconder os campos de pagamento parcelado
        document.getElementById("pagamentoP").addEventListener("change", function() {
            const camposParcelado = document.getElementById("parcelado-campos");
            if (this.checked) {
                camposParcelado.style.display = "block";
            } else {
                camposParcelado.style.display = "none";
            }
        });
    </script>



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
            document.querySelectorAll('.pg-parcelado').forEach(el => el.style.display = 'block');


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
                ordering: false,
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

            // Filtros definidos fora para poderem ser removidos depois
            let filtroData = function(settings, data) {
                const dataStr = data[2];
                const dataObj = new Date(dataStr);
                const inicio = $('#dataInicio').val();
                const fim = $('#dataFim').val();

                const inicioObj = inicio ? new Date(inicio) : null;
                const fimObj = fim ? new Date(fim) : null;

                return (!inicioObj || dataObj >= inicioObj) &&
                    (!fimObj || dataObj <= fimObj);
            };

            let filtroPago = function(settings, data) {
                return data[4] === 'pago';
            };

            // Botão: Filtrar por data
            $('#filtrarDatas').on('click', function() {
                $.fn.dataTable.ext.search = $.fn.dataTable.ext.search.filter(fn => fn !== filtroData);
                $.fn.dataTable.ext.search.push(filtroData);
                table.draw();
            });

            // Botão: Filtrar por pago
            $('#filtrarPago').on('click', function() {
                $.fn.dataTable.ext.search = $.fn.dataTable.ext.search.filter(fn => fn !== filtroPago);
                $.fn.dataTable.ext.search.push(filtroPago);
                table.draw();
            });

            // Botão: Limpar filtros
            $('#limparDatas').on('click', function() {
                $('#dataInicio').val('');
                $('#dataFim').val('');
                $.fn.dataTable.ext.search = $.fn.dataTable.ext.search
                    .filter(fn => fn !== filtroData && fn !== filtroPago);
                table.draw();
            });
        });
    </script>

</section>