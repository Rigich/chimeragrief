<div class="uk-container uk-container-xsmall">
    <div class="uk-card uk-card-primary uk-card-body uk-flex uk-flex-between uk-flex-middle uk-margin-bottom">
        <h4 class="uk-card-title">Статус модули: </h4>
        <?php
            $result = mysqli_query($connection, "SELECT value FROM lastbuys WHERE setting = 'status'");
            $row = mysqli_fetch_assoc($result);

            if($row['value'] == 'enabled') {
                echo '<a id="status-bans" class="uk-button uk-button-secondary" href="/admin/lastbuys/toggle">Выключить</a>';
            } else if($row['value'] == 'disabled') {
                echo '<a id="status-bans" class="uk-button uk-button-danger" href="/admin/lastbuys/toggle">Включить</a>';
            }
        ?>
    </div>
</div>