<div class="uk-container uk-container-xsmall">
    <?php
        if(!empty($_POST)) {

            if(empty($_POST['login'])) {
                echo '<div class="uk-alert-danger" uk-alert>
                    <a class="uk-alert-close" uk-close></a>
                    <p>Произошла ошибка, возможно не заполнены все поля.</p>
                </div>';
            } else {
                $login = $_SESSION['admin'];
                $new_login = $_POST['login'];
                if(!empty($_POST['password'])) {
                    $password = $_POST['password'];
                    $hash = password_hash($password, PASSWORD_BCRYPT);
                    mysqli_query($connection, "UPDATE admins SET password = '" . $hash . "' WHERE login = '" . $login . "'");
                }

                mysqli_query($connection, "UPDATE admins SET login = '" . $new_login . "' WHERE login = '" . $login . "'");
                $_SESSION['admin'] = $new_login;
                echo '<div class="uk-alert-success" uk-alert>
                    <a class="uk-alert-close" uk-close></a>
                    <p>Аккаунт успешно изменен!</p>
                </div>';
            }
        }
    ?>
    <div class="uk-card uk-card-secondary uk-card-body">
        <h4 class="uk-card-title">Настройка аккаунта</h4>
        <form method="POST">
            <fieldset class="uk-fieldset">
                <div class="uk-margin">
                    <label for="">Логин</label>
                    <input name="login" class="uk-input" type="text" placeholder="Хост" value="<?php echo $_SESSION['admin']; ?>">
                    
                </div>
                <div class="uk-margin">
                    <label for="">Новый пароль (Оставьте пустым, если не хотите изменять)</label>
                    <input name="password" class="uk-input" type="text" placeholder="Пароль">
                </div>

                <button class="uk-button uk-button-primary uk-width-1-1">Сохранить</button>
            </fieldset>
        </form>
    </div>
</div>