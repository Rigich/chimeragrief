<?php
    if(empty($_POST['product'])) {
        exit('[x] Ошибка! Не указан товар.');
    }
    if(empty($_POST['nickname'])) {
        exit('[x] Ошибка! Не указан никнейм.');
    }
    if(empty($_POST['promocode'])) {
        $promocode = "Промокод не найден";
    } else {
        $promocode = $_POST['promocode'];
    }
    if(empty($_POST['payment'])) {
        exit('[x] Ошибка! Не указан способ оплаты.');
    }
    if(empty($_POST['amount']) || $_POST['amount'] <= 0) {
        $amount = 1;
    } else {
        $amount = $_POST['amount'];
    }

    $id = $_POST['product'];
    $nickname = explode(" ", $_POST['nickname'])[0];
    $payment = $_POST['payment'];

    $stmt = $connection->prepare("SELECT id, price, discount, amounted, category_id FROM products WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    $product = mysqli_fetch_assoc($result);
    if(!$product) {
        exit('Продукт не найден');
    }

    $price = $product['price'];
    // test - start
    $stmt = $connection->prepare("SELECT product FROM orders WHERE nickname = ?");
    $stmt->bind_param("s", $nickname);
    $stmt->execute();
    $order_result = $stmt->get_result();

    $discount = null;
    while($order_row = mysqli_fetch_assoc($order_result)) {
        $oproduct_result = mysqli_query($connection, "SELECT price, category_id FROM products WHERE id = " . (int) $order_row['product']);
        $oproduct_row = mysqli_fetch_assoc($oproduct_result);
        if($oproduct_row) {
            if($oproduct_row['category_id'] != $product['category_id']) continue;

            $category_result = mysqli_query($connection, "SELECT supplement FROM categories WHERE id = " . (int) $oproduct_row['category_id']);
            $category_row = mysqli_fetch_assoc($category_result);
            
            if($category_row && $category_row['supplement']) {
                if($product['price'] > $oproduct_row['price']) {
                    if($oproduct_row['price'] > $discount) {
                        $discount = $oproduct_row['price'];
                    }
                } else {
                    $discount = 0;
                }
            }
        }
    }

    if($discount !== null) {
        if($discount > 0) {
            $price = $price - $discount;
        } else {
            exit('У Вас уже имеется продукт');
        }
    }
    // test - end

    $price = $price * $amount;

    if($product['discount'] != 0) {
        $price = $price - $price * ($product['discount'] / 100);
    }

    if($promocode !== "Промокод не найден") {
        $stmt = $connection->prepare("SELECT promocode, discount, amount FROM promocodes WHERE promocode = ?");
        $stmt->bind_param("s", $promocode);
        $stmt->execute();
        $result = $stmt->get_result();

        $promocode = mysqli_fetch_assoc($result);

        if($promocode && $promocode['amount'] > 0) {
            $price = $price - $price * ($promocode['discount'] / 100);
            $promocode = $promocode['promocode'];
        } else {
            $promocode = "Промокод не найден";
        }
    }

    $result = mysqli_query($connection, "SELECT value FROM settings WHERE setting = 'name' OR setting = 'domain'");
    $row = mysqli_fetch_assoc($result);

    $serverName = $row['value'];
    $comment = 'Покупка на сайте ' . $serverName;
    $row = mysqli_fetch_assoc($result);
    $successUrl = 'https://' . $row['value'];

    if($payment == "qiwi") {
        $result = mysqli_query($connection, "SELECT value FROM payments WHERE setting IN ('qiwi_status', 'qiwi_public') ORDER BY id");
        $row = mysqli_fetch_assoc($result);
        if($row['value'] == "disabled") {
            exit('Платёжная система отключена!');
        }
        $row = mysqli_fetch_assoc($result);
        $publicKey = $row['value'];

        $link = 'https://oplata.qiwi.com/create?publicKey=' . $publicKey . '&amount=' . $price . '&account=' . $nickname  . '&customFields[product]=' . $id . '&customFields[promocode]=' . ($promocode == "Промокод не найден" ? "empty" : $promocode) . '&customFields[amount]=' . $amount . '&comment=' . $comment . '&successUrl=' . $successUrl;
        header('Location: ' . $link);
    } else if($payment == "yoomoney") {
        $result = mysqli_query($connection, "SELECT value FROM payments WHERE setting IN ('yoomoney_status', 'yoomoney_id') ORDER BY id");
        $row = mysqli_fetch_assoc($result);
        if($row['value'] == "disabled") {
            exit('Платёжная система отключена!');
        }
        $row = mysqli_fetch_assoc($result);
        $receiver = $row['value'];

        $label = $nickname . '-' . $id . '-' . $amount . '-' . ($promocode == "Промокод не найден" ? "empty" : $promocode);
        exit('<form id="pay" name="pay" method="POST" action="https://yoomoney.ru/quickpay/confirm.xml">
            <input type="hidden" name="receiver" value="' . $receiver . '">
            <input type="hidden" name="formcomment" value="' . $comment . '">
            <input type="hidden" name="short-dest" value="' . $comment . '">
            <input type="hidden" name="label" value="' . $label . '">
            <input type="hidden" name="quickpay-form" value="shop">
            <input type="hidden" name="targets" value="Платёж игрока ' . $nickname . '">
            <input type="hidden" name="sum" value="' . $price . '">
            <input type="hidden" name="paymentType" value="AC">
            <input type="hidden" name="successURL" value="' . $successUrl . '">
        </form>
        <script type="text/javascript">
            document.getElementById("pay").submit();
        </script>');
    
    } else if($payment == "freekassa") {
        $result = mysqli_query($connection, "SELECT value FROM payments WHERE setting IN ('freekassa_status', 'freekassa_id', 'freekassa_secret1') ORDER BY id");
        $row = mysqli_fetch_assoc($result);
        if($row['value'] == "disabled") {
            exit('Платёжная система отключена!');
        }
        $row = mysqli_fetch_assoc($result);
        $merchant_id = $row['value'];

        $row = mysqli_fetch_assoc($result);
        $secret_word = $row['value'];

        $order_id = $nickname;
        $order_amount = $price;
        $currency = 'RUB';
        $sign = md5($merchant_id.':'.$order_amount.':'.$secret_word.':'.$currency.':'.$order_id);
        $promocode = $promocode == "Промокод не найден" ? "empty" : $promocode;

        $link = 'https://pay.freekassa.ru/?m=' . $merchant_id . '&oa=' . $price . '&currency=RUB&o=' . $nickname . '&s=' . $sign . '&lang=ru&us_product=' . $id . '&us_promocode=' . $promocode . '&us_amount=' . $amount;
        header('Location: ' . $link);
    } else if($payment == "enot") {
        $result = mysqli_query($connection, "SELECT value FROM payments WHERE setting IN ('enot_status', 'enot_id', 'enot_secret1') ORDER BY id");
        $row = mysqli_fetch_assoc($result);
        if($row['value'] == "disabled") {
            exit('Платёжная система отключена!');
        }

        $row = mysqli_fetch_assoc($result);
        $merchant = $row['value'];
        
        $row = mysqli_fetch_assoc($result);
        $secret_word = $row['value'];

        $label = $nickname . '-' . $id . '-' . $amount . '-' . ($promocode == "Промокод не найден" ? "empty" : $promocode);
        $sign = md5($merchant.':'.$price.':'.$secret_word.':'.$label);

        exit('<form id="pay" name="pay" method="post" action="https://enot.io/pay">
            <input type="hidden" name="m" value="' . $merchant . '">
            <input type="hidden" name="oa" value="' . $price . '">
            <input type="hidden" name="o" value="' . $label . '">
            <input type="hidden" name="s" value="' . $sign . '">
        </form>
        <script type="text/javascript">
            document.getElementById("pay").submit();
        </script>');
    } else if($payment == "anypay") {
        $result = mysqli_query($connection, "SELECT value FROM payments WHERE setting IN ('anypay_status', 'anypay_id', 'anypay_secret') ORDER BY id");
        $row = mysqli_fetch_assoc($result);
        if($row['value'] == "disabled") {
            exit('Платёжная система отключена!');
        }

        $row = mysqli_fetch_assoc($result);
        $merchant = $row['value'];
        
        $row = mysqli_fetch_assoc($result);
        $secret_word = $row['value'];

        $pay_id = rand(1000, 1000000);

        $arr_sign = array( 
            'RUB',
            $price, 
            $secret_word,
            $merchant,
            $pay_id
        );
      
        $sign = md5(implode(':', $arr_sign)); 

        $label = $nickname . '-' . $id . '-' . $amount . '-' . ($promocode == "Промокод не найден" ? "empty" : $promocode); //

        exit('<form id="pay" action="https://anypay.io/merchant" accept-charset="utf-8" method="post">
            <input type="hidden" name="merchant_id" value="' . $merchant . '">
            <input type="hidden" name="amount" value="' . $price . '">
            <input type="hidden" name="pay_id" value="' . $pay_id . '">
            <input type="hidden" name="sign" value="' . $sign . '">
            <input type="hidden" name="label" value="' . $label . '">
        </form>
        <script type="text/javascript">
            document.getElementById("pay").submit();
        </script>');
    } else {
        echo 'Такая система оплаты у нас не существует( Возможно скоро добавим.';
    }
?>