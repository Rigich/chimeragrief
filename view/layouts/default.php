<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="/resources/images/icon.png"/>
    <link rel="stylesheet" href="/resources/styles/fonts.css">
    <link rel="stylesheet" href="/resources/styles/default.css">
    <?php
        foreach($styles as $style) {
            echo '<link rel="stylesheet" href="/resources/styles/' . $style . '.css">';
        }
    ?>
    <title><? echo $title; ?> </title>
</head>
<body>
    <div class="wrapper">
        <main class="content">
            <header class="header">
                <nav class="header__row header__nav">
                    <div class="container">
                        <ul class="header__list">
                            <li class="header__list-item">
                                <a href="/" class="header__list-link">
                                    <img src="/resources/images/minecraft/end_crystal.png" class="header__list-icon">
                                    Главная
                                </a>
                            </li>
                            <li class="header__list-item">
                                <?php
                                    $result = mysqli_query($connection, "SELECT value FROM settings WHERE setting = 'vk'");
                                    $row = mysqli_fetch_assoc($result);
                                ?>
                                <a href="<? echo $row['value']; ?>" class="header__list-link" target="_blank">
                                    <img src="/resources/images/minecraft/ender_pearl.png" class="header__list-icon"target="_blank">
                                    ВКонтакте
                                </a>
                            </li>
                            </li>
                            <li class="header__list-item">
                                <a href="https://forum.nether-world.ru" class="header__list-link">
                                    <img src="/resources/images/minecraft/written_book.png" class="header__list-icon" target="_blank">
                                    Форум
                                </a>
                                </a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>
            <?php
                require_once $content;
            ?>
        </main>
<footer class="footer">
<div class="footer__container">
<a class="footer__logo logo" href="/">
<picture>
</picture>
</a>
<div class="footer__block-copyright">
<div class="footer__copyright-title">
                <?php
                    $result = mysqli_query($connection, "SELECT value FROM settings WHERE setting = 'name'");
                    $row = mysqli_fetch_assoc($result);
                ?>
<h1><?= $row['value'] ?></h1>
<br/>
                <?php
                    $result = mysqli_query($connection, "SELECT value FROM settings WHERE setting = 'name'");
                    $row = mysqli_fetch_assoc($result);
                ?>
<p>© 2023 <?= $row['value'] ?> Все права защищены.</p>
<p>Копирование запрещено</p>

Контактная почта:
<a class="footer__copyright-link">
                <?php
                    $result = mysqli_query($connection, "SELECT value FROM settings WHERE setting = 'email'");
                    $row = mysqli_fetch_assoc($result);
                ?>
<? echo $row['value']; ?></span></a>
</div>
<a class="footer__copyright-link" href="https://t.me/mikotik_yt">Разработчик NEKKA</a>
<p class="footer__copyright-text">
</p>
</div>
<div class="footer__block-politics" data-da=".footer__container,62, 4">
<p class="footer__politics-text">
                <?php
                    $result = mysqli_query($connection, "SELECT value FROM settings WHERE setting = 'name'");
                    $row = mysqli_fetch_assoc($result);
                ?>
<?= $row['value'] ?> не связан с Mojang AB.<br/>Все средства идут на развитие
проекта<br/>Коммерческая деятельность проекта<br/>соответствует
<a class="footer__politics-link" href="/mojang.pdf" target="_blank">политике Mojang AB.</a>
</p>
</div>
<nav class="footer__nav">
<ul class="footer__list">
<li class="footer__item">
<a class="footer__link" href="/">Главная</a>
</li>
<li class="footer__item">
<a class="footer__link" href="https://discord.gg/nighthvh" target="_blank">Правила</a>
</li>
<li class="footer__item">
<a class="footer__link" href="/oferta">Договор-оферты</a>
</li>
<li class="footer__item">
<a class="footer__link" href="/policy">Политика конфиденциальности</a>
</li>
</ul>
</nav>
<div class="footer__socials socials">
                <?php
                    $result = mysqli_query($connection, "SELECT value FROM settings WHERE setting = 'ds'");
                    $row = mysqli_fetch_assoc($result);
                ?>
<a class="footer__social socials__item socials__item_discord" href="<?= $row['value'] ?>" target="_blank"><svg class="discord" style="fill: currentColor" aria-hidden>
<use xlink:href="resources/images/icons.svg#svg-discord"></use>
                <?php
                    $result = mysqli_query($connection, "SELECT value FROM settings WHERE setting = 'vk'");
                    $row = mysqli_fetch_assoc($result);
                ?>
</svg></a><a class="footer__social socials__item socials__item_vk" href="<?= $row['value'] ?>" target="_blank"><svg class="vk" style="fill: currentColor" aria-hidden>
<use xlink:href="resources/images/icons.svg#svg-vk"></use>
                <?php
                    $result = mysqli_query($connection, "SELECT value FROM settings WHERE setting = 'tg'");
                    $row = mysqli_fetch_assoc($result);
                ?>
</svg></a><a class="footer__social socials__item socials__item_tg" href="<?= $row['value'] ?>" target="_blank"><svg class="tg" style="fill: currentColor" aria-hidden>
<use xlink:href="resources/images/icons.svg#svg-tg"></use>
</svg></a>
</div>
</div>
</footer>
</div>

    <script src="/resources/scripts/default.js"></script>
    <?php
        foreach($scripts as $script) {
            echo '<script src="/resources/scripts/' . $script . '.js"></script>';
        }
    ?>
</body>
</html>