<?php
    header('Content-Type: application/json; charset=utf-8');
    if($uri == 'data/categories') {
        $result = mysqli_query($connection, 'SELECT id, name, background FROM categories WHERE status = 1');

        $array = [];
        while($row = mysqli_fetch_assoc($result)) {
            $array[] = $row;
        }

        echo json_encode($array);
    } else if(preg_match('#data/products/[0-9]+$#', $uri)) {
        $id = preg_replace('#^data\/products\/#', '', $uri);
        $stmt = $connection->prepare("SELECT id, displayname, description, price, discount, amounted, background FROM products WHERE category_id = ? AND status = 1");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        $array = [];
        while($row = mysqli_fetch_assoc($result)) {
            $array[] = $row;
        }

        echo json_encode($array);
    } else if(preg_match('#data/product/[0-9]+$#', $uri)) {
        $id = preg_replace('/^data\/product\//', '', $uri);
        $stmt = $connection->prepare("SELECT id, displayname, description, price, discount, amounted, background FROM products WHERE id = ? AND status = 1");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        $array = mysqli_fetch_assoc($result);

        $array['description'] = str_replace(array("\r\n", "\n\r", "\n"), "<br>", $array['description']);

        echo json_encode($array);
    } else if(preg_match('#data/promocode/[a-zа-яё\d]*$#i', $uri)) {
        $promocode = preg_replace('/^data\/promocode\//', '', $uri);

        $stmt = $connection->prepare("SELECT discount FROM promocodes WHERE promocode = ? AND status = 1 AND amount > 0");
        $stmt->bind_param("s", $promocode);
        $stmt->execute();
        $result = $stmt->get_result();

        $array = mysqli_fetch_assoc($result);

        if($array) {
            echo json_encode(["status" => "OK", "discount" => $array['discount']]);
        } else {
            echo json_encode(["status" => "ERROR"]);
        }
    } else if(preg_match('#data/nickname/[a-zа-яё\d]*/[0-9]+$#i', $uri)) {
        $nickname = preg_replace(['/^data\/nickname\//', '/\/[0-9]+$/'], '', $uri);
        $product = preg_replace(['/^data\/nickname\//', '/[a-zа-яё\d]*\//i'], '', $uri);

        $stmt = $connection->prepare("SELECT product FROM orders WHERE nickname = ?");
        $stmt->bind_param("s", $nickname);
        $stmt->execute();
        $order_result = $stmt->get_result();

        $stmt = $connection->prepare("SELECT price, category_id FROM products WHERE id = ?");
        $stmt->bind_param("i", $product);
        $stmt->execute();
        $product_result = $stmt->get_result();
        $product_row = mysqli_fetch_assoc($product_result);

        if($product_row) {
            $discount = null;
            while($order_row = mysqli_fetch_assoc($order_result)) {
                $oproduct_result = mysqli_query($connection, "SELECT price, category_id FROM products WHERE id = " . (int) $order_row['product']);
                $oproduct_row = mysqli_fetch_assoc($oproduct_result);
                if($oproduct_row) {
                    if($oproduct_row['category_id'] != $product_row['category_id']) continue;

                    $category_result = mysqli_query($connection, "SELECT supplement FROM categories WHERE id = " . (int) $oproduct_row['category_id']);
                    $category_row = mysqli_fetch_assoc($category_result);
                    
                    if($category_row && $category_row['supplement']) {
                        if($product_row['price'] > $oproduct_row['price']) {
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
                    exit(json_encode(["status" => "OK", "discount" => $oproduct_row['price']]));
                } else {
                    exit(json_encode(["status" => "OK", "discount" => "0"]));
                }
            }
        }

        exit(json_encode(["status" => "NULL"]));
    } else {
        exit('NULL');
    }
?>