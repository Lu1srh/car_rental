<?= $this->extend('layout/principal') ?>

<?= $this->section('conteudo') ?>
<div class="container-fluid px-4">
    <h1 class="mt-4"><?= $titulo ?></h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Visão Geral</li>
    </ol>
    
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
    
    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="card bg-primary text-white mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="small">Total de Veículos</div>
                            <div class="fs-3"><?= $totalVeiculos ?></div>
                        </div>
                        <div>
                            <i class="fas fa-car fa-2x"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="<?= site_url('veiculos') ?>">Ver Detalhes</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-success text-white mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="small">Veículos Disponíveis</div>
                            <div class="fs-3"><?= $veiculosDisponiveis ?></div>
                        </div>
                        <div>
                            <i class="fas fa-check-circle fa-2x"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="<?= site_url('veiculos') ?>?status=disponivel">Ver Detalhes</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-warning text-white mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="small">Veículos Locados</div>
                            <div class="fs-3"><?= $veiculosLocados ?></div>
                        </div>
                        <div>
                            <i class="fas fa-key fa-2x"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="<?= site_url('veiculos') ?>?status=locado">Ver Detalhes</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-danger text-white mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="small">Em Manutenção</div>
                            <div class="fs-3"><?= $veiculosManutencao ?></div>
                        </div>
                        <div>
                            <i class="fas fa-tools fa-2x"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="<?= site_url('veiculos') ?>?status=manutencao">Ver Detalhes</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-xl-6">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-chart-pie me-1"></i>
                    Status das Locações
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-4">
                            <div class="card bg-primary text-white mb-2">
                                <div class="card-body py-2">
                                    <h5><?= $locacoesAtivas ?></h5>
                                    <div>Ativas</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-success text-white mb-2">
                                <div class="card-body py-2">
                                    <h5><?= $locacoesFinalizadas ?></h5>
                                    <div>Finalizadas</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-danger text-white mb-2">
                                <div class="card-body py-2">
                                    <h5><?= $locacoesCanceladas ?></h5>
                                    <div>Canceladas</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-center mt-3">
                        <a href="<?= site_url('locacoes') ?>" class="btn btn-primary">Gerenciar Locações</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-users me-1"></i>
                    Clientes
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-6">
                            <div class="card bg-info text-white mb-2">
                                <div class="card-body py-2">
                                    <h5><?= $totalClientes ?></h5>
                                    <div>Total de Clientes</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card bg-success text-white mb-2">
                                <div class="card-body py-2">
                                    <h5><?= $clientesAtivos ?></h5>
                                    <div>Clientes Ativos</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-center mt-3">
                        <a href="<?= site_url('clientes') ?>" class="btn btn-primary">Gerenciar Clientes</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-clipboard-list me-1"></i>
            Locações Recentes
        </div>
        <div class="card-body">
            <?php if (empty($locacoesRecentes)): ?>
                <div class="alert alert-info">
                    Nenhuma locação registrada.
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
                                <th>Status</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($locacoesRecentes as $locacao): ?>
                                <tr>
                                    <td><?= $locacao['id'] ?></td>
                                    <td><?= $locacao['cliente_nome'] ?></td>
                                    <td><?= $locacao['marca'] ?> <?= $locacao['modelo'] ?></td>
                                    <td><?= date('d/m/Y', strtotime($locacao['data_retirada'])) ?></td>
                                    <td><?= date('d/m/Y', strtotime($locacao['data_devolucao_prevista'])) ?></td>
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
                                        <a href="<?= site_url('locacoes/detalhes/' . $locacao['id']) ?>" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="text-center mt-3">
                    <a href="<?= site_url('locacoes') ?>" class="btn btn-primary">Ver Todas as Locações</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
