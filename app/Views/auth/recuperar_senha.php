<?= $this->extend('layout/login') ?>

<?= $this->section('conteudo') ?>
<div class="container">
    <h3>Recuperar Senha</h3>

    <?php if (session()->has('error')): ?>
        <div class="alert alert-danger"><?= session('error') ?></div>
    <?php endif; ?>

    <form action="<?= site_url('auth/verificarEmail') ?>" method="post">
        <label for="email">Digite seu email:</label>
        <input type="email" name="email" class="form-control" value="<?= old('email') ?>" required>
        <button type="submit" class="btn btn-primary mt-2">Verificar</button>
    </form>
</div>
<?= $this->endSection() ?>
