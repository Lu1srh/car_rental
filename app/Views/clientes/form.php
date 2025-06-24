<?= $this->extend('layout/principal') ?>

<?= $this->section('conteudo') ?>
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><?= $titulo ?></h1>
        <a href="<?= site_url('clientes') ?>" class="btn btn-secondary">
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
            $isEdit = isset($cliente);
            $actionUrl = $isEdit ? site_url('clientes/atualizar/' . $cliente['id']) : site_url('clientes/criar');
            ?>
            
            <form action="<?= $actionUrl ?>" method="post">
                <div class="row mb-3">
                    <div class="col-md-8">
                        <label for="nome" class="form-label">Nome Completo</label>
                        <input type="text" class="form-control" id="nome" name="nome" 
                               value="<?= old('nome', $isEdit ? $cliente['nome'] : '') ?>" required>
                    </div>
                    <div class="col-md-4">
                        <label for="cpf" class="form-label">CPF</label>
                        <input type="text" class="form-control" id="cpf" name="cpf" 
                               value="<?= old('cpf', $isEdit ? $cliente['cpf'] : '') ?>" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="logradouro" class="form-label">Logradouro</label>
                        <input type="text" class="form-control" id="logradouro" name="logradouro" 
                               value="<?= old('logradouro', $isEdit ? $cliente['logradouro'] : '') ?>" required>
                    </div>
                    <div class="col-md-2">
                        <label for="numero" class="form-label">Número</label>
                        <input type="text" class="form-control" id="numero" name="numero" 
                               value="<?= old('numero', $isEdit ? $cliente['numero'] : '') ?>" required>
                    </div>
                    <div class="col-md-4">
                        <label for="complemento" class="form-label">Complemento</label>
                        <input type="text" class="form-control" id="complemento" name="complemento" 
                               value="<?= old('complemento', $isEdit ? $cliente['complemento'] : '') ?>">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="bairro" class="form-label">Bairro</label>
                        <input type="text" class="form-control" id="bairro" name="bairro" 
                               value="<?= old('bairro', $isEdit ? $cliente['bairro'] : '') ?>" required>
                    </div>
                    <div class="col-md-4">
                        <label for="cidade" class="form-label">Cidade</label>
                        <input type="text" class="form-control" id="cidade" name="cidade" 
                               value="<?= old('cidade', $isEdit ? $cliente['cidade'] : '') ?>" required>
                    </div>
                    <div class="col-md-2">
                        <label for="estado" class="form-label">Estado</label>
                        <select class="form-select" id="estado" name="estado" required>
                            <option value="">Selecione...</option>
                            <?php foreach ($estados as $sigla => $nome): ?>
                                <option value="<?= $sigla ?>" <?= old('estado', $isEdit ? $cliente['estado'] : '') == $sigla ? 'selected' : '' ?>>
                                    <?= $sigla ?> - <?= $nome ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="cep" class="form-label">CEP</label>
                        <input type="text" class="form-control" id="cep" name="cep" 
                               value="<?= old('cep', $isEdit ? $cliente['cep'] : '') ?>" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="telefone" class="form-label">Telefone</label>
                        <input type="text" class="form-control" id="telefone" name="telefone" 
                               value="<?= old('telefone', $isEdit ? $cliente['telefone'] : '') ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" 
                               value="<?= old('email', $isEdit ? $cliente['email'] : '') ?>" required>
                    </div>
                    <?php if ($isEdit): ?>
                    <div class="col-md-2">
                        <div class="form-check mt-4">
                            <input class="form-check-input" type="checkbox" id="ativo" name="ativo" value="1" 
                                   <?= old('ativo', $cliente['ativo']) ? 'checked' : '' ?>>
                            <label class="form-check-label" for="ativo">
                                Cliente Ativo
                            </label>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> <?= $isEdit ? 'Atualizar' : 'Cadastrar' ?>
                    </button>
                    <a href="<?= site_url('clientes') ?>" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Máscara para CPF
    const cpfInput = document.getElementById('cpf');
    if (cpfInput) {
        cpfInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 11) value = value.slice(0, 11);
            
            if (value.length > 9) {
                value = value.replace(/^(\d{3})(\d{3})(\d{3})/, '$1.$2.$3-');
            } else if (value.length > 6) {
                value = value.replace(/^(\d{3})(\d{3})/, '$1.$2.');
            } else if (value.length > 3) {
                value = value.replace(/^(\d{3})/, '$1.');
            }
            
            e.target.value = value;
        });
    }
    
    // Máscara para CEP
    const cepInput = document.getElementById('cep');
    if (cepInput) {
        cepInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 8) value = value.slice(0, 8);
            
            if (value.length > 5) {
                value = value.replace(/^(\d{5})/, '$1-');
            }
            
            e.target.value = value;
        });
    }
    
    // Máscara para telefone
    const telefoneInput = document.getElementById('telefone');
    if (telefoneInput) {
        telefoneInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 11) value = value.slice(0, 11);
            
            if (value.length > 10) {
                value = value.replace(/^(\d{2})(\d{5})(\d{4})/, '($1) $2-$3');
            } else if (value.length > 6) {
                value = value.replace(/^(\d{2})(\d{4})/, '($1) $2-');
            } else if (value.length > 2) {
                value = value.replace(/^(\d{2})/, '($1) ');
            }
            
            e.target.value = value;
        });
    }
});
</script>
<?= $this->endSection() ?>
