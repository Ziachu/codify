<?php
	require_once('../core/redis.php');

	require_once __DIR__ . '/vendor/autoload.php';
	use PhpAmqpLib\Connection\AMQPStreamConnection;

	$rb_connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
	$rb_channel = $rb_connection->channel();

	$rb_channel->queue_declare('image_queue', false, false, false, false);

	echo " [*] Waiting for images to convert. To exit press CTRL+C\n";

	$callback = function($msg){
		global $rd;

		// odkodowuję wiadomość
		$file = json_decode($msg->body, true);

		// prosty print w konsoli
	  echo ' I\'ll wait few seconds ;-)';
	  sleep(5);
		echo " Converting image " . $file['name'] . "\n";
		
		$target_dir = "../uploads/";
		$target_file = $target_dir . basename($file["name"]);
		$m_thumb_target_file = substr_replace($target_file, "_m_thumb", strrpos($target_file, '.'), 0);
		$s_thumb_target_file = substr_replace($target_file, "_s_thumb", strrpos($target_file, '.'), 0);
		$uploadOk = 1;
		$imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);

		$check = getimagesize($file["tmp_name"]);

    if ($file["size"] > 50000000
    || $imageFileType != "jpg"
    || $check === false) {
	    $uploadOk = 0;
    }

		if ($uploadOk == 1) {
			// half size
			$percent = 0.5;
			list($width, $height) = getimagesize($file["tmp_name"]);
			$newwidth = $width * $percent;
			$newheight = $height * $percent;

			$m_thumb = imagecreatetruecolor($newwidth, $newheight);
			$source = imagecreatefromjpeg($file["tmp_name"]);

			imagecopyresized($m_thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
	
			if (imagejpeg($m_thumb, $m_thumb_target_file))
				echo 'medium thumb - saved' . "\n";
			else 
				echo 'medium thumb - fail';

		  // 200x200
		  $percent = 0.25;
			$newwidth = 200;
			$newheight = 200;

			$s_thumb = imagecreatetruecolor($newwidth, $newheight);
			imagefilter($s_thumb, IMG_FILTER_GRAYSCALE);
			imagecopyresized($s_thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

		  if (imagejpeg($s_thumb, $s_thumb_target_file))
				echo 'medium thumb - saved' . "\n";
			else 
				echo 'medium thumb - fail';

			// original
			var_dump($file['tmp_name']);
		  if (rename($file["tmp_name"], $target_file))
				echo 'normal - moved' . "\n";
			else {
				echo 'normal - fail';
				unlink($file['tmp_name']);
			}

		  $rd->srem('images_in_queue', str_replace('/srv/http/codify/pages/../', '', $file["tmp_name"]));
		  $rd->sadd('volatile_images', str_replace("..", "/codify/", $s_thumb_target_file));
		}
	};

	$rb_channel->basic_qos(null, 1, null);
	$rb_channel->basic_consume('image_queue', '', false, true, false, false, $callback);

	while(count($rb_channel->callbacks)) {
    $rb_channel->wait();
	}

	$rb_channel->close();
	$rb_connection-close();
	
?>