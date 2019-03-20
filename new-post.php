<?php
ob_start();
session_start();
include "includes/header.php";
if (!isset($_SESSION['id'])) header('Location: /');

$db = new DB('archive.db');

$user = $_SESSION['id'];

$error = false;
if (isset($_POST['name']) && isset($_POST['content'])) {
    $name = trim($_POST['name']);
    $name = htmlspecialchars($name);
    $content = trim($_POST['content']);
    $content = trim($_POST['content'], "&nbsp;");

    $name = $db->escape($name);
    $content = $db->escape($content);

    if (!empty($content)) {

        $result = $db->insert('posts', array(
            'Name'    => $name,
            'Content' => $content,
            'Author'  => $user,
            'Date'    => time()
        ));

        if ($result) {
            header('Location: /posts.php');
        } else {
            $error = 'Ошибка базы данных';
        }

    } else {
        $error = 'Введите текст записи';
    }
}

?>
    <main class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <?php if ($error): ?>
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <?= $error; ?>
                    </div>
                <?php endif; ?>
                <div class="jumbotron">
                    <h2 class="display-4">Добавление записи</h2>
                    <form action="" method="post">
                        <div class="form-group">
                            <label for="name">Название записи</label>
                            <input type="text" class="form-control" id="name" placeholder="Введите заголовок"
                                   name="name"
                                   value="<?= $name; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="content">Текст</label>
                            <textarea name="content" id="content" cols="30" rows="10" placeholder="..."
                                      class="form-control"><?= $content; ?></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Сохранить</button>
                    </form>
                </div>
            </div>
        </div>
    </main>
    <script src="edit.js"></script>
    <script>
        bkLib.onDomLoaded(function () {
            new nicEditor({fullPanel: true})
                .panelInstance('content');
        });
    </script>
<?php
include "includes/footer.php";
