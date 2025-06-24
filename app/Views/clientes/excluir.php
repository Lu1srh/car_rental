<?= $this->extend('layout/principal') ?>

<?= $this->section('conteudo') ?>
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><?= $titulo ?></h1>
        <a href="<?= site_url('clientes') ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Voltar
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="alert alert-danger">
                <h4 class="alert-heading">Confirmar Exclusão</h4>
                <p>Você está prestes a excluir o cliente abaixo. Esta ação não pode ser desfeita.</p>
                
                <?php if ($possuiLocacoes): ?>
                    <hr>
                    <p class="mb-0"><strong>Atenção:</strong> Este cliente possui locações registradas no sistema. 
                    A exclusão não é permitida para manter a integridade dos registros históricos.</p>
                <?php endif; ?>
            </div>

            <div class="row mb-4">
                <div class="col-md-6">
                    <h5>Informações do Cliente</h5>
                    <table class="table">
                        <tr>
                            <th style="width: 30%">ID:</th>
                            <td><?= $cliente['id'] ?></td>
                        </tr>
                        <tr>
                            <th>Nome:</th>
                            <td><?= $cliente['nome'] ?></td>
                        </tr>
                        <tr>
                            <th>CPF:</th>
                            <td><?= $cliente['cpf'] ?></td>
                        </tr>
                        <tr>
                            <th>Email:</th>
                            <td><?= $cliente['email'] ?></td>
                        </tr>
                    </table>
                </div>
            </div>

            <form action="<?= site_url('clientes/excluir/' . $cliente['id']) ?>" method="post">
                <div class="d-flex justify-content-end">
                    <a href="<?= site_url('clientes') ?>" class="btn btn-secondary me-2">
                        <i class="fas fa-times"></i> Cancelar
                    </a>
                    <?php if (!$possuiLocacoes): ?>
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash"></i> Confirmar Exclusão
                        </button>
                    <?php else: ?>
                        <button type="button" class="btn btn-danger" disabled>
                            <i class="fas fa-trash"></i> Exclusão Não Permitida
                        </button>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
