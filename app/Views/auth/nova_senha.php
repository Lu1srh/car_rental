<?= $this->extend('layout/login') ?>

<?= $this->section('conteudo') ?>
<div class="container">
    <h3>Nova Senha</h3>

    <?php if (session()->has('error')): ?>
        <div class="alert alert-danger"><?= session('error') ?></div>
    <?php endif; ?>

    <form action="<?= site_url('auth/novaSenha') ?>" method="post">
        <input type="hidden" name="email" value="<?= esc($email) ?>">
        
        <label for="senha">Nova Senha:</label>
        <input type="password" name="senha" class="form-control" required minlength="6">
        
        <button type="submit" class="btn btn-success mt-2">Salvar nova senha</button>
    </form>
</div>
<?= $this->endSection() ?>
