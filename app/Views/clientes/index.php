<?= $this->extend('layout/principal') ?>

<?= $this->section('conteudo') ?>
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><?= $titulo ?></h1>
        <a href="<?= site_url('clientes/novo') ?>" class="btn btn-primary">
            <i class="fas fa-plus"></i> Novo Cliente
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
            <form action="<?= site_url('clientes') ?>" method="get">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label for="nome" class="form-label">Nome</label>
                        <input type="text" class="form-control" id="nome" name="nome" value="<?= $filtros['nome'] ?? '' ?>">
                    </div>
                    <div class="col-md-3">
                        <label for="cpf" class="form-label">CPF</label>
                        <input type="text" class="form-control" id="cpf" name="cpf" value="<?= $filtros['cpf'] ?? '' ?>">
                    </div>
                    <div class="col-md-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="text" class="form-control" id="email" name="email" value="<?= $filtros['email'] ?? '' ?>">
                    </div>
                    <div class="col-md-3">
                        <label for="cidade" class="form-label">Cidade</label>
                        <input type="text" class="form-control" id="cidade" name="cidade" value="<?= $filtros['cidade'] ?? '' ?>">
                    </div>
                    <div class="col-md-3">
                        <label for="estado" class="form-label">Estado</label>
                        <select class="form-select" id="estado" name="estado">
                            <option value="">Todos</option>
                            <?php foreach ($estados as $sigla => $nome): ?>
                                <option value="<?= $sigla ?>" <?= ($filtros['estado'] ?? '') == $sigla ? 'selected' : '' ?>>
                                    <?= $sigla ?> - <?= $nome ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="ativo" class="form-label">Status</label>
                        <select class="form-select" id="ativo" name="ativo">
                            <option value="">Todos</option>
                            <option value="1" <?= (isset($filtros['ativo']) && $filtros['ativo'] === '1') ? 'selected' : '' ?>>Ativo</option>
                            <option value="0" <?= (isset($filtros['ativo']) && $filtros['ativo'] === '0') ? 'selected' : '' ?>>Inativo</option>
                        </select>
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary me-2">
                            <i class="fas fa-search"></i> Filtrar
                        </button>
                        <a href="<?= site_url('clientes') ?>" class="btn btn-secondary">
                            <i class="fas fa-eraser"></i> Limpar
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <?php if (empty($clientes)): ?>
                <div class="alert alert-info">
                    Nenhum cliente encontrado.
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nome</th>
                                <th>CPF</th>
                                <th>Telefone</th>
                                <th>Email</th>
                                <th>Cidade/UF</th>
                                <th>Status</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($clientes as $cliente): ?>
                                <tr>
                                    <td><?= $cliente['id'] ?></td>
                                    <td><?= $cliente['nome'] ?></td>
                                    <td><?= $cliente['cpf'] ?></td>
                                    <td><?= $cliente['telefone'] ?></td>
                                    <td><?= $cliente['email'] ?></td>
                                    <td><?= $cliente['cidade'] ?>/<?= $cliente['estado'] ?></td>
                                    <td>
                                        <?php if ($cliente['ativo']): ?>
                                            <span class="badge bg-success">Ativo</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger">Inativo</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="<?= site_url('clientes/detalhes/' . $cliente['id']) ?>" class="btn btn-info" title="Detalhes">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="<?= site_url('clientes/editar/' . $cliente['id']) ?>" class="btn btn-primary" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="<?= site_url('clientes/confirmarExclusao/' . $cliente['id']) ?>" class="btn btn-danger" title="Excluir">
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
