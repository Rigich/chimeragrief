<div uk-grid class="uk-child-width-1-1@s uk-child-width-1-2@m uk-child-width-1-4@xl uk-margin-large-bottom">
    <div>
        <div class="uk-card uk-card-default uk-card-body">
            <span class="statistics-text">Кол-во покупок</span><br />
            <span class="statistics-number">
                <?php
                    $result = mysqli_query($connection, "SELECT COUNT(*) AS count FROM orders");
                    $row = mysqli_fetch_assoc($result);
                    echo $row['count'];
                ?>
                <!-- <span class="uk-label uk-label-success">
                    8% <span class="ion-arrow-up-c"></span>
                </span> -->
            </span>
        </div>
    </div>
    <div>
        <div class="uk-card uk-card-default uk-card-body">
            <span class="statistics-text">Кол-во логов</span><br />
            <span class="statistics-number">
                <?php
                    $result = mysqli_query($connection, "SELECT COUNT(*) AS count FROM logs");
                    $row = mysqli_fetch_assoc($result);
                    echo $row['count'];
                ?>
                <!-- <span class="uk-label uk-label-danger">
                    13% <span class="ion-arrow-down-c"></span>
                </span> -->
            </span>
        </div>
    </div>
    <div>
        <div class="uk-card uk-card-default uk-card-body">
            <span class="statistics-text">Общий прибыль</span><br />
            <span class="statistics-number">
                <?php
                    $result = mysqli_query($connection, "SELECT SUM(profit) as profit FROM orders");
                    $row = mysqli_fetch_assoc($result);
                    echo $row['profit'] . '₽';
                ?>
                <!-- <span class="uk-label uk-label-success">
                    37% <span class="ion-arrow-up-c"></span>
                </span> -->
            </span>
        </div>
    </div>
    <div>
        <div class="uk-card uk-card-default uk-card-body">
            <span class="statistics-text">Кол-во промокодов</span><br />
            <span class="statistics-number">
                <?php
                    $result = mysqli_query($connection, "SELECT COUNT(*) AS count FROM promocodes");
                    $row = mysqli_fetch_assoc($result);
                    echo $row['count'];
                ?>
                <!-- <span class="uk-label uk-label-success">
                    26% <span class="ion-arrow-up-c"></span>
                </span> -->
            </span>
        </div>
    </div>
</div>
<div class="uk-flex uk-flex-column uk-margin-large-bottom">
    <h4 class="uk-card-title">Список последних (30) покупок</h4>
    <table class="uk-table uk-table-hover uk-table-striped" style="background-color: white; border-radius: 10px;">
        <thead>
            <tr>
                <th>ID</th>
                <th>Ник</th>
                <th>Продукт</th>
                <th>Прибыль</th>
                <th>Дата</th>
                <th>Способ оплаты</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $result = mysqli_query($connection, "SELECT * FROM orders ORDER BY id DESC LIMIT 30");

                while($row = mysqli_fetch_assoc($result)) {
            ?>
            <tr>
                <td><? echo $row['id']; ?></td>
                <td><? echo $row['nickname']; ?></td>
                <td><? echo $row['product']; ?></td>
                <td><span class="uk-label uk-label-success"><? echo $row['profit']; ?><span class="ion-arrow-up-c"></span></span></td>
                <td><? echo $row['date']; ?></td>
                <td><span class="uk-badge uk-label-primary uk-padding-small"><? echo $row['payment']; ?></span></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
<div class="uk-flex uk-flex-column uk-margin-large-bottom">
    <h4 class="uk-card-title">Список последних (30) логов</h4>
    <table class="uk-table uk-table-hover uk-table-striped" style="background-color: white; border-radius: 10px;">
        <thead>
            <tr>
                <th>ID</th>
                <th>Тип</th>
                <th>Название</th>
                <th>Сообщение</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $result = mysqli_query($connection, "SELECT * FROM logs ORDER BY id DESC LIMIT 30");

                while($row = mysqli_fetch_assoc($result)) {
            ?>
            <tr>
                <td><? echo $row['id']; ?></td>
                <td><span class="uk-badge uk-label-primary uk-padding-small"><? echo $row['type']; ?></span></td>
                <td><? echo $row['title']; ?></td>
                <td><? echo $row['message']; ?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>