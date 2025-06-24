<?= $this->extend('layout/principal') ?>

<?= $this->section('conteudo') ?>
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mt-4"><?= $titulo ?></h1>
        <a href="<?= site_url('dashboard') ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Voltar
        </a>
    </div>

    <?php if (session()->has('mensagem')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= session('mensagem') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
        </div>
    <?php endif; ?>

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

    <div class="row">
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Informações do Perfil</h5>
                </div>
                <div class="card-body">
                    <form action="<?= site_url('dashboard/atualizarPerfil') ?>" method="post">
                        <div class="mb-3">
                            <label for="nome" class="form-label">Nome</label>
                            <input type="text" class="form-control" id="nome" name="nome" 
                                   value="<?= old('nome', $usuario['nome']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" 
                                   value="<?= old('email', $usuario['email']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="senha" class="form-label">Nova Senha (deixe em branco para manter a atual)</label>
                            <input type="password" class="form-control" id="senha" name="senha">
                            <div class="form-text">Deixe em branco para manter a senha atual.</div>
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Atualizar Perfil
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Detalhes da Conta</h5>
                </div>
                <div class="card-body">
                    <table class="table">
                        <tr>
                            <th style="width: 40%">ID:</th>
                            <td><?= $usuario['id'] ?></td>
                        </tr>
                        <tr>
                            <th>Nível de Acesso:</th>
                            <td>
                                <?php if ($usuario['nivel_acesso'] == 'admin'): ?>
                                    <span class="badge bg-danger">Administrador</span>
                                <?php else: ?>
                                    <span class="badge bg-info">Operador</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <tr>
                            <th>Status:</th>
                            <td>
                                <?php if ($usuario['ativo']): ?>
                                    <span class="badge bg-success">Ativo</span>
                                <?php else: ?>
                                    <span class="badge bg-danger">Inativo</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <tr>
                            <th>Data de Cadastro:</th>
                            <td><?= date('d/m/Y H:i', strtotime($usuario['created_at'])) ?></td>
                        </tr>
                        <tr>
                            <th>Última Atualização:</th>
                            <td><?= date('d/m/Y H:i', strtotime($usuario['updated_at'])) ?></td>
                        </tr>
                    </table>
                </div>
            </div>
            
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Ações Rápidas</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="<?= site_url('dashboard') ?>" class="btn btn-primary">
                            <i class="fas fa-tachometer-alt"></i> Ir para o Dashboard
                        </a>
                        <a href="<?= site_url('auth/logout') ?>" class="btn btn-danger">
                            <i class="fas fa-sign-out-alt"></i> Sair do Sistema
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
