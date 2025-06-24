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
            <div class="row">
                <div class="col-md-6">
                    <h5 class="card-title">Informações do Veículo</h5>
                    <table class="table table-striped">
                        <tr>
                            <th style="width: 30%">ID:</th>
                            <td><?= $veiculo['id'] ?></td>
                        </tr>
                        <tr>
                            <th>Marca:</th>
                            <td><?= $veiculo['marca'] ?></td>
                        </tr>
                        <tr>
                            <th>Modelo:</th>
                            <td><?= $veiculo['modelo'] ?></td>
                        </tr>
                        <tr>
                            <th>Ano:</th>
                            <td><?= $veiculo['ano'] ?></td>
                        </tr>
                        <tr>
                            <th>Placa:</th>
                            <td><?= $veiculo['placa'] ?></td>
                        </tr>
                        <tr>
                            <th>Cor:</th>
                            <td><?= $veiculo['cor'] ?></td>
                        </tr>
                        <tr>
                            <th>Categoria:</th>
                            <td><?= $categoria['nome'] ?></td>
                        </tr>
                        <tr>
                            <th>Valor da Diária:</th>
                            <td>R$ <?= number_format($categoria['valor_diaria'], 2, ',', '.') ?></td>
                        </tr>
                        <tr>
                            <th>Status:</th>
                            <td>
                                <?php if ($veiculo['status'] == 'disponivel'): ?>
                                    <span class="badge bg-success">Disponível</span>
                                <?php elseif ($veiculo['status'] == 'locado'): ?>
                                    <span class="badge bg-warning text-dark">Locado</span>
                                <?php else: ?>
                                    <span class="badge bg-danger">Em Manutenção</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <tr>
                            <th>Data de Cadastro:</th>
                            <td><?= date('d/m/Y H:i', strtotime($veiculo['created_at'])) ?></td>
                        </tr>
                        <tr>
                            <th>Última Atualização:</th>
                            <td><?= $veiculo['updated_at'] ? date('d/m/Y H:i', strtotime($veiculo['updated_at'])) : 'N/A' ?></td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <h5 class="card-title">Ações</h5>
                    <div class="d-grid gap-2">
                        <a href="<?= site_url('veiculos/editar/' . $veiculo['id']) ?>" class="btn btn-primary">
                            <i class="fas fa-edit"></i> Editar Veículo
                        </a>
                        
                        <form action="<?= site_url('veiculos/atualizarStatus/' . $veiculo['id']) ?>" method="post" class="mb-3">
                            <div class="input-group">
                                <select class="form-select" name="status">
                                    <option value="disponivel" <?= $veiculo['status'] == 'disponivel' ? 'selected' : '' ?>>Disponível</option>
                                    <option value="locado" <?= $veiculo['status'] == 'locado' ? 'selected' : '' ?>>Locado</option>
                                    <option value="manutencao" <?= $veiculo['status'] == 'manutencao' ? 'selected' : '' ?>>Em Manutenção</option>
                                </select>
                                <button class="btn btn-outline-primary" type="submit">Atualizar Status</button>
                            </div>
                        </form>
                        
                        <a href="<?= site_url('veiculos/confirmarExclusao/' . $veiculo['id']) ?>" class="btn btn-danger">
                            <i class="fas fa-trash"></i> Excluir Veículo
                        </a>
                    </div>
                    
                    <!-- Aqui poderia mostrar o histórico de locações deste veículo quando o módulo de locações estiver pronto -->
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
