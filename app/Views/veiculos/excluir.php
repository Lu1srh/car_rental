<?= $this->extend('layout/principal') ?>

<?= $this->section('conteudo') ?>
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><?= $titulo ?></h1>
        <a href="<?= site_url('veiculos') ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Voltar
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="alert alert-danger">
                <h4 class="alert-heading">Confirmar Exclusão</h4>
                <p>Você está prestes a excluir o veículo abaixo. Esta ação não pode ser desfeita.</p>
            </div>

            <div class="row mb-4">
                <div class="col-md-6">
                    <h5>Informações do Veículo</h5>
                    <table class="table">
                        <tr>
                            <th style="width: 30%">ID:</th>
                            <td><?= $veiculo['id'] ?></td>
                        </tr>
                        <tr>
                            <th>Marca/Modelo:</th>
                            <td><?= $veiculo['marca'] ?> <?= $veiculo['modelo'] ?></td>
                        </tr>
                        <tr>
                            <th>Placa:</th>
                            <td><?= $veiculo['placa'] ?></td>
                        </tr>
                        <tr>
                            <th>Ano:</th>
                            <td><?= $veiculo['ano'] ?></td>
                        </tr>
                    </table>
                </div>
            </div>

            <form action="<?= site_url('veiculos/excluir/' . $veiculo['id']) ?>" method="post">
                <div class="d-flex justify-content-end">
                    <a href="<?= site_url('veiculos') ?>" class="btn btn-secondary me-2">
                        <i class="fas fa-times"></i> Cancelar
                    </a>
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash"></i> Confirmar Exclusão
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
