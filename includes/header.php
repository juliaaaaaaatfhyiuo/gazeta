<?php
include "sqlite.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Газета "Вперед"</title>

    <link rel="stylesheet" href="https://bootswatch.com/4/flatly/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
        <div class="container">
            <a class="navbar-brand" href="/">Газета "Вперед"</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor02"
                aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarColor02">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/index.php">Статьи</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/search.php">Поиск</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <?php if (isset($_SESSION['id'])): ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <?= $_SESSION['name']; ?>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="/new-post.php">Добавить новую статью</a>
                            <a class="dropdown-item" href="/posts.php">Просмотр статей</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="/logout.php">Выход</a>
                        </div>
                    </li>
                    <?php else: ?>
                    <li class="nav-item">
                        <a href="/login.php" class="nav-link">Вход</a>
                    </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>