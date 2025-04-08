<?php
    if(!empty($_POST)) {

        if(empty($_POST['name']) || empty($_POST['ip']) || empty($_POST['port']) || empty($_POST['password']) || empty($_POST['status'])) {
            echo '<div class="uk-alert-danger" uk-alert>
                <a class="uk-alert-close" uk-close></a>
                <p>Произошла ошибка, возможно не заполнены все поля.</p>
            </div>';
        } else {
            $name = $_POST['name'];
            $ip = $_POST['ip'];
            $port = $_POST['port'];
            $password = $_POST['password'];
            $status = $_POST['status'] == "on" ? 'true' : 'false';

            if(empty($_POST['old_id']) && empty($_POST['id'])) {
                $result = mysqli_query($connection, "INSERT INTO servers (name, ip, port, password, status) VALUES ('" . $name . "', '" . $ip . "', '" . $port . "', '" . $password . "', " . $status . ")");
                if($result) {
                    echo '<div class="uk-alert-success" uk-alert>
                        <a class="uk-alert-close" uk-close></a>
                        <p>Сервер успешно добавлен!</p>
                    </div>';
                } else {
                    echo '<div class="uk-alert-danger" uk-alert>
                        <a class="uk-alert-close" uk-close></a>
                        <p>Произошла ошибка в SQL запросе</p>
                    </div>';
                }
            } else {
                $result = mysqli_query($connection, "UPDATE servers SET id = " . $_POST['id'] . ", name = '" . $name . "', ip = '" . $ip . "', port = '" . $port . "', password = '" . $password . "', status = " . $status . " WHERE id = " . $_POST['old_id']);
                if($result) {
                    echo '<div class="uk-alert-success" uk-alert>
                        <a class="uk-alert-close" uk-close></a>
                        <p>Сервер успешно редактирован!</p>
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
?>

<p class="uk-flex uk-flex-right uk-margin-medium-bottom">
    <a href="/admin/server/add" class="uk-button uk-button-secondary">Добавить сервер</a>
</p>

<table class="uk-table uk-table-hover uk-table-striped" style="background-color: white; border-radius: 10px;">
    <thead>
        <tr>
            <th>ID</th>
            <th>Название</th>
            <th>Айпи</th>
            <th>Порт</th>
            <th>Пароль</th>
            <th>Статус</th>
            <th>Действия</th>
        </tr>
    </thead>
    <tbody>
        <?php
            $result = mysqli_query($connection, "SELECT * FROM servers");

            while($row = mysqli_fetch_assoc($result)) {
        ?>
        <tr>
            <td><? echo $row['id']; ?></td>
            <td><? echo $row['name']; ?></td>
            <td><? echo $row['ip']; ?></td>
            <td><? echo $row['port']; ?></td>
            <td><? echo $row['password']; ?></td>
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
                <a href="/admin/server/edit/<? echo $row['id']; ?>" class="uk-padding-small uk-badge uk-label-warning uk-margin-small-right"><span class="ion-edit"></span></a>
                <a uk-tooltip="Бывают ошибки из-за того, что имеется продукты с этим идентификатором" href="/admin/server/del/<? echo $row['id']; ?>" class="uk-padding-small uk-badge uk-label-danger"><span class="ion-trash-b"></span></a>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>