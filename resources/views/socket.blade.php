<?php
$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
$connection = socket_connect($socket, '192.168.0.132', 8000);
?>
