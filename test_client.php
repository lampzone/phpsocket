<?php
/***************************************************************************
 *
 * Copyright (c)2021 lampzone, Inc. All Rights Reserved
 *
 **************************************************************************/
/**
 * file test_client.php
 * author: lampzone
 * version: 1.0
 * time 2021/5/13 20:42
 */
$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
$conn = socket_connect($socket, "127.0.0.1", 8156);
if($conn) {
    $t = date("Y-m-d H:i:s");
    $msg = array(
        "user_id"=> 'test123' . $t,
    );
    $msg = json_encode($msg);
    socket_write($socket, $msg, strlen($msg));
    //发送结束标识
    socket_write($socket, "\n");
    $response = "";
    while (!empty($buff = socket_read($socket, 1024))) {
        $response = $response . $buff;
    }
    echo "接收到服务端的信息：" . $response. PHP_EOL;
}
//结束本次socket连接
echo "关闭SOCKET...\n";
socket_close($socket);
echo "关闭OK\n";