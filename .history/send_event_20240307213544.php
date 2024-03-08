<?php
$data = array('key' => 'value');
$options = array(
    'http' => array(
        'method' => 'POST',
        'header' => 'Content-Type: application/json',
        'content' => json_encode($data)
    )
);
$context = stream_context_create($options);
$result = file_get_contents('http://localhost:8000/events/event1', false, $context);
echo $result;
?>