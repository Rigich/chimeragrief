<?php
    if(!empty($_POST)) {
        $emptyServer = true;
        $servers = [];

        // $commands = explode("\n", str_replace(array("\r\n", "\n\r"), "\n", $_POST['commands']));
        // var_dump($commands);
        // exit();

        $result = mysqli_query($connection, "SELECT * FROM servers");
        while($row = mysqli_fetch_assoc($result)) {
            $serverName = "server-" . $row['id'];
            if(!empty($_POST[$serverName])) {
                $emptyServer = false;
                $servers[] = $row['id'];
            }
        }

        if(!isset($_POST['name']) || !isset($_POST['displayname']) || !isset($_POST['description']) || !isset($_POST['price']) || !isset($_POST['discount']) || !isset($_POST['amounted']) || !isset($_POST['background']) || !isset($_POST['category_id']) || !isset($_POST['status']) || !isset($_POST['commands']) || $emptyServer) {
            echo '<div class="uk-alert-danger" uk-alert>
                <a class="uk-alert-close" uk-close></a>
                <p>Произошла ошибка, возможно не заполнены все поля.</p>
            </div>';
        } else {
            $name = $_POST['name'];
            $displayname = $_POST['displayname'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $discount = $_POST['discount'];
            $background = $_POST['background'];
            $category_id = $_POST['category_id'];
            $commands = $_POST['commands'];
            $amounted = $_POST['amounted'] == "on" ? 'true' : 'false';
            $status = $_POST['status'] == "on" ? 'true' : 'false';

            if(!file_exists('resources/images/product/' . $background)) {
                echo '<div class="uk-alert-danger" uk-alert>
                    <a class="uk-alert-close" uk-close></a>
                    <p>Файл изображения не найден в папке /resources/images/product</p>
                </div>';
            } else {
                if(empty($_POST['old_id']) && empty($_POST['id'])) {
                    $result = mysqli_query($connection, "INSERT INTO products (name, displayname, description, price, discount, amounted, background, category_id, servers, commands, status) VALUES ('" . $name . "', '" . $displayname . "', '" . $description . "', " . $price . ", " . $discount . ", " . $amounted . ", '" . $background . "', " . $category_id . ", '" . implode(",", $servers) . "', '" . $commands . "', " . $status . ")");
                    if($result) {
                        echo '<div class="uk-alert-success" uk-alert>
                            <a class="uk-alert-close" uk-close></a>
                            <p>Продукт успешно добавлен!</p>
                        </div>';
                    } else {
                        echo '<div class="uk-alert-danger" uk-alert>
                            <a class="uk-alert-close" uk-close></a>
                            <p>Произошла ошибка в SQL запросе</p>
                        </div>';
                    }
                } else {
                    $result = mysqli_query($connection, "UPDATE products SET id = " . $_POST['id'] . ", name = '" . $name . "', displayname = '" . $displayname . "', description = '" . $description . "', price = " . $price . ", discount = " . $discount . ", amounted = " . $amounted . ", background = '" . $background . "', category_id = " . $category_id . ", servers = '" . implode(",", $servers) . "', commands = '" . $commands . "', status = " . $status . " WHERE id = " . $_POST['old_id']);
                    if($result) {
                        echo '<div class="uk-alert-success" uk-alert>
                            <a class="uk-alert-close" uk-close></a>
                            <p>Продукт успешно редактирован!</p>
                        </div>';
                    } else {
                        echo '<div class="uk-alert-danger" uk-alert>
                            <a class="uk-alert-close" uk-close></a>
                            <p>Произошла ошибка в SQL запросе</p>
                        </div>';
                    }
                }
            }
        }
    }
?>

<p class="uk-flex uk-flex-right uk-margin-medium-bottom">
    <a href="/admin/product/add" class="uk-button uk-button-secondary">Добавить продукт</a>
</p>

<table class="uk-table uk-table-hover uk-table-striped" style="background-color: white; border-radius: 10px;">
    <thead>
        <tr>
            <th>ID</th>
            <th>Название</th>
            <th>Название для вида</th>
            <th>Описание</th>
            <th>Цена</th>
            <th>Скидка</th>
            <th>Количество</th>
            <th>Изображение</th>
            <th>Категория</th>
            <th>Сервера</th>
            <th>Статус</th>
            <th>Действия</th>
        </tr>
    </thead>
    <tbody>
        <?php
            $result = mysqli_query($connection, "SELECT * FROM products");

            while($row = mysqli_fetch_assoc($result)) {
        ?>
        <tr>
            <td><? echo $row['id']; ?></td>
            <td><? echo $row['name']; ?></td>
            <td><? echo $row['displayname']; ?></td>
            <td><? echo $row['description']; ?></td>
            <td><? echo $row['price']; ?></td>
            <td><? echo $row['discount']; ?></td>
            <td>
                <?php
                    if($row['amounted']) {
                        echo '<span class="uk-badge uk-label-success uk-padding-small">Разрешено</span>';
                    } else {
                        echo '<span class="uk-badge uk-label-danger uk-padding-small">Запрещено</span>';
                    }
                ?>
            </td>
            <td><? echo $row['background']; ?></td>
            <td>
            <?php
            $cresult = mysqli_query($connection, "SELECT name FROM categories WHERE id = " . $row['category_id']);
            $category = mysqli_fetch_assoc($cresult);
            echo '<span class="uk-badge uk-padding-small">' . $category["name"] . '</span>';
            ?>
            </td>
            <td><? echo $row['servers']; ?></td>
            <td>
                <?php
                    if($row['status']) {
                        echo '<span class="uk-badge uk-label-success uk-padding-small">Включено</span>';
                    } else {
                        echo '<span class="uk-badge uk-label-danger uk-padding-small">Выключено</span>';
                    }
                ?>
            </td>
            <td class="uk-flex">
                <a href="/admin/product/edit/<? echo $row['id']; ?>" class="uk-padding-small uk-badge uk-label-warning uk-margin-small-right"><span class="ion-edit"></span></a>
                <a href="/admin/product/del/<? echo $row['id']; ?>" class="uk-padding-small uk-badge uk-label-danger"><span class="ion-trash-b"></span></a>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>