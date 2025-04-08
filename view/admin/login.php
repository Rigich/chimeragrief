<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/resources/styles/fonts.css">
    <link rel="stylesheet" href="/resources/styles/admin/login.css">
    <link rel="icon" type="image/png" href="/resources/images/icon.png"/>

    <?php
                    $result = mysqli_query($connection, "SELECT value FROM settings WHERE setting = 'name'");
                    $row = mysqli_fetch_assoc($result);
                ?>
    <title><?= $row['value'] ?> | Админ-панель </title>
</head>
<body>
    <div class="background"></div>
    <div class="wrapper">
        <form class="auth" method="POST">
            <h1 class="title">Авторизация</h1>

            <div class="component">
                <h3 class="text">Логин</h3>
                <input name="login" type="text" class="input">
            </div>
            <div class="component">
                <h3 class="text">Пароль</h3>
                <input name="password" type="password" class="input">
            </div>

            <button type="submit" class="send">Вход</button>
            <?php
                if(!empty($message)) {
                    echo '<div class="message">' . $message . '</div>';
                }
                // $_SESSION['admin'] = 'admin';
            ?>
        </form>
    </div>

    <script src="/resources/scripts/axios.min.js"></script>
    <script src="/resources/scripts/admin/login.js"></script>
</body>
</html>