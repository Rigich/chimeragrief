<?php
    if(!empty($_POST)) {

        if(empty($_POST['promocode']) || empty($_POST['discount']) || empty($_POST['amount']) || empty($_POST['status'])) {
            echo '<div class="uk-alert-danger" uk-alert>
                <a class="uk-alert-close" uk-close></a>
                <p>Произошла ошибка, возможно не заполнены все поля.</p>
            </div>';
        } else {
            $promocode = $_POST['promocode'];
            $discount = $_POST['discount'];
            $amount = $_POST['amount'];;
            $status = $_POST['status'] == "on" ? 'true' : 'false';

            if(empty($_POST['old_id']) && empty($_POST['id'])) {
                $result = mysqli_query($connection, "INSERT INTO promocodes (promocode, discount, amount, status) VALUES ('" . $promocode . "', " . $discount . ", " . $amount . ", " . $status . ")");
                if($result) {
                    echo '<div class="uk-alert-success" uk-alert>
                        <a class="uk-alert-close" uk-close></a>
                        <p>Промокод успешно добавлен!</p>
                    </div>';
                } else {
                    echo '<div class="uk-alert-danger" uk-alert>
                        <a class="uk-alert-close" uk-close></a>
                        <p>Произошла ошибка в SQL запросе</p>
                    </div>';
                }
            } else {
                $result = mysqli_query($connection, "UPDATE promocodes SET id = " . $_POST['id'] . ", promocode = '" . $promocode . "', discount = " . $discount . ", amount = " . $amount . ", status = " . $status . " WHERE id = " . $_POST['old_id']);
                if($result) {
                    echo '<div class="uk-alert-success" uk-alert>
                        <a class="uk-alert-close" uk-close></a>
                        <p>Промокод успешно редактирован!</p>
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
    <a href="/admin/promocode/add" class="uk-button uk-button-secondary">Добавить промокод</a>
</p>

<table class="uk-table uk-table-hover uk-table-striped" style="background-color: white; border-radius: 10px;">
    <thead>
        <tr>
            <th>ID</th>
            <th>Промокод</th>
            <th>Скидка</th>
            <th>Количество</th>
            <th>Статус</th>
            <th>Действия</th>
        </tr>
    </thead>
    <tbody>
        <?php
            $result = mysqli_query($connection, "SELECT * FROM promocodes");

            while($row = mysqli_fetch_assoc($result)) {
        ?>
        <tr>
            <td><? echo $row['id']; ?></td>
            <td><? echo $row['promocode']; ?></td>
            <td><? echo $row['discount']; ?></td>
            <td><? echo $row['amount']; ?></td>
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
                <a href="/admin/promocode/edit/<? echo $row['id']; ?>" class="uk-padding-small uk-badge uk-label-warning uk-margin-small-right"><span class="ion-edit"></span></a>
                <a href="/admin/promocode/del/<? echo $row['id']; ?>" class="uk-padding-small uk-badge uk-label-danger"><span class="ion-trash-b"></span></a>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>