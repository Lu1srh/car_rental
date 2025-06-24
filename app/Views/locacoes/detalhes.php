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
            <div class="row">
                <div class="col-md-6">
                    <h5 class="card-title">Informações da Locação</h5>
                    <table class="table table-striped">
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
                            <th>Categoria:</th>
                            <td><?= $categoria['nome'] ?></td>
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
                            <th>Devolução Efetiva:</th>
                            <td>
                                <?= $locacao['data_devolucao_efetiva'] ? date('d/m/Y H:i', strtotime($locacao['data_devolucao_efetiva'])) : 'Pendente' ?>
                            </td>
                        </tr>
                        <tr>
                            <th>Valor da Diária:</th>
                            <td>R$ <?= number_format($locacao['valor_diaria'], 2, ',', '.') ?></td>
                        </tr>
                        <tr>
                            <th>Valor Total:</th>
                            <td>R$ <?= number_format($locacao['valor_total'], 2, ',', '.') ?></td>
                        </tr>
                        <?php if ($locacao['multa_atraso'] > 0): ?>
                        <tr>
                            <th>Multa por Atraso:</th>
                            <td>R$ <?= number_format($locacao['multa_atraso'], 2, ',', '.') ?></td>
                        </tr>
                        <?php endif; ?>
                        <tr>
                            <th>Status:</th>
                            <td>
                                <?php if ($locacao['status'] == 'ativa'): ?>
                                    <span class="badge bg-primary">Ativa</span>
                                <?php elseif ($locacao['status'] == 'finalizada'): ?>
                                    <span class="badge bg-success">Finalizada</span>
                                <?php else: ?>
                                    <span class="badge bg-danger">Cancelada</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <tr>
                            <th>Data de Registro:</th>
                            <td><?= date('d/m/Y H:i', strtotime($locacao['created_at'])) ?></td>
                        </tr>
                        <tr>
                            <th>Última Atualização:</th>
                            <td><?= $locacao['updated_at'] ? date('d/m/Y H:i', strtotime($locacao['updated_at'])) : 'N/A' ?></td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <h5 class="card-title">Informações do Cliente</h5>
                    <table class="table table-striped mb-4">
                        <tr>
                            <th style="width: 30%">Nome:</th>
                            <td><?= $cliente['nome'] ?></td>
                        </tr>
                        <tr>
                            <th>CPF:</th>
                            <td><?= $cliente['cpf'] ?></td>
                        </tr>
                        <tr>
                            <th>Telefone:</th>
                            <td><?= $cliente['telefone'] ?></td>
                        </tr>
                        <tr>
                            <th>Email:</th>
                            <td><?= $cliente['email'] ?></td>
                        </tr>
                    </table>
                    
                    <h5 class="card-title">Informações do Veículo</h5>
                    <table class="table table-striped mb-4">
                        <tr>
                            <th style="width: 30%">Marca/Modelo:</th>
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
                        <tr>
                            <th>Cor:</th>
                            <td><?= $veiculo['cor'] ?></td>
                        </tr>
                    </table>
                    
                    <?php if ($locacao['status'] == 'ativa'): ?>
                    <div class="d-grid gap-2">
                        <a href="<?= site_url('locacoes/devolucao/' . $locacao['id']) ?>" class="btn btn-success">
                            <i class="fas fa-check-circle"></i> Registrar Devolução
                        </a>
                        <a href="<?= site_url('locacoes/confirmarCancelamento/' . $locacao['id']) ?>" class="btn btn-danger">
                            <i class="fas fa-times-circle"></i> Cancelar Locação
                        </a>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <?php if (!empty($locacao['observacoes_devolucao'])): ?>
            <div class="row mt-4">
                <div class="col-12">
                    <h5 class="card-title">Observações da Devolução</h5>
                    <div class="alert alert-info">
                        <?= nl2br($locacao['observacoes_devolucao']) ?>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
