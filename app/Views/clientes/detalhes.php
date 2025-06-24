<?= $this->extend('layout/principal') ?>

<?= $this->section('conteudo') ?>
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><?= $titulo ?></h1>
        <a href="<?= site_url('clientes') ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Voltar
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h5 class="card-title">Informações do Cliente</h5>
                    <table class="table table-striped">
                        <tr>
                            <th style="width: 30%">ID:</th>
                            <td><?= $cliente['id'] ?></td>
                        </tr>
                        <tr>
                            <th>Nome:</th>
                            <td><?= $cliente['nome'] ?></td>
                        </tr>
                        <tr>
                            <th>CPF:</th>
                            <td><?= $cliente['cpf'] ?></td>
                        </tr>
                        <tr>
                            <th>Endereço:</th>
                            <td><?= $endereco ?></td>
                        </tr>
                        <tr>
                            <th>Telefone:</th>
                            <td><?= $cliente['telefone'] ?></td>
                        </tr>
                        <tr>
                            <th>Email:</th>
                            <td><?= $cliente['email'] ?></td>
                        </tr>
                        <tr>
                            <th>Status:</th>
                            <td>
                                <?php if ($cliente['ativo']): ?>
                                    <span class="badge bg-success">Ativo</span>
                                <?php else: ?>
                                    <span class="badge bg-danger">Inativo</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <tr>
                            <th>Data de Cadastro:</th>
                            <td><?= date('d/m/Y H:i', strtotime($cliente['created_at'])) ?></td>
                        </tr>
                        <tr>
                            <th>Última Atualização:</th>
                            <td><?= $cliente['updated_at'] ? date('d/m/Y H:i', strtotime($cliente['updated_at'])) : 'N/A' ?></td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <h5 class="card-title">Ações</h5>
                    <div class="d-grid gap-2">
                        <a href="<?= site_url('clientes/editar/' . $cliente['id']) ?>" class="btn btn-primary">
                            <i class="fas fa-edit"></i> Editar Cliente
                        </a>
                        
                        <?php if ($cliente['ativo']): ?>
                            <form action="<?= site_url('clientes/atualizar/' . $cliente['id']) ?>" method="post" class="mb-3">
                                <input type="hidden" name="nome" value="<?= $cliente['nome'] ?>">
                                <input type="hidden" name="cpf" value="<?= $cliente['cpf'] ?>">
                                <input type="hidden" name="logradouro" value="<?= $cliente['logradouro'] ?>">
                                <input type="hidden" name="numero" value="<?= $cliente['numero'] ?>">
                                <input type="hidden" name="complemento" value="<?= $cliente['complemento'] ?>">
                                <input type="hidden" name="bairro" value="<?= $cliente['bairro'] ?>">
                                <input type="hidden" name="cidade" value="<?= $cliente['cidade'] ?>">
                                <input type="hidden" name="estado" value="<?= $cliente['estado'] ?>">
                                <input type="hidden" name="cep" value="<?= $cliente['cep'] ?>">
                                <input type="hidden" name="telefone" value="<?= $cliente['telefone'] ?>">
                                <input type="hidden" name="email" value="<?= $cliente['email'] ?>">
                                <input type="hidden" name="ativo" value="0">
                                <button type="submit" class="btn btn-warning w-100">
                                    <i class="fas fa-user-slash"></i> Desativar Cliente
                                </button>
                            </form>
                        <?php else: ?>
                            <form action="<?= site_url('clientes/atualizar/' . $cliente['id']) ?>" method="post" class="mb-3">
                                <input type="hidden" name="nome" value="<?= $cliente['nome'] ?>">
                                <input type="hidden" name="cpf" value="<?= $cliente['cpf'] ?>">
                                <input type="hidden" name="logradouro" value="<?= $cliente['logradouro'] ?>">
                                <input type="hidden" name="numero" value="<?= $cliente['numero'] ?>">
                                <input type="hidden" name="complemento" value="<?= $cliente['complemento'] ?>">
                                <input type="hidden" name="bairro" value="<?= $cliente['bairro'] ?>">
                                <input type="hidden" name="cidade" value="<?= $cliente['cidade'] ?>">
                                <input type="hidden" name="estado" value="<?= $cliente['estado'] ?>">
                                <input type="hidden" name="cep" value="<?= $cliente['cep'] ?>">
                                <input type="hidden" name="telefone" value="<?= $cliente['telefone'] ?>">
                                <input type="hidden" name="email" value="<?= $cliente['email'] ?>">
                                <input type="hidden" name="ativo" value="1">
                                <button type="submit" class="btn btn-success w-100">
                                    <i class="fas fa-user-check"></i> Ativar Cliente
                                </button>
                            </form>
                        <?php endif; ?>
                        
                        <a href="<?= site_url('clientes/confirmarExclusao/' . $cliente['id']) ?>" class="btn btn-danger">
                            <i class="fas fa-trash"></i> Excluir Cliente
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="row mt-4">
                <div class="col-12">
                    <h5 class="card-title">Histórico de Locações</h5>
                    <?php if (empty($historicoLocacoes)): ?>
                        <div class="alert alert-info">
                            Este cliente ainda não realizou nenhuma locação.
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Veículo</th>
                                        <th>Data Retirada</th>
                                        <th>Data Devolução Prevista</th>
                                        <th>Data Devolução Efetiva</th>
                                        <th>Valor Total</th>
                                        <th>Status</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($historicoLocacoes as $locacao): ?>
                                        <tr>
                                            <td><?= $locacao['id'] ?></td>
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
                                                <a href="<?= site_url('locacoes/detalhes/' . $locacao['id']) ?>" class="btn btn-sm btn-info">
                                                    <i class="fas fa-eye"></i>
                                                </a>
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
    </div>
</div>
<?= $this->endSection() ?>
