<!-- Botões de Ação -->
<div id="acoesRapidas">
    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalAddCaixa">
        + Adicionar Caixa
    </button>
    <button>avista</button>
    <button>cartão</button>
</div>

<!-- Modal -->
<div class="modal fade" id="modalAddCaixa" tabindex="-1" aria-labelledby="modalAddCaixaLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content shadow">
            <form id="formAddCaixa" method="POST" action="<?php echo $base ?>src/model/AddCaixa.php">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title text-light" id="modalAddCaixaLabel">Adicionar Caixa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>

                <div class="modal-body">
                    <div class="row g-3">

                        <!-- Descrição (Forma de Pagamento) -->
                        <div class="col-md-6">
                            <label for="descricao" class="form-label">Descrição</label>
                            <select class="form-select" id="descricao" name="descricao" required>
                                <option value="">Selecione</option>
                                <option value="cartao">Cartão</option>
                                <option value="pix">Pix</option>
                                <option value="dinheiro">Dinheiro</option>
                                <option value="cheque">Cheque</option>
                            </select>
                        </div>

                        <!-- Valor -->
                        <div class="col-md-6">
                            <label for="valor" class="form-label">Valor</label>
                            <input type="number" step="0.01" class="form-control" id="valor" name="valor" required>
                        </div>

                        <!-- Data -->
                        <div class="col-md-6">
                            <label for="data" class="form-label">Data</label>
                            <input type="date" class="form-control" id="data" name="data" required>
                        </div>

                        <!-- Observação (opcional) -->
                        <div class="col-md-6">
                            <label for="observacao" class="form-label">Observação</label>
                            <input type="text" class="form-control" id="observacao" name="observacao">
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

<!-- Estilo CSS -->
<style>
    #acoesRapidas {
        display: flex;
        flex-direction: row;
        justify-content: flex-end;
    }

    #acoesRapidas button,
    #acoesCaixasMenu button {
        border: none;
        margin: 5px;
        padding: 3px 5px;
        box-shadow: 0px 2px 5px black;
        border-radius: 5px;
    }

    #formAddCaixa {
        z-index: 2000;
    }
</style>