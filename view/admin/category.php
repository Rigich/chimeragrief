<?php
    if(!empty($_POST)) {

        if(empty($_POST['name']) || empty($_POST['background']) || empty($_POST['status']) || empty($_POST['supplement'])) {
            echo '<div class="uk-alert-danger" uk-alert>
                <a class="uk-alert-close" uk-close></a>
                <p>Произошла ошибка, возможно не заполнены все поля.</p>
            </div>';
        } else {
            $name = $_POST['name'];
            $background = $_POST['background'];
            $supplement = $_POST['supplement'] == "on" ? 'true' : 'false';
            $status = $_POST['status'] == "on" ? 'true' : 'false';
            
            if(!file_exists('resources/images/category/' . $background)) {
                echo '<div class="uk-alert-danger" uk-alert>
                    <a class="uk-alert-close" uk-close></a>
                    <p>Файл изображения не найден в папке /resources/images/category</p>
                </div>';
            } else {
                if(empty($_POST['old_id']) && empty($_POST['id'])) {
                    $result = mysqli_query($connection, "INSERT INTO categories (name, background, supplement, status) VALUES ('" . $name . "', '" . $background . "', " . $supplement . ", " . $status . ")");
                    if($result) {
                        echo '<div class="uk-alert-success" uk-alert>
                            <a class="uk-alert-close" uk-close></a>
                            <p>Категорие успешно добавлен!</p>
                        </div>';
                    } else {
                        echo '<div class="uk-alert-danger" uk-alert>
                            <a class="uk-alert-close" uk-close></a>
                            <p>Произошла ошибка в SQL запросе</p>
                        </div>';
                    }
                } else {
                    $result = mysqli_query($connection, "UPDATE categories SET id = " . $_POST['id'] . ", name = '" . $name . "', background = '" . $background . "', supplement = " . $supplement  . ", status = " . $status . " WHERE id = " . $_POST['old_id']);
                    if($result) {
                        echo '<div class="uk-alert-success" uk-alert>
                            <a class="uk-alert-close" uk-close></a>
                            <p>Категорие успешно редактирован!</p>
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
    <a href="/admin/category/add" class="uk-button uk-button-secondary">Добавить категорию</a>
</p>

<table class="uk-table uk-table-hover uk-table-striped" style="background-color: white; border-radius: 10px;">
    <thead>
        <tr>
            <th>ID</th>
            <th>Название</th>
            <th>Изображение</th>
            <th>Доплата</th>
            <th>Статус</th>
            <th>Действия</th>
        </tr>
    </thead>
    <tbody>
        <?php
            $result = mysqli_query($connection, "SELECT * FROM categories");

            while($row = mysqli_fetch_assoc($result)) {
        ?>
        <tr>
            <td><? echo $row['id']; ?></td>
            <td><? echo $row['name']; ?></td>
            <td><? echo $row['background']; ?></td>
            <td>
                <?php
                    if($row['supplement']) {
                        echo '<span class="uk-badge uk-label-success uk-padding-small">Включено</span>';
                    } else {
                        echo '<span class="uk-badge uk-label-danger uk-padding-small">Выключено</span>';
                    }
                ?>
            </td>
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
                <a href="/admin/category/edit/<? echo $row['id']; ?>" class="uk-padding-small uk-badge uk-label-warning uk-margin-small-right"><span class="ion-edit"></span></a>
                <a uk-tooltip="Бывают ошибки из-за того, что имеется продукты с этим идентификатором" href="/admin/category/del/<? echo $row['id']; ?>" class="uk-padding-small uk-badge uk-label-danger"><span class="ion-trash-b"></span></a>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>