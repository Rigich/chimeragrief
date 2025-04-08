<section class="steps">
    <div class="container">
        <ul class="step__list">
            <li class="step__item">
                <div class="step__number">1<br>ШАГ</div>
                <h4 class="step__title">Скачайте лаунчер, например - TLauncher</h4>
                <img class="step__image" src="/resources/images/howplay/step1.png">
            </li>
            <li class="step__item">
                <div class="step__number">2<br>ШАГ</div>
                <?php
                    $result = mysqli_query($connection, "SELECT value FROM settings WHERE setting = 'ip'");
                    $row = mysqli_fetch_assoc($result);
                ?>
                <h4 class="step__title">Скопируйте наш IP: <span class="badge-blue"><? echo $row['value']; ?></span> и добавьте в список серверов!</h4>
                <img class="step__image" src="/resources/images/howplay/step2.png">
            </li>
            <li class="step__item">
                <div class="step__number">3<br>ШАГ</div>
                <h4 class="step__title">Нажмите на кнопку <span class="badge-blue">Подключиться</span> и играйте на нашем сервере!</h4>
                <img class="step__image" src="/resources/images/howplay/step3.jpg">
            </li>
        </ul>
    </div>
</section>