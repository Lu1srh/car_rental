<?= $this->extend('layout/principal') ?>

<?= $this->section('conteudo') ?>
<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">
            <h1>Bem-vindo ao Sistema de Locadora de Carros</h1>
            <p class="lead">Sistema de gerenciamento completo para sua locadora de veículos.</p>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0"><i class="fas fa-car me-2"></i>Gestão de Veículos</h5>
                </div>
                <div class="card-body">
                    <p class="card-text">Cadastre e gerencie todos os veículos da sua frota, com informações detalhadas e status atualizado.</p>
                    <a href="<?= site_url('veiculos') ?>" class="btn btn-primary">Acessar</a>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-header bg-success text-white">
                    <h5 class="card-title mb-0"><i class="fas fa-users me-2"></i>Gestão de Clientes</h5>
                </div>
                <div class="card-body">
                    <p class="card-text">Cadastre e gerencie seus clientes, mantendo um histórico completo de locações e preferências.</p>
                    <a href="<?= site_url('clientes') ?>" class="btn btn-success">Acessar</a>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-header bg-info text-white">
                    <h5 class="card-title mb-0"><i class="fas fa-clipboard-list me-2"></i>Gestão de Locações</h5>
                </div>
                <div class="card-body">
                    <p class="card-text">Registre novas locações, controle devoluções e calcule valores automaticamente.</p>
                    <a href="<?= site_url('locacoes') ?>" class="btn btn-info">Acessar</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-2">
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header bg-warning text-dark">
                    <h5 class="card-title mb-0"><i class="fas fa-tags me-2"></i>Categorias de Veículos</h5>
                </div>
                <div class="card-body">
                    <p class="card-text">Gerencie as categorias de veículos e seus respectivos valores de diária.</p>
                    <a href="<?= site_url('categorias') ?>" class="btn btn-warning">Acessar</a>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header bg-secondary text-white">
                    <h5 class="card-title mb-0"><i class="fas fa-chart-bar me-2"></i>Relatórios</h5>
                </div>
                <div class="card-body">
                    <p class="card-text">Visualize relatórios e estatísticas sobre locações, veículos mais alugados e faturamento.</p>
                    <a href="<?= site_url('relatorios') ?>" class="btn btn-secondary">Acessar</a>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
