<?php
require 'vendor/autoload.php';

use ElephantIO\Client;
use ElephantIO\Engine\SocketIO\Version2X;

$port = 3000;
$server = 'http://localhost:' . $port;

$chat = new ChatServer($server, $port);
$chat->run();

class ChatServer
{
    private $client;

    public function __construct($server, $port)
    {
        $this->client = new Client(new Version2X($server));
    }

    public function run()
    {
        $this->client->initialize();
        $this->client->emit('message', 'Server connected.');

        $this->client->on('message', function ($data) {
            echo "Message received: $data\n";
            $this->client->emit('message', "Received: $data");
        });

        $this->client->on('error', function ($error) {
            echo "Error: $error\n";
        });

        $this->client->on('close', function () {
            echo "Connection closed\n";
        });

        $this->client->on('disconnect', function () {
            echo "Disconnected\n";
        });

        $this->client->on('connect', function () {
            echo "Connected\n";
        });

        $this->client->close();
    }
}
