<div class="uk-container uk-container-xsmall">
    <?php
        if(!empty($_POST)) {
            if(!isset($_POST['name']) || !isset($_POST['domain']) || !isset($_POST['ip']) || !isset($_POST['port']) || !isset($_POST['description']) || !isset($_POST['full_description']) || !isset($_POST['logotype']) || !isset($_POST['favicon']) || !isset($_POST['book_image']) || !isset($_POST['book']) || !isset($_POST['vk'])) {
                echo '<div class="uk-alert-danger" uk-alert>
                <a class="uk-alert-close" uk-close></a>
                <p>Произошла ошибка, возможно не заполнены все поля.</p>
            </div>';
            } else {
                $name = $_POST['name'];
                $domain = $_POST['domain'];
                $ip = $_POST['ip'];
                $port = $_POST['port'];
                $description = $_POST['description'];
                $full_descriptionme = $_POST['full_description'];
                $logotype = $_POST['logotype'];
                $favicon = $_POST['favicon'];
                $book_image = $_POST['book_image'];
                $book = $_POST['book'];
                $ds = $_POST['ds'];
                $vk = $_POST['vk'];
                $tg = $_POST['tg'];

                mysqli_query($connection, "UPDATE settings SET value = '" . $name . "' WHERE setting = 'name'");
                mysqli_query($connection, "UPDATE settings SET value = '" . $domain . "' WHERE setting = 'domain'");
                mysqli_query($connection, "UPDATE settings SET value = '" . $ip . "' WHERE setting = 'ip'");
                mysqli_query($connection, "UPDATE settings SET value = '" . $port . "' WHERE setting = 'port'");
                mysqli_query($connection, "UPDATE settings SET value = '" . $description . "' WHERE setting = 'description'");
                mysqli_query($connection, "UPDATE settings SET value = '" . $full_descriptionme . "' WHERE setting = 'full_description'");
                mysqli_query($connection, "UPDATE settings SET value = '" . $logotype . "' WHERE setting = 'logotype'");
                mysqli_query($connection, "UPDATE settings SET value = '" . $favicon . "' WHERE setting = 'favicon'");
                mysqli_query($connection, "UPDATE settings SET value = '" . $book_image . "' WHERE setting = 'book_image'");
                mysqli_query($connection, "UPDATE settings SET value = '" . $book . "' WHERE setting = 'book'");
                mysqli_query($connection, "UPDATE settings SET value = '" . $ds . "' WHERE setting = 'ds'");
                mysqli_query($connection, "UPDATE settings SET value = '" . $vk . "' WHERE setting = 'vk'");
                mysqli_query($connection, "UPDATE settings SET value = '" . $tg . "' WHERE setting = 'tg'");
                echo '<div class="uk-alert-success" uk-alert>
                    <a class="uk-alert-close" uk-close></a>
                    <p>Настройки успешно изменены!</p>
                </div>';
            }
        }
    ?>
    <div class="uk-card uk-card-primary uk-card-body uk-margin-bottom">
        <h4 class="uk-card-title">Редактировании информации:</h4>

        <?php
            $result = mysqli_query($connection, "SELECT * FROM settings");
        ?>
        <form action="/admin/settings" method="POST">
            <fieldset class="uk-fieldset">
                <div class="uk-margin">
                    <label for="">Название</label>
                    <?php
                        $row = mysqli_fetch_assoc($result);
                        echo '<input name="name" class="uk-input" type="text" placeholder="Название" value="' . $row['value'] . '">';
                    ?>
                </div>
                <div class="uk-margin">
                    <label for="">Домен</label>
                    <?php
                        $row = mysqli_fetch_assoc($result);
                        echo '<input name="domain" class="uk-input" type="text" placeholder="Домен" value="' . $row['value'] . '">';
                    ?>
                </div>
                <div class="uk-margin">
                    <label for="">Айпи</label>
                    <?php
                        $row = mysqli_fetch_assoc($result);
                        echo '<input name="ip" class="uk-input" type="text" placeholder="Айпи" value="' . $row['value'] . '">';
                    ?>
                </div>
                <div class="uk-margin">
                    <label for="">Порт (По умолчанию - 25565)</label>
                    <?php
                        $row = mysqli_fetch_assoc($result);
                        echo '<input name="port" class="uk-input" type="text" placeholder="Порт" value="' . $row['value'] . '">';
                    ?>
                </div>
                <div class="uk-margin">
                    <label for="">Краткое описание</label>
                    <?php
                        $row = mysqli_fetch_assoc($result);
                        echo '<input name="description" class="uk-input" type="text" placeholder="Краткое описание" value="' . $row['value'] . '">';
                    ?>
                </div>
                <div class="uk-margin">
                    <label for="">Подробное описание</label>
                    <?php
                        $row = mysqli_fetch_assoc($result);
                        echo '<textarea name="full_description" class="uk-textarea" placeholder="Подробное описание" style="resize: none;" rows="5">' . $row['value'] . '</textarea>';
                    ?>
                </div>
                <div class="uk-margin">
                    <label for="">Логотип (/resources/images/ФАЙЛ)</label>
                    <?php
                        $row = mysqli_fetch_assoc($result);
                        echo '<input name="logotype" class="uk-input" type="text" placeholder="Логотип" value="' . $row['value'] . '">';
                    ?>
                </div>
                <div class="uk-margin">
                    <label for="">Иконка (/resources/images/ФАЙЛ)</label>
                    <?php
                        $row = mysqli_fetch_assoc($result);
                        echo '<input name="favicon" class="uk-input" type="text" placeholder="Иконка" value="' . $row['value'] . '">';
                    ?>
                </div>
                <div class="uk-margin">
                    <label for="">Картинка книги, если нужно поменять на другое (/resources/images/ФАЙЛ)</label>
                    <?php
                        $row = mysqli_fetch_assoc($result);
                        echo '<input name="book_image" class="uk-input" type="text" placeholder="Картинка" value="' . $row['value'] . '">';
                    ?>
                </div>
                <div class="uk-margin">
                    <label for="">Текст в книге</label>
                    <?php
                        $row = mysqli_fetch_assoc($result);
                        echo '<textarea name="book" class="uk-textarea" placeholder="Текст в книге" style="resize: none;" rows="10">' . $row['value'] . '</textarea>';
                    ?>
                </div>
                <div class="uk-margin">
                    <label for="">Дискорд</label>
                    <?php
                        $row = mysqli_fetch_assoc($result);
                        echo '<input name="ds" class="uk-input" type="text" placeholder="Дискорд" value="' . $row['value'] . '">';
                    ?>
                </div>
                <div class="uk-margin">
                    <label for="">ВКонтакте</label>
                    <?php
                        $row = mysqli_fetch_assoc($result);
                        echo '<input name="vk" class="uk-input" type="text" placeholder="ВКонтакте" value="' . $row['value'] . '">';
                    ?>
                </div>
                <div class="uk-margin">
                    <label for="">Телеграм</label>
                    <?php
                        $row = mysqli_fetch_assoc($result);
                        echo '<input name="tg" class="uk-input" type="text" placeholder="Телеграм" value="' . $row['value'] . '">';
                    ?>
                </div>

                <button class="uk-button uk-button-primary uk-width-1-1">Сохранить</button>
            </fieldset>
        </form>
    </div>

    <div class="uk-card uk-card-secondary uk-card-body">
        <h4 class="uk-card-title">Компоненты:</h4>
        
        <form action="/admin/settings/toggle" method="POST">
            <fieldset class="uk-fieldset">
                <div class="uk-margin-small-bottom uk-flex uk-flex-middle">
                    <label class="uk-margin-right" for="">Кнопка "Играть": </label>
                    <div class="switch">
                        <?php
                            $row = mysqli_fetch_assoc($result);
                            echo '<label><input name="btn_play" type="checkbox" value="y" ' . ($row['value'] == "enabled" ? "checked" : "") . '/></label>';
                        ?>
                    </div>
                </div>
                <div class="uk-margin-small-bottom uk-flex uk-flex-middle">
                    <label class="uk-margin-right" for="">Кнопка "Донат": </label>
                    <div class="switch">
                        <?php
                            $row = mysqli_fetch_assoc($result);
                            echo '<label><input name="btn_donate" type="checkbox" value="y" ' . ($row['value'] == "enabled" ? "checked" : "") . '/></label>';
                        ?>
                    </div>
                </div>
                <div class="uk-margin-small-bottom uk-flex uk-flex-middle">
                    <label class="uk-margin-right" for="">Онлайн: </label>
                    <div class="switch">
                        <?php
                            $row = mysqli_fetch_assoc($result);
                            echo '<label><input name="online_toogle" type="checkbox" value="y" ' . ($row['value'] == "enabled" ? "checked" : "") . '/></label>';
                        ?>
                    </div>
                </div>
                <button class="uk-button uk-button-primary uk-width-1-1">Сохранить</button>
            </fieldset>
        </form>
    </div>
</div>