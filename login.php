<?php
ob_start();
session_start();
include "includes/header.php";

$db = new DB('archive.db');

if (isset($_SESSION['id'])) {
    header('Location: /');
}

if (isset($_POST['login']) && isset($_POST['password'])) {
    $login = trim($_POST['login']);
    $login = htmlspecialchars($login);
    $password = trim($_POST['password']);

    $user = $db->selectOne('authors', ['ID', 'Name'], 'login = "' . $login . '" AND password = "' . $password . '"');
    $error = false;

    if (isset($user['ID'])) {
        $_SESSION['id'] = $user['ID'];
        $_SESSION['name'] = $user['Name'];
        header('Location: /');
    } else {
        $error = true;
    }
}
?>
    <main class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <?php if ($error): ?>
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        Неверный логин/пароль
                    </div>
                <?php endif; ?>
                <div class="jumbotron">
                    <h2 class="display-4">Авторизация</h2>
                    <form action="" method="post">
                        <div class="form-group">
                            <label for="login">Логин</label>
                            <input type="text" class="form-control" id="login" placeholder="Введите логин" name="login"
                                   value="<?= $login; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Пароль</label>
                            <input type="password" class="form-control" id="password" placeholder="•••••"
                                   name="password" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Войти</button>
                    </form>
                </div>
            </div>
        </div>
    </main>
<?php
include "includes/footer.php";