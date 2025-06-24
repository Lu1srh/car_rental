<?= $this->extend('layout/principal') ?>

<?= $this->section('conteudo') ?>
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><?= $titulo ?></h1>
        <a href="<?= site_url('locacoes') ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Voltar
        </a>
    </div>

    <?php if (session()->has('errors')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <h4 class="alert-heading">Erros encontrados!</h4>
            <ul>
                <?php foreach (session('errors') as $error): ?>
                    <li><?= $error ?></li>
                <?php endforeach; ?>
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
        </div>
    <?php endif; ?>

    <div class="card">
        <div class="card-body">
            <form action="<?= site_url('locacoes/criar') ?>" method="post" id="formLocacao">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="cliente_id" class="form-label">Cliente</label>
                        <select class="form-select" id="cliente_id" name="cliente_id" required>
                            <option value="">Selecione um cliente...</option>
                            <?php foreach ($clientes as $cliente): ?>
                                <option value="<?= $cliente['id'] ?>" <?= old('cliente_id') == $cliente['id'] ? 'selected' : '' ?>>
                                    <?= $cliente['nome'] ?> - CPF: <?= $cliente['cpf'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="veiculo_id" class="form-label">Veículo</label>
                        <select class="form-select" id="veiculo_id" name="veiculo_id" required>
                            <option value="">Selecione um veículo...</option>
                            <?php foreach ($veiculos as $veiculo): ?>
                                <option value="<?= $veiculo['id'] ?>" <?= old('veiculo_id') == $veiculo['id'] ? 'selected' : '' ?>>
                                    <?= $veiculo['marca'] ?> <?= $veiculo['modelo'] ?> - Placa: <?= $veiculo['placa'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-3">
                        <label for="categoria" class="form-label">Categoria</label>
                        <input type="text" class="form-control" id="categoria" readonly>
                        <!-- Opcional: hidden para categoria se quiser enviar -->
                        <!--<input type="hidden" id="categoria_hidden" name="categoria">-->
                    </div>
                    <div class="col-md-3">
                        <label for="valor_diaria" class="form-label">Valor da Diária (R$)</label>
                        <input type="text" class="form-control" id="valor_diaria" readonly>
                        <input type="hidden" id="valor_diaria_hidden" name="valor_diaria">
                    </div>
                    <div class="col-md-3">
                        <label for="data_retirada" class="form-label">Data de Retirada</label>
                        <input type="datetime-local" class="form-control" id="data_retirada" name="data_retirada" 
                               value="<?= old('data_retirada', date('Y-m-d\TH:i')) ?>" required>
                    </div>
                    <div class="col-md-3">
                        <label for="data_devolucao_prevista" class="form-label">Data de Devolução Prevista</label>
                        <input type="datetime-local" class="form-control" id="data_devolucao_prevista" name="data_devolucao_prevista" 
                               value="<?= old('data_devolucao_prevista', date('Y-m-d\TH:i', strtotime('+1 day'))) ?>" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="valor_total" class="form-label">Valor Total Estimado (R$)</label>
                        <input type="text" class="form-control" id="valor_total" readonly>
                    </div>
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Registrar Locação
                    </button>
                    <a href="<?= site_url('locacoes') ?>" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const veiculoSelect = document.getElementById('veiculo_id');
    const categoriaInput = document.getElementById('categoria');
    const valorDiariaInput = document.getElementById('valor_diaria');
    const valorDiariaHidden = document.getElementById('valor_diaria_hidden');
    const dataRetiradaInput = document.getElementById('data_retirada');
    const dataDevolucaoInput = document.getElementById('data_devolucao_prevista');
    const valorTotalInput = document.getElementById('valor_total');
    
    // Função para buscar valor da diária
    function buscarValorDiaria() {
        const veiculoId = veiculoSelect.value;
        if (!veiculoId) {
            categoriaInput.value = '';
            valorDiariaInput.value = '';
            valorDiariaHidden.value = '';
            valorTotalInput.value = '';
            return;
        }
        
        fetch(`<?= site_url('locacoes/getValorDiaria') ?>?veiculo_id=${veiculoId}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    categoriaInput.value = data.categoria;
                    valorDiariaInput.value = parseFloat(data.valor_diaria).toFixed(2);
                    valorDiariaHidden.value = data.valor_diaria;
                    calcularValorTotal();
                } else {
                    alert('Erro ao buscar valor da diária: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Erro:', error);
            });
    }
    
    // Função para calcular valor total
    function calcularValorTotal() {
        const valorDiaria = valorDiariaHidden.value;
        const dataRetirada = dataRetiradaInput.value;
        const dataDevolucao = dataDevolucaoInput.value;
        
        if (!valorDiaria || !dataRetirada || !dataDevolucao) {
            valorTotalInput.value = '';
            return;
        }
        
        fetch(`<?= site_url('locacoes/calcularValor') ?>?valor_diaria=${valorDiaria}&data_retirada=${dataRetirada}&data_devolucao=${dataDevolucao}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    valorTotalInput.value = parseFloat(data.valor_total).toFixed(2);
                }
            })
            .catch(error => {
                console.error('Erro:', error);
            });
    }
    
    // Eventos
    veiculoSelect.addEventListener('change', buscarValorDiaria);
    dataRetiradaInput.addEventListener('change', calcularValorTotal);
    dataDevolucaoInput.addEventListener('change', calcularValorTotal);
    
    // Inicializar se já houver um veículo selecionado
    if (veiculoSelect.value) {
        buscarValorDiaria();
    }
    
    // Validação do formulário
    document.getElementById('formLocacao').addEventListener('submit', function(e) {
        const dataRetirada = new Date(dataRetiradaInput.value);
        const dataDevolucao = new Date(dataDevolucaoInput.value);
        
        if (dataDevolucao <= dataRetirada) {
            e.preventDefault();
            alert('A data de devolução deve ser posterior à data de retirada.');
        }
    });
});
</script>
<?= $this->endSection() ?>
