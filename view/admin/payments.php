<div class="uk-container uk-container-small">
    <ul class="uk-tab" data-uk-tab="{connect:'#my-id'}">
        <li><a href="">QIWI</a></li>
        <li><a href="">YooMoney</a></li>
        <li><a href="">FreeKassa</a></li>
        <li><a href="">Enot</a></li>
        <li><a href="">AnyPay</a></li>
    </ul>
    <ul id="my-id" class="uk-switcher uk-margin">
        <!-- QIWI -->
        <li>
            <div class="uk-card uk-card-primary uk-card-body uk-flex uk-flex-between uk-flex-middle uk-margin-bottom">
                <h4 class="uk-card-title">Статус платёжника: </h4>
                <?php
                    $result = mysqli_query($connection, "SELECT value FROM payments WHERE setting = 'qiwi_status'");
                    $row = mysqli_fetch_assoc($result);

                    if($row['value'] == 'enabled') {
                        echo '<a id="status-bans" class="uk-button uk-button-secondary" href="/admin/payments/qiwitoggle">Выключить</a>';
                    } else if($row['value'] == 'disabled') {
                        echo '<a id="status-bans" class="uk-button uk-button-danger" href="/admin/payments/qiwitoggle">Включить</a>';
                    }
                ?>
            </div>
            <div class="uk-card uk-card-secondary uk-card-body">
                <h4 class="uk-card-title">Настройка платёжника</h4>

                <?php
                    $result = mysqli_query($connection, "SELECT value FROM payments WHERE setting LIKE 'qiwi%'");
                ?>
                <form action="/admin/payments/qiwi" method="POST">
                    <fieldset class="uk-fieldset">
                        <div class="uk-margin">
                            <label for="">Публичный ключ</label>
                            <?php
                                $row = mysqli_fetch_assoc($result);
                                echo '<input name="public" class="uk-input" type="text" placeholder="Публичный ключ" value="' . $row['value'] . '">';
                            ?>
                            
                        </div>
                        <div class="uk-margin">
                            <label for="">Секретный ключ</label>
                            <?php
                                $row = mysqli_fetch_assoc($result);
                                echo '<input name="secret" class="uk-input" type="text" placeholder="Секретный ключ" value="' . $row['value'] . '">';
                            ?>
                        </div>

                        <button class="uk-button uk-button-primary uk-width-1-1">Сохранить</button>
                    </fieldset>
                </form>
            </div>
        </li>
        <!-- YOOMONEY -->
        <li>
            <div class="uk-card uk-card-primary uk-card-body uk-flex uk-flex-between uk-flex-middle uk-margin-bottom">
                <h4 class="uk-card-title">Статус платёжника: </h4>
                <?php
                    $result = mysqli_query($connection, "SELECT value FROM payments WHERE setting = 'yoomoney_status'");
                    $row = mysqli_fetch_assoc($result);

                    if($row['value'] == 'enabled') {
                        echo '<a id="status-bans" class="uk-button uk-button-secondary" href="/admin/payments/yoomoneytoggle">Выключить</a>';
                    } else if($row['value'] == 'disabled') {
                        echo '<a id="status-bans" class="uk-button uk-button-danger" href="/admin/payments/yoomoneytoggle">Включить</a>';
                    }
                ?>
            </div>
            <div class="uk-card uk-card-secondary uk-card-body">
                <h4 class="uk-card-title">Настройка платёжника</h4>

                <?php
                    $result = mysqli_query($connection, "SELECT value FROM payments WHERE setting LIKE 'yoomoney%'");
                ?>
                <form action="/admin/payments/yoomoney" method="POST">
                    <fieldset class="uk-fieldset">
                        <div class="uk-margin">
                            <label for="">Идентификатор кошелька</label>
                            <?php
                                $row = mysqli_fetch_assoc($result);
                                echo '<input name="id" class="uk-input" type="text" placeholder="Идентификатор кошелька" value="' . $row['value'] . '">';
                            ?>
                            
                        </div>
                        <div class="uk-margin">
                            <label for="">Секретный ключ</label>
                            <?php
                                $row = mysqli_fetch_assoc($result);
                                echo '<input name="secret" class="uk-input" type="text" placeholder="Секретный ключ" value="' . $row['value'] . '">';
                            ?>
                        </div>

                        <button class="uk-button uk-button-primary uk-width-1-1">Сохранить</button>
                    </fieldset>
                </form>
            </div>
        </li>
        <!-- FREEKASSA -->
        <li>
            <div class="uk-card uk-card-primary uk-card-body uk-flex uk-flex-between uk-flex-middle uk-margin-bottom">
                <h4 class="uk-card-title">Статус платёжника: </h4>
                <?php
                    $result = mysqli_query($connection, "SELECT value FROM payments WHERE setting = 'freekassa_status'");
                    $row = mysqli_fetch_assoc($result);

                    if($row['value'] == 'enabled') {
                        echo '<a id="status-bans" class="uk-button uk-button-secondary" href="/admin/payments/freekassatoggle">Выключить</a>';
                    } else if($row['value'] == 'disabled') {
                        echo '<a id="status-bans" class="uk-button uk-button-danger" href="/admin/payments/freekassatoggle">Включить</a>';
                    }
                ?>
            </div>
            <div class="uk-card uk-card-secondary uk-card-body">
                <h4 class="uk-card-title">Настройка платёжника</h4>

                <?php
                    $result = mysqli_query($connection, "SELECT value FROM payments WHERE setting LIKE 'freekassa%'");
                ?>
                <form action="/admin/payments/freekassa" method="POST">
                    <fieldset class="uk-fieldset">
                        <div class="uk-margin">
                            <label for="">Идентификатор кошелька</label>
                            <?php
                                $row = mysqli_fetch_assoc($result);
                                echo '<input name="id" class="uk-input" type="text" placeholder="Идентификатор магазина" value="' . $row['value'] . '">';
                            ?>
                        </div>
                        <div class="uk-margin">
                            <label for="">Секретный ключ #1</label>
                            <?php
                                $row = mysqli_fetch_assoc($result);
                                echo '<input name="secret1" class="uk-input" type="text" placeholder="Секретный ключ #1" value="' . $row['value'] . '">';
                            ?>
                        </div>
                        <div class="uk-margin">
                            <label for="">Секретный ключ #2</label>
                            <?php
                                $row = mysqli_fetch_assoc($result);
                                echo '<input name="secret2" class="uk-input" type="text" placeholder="Секретный ключ #2" value="' . $row['value'] . '">';
                            ?>
                        </div>

                        <button class="uk-button uk-button-primary uk-width-1-1">Сохранить</button>
                    </fieldset>
                </form>
            </div>
        </li>
        <!-- ENOT -->
        <li>
            <div class="uk-card uk-card-primary uk-card-body uk-flex uk-flex-between uk-flex-middle uk-margin-bottom">
                <h4 class="uk-card-title">Статус платёжника: </h4>
                <?php
                    $result = mysqli_query($connection, "SELECT value FROM payments WHERE setting = 'enot_status'");
                    $row = mysqli_fetch_assoc($result);

                    if($row['value'] == 'enabled') {
                        echo '<a id="status-bans" class="uk-button uk-button-secondary" href="/admin/payments/enottoggle">Выключить</a>';
                    } else if($row['value'] == 'disabled') {
                        echo '<a id="status-bans" class="uk-button uk-button-danger" href="/admin/payments/enottoggle">Включить</a>';
                    }
                ?>
            </div>
            <div class="uk-card uk-card-secondary uk-card-body">
                <h4 class="uk-card-title">Настройка платёжника</h4>

                <?php
                    $result = mysqli_query($connection, "SELECT value FROM payments WHERE setting LIKE 'enot%'");
                ?>
                <form action="/admin/payments/enot" method="POST">
                    <fieldset class="uk-fieldset">
                        <div class="uk-margin">
                            <label for="">Идентификатор кошелька</label>
                            <?php
                                $row = mysqli_fetch_assoc($result);
                                echo '<input name="id" class="uk-input" type="text" placeholder="Идентификатор магазина" value="' . $row['value'] . '">';
                            ?>
                        </div>
                        <div class="uk-margin">
                            <label for="">Секретный ключ #1</label>
                            <?php
                                $row = mysqli_fetch_assoc($result);
                                echo '<input name="secret1" class="uk-input" type="text" placeholder="Секретный ключ #1" value="' . $row['value'] . '">';
                            ?>
                        </div>
                        <div class="uk-margin">
                            <label for="">Секретный ключ #2</label>
                            <?php
                                $row = mysqli_fetch_assoc($result);
                                echo '<input name="secret2" class="uk-input" type="text" placeholder="Секретный ключ #2" value="' . $row['value'] . '">';
                            ?>
                        </div>

                        <button class="uk-button uk-button-primary uk-width-1-1">Сохранить</button>
                    </fieldset>
                </form>
            </div>
        </li>
        <!-- ANYPAY -->
        <li>
            <div class="uk-card uk-card-primary uk-card-body uk-flex uk-flex-between uk-flex-middle uk-margin-bottom">
                <h4 class="uk-card-title">Статус платёжника: </h4>
                <?php
                    $result = mysqli_query($connection, "SELECT value FROM payments WHERE setting = 'anypay_status'");
                    $row = mysqli_fetch_assoc($result);

                    if($row['value'] == 'enabled') {
                        echo '<a id="status-bans" class="uk-button uk-button-secondary" href="/admin/payments/anypaytoggle">Выключить</a>';
                    } else if($row['value'] == 'disabled') {
                        echo '<a id="status-bans" class="uk-button uk-button-danger" href="/admin/payments/anypaytoggle">Включить</a>';
                    }
                ?>
            </div>
            <div class="uk-card uk-card-secondary uk-card-body">
                <h4 class="uk-card-title">Настройка платёжника</h4>

                <?php
                    $result = mysqli_query($connection, "SELECT value FROM payments WHERE setting LIKE 'anypay%'");
                ?>
                <form action="/admin/payments/anypay" method="POST">
                    <fieldset class="uk-fieldset">
                        <div class="uk-margin">
                            <label for="">Идентификатор кошелька</label>
                            <?php
                                $row = mysqli_fetch_assoc($result);
                                echo '<input name="id" class="uk-input" type="text" placeholder="Идентификатор магазина" value="' . $row['value'] . '">';
                            ?>
                        </div>
                        <div class="uk-margin">
                            <label for="">Секретный ключ</label>
                            <?php
                                $row = mysqli_fetch_assoc($result);
                                echo '<input name="secret" class="uk-input" type="text" placeholder="Секретный ключ" value="' . $row['value'] . '">';
                            ?>
                        </div>

                        <button class="uk-button uk-button-primary uk-width-1-1">Сохранить</button>
                    </fieldset>
                </form>
            </div>
        </li>
    </ul>
</div>