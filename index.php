<?php
    // error_reporting(E_ALL);
	// ini_set('display_errors', 'on');

    $config = require_once 'config.php';

    require_once 'system/database.php';

    $uri = trim($_SERVER['REQUEST_URI'], '/');

    $styles = [];
    $scripts = [];

    $result = mysqli_query($connection, "SELECT value FROM settings WHERE setting = 'name'");
    $row = mysqli_fetch_assoc($result);
    $name = $row['value'];

    if(!$uri) {
        $title = $name . ' - Главная';
        $content = 'view/main.php';
        $styles = [
            'main',
        ];
        $scripts = [
            'axios.min',
            'main'
        ];
        require_once 'view/layouts/default.php';
    } else {
        switch($uri) {
            case "rules":
                $title = $name . ' - Правила';
                $content = 'view/rules.php';
                $styles = [
                    'rules',
                ];
                $scripts = [
                    'rules',
                ];
                require_once 'view/layouts/default.php';
                break;
            case "howplay":
                $title = $name . ' - Как начать играть?';
                $content = 'view/howplay.php';
                $styles = [
                    'howplay',
                ];
                require_once 'view/layouts/default.php';
                break;
            case "pay":
                if(empty($_POST)){
                    echo '[/] Ошибка [\]';
                    break;
                }
                require_once 'system/payment.php';
                break;
            case "online":
                require_once 'system/online.php';
                break;
            default:
                if(preg_match('#^data#', $uri)) {
                    require_once 'system/data.php';
                } else if(preg_match('#^admin#', $uri)) {
                    require_once 'system/admin.php';
                } else if(preg_match('#^check#', $uri)) {
                    require_once 'system/check.php';
                } else {
                    http_response_code(404);
                    $title = $name . ' - 404';
                    $content = 'view/404.php';
                    $styles = [
                        '404',
                    ];
                    require_once 'view/layouts/default.php';
                }
                break;
        }
    }

    mysqli_close($connection);
?>