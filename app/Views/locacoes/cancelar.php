<?= $this->extend('layout/principal') ?>

<?= $this->section('conteudo') ?>
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><?= $titulo ?></h1>
        <a href="<?= site_url('locacoes') ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Voltar
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="alert alert-danger">
                <h4 class="alert-heading">Confirmar Cancelamento</h4>
                <p>Você está prestes a cancelar a locação abaixo. Esta ação não pode ser desfeita.</p>
                <p>O veículo será marcado como disponível novamente no sistema.</p>
            </div>

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
                            <th>Valor Total:</th>
                            <td>R$ <?= number_format($locacao['valor_total'], 2, ',', '.') ?></td>
                        </tr>
                    </table>
                </div>
            </div>

            <form action="<?= site_url('locacoes/cancelar/' . $locacao['id']) ?>" method="post">
                <div class="d-flex justify-content-end">
                    <a href="<?= site_url('locacoes') ?>" class="btn btn-secondary me-2">
                        <i class="fas fa-times"></i> Voltar
                    </a>
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash"></i> Confirmar Cancelamento
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
