<?php
    $check_uri = preg_replace('/^check\//', '', $uri);

    function give($nickname, $price, $product, $amount, $promocode, $payment) {
        global $connection;

        $stmt = $connection->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->bind_param("i", $product);
        $stmt->execute();
        $result = $stmt->get_result();
        $prod = mysqli_fetch_assoc($result);

        if($prod == null) {
            mysqli_query($connection, "INSERT INTO logs (type, title, message) VALUES ('error', 'Ошибка платёжа игрока " . $nickname . "', 'Игрок " . $nickname . " попытался купить продукт, а система не нашёл его - " . $product . ". Дата - " . date("Y-m-d H:i:s") . ", Платёжная система - " . $payment . "')");
            exit('Ошибка платёжа');
        }
        
        $promoDiscount = 0;
        if($promocode != 'empty') {
            $stmt = $connection->prepare("SELECT * FROM promocodes WHERE promocode = ?");
            $stmt->bind_param("s", $promocode);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = mysqli_fetch_assoc($result);

            if($row != null) {
                $promoDiscount = $row['discount'];
                mysqli_query($connection, "UPDATE promocodes SET amount = " . (--$row['amount']) . " WHERE promocode = '" . $row['promocode'] . "'");
            }
        }

        $realPrice = $prod['price']; 
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
                if($oproduct_row['category_id'] != $prod['category_id']) continue;

                $category_result = mysqli_query($connection, "SELECT supplement FROM categories WHERE id = " . (int) $oproduct_row['category_id']);
                $category_row = mysqli_fetch_assoc($category_result);
                
                if($category_row && $category_row['supplement']) {
                    if($prod['price'] > $oproduct_row['price']) {
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
                $realPrice = $realPrice - $discount;
            } else {
                mysqli_query($connection, "INSERT INTO logs (type, title, message) VALUES ('error', 'Ошибка выдачи продукта игрока " . $nickname . "', 'Игрок " . $nickname . " попытался купить продукт " . $prod['displayname'] . " (" . $product . "), но он уже купил данный продукт. Дата - " . date("Y-m-d H:i:s") . ", Платёжная система - " . $payment . "')");
                exit('Ошибка платёжа');
            }
        }
        // test - end

        $realPrice = ($realPrice * $amount) - ($realPrice * $amount) * ($prod['discount']/100);
        $realPrice = (float) $realPrice - $realPrice * ($promoDiscount/100);

        if($price !== $realPrice) {
            mysqli_query($connection, "INSERT INTO logs (type, title, message) VALUES ('error', 'Ошибка платёжа игрока " . $nickname . "', 'Игрок " . $nickname . " попытался купить продукт " . $prod['displayname'] . " (" . $product . "), но не совпалось цены от системы платёжника (" . $price . ") и от нашей системы (" . $realPrice . "). Возможно, игрок попытался взломать систему или вы изменили/удалили цену, скидку продукта или скидку промокода. Количество - " . $amount . ". Дата - " . date("Y-m-d H:i:s") . ", Платёжная система - " . $payment . "')");
            exit('Ошибка платёжа');
        }

        $servers = explode(',', $prod['servers']);

        if(!is_array($servers) || empty($servers)) {
            mysqli_query($connection, "INSERT INTO logs (type, title, message) VALUES ('error', 'Ошибка продукта " . $prod['name'] . "', 'Игрок " . $nickname . " попытался купить продукт " . $prod['displayname'] . " (" . $product . "), но не были найдены сервера продукта. Дата - " . date("Y-m-d H:i:s") . ", Платёжная система - " . $payment . "')");
            exit('Ошибка платёжа');
        }

        require_once 'libs/rcon.class.php';

        //list commands
        $commands = explode("\n", str_replace(array("\r\n", "\n\r"), "\n", $prod['commands']));

        foreach($servers as $server_id) {
            $result = mysqli_query($connection, "SELECT * FROM servers WHERE id = " . $server_id);
            $row = mysqli_fetch_assoc($result);

            if($row == null) {
                mysqli_query($connection, "INSERT INTO logs (type, title, message) VALUES ('error', 'Ошибка продукта " . $prod['name'] . "', 'Игрок " . $nickname . " попытался купить продукт " . $prod['displayname'] . " (" . $product . "), но не был найден сервер (ID: " . $server_id . ") продукта. Дата - " . date("Y-m-d H:i:s") . ", Платёжная система - " . $payment . "')");
                continue;
            }

            $ip = $row['ip'];
            $port = $row['port'];
            $password = $row['password'];

            $count = 5;
            while($count) {
                $rcon = new Rcon($ip, $port, $password, 10);
                if (@$rcon->connect()) {
                    // @$rcon->send_command($cmd);
                    foreach($commands as $command) {
                        $command = str_replace(['%user%', '%name%', '%displayname%', '%amount%'], [$nickname, $prod['name'], $prod['displayname'], $amount], $command);;
                        @$rcon->send_command($command);
                    }
                    $count = 0;
                } else {
                    $count--;
                    if(!$count) {
                        mysqli_query($connection, "INSERT INTO logs (type, title, message) VALUES ('error', 'Ошибка продукта " . $prod['name'] . "', 'Игрок " . $nickname . " попытался купить продукт " . $prod['displayname'] . " (" . $product . "), но сервер " . $row['name'] . " (" . $row['id'] . ") не смог подключиться к RCON. Дата - " . date("Y-m-d H:i:s") . ", Платёжная система - " . $payment . "')");
                        exit('Ошибка платёжа');
                    }
                }
            }
        }
        mysqli_query($connection, "INSERT INTO orders (nickname, product, date, payment, profit) VALUES ('" . $nickname . "', '" . $product . "', '" . date("Y-m-d H:i:s") . "', '" . $payment . "', " . $price . ")");

    }

    if($check_uri == "qiwi") {
        if(strcasecmp($_SERVER['REQUEST_METHOD'], 'POST') !== 0){
            exit('Не над дядя');
        }

        $addr_range1 = range(ip2long('79.142.16.1'), ip2long('79.142.31.254'));
        $addr_range2 = range(ip2long('195.189.100.1'), ip2long('195.189.103.254'));
        $addr_range3 = range(ip2long('91.232.230.1'), ip2long('91.232.231.254'));
        $addr_range4 = range(ip2long('91.213.51.1'), ip2long('91.213.51.254'));

        if(!in_array(ip2long($_SERVER['REMOTE_ADDR']), $addr_range1) && !in_array(ip2long($_SERVER['REMOTE_ADDR']), $addr_range2) && !in_array(ip2long($_SERVER['REMOTE_ADDR']), $addr_range3) && !in_array(ip2long($_SERVER['REMOTE_ADDR']), $addr_range4)) {
            exit("Уйди!");
        }
        
        $result = mysqli_query($connection, "SELECT value FROM payments WHERE setting = 'qiwi_secret'");
        $row = mysqli_fetch_assoc($result);
        $secretKey = $row['value'];

        $sha256_hash_qiwi = $_SERVER['HTTP_X_API_SIGNATURE_SHA256'];
        $content = trim(file_get_contents("php://input"));
        $decoded = json_decode($content, true);

        if(!is_array($decoded)){
            die();
        }

        $amountCurrency = $decoded['bill']['amount']['currency'];
        $amountValue = $decoded['bill']['amount']['value'];
        $billId = $decoded['bill']['billId'];
        $siteId = $decoded['bill']['siteId'];
        $statusValue = $decoded['bill']['status']['value'];

        $invoiceParameters = $amountCurrency . '|' . $amountValue . '|' . $billId . '|' . $siteId . '|' . $statusValue;

        $sha256_hash = hash_hmac('sha256', $invoiceParameters, $secretKey);

        if($sha256_hash_qiwi !== $sha256_hash) {
            exit('Ты далеко зашёл чувак, давай без этого!');
        }

        if($decoded['bill']['status']['value'] !== 'PAID') die();
        
        // Успешный платёж
        $nickname = $decoded['bill']['customer']['account'];
        $price = (float) $decoded['bill']['amount']['value'];
        $product = (int) $decoded['bill']['customFields']['product'];
        $amount = (int) $decoded['bill']['customFields']['amount'];
        $promocode = $decoded['bill']['customFields']['promocode'];

        give($nickname, $price, $product, $amount, $promocode, $check_uri);
    } else if($check_uri == "yoomoney") {

        if($_SERVER['REQUEST_METHOD'] != "POST") {
            exit('Не над дядя');
        }

        $result = mysqli_query($connection, "SELECT value FROM payments WHERE setting = 'yoomoney_secret'");
        $row = mysqli_fetch_assoc($result);
        $secretKey = $row['value'];

        $key = join('&', array(
            $_POST['notification_type'],
            $_POST['operation_id'],
            $_POST['amount'],
            $_POST['currency'],
            $_POST['datetime'],
            $_POST['sender'],
            $_POST['codepro'],
            $secretKey,
            $_POST['label']));
    
        if (sha1($key) != $_POST['sha1_hash'] || $_POST['codepro'] === true || @$_POST['unaccepted'] === true) exit("Ты далеко зашёл чувак, давай без этого!");
    
        $array = explode("-", $_POST['label']);
        
        // Успешный платёж
        $nickname = $array[0];
        $price = (float) $_POST['withdraw_amount'];
        $product = (int) $array[1];
        $amount = (int) $array[2];
        $promocode = $array[3];

        // Проверка прайса
        give($nickname, $price, $product, $amount, $promocode, $check_uri);
    } else if($check_uri == "freekassa") {
        if($_SERVER['REQUEST_METHOD'] != "POST") {
            exit('Не над дядя');
        }

        function getIP() {
            if(isset($_SERVER['HTTP_X_REAL_IP'])) return $_SERVER['HTTP_X_REAL_IP'];
            return $_SERVER['REMOTE_ADDR'];
        }
    
        if(!in_array(getIP(), array('168.119.157.136', '168.119.60.227', '138.201.88.124', '178.154.197.79'))) die("Уйди!");

        $result = mysqli_query($connection, "SELECT value FROM payments WHERE setting = 'freekassa_secret2'");
        $row = mysqli_fetch_assoc($result);
        $secretKey2 = $row['value'];

        $sign = md5($_REQUEST['MERCHANT_ID'].':'.$_REQUEST['AMOUNT'].':'.$secretKey2.':'.$_REQUEST['MERCHANT_ORDER_ID']);

        if($sign != $_REQUEST['SIGN']) die('Ты далеко зашёл чувак, давай без этого!');
        // Успешный платёж
        $nickname = $_REQUEST['MERCHANT_ORDER_ID'];
        $price = (float) $_REQUEST['AMOUNT'];
        $product = (int) $_REQUEST['us_product'];
        $amount = (int) $_REQUEST['us_amount'];
        $promocode = $_REQUEST['us_promocode'];

        // Проверка прайса
        give($nickname, $price, $product, $amount, $promocode, $check_uri);
    } else if($check_uri == "enot") {

        if($_SERVER['REQUEST_METHOD'] != "POST") {
            exit('Не над дядя');
        }

        $result = mysqli_query($connection, "SELECT value FROM payments WHERE setting = 'enot_secret2'");
        $row = mysqli_fetch_assoc($result);
        $secretKey2 = $row['value'];

        $sign = md5($_REQUEST['merchant'].':'.$_REQUEST['amount'].':'.$secretKey2.':'.$_REQUEST['merchant_id']);
        
        if($sign != $_REQUEST['sign_2']) die('Ты далеко зашёл чувак, давай без этого!');

        $array = explode("-", $_POST['merchant_id']);

        // Успешный платёж
        $nickname = $array[0];
        $price = (float) $_REQUEST['amount'];
        $product = (int) $array[1];
        $amount = (int) $array[2];
        $promocode = $array[3];

        // Проверка прайса
        give($nickname, $price, $product, $amount, $promocode, $check_uri);
    } else if($check_uri == "anypay") {

        if($_SERVER['REQUEST_METHOD'] != "POST") {
            exit('Не над дядя');
        }

        function getIP() {
            if(isset($_SERVER['HTTP_X_REAL_IP'])) return $_SERVER['HTTP_X_REAL_IP'];
            return $_SERVER['REMOTE_ADDR'];
        }
    
        if(!in_array(getIP(), array('185.162.128.38', '185.162.128.39', '185.162.128.88'))) die("Уйди!");

        $result = mysqli_query($connection, "SELECT value FROM payments WHERE setting = 'anypay_id'");
        $row = mysqli_fetch_assoc($result);
        $merchant = $row['value'];

        $result = mysqli_query($connection, "SELECT value FROM payments WHERE setting = 'anypay_secret'");
        $row = mysqli_fetch_assoc($result);
        $secretKey = $row['value'];

        $arr_sign = array( 
            $merchant,
            $_REQUEST['amount'],
            $_REQUEST['pay_id'],
            $secretKey
        );
      
        $sign = md5(implode(':', $arr_sign)); 
        
        if($sign != $_REQUEST['sign']) die('Ты далеко зашёл чувак, давай без этого!');

        $array = explode("-", $_REQUEST['label']);

        echo 'OK';

        // Успешный платёж
        $nickname = $array[0];
        $price = (float) $_REQUEST['amount'];
        $product = (int) $array[1];
        $amount = (int) $array[2];
        $promocode = $array[3];

        // Проверка прайса
        give($nickname, $price, $product, $amount, $promocode, $check_uri);
    } else {
        exit('Тебе не стоит тут быть!');
    }
?>