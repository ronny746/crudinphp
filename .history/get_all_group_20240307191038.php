<?php
require_once 'connection.php'; // Include database connection script

// Require the autoload file for Ratchet
require __DIR__ . '/vendor/autoload.php';

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;

// Define your WebSocket server class
class WebSocketServer implements MessageComponentInterface {
    protected $clients;

    public function __construct() {
        $this->clients = new \SplObjectStorage;
    }

    public function onOpen(ConnectionInterface $conn) {
        $this->clients->attach($conn);
        echo "New connection! ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        foreach ($this->clients as $client) {
            if ($client !== $from) {
                $client->send($msg);
            }
        }
    }

    public function onClose(ConnectionInterface $conn) {
        $this->clients->detach($conn);
        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n";
        $conn->close();
    }
}

// Handle GET request to fetch all groups
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Select all groups from the database
    $selectGroupsQuery = "SELECT * FROM groups";
    $result = mysqli_query($conn, $selectGroupsQuery);

    // Prepare array to hold groups
    $groups = array();

    // Check if there are any groups
    if (mysqli_num_rows($result) > 0) {
        // Fetch groups and store them in the array
        while ($row = mysqli_fetch_assoc($result)) {
            $group = array(
                'id' => $row['id'],
                'name' => $row['name']
                // Add more fields if needed
            );
            $groups[] = $group;
        }
        // Return JSON response with groups
        echo json_encode(array("message" => "Groups fetched successfully", "groups" => $groups));
    } else {
        // No groups found
        echo json_encode(array("message" => "No groups found"));
    }
} else {
    // Invalid request method
    echo json_encode(array("message" => "Invalid request method"));
}

// Start the WebSocket server
$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            new WebSocketServer()
        )
    ),
    8080 // Port number to listen on
);

$server->run();
?>
