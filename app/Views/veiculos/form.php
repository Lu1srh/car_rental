<?= $this->extend('layout/principal') ?>

<?= $this->section('conteudo') ?>
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><?= $titulo ?></h1>
        <a href="<?= site_url('veiculos') ?>" class="btn btn-secondary">
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
            $isEdit = isset($veiculo);
            $actionUrl = $isEdit ? site_url('veiculos/atualizar/' . $veiculo['id']) : site_url('veiculos/criar');
            ?>
            
            <form action="<?= $actionUrl ?>" method="post">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="marca" class="form-label">Marca</label>
                        <input type="text" class="form-control" id="marca" name="marca" 
                               value="<?= old('marca', $isEdit ? $veiculo['marca'] : '') ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label for="modelo" class="form-label">Modelo</label>
                        <input type="text" class="form-control" id="modelo" name="modelo" 
                               value="<?= old('modelo', $isEdit ? $veiculo['modelo'] : '') ?>" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-3">
                        <label for="ano" class="form-label">Ano</label>
                        <input type="number" class="form-control" id="ano" name="ano" min="1900" max="<?= date('Y') + 1 ?>" 
                               value="<?= old('ano', $isEdit ? $veiculo['ano'] : '') ?>" required>
                    </div>
                    <div class="col-md-3">
                        <label for="placa" class="form-label">Placa</label>
                        <input type="text" class="form-control" id="placa" name="placa" 
                               value="<?= old('placa', $isEdit ? $veiculo['placa'] : '') ?>" required>
                    </div>
                    <div class="col-md-3">
                        <label for="cor" class="form-label">Cor</label>
                        <input type="text" class="form-control" id="cor" name="cor" 
                               value="<?= old('cor', $isEdit ? $veiculo['cor'] : '') ?>" required>
                    </div>
                    <div class="col-md-3">
                        <label for="categoria_id" class="form-label">Categoria</label>
                        <select class="form-select" id="categoria_id" name="categoria_id" required>
                            <option value="">Selecione...</option>
                            <?php foreach ($categorias as $id => $nome): ?>
                                <option value="<?= $id ?>" <?= old('categoria_id', $isEdit ? $veiculo['categoria_id'] : '') == $id ? 'selected' : '' ?>>
                                    <?= $nome ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="disponivel" <?= old('status', $isEdit ? $veiculo['status'] : '') == 'disponivel' ? 'selected' : '' ?>>
                                Disponível
                            </option>
                            <option value="locado" <?= old('status', $isEdit ? $veiculo['status'] : '') == 'locado' ? 'selected' : '' ?>>
                                Locado
                            </option>
                            <option value="manutencao" <?= old('status', $isEdit ? $veiculo['status'] : '') == 'manutencao' ? 'selected' : '' ?>>
                                Em Manutenção
                            </option>
                        </select>
                    </div>
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> <?= $isEdit ? 'Atualizar' : 'Cadastrar' ?>
                    </button>
                    <a href="<?= site_url('veiculos') ?>" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>