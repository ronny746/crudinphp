<?php
require_once 'HTTP/Request2.php';
$request = new HTTP_Request2();
$request->setUrl('http://localhost/crudinphp/add_post.php');
$request->setMethod(HTTP_Request2::METHOD_POST);
$request->setConfig(array(
  'follow_redirects' => TRUE
));
$request->setHeader(array(
  'Cookie' => 'PHPSESSID=8ceqggu43bpdnd96t9s9lbsm7g'
));
$request->addPostParameter(array(
  'content' => 'The great world',
  'user_id' => '1'
));
$request->addUpload('image', '/Users/rohitrana/Downloads/otp image.png', 'otp image.png', '<Content-Type Header>');
try {
  $response = $request->send();
  if ($response->getStatus() == 200) {
    echo $response->getBody();
  }
  else {
    echo 'Unexpected HTTP status: ' . $response->getStatus() . ' ' .
    $response->getReasonPhrase();
  }
}
catch(HTTP_Request2_Exception $e) {
  echo 'Error: ' . $e->getMessage();
}