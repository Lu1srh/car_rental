<?= $this->extend('layout/login') ?>

<?= $this->section('conteudo') ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-5">
            <div class="card shadow-lg border-0 rounded-lg mt-5">
                <div class="card-header">
                    <h3 class="text-center font-weight-light my-4">Login</h3>
                </div>
                <div class="card-body">
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

                    <form action="<?= site_url('auth/login') ?>" method="post">
                        <?= csrf_field() ?>
                        <div class="form-floating mb-3">
                            <input class="form-control" id="email" name="email" type="email" required />
                            <label for="email">Email</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input class="form-control" id="senha" name="senha" type="password" required />
                            <label for="senha">Senha</label>
                        </div>
                        <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                            <button class="btn btn-primary" type="submit">Entrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>