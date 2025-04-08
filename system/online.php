<?php
    require_once 'system/libs/minestat.php'; 

    $result = mysqli_query($connection, "SELECT value FROM settings WHERE setting = 'ip'");
    $ip = mysqli_fetch_assoc($result)['value'];

    $result = mysqli_query($connection, "SELECT value FROM settings WHERE setting = 'port'");
    $port = (int) mysqli_fetch_assoc($result)['value'];

    $ms = new MineStat($ip, $port);

    if($ms->is_online()) {
        echo $ms->get_current_players();
    }
?>