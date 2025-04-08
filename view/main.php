<section class="about">
    <div class="container">
        <div class="about__column">
            <div class="about__title">
                <?php
                    $result = mysqli_query($connection, "SELECT value FROM settings WHERE setting = 'name'");
                    $row = mysqli_fetch_assoc($result);
                ?>
                <h2 class="about__title-name"><?= $row['value'] ?></h2>
                <?php
                    $result = mysqli_query($connection, "SELECT value FROM settings WHERE setting = 'description'");
                    $row = mysqli_fetch_assoc($result);
                ?>
                <p class="about__title-tagline"><?= $row['value'] ?></p>
            </div>
            <div class="about__description">
                <?php
                    $result = mysqli_query($connection, "SELECT value FROM settings WHERE setting = 'full_description'");
                    $row = mysqli_fetch_assoc($result);
                ?>
                <p class="about__description-text"><?= $row['value'] ?></p>
            </div>
            <div class="about__buttons">
                <?php
                    $result = mysqli_query($connection, "SELECT value FROM settings WHERE setting = 'btn_play'");
                    $row = mysqli_fetch_assoc($result);

                    if($row['value'] == 'enabled') {
                ?>
                <a class="buttonstyle-default about__button-play btn-popup" href="/howplay">
                    <div class="button-icon">
                        <img src="/resources/images/minecraft/netherite_sword.png">
                    </div>
                    Играть
                </a>
                <?php
                    }

                    $result = mysqli_query($connection, "SELECT value FROM settings WHERE setting = 'btn_donate'");
                    $row = mysqli_fetch_assoc($result);

                    if($row['value'] == 'enabled') {
                ?>
                <buttton class="buttonstyle-default buttonstyle-purplecolor about__button-donate">
                    <div class="button-icon">
                        <img src="/resources/images/minecraft/gold_nugget.png">
                    </div>
                    Донат
                </buttton>
                <?php
                    }
                ?>
            </div>
        </div>
        <div class="about__column">
            <?php
                $result = mysqli_query($connection, "SELECT value FROM settings WHERE setting = 'book_image'");
                $row = mysqli_fetch_assoc($result);
            ?>
            <div class="about__book" style="background-image: url('/resources/images/<? echo $row['value']; ?>');">
                <?php
                    $result = mysqli_query($connection, "SELECT value FROM settings WHERE setting = 'book'");
                    $row = mysqli_fetch_assoc($result);
                ?>
                <div class="about__text"><?= str_replace(array("\r\n", "\n\r", "\n"), "<br>", $row['value']) ?></div>
                <?php
                    $result = mysqli_query($connection, "SELECT value FROM settings WHERE setting = 'online_toogle'");
                    $row = mysqli_fetch_assoc($result);

                    if($row['value'] == 'enabled') {
                ?>
                <div class="about__online">
                    <div class="about__online-dots">
                        <div class="about__online-dot"></div>
                        <div class="about__online-dot"></div>
                        <div class="about__online-dot"></div>
                    </div>

                    <div class="about__online-text">Онлайн: <span class="about__online-value">?</span></div>
                </div>
                <?php
                    }
                ?>
            </div>
        </div>
    </div>
</section>
<section class="donate container">
    <div class="donate__title">
        <h3 class="titlestyle-default donate__title-text">Покупка товара</h3>
    </div>
    <div class="donate__control">
        <div class="titlestyle-donate donate__subtitle">
            <img src="/resources/images/minecraft/firework_rocket.png" class="titlestyle-donateicon">
            <?php 
                $result = mysqli_query($connection, "SELECT * FROM categories WHERE status = 1");
                if(mysqli_num_rows($result)) {
                    echo '<h6 class="titlestyle-donatetext donate__info">Выберите категорию:</h6>';
                } else {
                    echo '<h6 class="titlestyle-donatetext donate__info">Не найдены категории товаров</h6>';
                }
            ?>
        </div>
        <buttton class="buttonstyle-default buttonstyle-back donate__control-back hide">
            <div class="button-icon">
                <img src="/resources/images/minecraft/back.png">
            </div>
            Вернуться назад
        </buttton>
    </div>
    <div class="donate__cards">
        <?php 
            while($row = mysqli_fetch_assoc($result)) {
                echo 
                '<div class="donate__item" category-id="' . $row['id'] . '">
                    <img src="/resources/images/category/' . $row['background'] . '" class="donate__item-background">
                    <div class="donate__item-name">' . $row['name'] . '</div>
                </div>';
            }
        ?>
    </div>
    <form class="donate__form hide" action="/pay" method="POST">
        <div class="donate__form-info">
            <div class="donate__item donate__item-product donate__item-form" name="test">
                <img id="form-image" src="/resources/images/product/1.png" class="donate__item-background">
                <div id="form-name" class="donate__item-name"></div>
                <div id="form-price" class="donate__item-price"></div>
            </div>
            <div id="form-description" class="donate__form-text">
                
            </div>
        </div>
        

        <div class="donate__form-pay">
            <div class="donate__form-user">
                <input type="hidden" id="form-product" name="product" value="">
                <div class="donate__form-text">Ваш никнейм:</div>
                <input id="form-user" name="nickname" type="text" class="donate__form-input">
                <div class="donate__form-text">Промокод:</div>
                <input id="form-promo" name="promocode" type="text" class="donate__form-input">
                <div class="donate__form-amount">
                    <div class="donate__form-text">Количество:</div>
                    <input id="form-amount" name="amount" type="number" class="donate__form-input" value="1">
                </div>
            </div>
            <div class="donate__form-ways">
                <div class="donate__form-text">Выберите способ оплаты:</div>
                <div class="donate__ways-box">
                    <?php
                        $result = mysqli_query($connection, "SELECT setting, value FROM payments WHERE setting LIKE '%status'");

                        $i = 1;
                        while($row = mysqli_fetch_assoc($result)) {
                            if($row['value'] == "disabled") continue;
                            $payment_name = preg_replace('/_status$/', '', $row['setting']);
                    ?>
                            <div class="donate__form-way">
                                <input type="radio" name="payment" class="donate__form-check" id="payments<?= $i ?>" value="<?= $payment_name ?>" <?= $i == 1 ? "checked" : "" ?>>
                                <label for="payments<?= $i ?>">
                                    <img src="/resources/images/payments/<?= $payment_name ?>.png">
                                </label>
                            </div>
                    <?php
                            $i++;
                        }
                    ?>
                </div>
            </div>
        </div>

        <div class="donate__form-buttons">
            <buttton class="buttonstyle-default buttonstyle-back donate__form-back hide">
                <div class="button-icon">
                    <img src="/resources/images/minecraft/back.png">
                </div>
                Вернуться назад
            </buttton>
            <button class="donate__form-button">
                <div class="donate__form-btntext">Продолжить</div>
                <div class="donate__form-price">К оплате <span class="donate__form-pricevalue">0P</span></div>
                <img src="/resources/images/minecraft/arrow.png" class="donate__form-btnimage">
            </button>
        </div>
    </form>
</section>
<?php
$result = mysqli_query($connection, "SELECT value FROM lastbuys WHERE setting = 'status'");
$row = mysqli_fetch_assoc($result);

if($row['value'] == 'enabled') {
?>
        <div class="last__title">
            <h3 class="titlestyle-default last__title-text">Последние покупки</h3>
        </div>
        <?php
        $result = mysqli_query($connection, "SELECT nickname, product, date FROM orders ORDER BY id DESC LIMIT 5");
        
        if(mysqli_num_rows($result) == 0) {
        ?>
            <h3 class="titlestyle-default last__title-notbuys">Покупок нету :(</h3>
        <?php
        } else {
        ?>
        <div class="last__cards">
            <?php
                while($row = mysqli_fetch_assoc($result)) {
                    $result2 = mysqli_query($connection, "SELECT background FROM products WHERE id = " . $row['product']);
                    $product = mysqli_fetch_assoc($result2);
            ?>
                <div class="last__item">
                    <div class="last__item-image">
                        <img src="/resources/images/product/<?= $product['background'] ?>">
                    </div>
                    <div class="last__item-name"><?= $row['nickname'] ?></div>
                    <div class="last__item-date"><?= $row['date'] ?></div>
                </div>
            <?php
            }
            ?>
        </div>
        <?php
        }
        ?>
<?php
}
?>

<script>
    const lOl = document.getElementById("form-user");
    lOl.addEventListener('input', () => {
        lOl.value = lOl.value.replace(' ', '');
    });
</script>