<?php
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use MyApp\ServerUpdate;

require dirname(__DIR__) . '/vendor/autoload.php';

function colorize($text, $status = "SUCCESS") {
    $out = "";
    switch($status) {
        case "SUCCESS":
            $out = "[42m"; //Green background
            break;
        case "FAILURE":
            $out = "[41m"; //Red background
            break;
        case "WARNING":
            $out = "[43m"; //Yellow background
            break;
        case "NOTE":
            $out = "[44m"; //Blue background
            break;
        default:
            throw new Exception("Invalid status: " . $status);
    }
    return chr(27) . "$out" . " $text " . chr(27) . "[0m\n";
}

$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            new ServerUpdate()
        )
    ),
    8080
);

echo colorize('Server running...', 'NOTE');

$server->run();
