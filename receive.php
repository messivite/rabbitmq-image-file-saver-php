
<?php

require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use \Gumlet\ImageResize;
$connection = new AMQPStreamConnection('localhost', 5672, 'root', 'root');
$channel = $connection->channel();

$channel->queue_declare('doResizeImage', false, false, false, false);

$channel->queue_declare('hello2', false, false, false, false);



echo " [*] Waiting for messages. To exit press CTRL+C\n";

$callback = function ($msg) {


  if($msg->body == "_doResizeImage") {
  	echo ' [x] Alındı ', $msg->body, "\n";

  	$image = new ImageResize('image.jpg');
$image->scale(50);
$image->save('image2.jpg');

$image->resizeToBestFit(500, 300);
$image->save('image3.jpg');
  }	else{
  	echo ' [x] Received ', $msg->body, "\n";
  }	
  
};


$channel->basic_consume('doResizeImage', '', false, true, false, false, $callback);
$channel->basic_consume('hello2', '', false, true, false, false, $callback);
while (count($channel->callbacks)) {
    $channel->wait();
}


?>