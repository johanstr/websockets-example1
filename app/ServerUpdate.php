<?php
namespace MyApp;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class ServerUpdate implements MessageComponentInterface {
    protected $clients;

    public function __construct() {
        $this->clients = new \SplObjectStorage;
    }

    public function onOpen(ConnectionInterface $conn) {
        // Store the new connection to send messages to later
        $this->clients->attach($conn);

        echo $this->colorize("New connection: ({$conn->resourceId})");
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        $rows = '';

        $numRecv = count($this->clients) - 1;
        echo $this->colorize("Sending update to clients...");

        try {
            $db = new \PDO("mysql:host=localhost;dbname=websockets", 'root', 'root');

            $dbh = $db->prepare('UPDATE workshops
               SET plaatsen = plaatsen - 1
               WHERE id = :id');

            $dbh->execute( array(
                ':id' => $msg
            ));

            $dbh = $db->prepare('SELECT * FROM workshops');
            $dbh->execute();

            $rows = json_encode($dbh->fetchAll());

        } catch(\PDOException $e) {
            echo '<span style="color: red;">ERROR: ' .$e->getMessage() . '</span>';
        }

        foreach ($this->clients as $client) {
                $client->send($rows);
        }
    }

    public function onClose(ConnectionInterface $conn) {
        // The connection is closed, remove it, as we can no longer send it messages
        $this->clients->detach($conn);

        echo $this->colorize("Connection {$conn->resourceId} has disconnected", "WARNING");
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo $this->colorize("ERROR: {$e->getMessage()}", "FAILURE");

        $conn->close();
    }

    private function colorize($text, $status = "SUCCESS") {
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
}
