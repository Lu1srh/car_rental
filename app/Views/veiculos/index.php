<?= $this->extend('layout/principal') ?>

<?= $this->section('conteudo') ?>
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><?= $titulo ?></h1>
        <a href="<?= site_url('veiculos/novo') ?>" class="btn btn-primary">
            <i class="fas fa-plus"></i> Novo Veículo
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
            <form action="<?= site_url('veiculos') ?>" method="get">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label for="marca" class="form-label">Marca</label>
                        <input type="text" class="form-control" id="marca" name="marca" value="<?= $filtros['marca'] ?? '' ?>">
                    </div>
                    <div class="col-md-3">
                        <label for="modelo" class="form-label">Modelo</label>
                        <input type="text" class="form-control" id="modelo" name="modelo" value="<?= $filtros['modelo'] ?? '' ?>">
                    </div>
                    <div class="col-md-2">
                        <label for="ano" class="form-label">Ano</label>
                        <input type="text" class="form-control" id="ano" name="ano" value="<?= $filtros['ano'] ?? '' ?>">
                    </div>
                    <div class="col-md-2">
                        <label for="cor" class="form-label">Cor</label>
                        <input type="text" class="form-control" id="cor" name="cor" value="<?= $filtros['cor'] ?? '' ?>">
                    </div>
                    <div class="col-md-2">
                        <label for="categoria_id" class="form-label">Categoria</label>
                        <select class="form-select" id="categoria_id" name="categoria_id">
                            <option value="">Todas</option>
                            <?php foreach ($categorias as $categoria): ?>
                                <option value="<?= $categoria['id'] ?>" <?= ($filtros['categoria_id'] ?? '') == $categoria['id'] ? 'selected' : '' ?>>
                                    <?= $categoria['nome'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status">
                            <option value="">Todos</option>
                            <option value="disponivel" <?= ($filtros['status'] ?? '') == 'disponivel' ? 'selected' : '' ?>>Disponível</option>
                            <option value="locado" <?= ($filtros['status'] ?? '') == 'locado' ? 'selected' : '' ?>>Locado</option>
                            <option value="manutencao" <?= ($filtros['status'] ?? '') == 'manutencao' ? 'selected' : '' ?>>Em Manutenção</option>
                        </select>
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary me-2">
                            <i class="fas fa-search"></i> Filtrar
                        </button>
                        <a href="<?= site_url('veiculos') ?>" class="btn btn-secondary">
                            <i class="fas fa-eraser"></i> Limpar
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <?php if (empty($veiculos)): ?>
                <div class="alert alert-info">
                    Nenhum veículo encontrado.
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Marca/Modelo</th>
                                <th>Placa</th>
                                <th>Ano</th>
                                <th>Cor</th>
                                <th>Categoria</th>
                                <th>Status</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($veiculos as $veiculo): ?>
                                <tr>
                                    <td><?= $veiculo['id'] ?></td>
                                    <td><?= $veiculo['marca'] ?> <?= $veiculo['modelo'] ?></td>
                                    <td><?= $veiculo['placa'] ?></td>
                                    <td><?= $veiculo['ano'] ?></td>
                                    <td><?= $veiculo['cor'] ?></td>
                                    <td><?= $veiculo['categoria_nome'] ?></td>
                                    <td>
                                        <?php if ($veiculo['status'] == 'disponivel'): ?>
                                            <span class="badge bg-success">Disponível</span>
                                        <?php elseif ($veiculo['status'] == 'locado'): ?>
                                            <span class="badge bg-warning text-dark">Locado</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger">Em Manutenção</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="<?= site_url('veiculos/detalhes/' . $veiculo['id']) ?>" class="btn btn-info" title="Detalhes">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="<?= site_url('veiculos/editar/' . $veiculo['id']) ?>" class="btn btn-primary" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="<?= site_url('veiculos/confirmarExclusao/' . $veiculo['id']) ?>" class="btn btn-danger" title="Excluir">
                                                <i class="fas fa-trash"></i>
                                            </a>
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
