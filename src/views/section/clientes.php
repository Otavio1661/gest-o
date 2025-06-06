<head>

  <!-- Inclua os estilos do DataTables -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet"> <!-- Ícones aqui -->

  <style>
    td div {
      width: 100%;
      height: 100%;
      font-size: 20px;
      display: flex;
      justify-content: space-evenly;
      align-items: center;
    }

    td div i {
      cursor: pointer;
    }


    #acoesClientesMenu {
      display: flex;
      flex-direction: row;
      justify-content: space-between;
      padding: 20px 10px;
    }


    #acoesRapidas {
      display: flex;
      flex-direction: row;
      justify-content: flex-end;
    }

    #acoesRapidas button,
    #acoesClientesMenu button {
      border: none;
      margin: 5px;
      padding: 3px 5px;
      box-shadow: 0px 2px 5px black;
      border-radius: 5px;
    }

    #formAddCliente {
      z-index: 2000;
    }
  </style>

</head>


<div class="content-area">


  <div id="acoesRapidas">
    <button>avista</button>
    <button>cartão</button>
  </div>
  <section id="clientes-section" class="bg-light p-4">
    <h2 class="mb-3">Clientes</h2>

    <div id="acoesClientesMenu">
      <button onclick="addCliente()">Adicionar</button>

    </div>

    <table id="clientes-tabela" class="display" style="width:100%">
      <thead>
        <tr>
          <th style="display:none;">idcliente</th>
          <th>nome</th>
          <th>telefone</th>
          <th>cpf</th>
          <th>uf</th>
          <th>cidade</th>
          <th>bairro</th>
          <th>rua</th>
          <th>numero</th>
          <th>ativo</th>
          <th style="width: 100px;">ação</th>
        </tr>
      </thead>

      <tbody>
        <?php
        $sql = "SELECT * FROM clientes";
        $result = mysqli_query($connect, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
          while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td style='display:none;''>{$row['idcliente']}</td>";
            echo "<td>{$row['nome']}</td>";
            echo "<td>{$row['telefone']}</td>";
            echo "<td>{$row['cpf']}</td>";
            echo "<td>{$row['uf']}</td>";
            echo "<td>{$row['cidade']}</td>";
            echo "<td>{$row['bairro']}</td>";
            echo "<td>{$row['rua']}</td>";
            echo "<td>{$row['numero']}</td>";
            echo "<td>" . ($row['ativo'] ? 'ativo' : 'inativo') . "</td>";
            echo '<td><div>
            <i class="bi bi-cash-coin" onclick="addNotinha(' . htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8') . ')"></i> |
            <i onclick="UpCliente(' . $row['idcliente'] . ')" class="bi bi-cloud-arrow-up-fill"></i> |
            <i onclick="DeleteCliente(' . $row['idcliente'] . ')" class="bi bi-trash3-fill"></i>
          </div></td>';
            echo "</tr>";
          }
        } else {
          echo "<tr><td colspan='10'>Nenhum cliente encontrado.</td></tr>";
        }
        ?>
      </tbody>
    </table>

    <!-- Modal de Adicionar Cliente -->
    <div class="modal fade" id="modalAddCliente" tabindex="-1" aria-labelledby="modalAddClienteLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <form id="formAddCliente" method="POST" action="../../../../projeto_01/src/model/AddCliente.php"> <!-- Ajuste o action conforme seu backend -->
            <div class="modal-header">
              <h5 class="modal-title" id="modalAddClienteLabel">Adicionar Cliente</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
              <!-- Campo oculto para o ID do cliente -->
              <input type="hidden" name="idcliente" id="idcliente">

              <div class="row g-3">
                <div class="col-md-6">
                  <label for="nome" class="form-label">Nome</label>
                  <input type="text" class="form-control" name="nome" id="nome">
                </div>
                <div class="col-md-6">
                  <label for="telefone" class="form-label">Telefone</label>
                  <input type="text" class="form-control" name="telefone" id="telefone">
                </div>
                <div class="col-md-6">
                  <label for="cpf" class="form-label">CPF</label>
                  <input type="text" class="form-control" name="cpf" id="cpf">
                </div>
                <div class="col-md-2">
                  <label for="uf" class="form-label">UF</label>
                  <input type="text" class="form-control" name="uf" id="uf">
                </div>
                <div class="col-md-4">
                  <label for="cidade" class="form-label">Cidade</label>
                  <input type="text" class="form-control" name="cidade" id="cidade">
                </div>
                <div class="col-md-4">
                  <label for="bairro" class="form-label">Bairro</label>
                  <input type="text" class="form-control" name="bairro" id="bairro">
                </div>
                <div class="col-md-5">
                  <label for="rua" class="form-label">Rua</label>
                  <input type="text" class="form-control" name="rua" id="rua">
                </div>
                <div class="col-md-2">
                  <label for="numero" class="form-label">Número</label>
                  <input type="text" class="form-control" name="numero" id="numero">
                </div>
                <div class="col-md-2">
                  <label class="form-check-label" for="ativo">Ativo</label>
                  <div class="form-check form-switch mt-1">
                    <input class="form-check-input" type="checkbox" id="ativo" name="ativo">
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary">Salvar</button>
              </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Modal de Adicionar Notinha -->
    <div class="modal fade" id="modalAddNotinha" tabindex="-1" aria-labelledby="modalAddNotinhaLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <form id="formAddNotinha" method="POST" action="CAMINHO_PARA_ADICIONAR_NOTINHA.php"> <!-- Ajuste conforme seu backend -->
            <div class="modal-header">
              <h5 class="modal-title" id="modalAddNotinhaLabel">Adicionar Notinha</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
              <input type="hidden" name="idcliente" id="notinha-idcliente">

              <div class="mb-3">
                <label class="form-label">Nome:</label>
                <input type="text" class="form-control" id="notinha-nome" disabled>
              </div>
              <div class="mb-3">
                <label class="form-label">Telefone:</label>
                <input type="text" class="form-control" id="notinha-telefone" disabled>
              </div>
              <div class="mb-3">
                <label class="form-label">CPF:</label>
                <input type="text" class="form-control" id="notinha-cpf" disabled>
              </div>
              <div class="mb-3">
                <label class="form-label">Endereço:</label>
                <input type="text" class="form-control" id="notinha-endereco" disabled>
              </div>

              <div class="mb-3">
                <label for="data" class="form-label">Data</label>
                <input type="date" class="form-control" name="data" required>
              </div>
              <div class="mb-3">
                <label for="valor" class="form-label">Valor</label>
                <input type="number" step="0.01" class="form-control" name="valor" required>
              </div>
              <div class="mb-3">
                <label for="tipo_pagamento" class="form-label">Tipo de Pagamento</label>
                <select class="form-control" name="tipo_pagamento" required>
                  <option value="Dinheiro">Dinheiro</option>
                  <option value="Cartão">Cartão</option>
                  <option value="PIX">PIX</option>
                  <option value="Outros">Outros</option>
                </select>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" name="pago" id="pago">
                <label class="form-check-label" for="pago">Pago</label>
              </div>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
              <button type="submit" class="btn btn-primary">Salvar Notinha</button>
            </div>
          </form>
        </div>
      </div>
    </div>


  </section>

  <!-- Scripts necessários -->
  <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

  <!-- Bootstrap Bundle JS (modais e tudo mais) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    function addNotinha(cliente) {
      // Preencher os dados no modal
      document.getElementById('notinha-idcliente').value = cliente.idcliente;
      document.getElementById('notinha-nome').value = cliente.nome;
      document.getElementById('notinha-telefone').value = cliente.telefone;
      document.getElementById('notinha-cpf').value = cliente.cpf;
      document.getElementById('notinha-endereco').value = cliente.rua + ', ' + cliente.numero + ', ' + cliente.bairro + ', ' + cliente.cidade + ' - ' + cliente.uf;

      // Abrir o modal
      const modal = new bootstrap.Modal(document.getElementById('modalAddNotinha'));
      modal.show();
    }
  </script>


  <script>
    function UpCliente(id) {
      const tabela = document.getElementById("clientes-tabela");
      const linhas = tabela.getElementsByTagName("tr");

      for (let i = 1; i < linhas.length; i++) {
        const colunas = linhas[i].getElementsByTagName("td");
        const idcliente = colunas[0].innerText;

        if (parseInt(idcliente) === id) {
          document.getElementById("idcliente").value = idcliente;
          document.getElementById("nome").value = colunas[1].innerText;
          document.getElementById("telefone").value = colunas[2].innerText;
          document.getElementById("cpf").value = colunas[3].innerText;
          document.getElementById("uf").value = colunas[4].innerText;
          document.getElementById("cidade").value = colunas[5].innerText;
          document.getElementById("bairro").value = colunas[6].innerText;
          document.getElementById("rua").value = colunas[7].innerText;
          document.getElementById("numero").value = colunas[8].innerText;
          document.getElementById("ativo").value = colunas[9].innerText;

          // Abre o modal
          const modal = new bootstrap.Modal(document.getElementById('modalAddCliente'));
          modal.show();

          break;
        }
      }
    }
  </script>

  <script>
    function addCliente() {
      const modal = new bootstrap.Modal(document.getElementById('modalAddCliente'));
      modal.show();
    }
  </script>

  <script>
    function DeleteCliente(id) {
      if (confirm("Tem certeza que deseja deletar este cliente?")) {
        fetch('../../../../projeto_01/src/model/DeleteCliente.php', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: 'id=' + encodeURIComponent(id)
          })
          .then(response => response.text())
          .then(data => {
            if (data === "success") {
              alert("Cliente deletado com sucesso!");
              location.reload(); // Recarrega a tabela
            } else {
              alert("Erro ao deletar cliente.");
            }
          })
          .catch(error => {
            console.error("Erro:", error);
            alert("Erro na requisição.");
          });
      }
    }
  </script>

  <!-- Inicialização do DataTables -->
  <script>
    $(document).ready(function() {
      $('#clientes-tabela').DataTable({
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