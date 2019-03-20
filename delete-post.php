<?php
ob_start();
session_start();
include "includes/header.php";
if (!isset($_SESSION['id'])) header('Location: /');

$db = new DB('archive.db');

$user = $_SESSION['id'];
$id = (int)$_GET['id'];

$error = false;
if (isset($_POST['delete'])) {
    $result = $db->delete('posts', 'ID = ' . $id . ' AND Author = ' . $user);

    if (!$result) {
        $error = 'Ошибка базы данных';
    } else {
        $_SESSION['delete_post'] = true;
        header('Location: /posts.php');
    }
}

$post = $db->selectOne('posts', 'id', '`id` = ' . $id . ' AND Author = ' . $user);
if (!$post) header('Location: /posts.php');

?>
    <main class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <h2 class="display-4">Удалить запись? Отменить будет невозможно!</h2>
                <form action="" method="post">
                    <input type="hidden" name="delete" value="<?= $post['ID']; ?>">
                    <button class="btn btn-success btn-lg" type="submit">Да</button>
                    <a href="/posts.php" class="btn btn-danger btn-lg">Нет</a>
                </form>
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
