<?php
/***************************************************************************
 *
 * Copyright (c)2021 lampzone, Inc. All Rights Reserved
 *
 **************************************************************************/
/**
 * file test_server.php
 * author: lampzone
 * version: 1.0
 * time 2021/5/13 20:42
 */
$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
socket_bind($socket, "127.0.0.1", 8156);
socket_listen($socket);
do {
    if(($conn = socket_accept($socket)) === false) {
        echo "socket_accept错误". PHP_EOL;
        break;
    } else {
        $response = "";
        while($buff = socket_read($conn, 1024)) {
            if(!$buff) {
                break;
            }
            $response .= $buff;
            //接收到结束标识
            if (substr($buff, -1) == "\n") {
                echo "接收完毕，退出socket_read\n";
                break;
            }
        }
        $response = trim($response);
        $ret = json_decode($response, true);
        echo "收到的消息是：" . $response . PHP_EOL;
        socket_write($conn, "消息收到了" . $ret['user_id'] . "\r\n");
        //结束本地socket连接
        socket_close($conn);
    }
}while(true);
socket_close($socket);
