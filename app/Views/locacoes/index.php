<?= $this->extend('layout/principal') ?>

<?= $this->section('conteudo') ?>
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><?= $titulo ?></h1>
        <a href="<?= site_url('locacoes/nova') ?>" class="btn btn-primary">
            <i class="fas fa-plus"></i> Nova Locação
        </a>
    </div>

    <?php if (session()->has('mensagem')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= session('mensagem') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
        </div>
    <?php endif; ?>

    <?php if (session()->has('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= session('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
        </div>
    <?php endif; ?>

    <div class="card mb-4">
        <div class="card-header bg-light">
            <h5 class="mb-0">Filtros</h5>
        </div>
        <div class="card-body">
            <form action="<?= site_url('locacoes') ?>" method="get">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label for="cliente_id" class="form-label">Cliente</label>
                        <select class="form-select" id="cliente_id" name="cliente_id">
                            <option value="">Todos</option>
                            <?php foreach ($clientes as $cliente): ?>
                                <option value="<?= $cliente['id'] ?>" <?= ($filtros['cliente_id'] ?? '') == $cliente['id'] ? 'selected' : '' ?>>
                                    <?= $cliente['nome'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="veiculo_id" class="form-label">Veículo</label>
                        <select class="form-select" id="veiculo_id" name="veiculo_id">
                            <option value="">Todos</option>
                            <?php foreach ($veiculos as $veiculo): ?>
                                <option value="<?= $veiculo['id'] ?>" <?= ($filtros['veiculo_id'] ?? '') == $veiculo['id'] ? 'selected' : '' ?>>
                                    <?= $veiculo['marca'] ?> <?= $veiculo['modelo'] ?> (<?= $veiculo['placa'] ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status">
                            <option value="">Todos</option>
                            <option value="ativa" <?= ($filtros['status'] ?? '') == 'ativa' ? 'selected' : '' ?>>Ativa</option>
                            <option value="finalizada" <?= ($filtros['status'] ?? '') == 'finalizada' ? 'selected' : '' ?>>Finalizada</option>
                            <option value="cancelada" <?= ($filtros['status'] ?? '') == 'cancelada' ? 'selected' : '' ?>>Cancelada</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="data_inicio" class="form-label">Data Início</label>
                        <input type="date" class="form-control" id="data_inicio" name="data_inicio" value="<?= $filtros['data_inicio'] ?? '' ?>">
                    </div>
                    <div class="col-md-2">
                        <label for="data_fim" class="form-label">Data Fim</label>
                        <input type="date" class="form-control" id="data_fim" name="data_fim" value="<?= $filtros['data_fim'] ?? '' ?>">
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary me-2">
                            <i class="fas fa-search"></i> Filtrar
                        </button>
                        <a href="<?= site_url('locacoes') ?>" class="btn btn-secondary">
                            <i class="fas fa-eraser"></i> Limpar
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <?php if (empty($locacoes)): ?>
                <div class="alert alert-info">
                    Nenhuma locação encontrada.
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Cliente</th>
                                <th>Veículo</th>
                                <th>Retirada</th>
                                <th>Devolução Prevista</th>
                                <th>Devolução Efetiva</th>
                                <th>Valor Total</th>
                                <th>Status</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($locacoes as $locacao): ?>
                                <tr>
                                    <td><?= $locacao['id'] ?></td>
                                    <td><?= $locacao['cliente_nome'] ?></td>
                                    <td><?= $locacao['marca'] ?> <?= $locacao['modelo'] ?> (<?= $locacao['placa'] ?>)</td>
                                    <td><?= date('d/m/Y H:i', strtotime($locacao['data_retirada'])) ?></td>
                                    <td><?= date('d/m/Y H:i', strtotime($locacao['data_devolucao_prevista'])) ?></td>
                                    <td>
                                        <?= $locacao['data_devolucao_efetiva'] ? date('d/m/Y H:i', strtotime($locacao['data_devolucao_efetiva'])) : 'Pendente' ?>
                                    </td>
                                    <td>R$ <?= number_format($locacao['valor_total'], 2, ',', '.') ?></td>
                                    <td>
                                        <?php if ($locacao['status'] == 'ativa'): ?>
                                            <span class="badge bg-primary">Ativa</span>
                                        <?php elseif ($locacao['status'] == 'finalizada'): ?>
                                            <span class="badge bg-success">Finalizada</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger">Cancelada</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="<?= site_url('locacoes/detalhes/' . $locacao['id']) ?>" class="btn btn-info" title="Detalhes">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <?php if ($locacao['status'] == 'ativa'): ?>
                                                <a href="<?= site_url('locacoes/devolucao/' . $locacao['id']) ?>" class="btn btn-success" title="Registrar Devolução">
                                                    <i class="fas fa-check-circle"></i>
                                                </a>
                                                <a href="<?= site_url('locacoes/confirmarCancelamento/' . $locacao['id']) ?>" class="btn btn-danger" title="Cancelar">
                                                    <i class="fas fa-times-circle"></i>
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
