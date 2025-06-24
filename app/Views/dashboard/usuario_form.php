<?= $this->extend('layout/principal') ?>

<?= $this->section('conteudo') ?>
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mt-4"><?= $titulo ?></h1>
        <a href="<?= site_url('dashboard/usuarios') ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Voltar
        </a>
    </div>

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

    <div class="card">
        <div class="card-body">
            <?php 
            $isEdit = isset($usuario);
            $actionUrl = $isEdit ? site_url('dashboard/atualizarUsuario/' . $usuario['id']) : site_url('dashboard/criarUsuario');
            ?>
            
            <form action="<?= $actionUrl ?>" method="post">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="nome" class="form-label">Nome</label>
                        <input type="text" class="form-control" id="nome" name="nome" 
                               value="<?= old('nome', $isEdit ? $usuario['nome'] : '') ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" 
                               value="<?= old('email', $isEdit ? $usuario['email'] : '') ?>" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="senha" class="form-label"><?= $isEdit ? 'Nova Senha (deixe em branco para manter a atual)' : 'Senha' ?></label>
                        <input type="password" class="form-control" id="senha" name="senha" 
                               <?= $isEdit ? '' : 'required' ?>>
                        <?php if ($isEdit): ?>
                            <div class="form-text">Deixe em branco para manter a senha atual.</div>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-6">
                        <label for="nivel_acesso" class="form-label">Nível de Acesso</label>
                        <select class="form-select" id="nivel_acesso" name="nivel_acesso" required>
                            <option value="">Selecione...</option>
                            <option value="admin" <?= old('nivel_acesso', $isEdit ? $usuario['nivel_acesso'] : '') == 'admin' ? 'selected' : '' ?>>
                                Administrador
                            </option>
                            <option value="operador" <?= old('nivel_acesso', $isEdit ? $usuario['nivel_acesso'] : '') == 'operador' ? 'selected' : '' ?>>
                                Operador
                            </option>
                        </select>
                    </div>
                </div>

                <?php if ($isEdit): ?>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="ativo" name="ativo" value="1" 
                                   <?= old('ativo', $usuario['ativo']) ? 'checked' : '' ?>>
                            <label class="form-check-label" for="ativo">
                                Usuário Ativo
                            </label>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> <?= $isEdit ? 'Atualizar' : 'Cadastrar' ?>
                    </button>
                    <a href="<?= site_url('dashboard/usuarios') ?>" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
