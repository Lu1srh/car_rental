<?= $this->extend('layout/principal') ?>

<?= $this->section('conteudo') ?>
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mt-4"><?= $titulo ?></h1>
        <?php if (session()->get('nivel_acesso') === 'admin'): ?>
        <a href="<?= site_url('dashboard/novoUsuario') ?>" class="btn btn-primary">
            <i class="fas fa-plus"></i> Novo Usuário
        </a>
        <?php endif; ?>
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
            <form action="<?= site_url('dashboard/usuarios') ?>" method="get">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label for="nome" class="form-label">Nome</label>
                        <input type="text" class="form-control" id="nome" name="nome" value="<?= $filtros['nome'] ?? '' ?>">
                    </div>
                    <div class="col-md-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="text" class="form-control" id="email" name="email" value="<?= $filtros['email'] ?? '' ?>">
                    </div>
                    <div class="col-md-2">
                        <label for="nivel_acesso" class="form-label">Nível de Acesso</label>
                        <select class="form-select" id="nivel_acesso" name="nivel_acesso">
                            <option value="">Todos</option>
                            <option value="admin" <?= ($filtros['nivel_acesso'] ?? '') == 'admin' ? 'selected' : '' ?>>Administrador</option>
                            <option value="operador" <?= ($filtros['nivel_acesso'] ?? '') == 'operador' ? 'selected' : '' ?>>Operador</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="ativo" class="form-label">Status</label>
                        <select class="form-select" id="ativo" name="ativo">
                            <option value="">Todos</option>
                            <option value="1" <?= (isset($filtros['ativo']) && $filtros['ativo'] === '1') ? 'selected' : '' ?>>Ativo</option>
                            <option value="0" <?= (isset($filtros['ativo']) && $filtros['ativo'] === '0') ? 'selected' : '' ?>>Inativo</option>
                        </select>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary me-2">
                            <i class="fas fa-search"></i> Filtrar
                        </button>
                        <a href="<?= site_url('dashboard/usuarios') ?>" class="btn btn-secondary">
                            <i class="fas fa-eraser"></i> Limpar
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <?php if (empty($usuarios)): ?>
                <div class="alert alert-info">
                    Nenhum usuário encontrado.
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nome</th>
                                <th>Email</th>
                                <th>Nível de Acesso</th>
                                <th>Status</th>
                                <th>Data de Cadastro</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($usuarios as $usuario): ?>
                                <tr>
                                    <td><?= $usuario['id'] ?></td>
                                    <td><?= $usuario['nome'] ?></td>
                                    <td><?= $usuario['email'] ?></td>
                                    <td>
                                        <?php if ($usuario['nivel_acesso'] == 'admin'): ?>
                                            <span class="badge bg-danger">Administrador</span>
                                        <?php else: ?>
                                            <span class="badge bg-info">Operador</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($usuario['ativo']): ?>
                                            <span class="badge bg-success">Ativo</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger">Inativo</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= date('d/m/Y', strtotime($usuario['created_at'])) ?></td>
                                    <td>
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="<?= site_url('dashboard/editarUsuario/' . $usuario['id']) ?>" class="btn btn-primary" title="Editar">
                                                <i class="fas fa-edit"></i>
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
