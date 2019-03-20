<?php
session_start();
include "includes/header.php";

$db = new DB('archive.db');
$posts = $db->select('posts', '*', '1', ['date', 'DESC']);

$_authors = $db->select('authors');
$authors = array();
foreach ($_authors as $author) {
    $authors[$author['ID']] = $author['Name'];
}

?>
    <main class="container">
        <?php foreach ($posts as $post): ?>
            <div class="jumbotron">
                <h1 class="display-4"><?= $post['Name']; ?></h1>
                <p class="lead"><?= $authors[$post['Author']]; ?></p>
                <p><?= date('d.m.Y в H:i', $post['Date']); ?></p>
                <p class="lead">
                    <a class="btn btn-primary btn-lg" href="/post.php?id=<?= $post['ID']; ?>" role="button">Открыть статью</a>
                </p>
            </div>
        <?php endforeach; ?>
    </main>
<?php
include "includes/footer.php";