<?php



require_once __DIR__ . '/rabbitMQ.class.php';





//startRabbitMQ
$database = Database::instance();

$channel = $database->startRabbitMQ();

$channel->queue_declare('doResizeImage', false, false, false, false);
$channel->queue_declare('hello2', false, false, false, false);



$myQueAction = $database->amqDoResizeImage();

$channel->basic_publish($myQueAction, '', 'doResizeImage');



  if(!empty($_FILES['uploaded_file']))
  {
    $path = "uploads/";
    $path = $path . basename( $_FILES['uploaded_file']['name']);
    if(move_uploaded_file($_FILES['uploaded_file']['tmp_name'], $path)) {
 
      echo $path;
      $filepath = basename( $_FILES['uploaded_file']['name']);

          	$msg2 = new AMQPMessage($filepath);
$channel->basic_publish($msg2, '', 'hello2');
    } else{
        echo "There was an error uploading the file, please try again!";
    }


  }





//echo " [x] Send ".$message." \n ";

/*
echo " [x] Sent 'Hello World!'\n";*/

$database->channel->close();
$database->connection->close();


?>

<! DOCTYPE html>
<html>
<body>
<form action="" method="post" enctype="multipart/form-data"> Select image to upload:
<input type="file" name="uploaded_file">
<input type="submit" value="Upload Image" name="submit">
</form>
</body>