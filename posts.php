<?php
ob_start();
session_start();
include "includes/header.php";
if (!isset($_SESSION['id'])) header('Location: /');

$db = new DB('archive.db');
$user = $_SESSION['id'];

$posts = $db->select('posts', '*', 'Author = "' . $user . '"', ['id', 'DESC']);

?>
    <main class="container">
        <h2 class="display-4">Записи</h2>
        <?php if ($_SESSION['delete_post']): ?>
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                Запись успешно удалена
                <?php unset($_SESSION['delete_post']); ?>
            </div>
        <?php endif; ?>
        <div class="table-responsive">
            <table class="table">
                <thead>
                <tr class="table-primary">
                    <th scope="col">#</th>
                    <th scope="col">Название</th>
                    <th scope="col">Дата</th>
                    <th scope="col"> </th>
                </tr>
                </thead>
                <tbody>
                <?php if ($posts): ?>
                    <?php foreach ($posts as $post): ?>
                        <tr>
                            <td><?= $post['ID']; ?></td>
                            <td><?= $post['Name']; ?></td>
                            <td><?= date('d.m.Y в H:i', $post['Date']); ?></td>
                            <td style="text-align: right;">
                                <a href="/edit-post.php?id=<?= $post['ID']; ?>" class="btn btn-warning">Изменить</a>
                                <a href="/delete-post.php?id=<?= $post['ID']; ?>" class="btn btn-danger">Удалить</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4">Нет записей</td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>
<?php
include "includes/footer.php";