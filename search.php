<?php
session_start();
include "includes/header.php";


$db = new DB('archive.db');

if (isset($_GET['q'])): ?>
    <?php
    $q = trim($_GET['q']);
    $q = $db->escape($q);

    $posts = $db->select(['posts', 'authors'],
        'posts.ID, posts.`Date`, posts.Name, posts.Content, authors.Name as Author',
        'authors.ID = posts.Author AND (lower(posts.`Name`) LIKE lower("%' . $q . '%") OR lower(authors.`Name`) LIKE lower("%' . $q . '%"))');

    ?>
    <main class="container">
        <div class="row">
            <div class="jumbotron col-12">
                <h2>Поиск</h2>
                <form action="" method="get">
                    <div class="form-group">
                        <input type="search" name="q" placeholder="Введите название или автора статьи"
                               class="form-control" required minlength="3" maxlength="100" value="<?= $q; ?>">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Найти</button>
                    </div>
                </form>
            </div>
        </div>
        <?php if ($posts): ?>
            <?php foreach ($posts as $post): ?>
                <div class="jumbotron">
                    <h1 class="display-4"><?= $post['Name']; ?></h1>
                    <p class="lead"><?= $post['Author']; ?></p>
                    <p><?= date('d.m.Y в H:i', $post['Date']); ?></p>
                    <p class="lead">
                        <a class="btn btn-primary btn-lg" href="/post.php?id=<?= $post['ID']; ?>" role="button">Открыть
                            статью</a>
                    </p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            Ничего не найдено
        <?php endif; ?>
    </main>
<?php else: ?>
    <main class="container">
        <div class="row">
            <div class="jumbotron col-12">
                <h2>Поиск</h2>
                <form action="" method="get">
                    <div class="form-group">
                        <input type="search" name="q" placeholder="Введите название или автора статьи"
                               class="form-control" required minlength="3" maxlength="100" value="<?= $q; ?>">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Найти</button>
                    </div>
                </form>
            </div>
        </div>
    </main>
<?php endif; ?>
<?php
include "includes/footer.php";