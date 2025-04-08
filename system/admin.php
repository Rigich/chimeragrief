<?php
    if(!isset($_SESSION)) {
        session_start();
    }

    $admin_uri = preg_replace('/^admin\//', '', $uri);

    // LOGIN
    if($admin_uri == "login") {
        $message = "";
        if(!empty($_POST)) {

            if(empty($_POST['login']) || empty($_POST['password'])) {
                $message = "Тут что-то не так..";
            } else {
                $login = $_POST['login'];
                $password = $_POST['password'];
                
                $stmt = $connection->prepare("SELECT * FROM admins WHERE login = ?");
                $stmt->bind_param("s", $login);
                $stmt->execute();
                $result = $stmt->get_result();
    
                $row = mysqli_fetch_assoc($result);
                
                if(!$row || !password_verify($password, $row['password'])) {
                    $message = "Неверный логин или пароль";
                } else {
                    $_SESSION['admin'] = $login;
                }
            }
        }
        if(!isset($_SESSION['admin'])) {
            require_once 'view/admin/login.php';
        } else {
            header("Location: /admin");
        }
    // LOGOUT
    } else if($admin_uri == "logout") {
        unset($_SESSION['admin']);
        session_destroy();
        header("Location: /admin/login");
    // DEFAULT
    } else if($admin_uri == "admin") {
        if(!isset($_SESSION['admin'])) {
            header("Location: /admin/login");
        } else {
            $name = "Информация";
            $content = 'view/admin/index.php';
            require_once 'view/layouts/admin.php';
        }
    // CATEGORY
    } else if($admin_uri == "category") {
        if(!isset($_SESSION['admin'])) {
            header("Location: /admin/login");
        } else {
            $name = "Категории";
            $content = 'view/admin/category.php';
            require_once 'view/layouts/admin.php';
        }
    } else if($admin_uri == "category/add") {
        if(!isset($_SESSION['admin'])) {
            header("Location: /admin/login");
        } else {
            $name = "Добавление категории";
            $content = 'view/admin/category-add.php';
            require_once 'view/layouts/admin.php';
        }
    } else if(preg_match('#category/del/[0-9]+$#', $admin_uri)) {
        if(!isset($_SESSION['admin'])) {
            header("Location: /admin/login");
        } else {
            $category_id = preg_replace('/^category\/del\//', '', $admin_uri);
            mysqli_query($connection, "DELETE FROM categories WHERE id = " . $category_id);
            header("Location: /admin/category");
        }
    } else if(preg_match('#category/edit/[0-9]+$#', $admin_uri)) {
        if(!isset($_SESSION['admin'])) {
            header("Location: /admin/login");
        } else {
            $name = "Редактирование категории";
            $category_id = preg_replace('/^category\/edit\//', '', $admin_uri);
            $content = 'view/admin/category-edit.php';
            require_once 'view/layouts/admin.php';
        }
    // SERVER
    } else if($admin_uri == "server") {
        if(!isset($_SESSION['admin'])) {
            header("Location: /admin/login");
        } else {
            $name = "Сервера";
            $content = 'view/admin/server.php';
            require_once 'view/layouts/admin.php';
        }
    } else if($admin_uri == "server/add") {
        if(!isset($_SESSION['admin'])) {
            header("Location: /admin/login");
        } else {
            $name = "Добавление сервера";
            $content = 'view/admin/server-add.php';
            require_once 'view/layouts/admin.php';
        }
    } else if(preg_match('#server/del/[0-9]+$#', $admin_uri)) {
        if(!isset($_SESSION['admin'])) {
            header("Location: /admin/login");
        } else {
            $server_id = preg_replace('/^server\/del\//', '', $admin_uri);
            mysqli_query($connection, "DELETE FROM servers WHERE id = " . $server_id);
            header("Location: /admin/server");
        }
    } else if(preg_match('#server/edit/[0-9]+$#', $admin_uri)) {
        if(!isset($_SESSION['admin'])) {
            header("Location: /admin/login");
        } else {
            $name = "Редактирование сервера";
            $server_id = preg_replace('/^server\/edit\//', '', $admin_uri);
            $content = 'view/admin/server-edit.php';
            require_once 'view/layouts/admin.php';
        }
    // PRODUCT
    } else if($admin_uri == "product") {
        if(!isset($_SESSION['admin'])) {
            header("Location: /admin/login");
        } else {
            $name = "Продукты";
            $content = 'view/admin/product.php';
            require_once 'view/layouts/admin.php';
        }
    } else if($admin_uri == "product/add") {
        if(!isset($_SESSION['admin'])) {
            header("Location: /admin/login");
        } else {
            $name = "Добавление продукта";
            $content = 'view/admin/product-add.php';
            require_once 'view/layouts/admin.php';
        }
    } else if(preg_match('#product/del/[0-9]+$#', $admin_uri)) {
        if(!isset($_SESSION['admin'])) {
            header("Location: /admin/login");
        } else {
            $product_id = preg_replace('/^product\/del\//', '', $admin_uri);
            mysqli_query($connection, "DELETE FROM products WHERE id = " . $product_id);
            header("Location: /admin/product");
        }
    } else if(preg_match('#product/edit/[0-9]+$#', $admin_uri)) {
        if(!isset($_SESSION['admin'])) {
            header("Location: /admin/login");
        } else {
            $name = "Редактирование продукта";
            $product_id = preg_replace('/^product\/edit\//', '', $admin_uri);
            $content = 'view/admin/product-edit.php';
            require_once 'view/layouts/admin.php';
        }
    // PROMOCODE
    } else if($admin_uri == "promocode") {
        if(!isset($_SESSION['admin'])) {
            header("Location: /admin/login");
        } else {
            $name = "Промокоды";
            $content = 'view/admin/promocode.php';
            require_once 'view/layouts/admin.php';
        }
    } else if($admin_uri == "promocode/add") {
        if(!isset($_SESSION['admin'])) {
            header("Location: /admin/login");
        } else {
            $name = "Добавление промокода";
            $content = 'view/admin/promocode-add.php';
            require_once 'view/layouts/admin.php';
        }
    } else if(preg_match('#promocode/del/[0-9]+$#', $admin_uri)) {
        if(!isset($_SESSION['admin'])) {
            header("Location: /admin/login");
        } else {
            $promocode_id = preg_replace('/^promocode\/del\//', '', $admin_uri);
            mysqli_query($connection, "DELETE FROM promocodes WHERE id = " . $promocode_id);
            header("Location: /admin/promocode");
        }
    } else if(preg_match('#promocode/edit/[0-9]+$#', $admin_uri)) {
        if(!isset($_SESSION['admin'])) {
            header("Location: /admin/login");
        } else {
            $name = "Редактирование промокода";
            $promocode_id = preg_replace('/^promocode\/edit\//', '', $admin_uri);
            $content = 'view/admin/promocode-edit.php';
            require_once 'view/layouts/admin.php';
        }
    // LASTBUYS
    } else if($admin_uri == "lastbuys") {
        if(!isset($_SESSION['admin'])) {
            header("Location: /admin/login");
        } else {
            $name = "Последние покупки";
            $title = "Последние покупки";
            $content = 'view/admin/lastbuys.php';
            require_once 'view/layouts/admin.php';
        }
    } else if($admin_uri == "lastbuys/toggle") {
        if(!isset($_SESSION['admin'])) {
            header("Location: /admin/login");
        } else {
            $result = mysqli_query($connection, "SELECT value FROM lastbuys WHERE setting = 'status'");
            $row = mysqli_fetch_assoc($result);

            if($row['value'] == 'enabled') {
                $result = mysqli_query($connection, "UPDATE lastbuys SET value = 'disabled' WHERE setting = 'status'");
            } else if($row['value'] == 'disabled') {
                $result = mysqli_query($connection, "UPDATE lastbuys SET value = 'enabled' WHERE setting = 'status'");
            }
            header("Location: /admin/lastbuys");
        }
    // SETTINGS
    } else if($admin_uri == "settings") {
        if(!isset($_SESSION['admin'])) {
            header("Location: /admin/login");
        } else {
            $styles = [
                'settings'
            ];
            $name = "Настройки";
            $title = "Настройки";
            $content = 'view/admin/settings.php';
            require_once 'view/layouts/admin.php';
        }
    } else if($admin_uri == "settings/toggle") {
        if(!isset($_SESSION['admin'])) {
            header("Location: /admin/login");
        } else {
            if(isset($_POST['btn_play'])) {
                mysqli_query($connection, "UPDATE settings SET value = 'enabled' WHERE setting = 'btn_play'");
            } else {
                mysqli_query($connection, "UPDATE settings SET value = 'disabled' WHERE setting = 'btn_play'");
            }
            if(isset($_POST['btn_donate'])) {
                mysqli_query($connection, "UPDATE settings SET value = 'enabled' WHERE setting = 'btn_donate'");
            } else {
                mysqli_query($connection, "UPDATE settings SET value = 'disabled' WHERE setting = 'btn_donate'");
            }
            if(isset($_POST['online_toogle'])) {
                mysqli_query($connection, "UPDATE settings SET value = 'enabled' WHERE setting = 'online_toogle'");
            } else {
                mysqli_query($connection, "UPDATE settings SET value = 'disabled' WHERE setting = 'online_toogle'");
            }
            header("Location: /admin/settings");
        }
    // PAYMENTS
    } else if($admin_uri == "payments") {
        if(!isset($_SESSION['admin'])) {
            header("Location: /admin/login");
        } else {
            $name = "Способы оплат";
            $title = "Способы оплат";
            $content = 'view/admin/payments.php';
            require_once 'view/layouts/admin.php';
        }
    } else if($admin_uri == "payments/qiwitoggle") {
        if(!isset($_SESSION['admin'])) {
            header("Location: /admin/login");
        } else {
            $result = mysqli_query($connection, "SELECT value FROM payments WHERE setting = 'qiwi_status'");
            $row = mysqli_fetch_assoc($result);

            if($row['value'] == 'enabled') {
                $result = mysqli_query($connection, "UPDATE payments SET value = 'disabled' WHERE setting = 'qiwi_status'");
            } else if($row['value'] == 'disabled') {
                $result = mysqli_query($connection, "UPDATE payments SET value = 'enabled' WHERE setting = 'qiwi_status'");
            }
            header("Location: /admin/payments");
        }
    } else if($admin_uri == "payments/qiwi") {
        if(!isset($_SESSION['admin'])) {
            header("Location: /admin/login");
        } else {
            if(!empty($_POST)) {
                if(!empty($_POST['public']) && !empty($_POST['secret'])) {
                    $public = $_POST['public'];
                    $secret = $_POST['secret'];

                    mysqli_query($connection, "UPDATE payments SET value = '" . $public . "' WHERE setting = 'qiwi_public'");
                    mysqli_query($connection, "UPDATE payments SET value = '" . $secret . "' WHERE setting = 'qiwi_secret'");
                }
            }
            header("Location: /admin/payments");
        }
    } else if($admin_uri == "payments/yoomoneytoggle") {
        if(!isset($_SESSION['admin'])) {
            header("Location: /admin/login");
        } else {
            $result = mysqli_query($connection, "SELECT value FROM payments WHERE setting = 'yoomoney_status'");
            $row = mysqli_fetch_assoc($result);

            if($row['value'] == 'enabled') {
                $result = mysqli_query($connection, "UPDATE payments SET value = 'disabled' WHERE setting = 'yoomoney_status'");
            } else if($row['value'] == 'disabled') {
                $result = mysqli_query($connection, "UPDATE payments SET value = 'enabled' WHERE setting = 'yoomoney_status'");
            }
            header("Location: /admin/payments");
        }
    } else if($admin_uri == "payments/yoomoney") {
        if(!isset($_SESSION['admin'])) {
            header("Location: /admin/login");
        } else {
            if(!empty($_POST)) {
                if(!empty($_POST['id']) && !empty($_POST['secret'])) {
                    $id = $_POST['id'];
                    $secret = $_POST['secret'];

                    mysqli_query($connection, "UPDATE payments SET value = '" . $id . "' WHERE setting = 'yoomoney_id'");
                    mysqli_query($connection, "UPDATE payments SET value = '" . $secret . "' WHERE setting = 'yoomoney_secret'");
                }
            }
            header("Location: /admin/payments");
        }
    } else if($admin_uri == "payments/freekassatoggle") {
        if(!isset($_SESSION['admin'])) {
            header("Location: /admin/login");
        } else {
            $result = mysqli_query($connection, "SELECT value FROM payments WHERE setting = 'freekassa_status'");
            $row = mysqli_fetch_assoc($result);

            if($row['value'] == 'enabled') {
                $result = mysqli_query($connection, "UPDATE payments SET value = 'disabled' WHERE setting = 'freekassa_status'");
            } else if($row['value'] == 'disabled') {
                $result = mysqli_query($connection, "UPDATE payments SET value = 'enabled' WHERE setting = 'freekassa_status'");
            }
            header("Location: /admin/payments");
        }
    } else if($admin_uri == "payments/freekassa") {
        if(!isset($_SESSION['admin'])) {
            header("Location: /admin/login");
        } else {
            if(!empty($_POST)) {
                if(!empty($_POST['id']) && !empty($_POST['secret1']) && !empty($_POST['secret2'])) {
                    $id = $_POST['id'];
                    $secret1 = $_POST['secret1'];
                    $secret2 = $_POST['secret2'];

                    mysqli_query($connection, "UPDATE payments SET value = '" . $id . "' WHERE setting = 'freekassa_id'");
                    mysqli_query($connection, "UPDATE payments SET value = '" . $secret1 . "' WHERE setting = 'freekassa_secret1'");
                    mysqli_query($connection, "UPDATE payments SET value = '" . $secret2 . "' WHERE setting = 'freekassa_secret2'");
                }
            }
            header("Location: /admin/payments");
        }
    } else if($admin_uri == "payments/enottoggle") {
        if(!isset($_SESSION['admin'])) {
            header("Location: /admin/login");
        } else {
            $result = mysqli_query($connection, "SELECT value FROM payments WHERE setting = 'enot_status'");
            $row = mysqli_fetch_assoc($result);

            if($row['value'] == 'enabled') {
                $result = mysqli_query($connection, "UPDATE payments SET value = 'disabled' WHERE setting = 'enot_status'");
            } else if($row['value'] == 'disabled') {
                $result = mysqli_query($connection, "UPDATE payments SET value = 'enabled' WHERE setting = 'enot_status'");
            }
            header("Location: /admin/payments");
        }
    } else if($admin_uri == "payments/enot") {
        if(!isset($_SESSION['admin'])) {
            header("Location: /admin/login");
        } else {
            if(!empty($_POST)) {
                if(!empty($_POST['id']) && !empty($_POST['secret1']) && !empty($_POST['secret2'])) {
                    $id = $_POST['id'];
                    $secret1 = $_POST['secret1'];
                    $secret2 = $_POST['secret2'];

                    mysqli_query($connection, "UPDATE payments SET value = '" . $id . "' WHERE setting = 'enot_id'");
                    mysqli_query($connection, "UPDATE payments SET value = '" . $secret1 . "' WHERE setting = 'enot_secret1'");
                    mysqli_query($connection, "UPDATE payments SET value = '" . $secret2 . "' WHERE setting = 'enot_secret2'");
                }
            }
            header("Location: /admin/payments");
        }
    } else if($admin_uri == "payments/enottoggle") {
        if(!isset($_SESSION['admin'])) {
            header("Location: /admin/login");
        } else {
            $result = mysqli_query($connection, "SELECT value FROM payments WHERE setting = 'enot_status'");
            $row = mysqli_fetch_assoc($result);

            if($row['value'] == 'enabled') {
                $result = mysqli_query($connection, "UPDATE payments SET value = 'disabled' WHERE setting = 'enot_status'");
            } else if($row['value'] == 'disabled') {
                $result = mysqli_query($connection, "UPDATE payments SET value = 'enabled' WHERE setting = 'enot_status'");
            }
            header("Location: /admin/payments");
        }
    } else if($admin_uri == "payments/enot") {
        if(!isset($_SESSION['admin'])) {
            header("Location: /admin/login");
        } else {
            if(!empty($_POST)) {
                if(!empty($_POST['id']) && !empty($_POST['secret1']) && !empty($_POST['secret2'])) {
                    $id = $_POST['id'];
                    $secret1 = $_POST['secret1'];
                    $secret2 = $_POST['secret2'];

                    mysqli_query($connection, "UPDATE payments SET value = '" . $id . "' WHERE setting = 'enot_id'");
                    mysqli_query($connection, "UPDATE payments SET value = '" . $secret1 . "' WHERE setting = 'enot_secret1'");
                    mysqli_query($connection, "UPDATE payments SET value = '" . $secret2 . "' WHERE setting = 'enot_secret2'");
                }
            }
            header("Location: /admin/payments");
        }
    } else if($admin_uri == "payments/anypaytoggle") {
        if(!isset($_SESSION['admin'])) {
            header("Location: /admin/login");
        } else {
            $result = mysqli_query($connection, "SELECT value FROM payments WHERE setting = 'anypay_status'");
            $row = mysqli_fetch_assoc($result);

            if($row['value'] == 'enabled') {
                $result = mysqli_query($connection, "UPDATE payments SET value = 'disabled' WHERE setting = 'anypay_status'");
            } else if($row['value'] == 'disabled') {
                $result = mysqli_query($connection, "UPDATE payments SET value = 'enabled' WHERE setting = 'anypay_status'");
            }
            header("Location: /admin/payments");
        }
    } else if($admin_uri == "payments/anypay") {
        if(!isset($_SESSION['admin'])) {
            header("Location: /admin/login");
        } else {
            if(!empty($_POST)) {
                if(!empty($_POST['id']) && !empty($_POST['secret'])) {
                    $id = $_POST['id'];
                    $secret = $_POST['secret'];

                    mysqli_query($connection, "UPDATE payments SET value = '" . $id . "' WHERE setting = 'anypay_id'");
                    mysqli_query($connection, "UPDATE payments SET value = '" . $secret . "' WHERE setting = 'anypay_secret'");
                }
            }
            header("Location: /admin/payments");
        }
    // PROFILE
    } else if($admin_uri == "profile") {
        if(!isset($_SESSION['admin'])) {
            header("Location: /admin/login");
        } else {
            $name = "Редактирование аккаунта";
            $title = "Редактирование аккаунта";
            $content = 'view/admin/profile.php';
            require_once 'view/layouts/admin.php';
        }
    // 404
    } else {
        if(!isset($_SESSION['admin'])) {
            header("Location: /admin/login");
        } else {
            $name = "Страница не найдена";
            require_once 'view/layouts/admin.php';
        }
    }
?>