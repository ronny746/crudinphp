<?php
// Set headers to allow cross-origin resource sharing (CORS)
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Read the input stream
    $data = file_get_contents("php://input");
    
    // Check if data is not empty
    if (!empty($data)) {
        // Decode the JSON data
        $decodedData = json_decode($data, true);

        // Check if decoding was successful
        if ($decodedData !== null) {
            // Send back the decoded data
            echo json_encode(array("message" => "Data received", "data" => $decodedData));
        } else {
            // Invalid JSON data
            echo json_encode(array("message" => "Invalid JSON data"));
        }
    } else {
        // Empty request body
        echo json_encode(array("message" => "Empty request body"));
    }
} else {
    // Invalid request method
    echo json_encode(array("message" => "Invalid request method"));
}
?>
