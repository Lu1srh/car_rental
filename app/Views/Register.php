<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastro</title>
</head>
<body>
    <h2>Cadastro</h2>

    <?php if(isset($errors)): ?>
        <ul style="color:red">
            <?php foreach($errors as $error): ?>
                <li><?= esc($error) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <form action="<?= site_url('auth/signUp') ?>" method="post">
        <?= csrf_field() ?>
        
        <label>Usuário:</label><br>
        <input type="text" name="username" value="<?= old('username') ?>" required><br><br>

        <label>Email:</label><br>
        <input type="email" name="email" value="<?= old('email') ?>" required><br><br>

        <label>Senha:</label><br>
        <input type="password" name="password" required><br><br>

        <label>Confirmar senha:</label><br>
        <input type="password" name="password_confirm" required><br><br>

        <button type="submit">Cadastrar</button>
    </form>

    <p>Já tem cadastro? <a href="<?= site_url('auth/login') ?>">Faça login aqui</a></p>
</body>
</html>