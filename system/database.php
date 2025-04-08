<?php
    $connection = mysqli_connect($config['database']['host'], $config['database']['user'], $config['database']['password'], $config['database']['name']);

    if(!$connection) {
        echo "Ошибка при подключении к базе данных!";
        die();
    }
?>