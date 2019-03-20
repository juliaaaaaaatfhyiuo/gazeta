<?php
session_start();
include "includes/header.php";

$id = (int)$_GET['id'];

$db = new DB('archive.db');
$post = $db->selectOne('posts', '*', '`id` = ' . $id);
if (!$post) exit('Не найдено');

$author = $db->selectOne('authors', 'Name', '`id` = ' . $post['Author']);

?>
    <main class="container">
        <div class="row">
            <h1><?= $post['Name']; ?></h1>
            <div class="col-12">
                <ol class="post-info breadcrumb">
                    <li class="breadcrumb-item">
                        #<?= $post['ID']; ?>
                    </li>
                    <li class="breadcrumb-item">
                        <?= date('d.m.Y в H:i ', $post['Date']); ?>
                    </li>
                    <li class="breadcrumb-item">
                        <?= $author['Name']; ?>
                    </li>
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="content">
                    <?= nl2br($post['Content']); ?>
                </div>
            </div>
        </div>
    </main>
<?php
include "includes/footer.php";