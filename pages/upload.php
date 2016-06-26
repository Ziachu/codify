<?php
	require_once __DIR__ . '/vendor/autoload.php';
	use PhpAmqpLib\Connection\AMQPStreamConnection;
	use PhpAmqpLib\Message\AMQPMessage;

  // tworzę połączenie TCP
  $rb_connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
  // tworzę kanał
  $rb_channel = $rb_connection->channel();
  // tworzę kolejkę (w razie gdyby nie istaniała jeszcze)
	$rb_channel->queue_declare('image_queue', false, false, false, false);

	$file = $_FILES["fileToUpload"];
	$target_dir = "tmp/";
	$target_file = $target_dir . basename($file["name"]);
  move_uploaded_file($file["tmp_name"], $target_file);
	$abs_target_dir = __DIR__ . "/../tmp/";
	$abs_target_file = $abs_target_dir . basename($file["name"]);
	$data = $file;
	$data['tmp_name'] = $abs_target_file;
	$data = json_encode($data);

	$msg = new AMQPMessage($data, array('delivery_mode' => 2));
	$rb_channel->basic_publish($msg, '', 'image_queue');
	$rd->sadd('images_in_queue', $target_file);

	$rb_channel->close();
	$rb_connection->close();

	header('Location: /codify/');
?>
