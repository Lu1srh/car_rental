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
            <div class="row mb-4">
                <div class="col-md-6">
                    <h5>Informações da Locação</h5>
                    <table class="table">
                        <tr>
                            <th style="width: 30%">ID:</th>
                            <td><?= $locacao['id'] ?></td>
                        </tr>
                        <tr>
                            <th>Cliente:</th>
                            <td><?= $cliente['nome'] ?></td>
                        </tr>
                        <tr>
                            <th>Veículo:</th>
                            <td><?= $veiculo['marca'] ?> <?= $veiculo['modelo'] ?> (<?= $veiculo['placa'] ?>)</td>
                        </tr>
                        <tr>
                            <th>Data de Retirada:</th>
                            <td><?= date('d/m/Y H:i', strtotime($locacao['data_retirada'])) ?></td>
                        </tr>
                        <tr>
                            <th>Devolução Prevista:</th>
                            <td><?= date('d/m/Y H:i', strtotime($locacao['data_devolucao_prevista'])) ?></td>
                        </tr>
                        <tr>
                            <th>Valor da Diária:</th>
                            <td>R$ <?= number_format($locacao['valor_diaria'], 2, ',', '.') ?></td>
                        </tr>
                        <tr>
                            <th>Valor Total:</th>
                            <td>R$ <?= number_format($locacao['valor_total'], 2, ',', '.') ?></td>
                        </tr>
                    </table>
                </div>
            </div>

            <form action="<?= site_url('locacoes/processarDevolucao/' . $locacao['id']) ?>" method="post">
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="data_devolucao_efetiva" class="form-label">Data de Devolução Efetiva</label>
                        <input type="datetime-local" class="form-control" id="data_devolucao_efetiva" name="data_devolucao_efetiva" 
                               value="<?= old('data_devolucao_efetiva', $data_atual) ?>" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-12">
                        <label for="observacoes_devolucao" class="form-label">Observações da Devolução</label>
                        <textarea class="form-control" id="observacoes_devolucao" name="observacoes_devolucao" rows="4"><?= old('observacoes_devolucao') ?></textarea>
                        <div class="form-text">Informe as condições do veículo no momento da devolução, danos ou outras observações relevantes.</div>
                    </div>
                </div>

                <div class="alert alert-warning">
                    <h5 class="alert-heading">Atenção!</h5>
                    <p>Se a devolução for realizada após a data prevista, será aplicada uma multa de 10% do valor da diária por dia de atraso.</p>
                    <p class="mb-0">Data de devolução prevista: <strong><?= date('d/m/Y H:i', strtotime($locacao['data_devolucao_prevista'])) ?></strong></p>
                </div>

                <div class="d-flex justify-content-end">
                    <a href="<?= site_url('locacoes') ?>" class="btn btn-secondary me-2">
                        <i class="fas fa-times"></i> Cancelar
                    </a>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-check-circle"></i> Confirmar Devolução
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const dataDevolucaoInput = document.getElementById('data_devolucao_efetiva');
    const dataPrevista = new Date('<?= $locacao['data_devolucao_prevista'] ?>');
    
    dataDevolucaoInput.addEventListener('change', function() {
        const dataEfetiva = new Date(this.value);
        
        if (dataEfetiva < dataPrevista) {
            // Devolução antecipada
            document.querySelector('.alert-warning').classList.remove('alert-danger');
            document.querySelector('.alert-warning').classList.add('alert-success');
            document.querySelector('.alert-heading').textContent = 'Devolução Antecipada';
            document.querySelector('.alert-warning p').textContent = 'A devolução está sendo realizada antes da data prevista. Não haverá multa por atraso.';
        } else if (dataEfetiva > dataPrevista) {
            // Devolução com atraso
            document.querySelector('.alert-warning').classList.remove('alert-success');
            document.querySelector('.alert-warning').classList.add('alert-danger');
            document.querySelector('.alert-heading').textContent = 'Devolução com Atraso';
            
            // Calcula dias de atraso
            const diffTime = Math.abs(dataEfetiva - dataPrevista);
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
            
            document.querySelector('.alert-warning p').textContent = `A devolução está sendo realizada com ${diffDays} dia(s) de atraso. Será aplicada uma multa de 10% do valor da diária por dia de atraso.`;
        } else {
            // Devolução na data prevista
            document.querySelector('.alert-warning').classList.remove('alert-danger');
            document.querySelector('.alert-warning').classList.remove('alert-success');
            document.querySelector('.alert-warning').classList.add('alert-info');
            document.querySelector('.alert-heading').textContent = 'Devolução na Data Prevista';
            document.querySelector('.alert-warning p').textContent = 'A devolução está sendo realizada na data prevista. Não haverá multa por atraso.';
        }
    });
});
</script>
<?= $this->endSection() ?>
