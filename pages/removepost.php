<?php
	if (isset($_POST) && isset($_POST['post_id'])) {
		$post_id = $_POST['post_id'];
		echo $post_id . '<br>';

		$addressee_id = $db->get_addressee_of_post_id($post_id);

		$sql = 'SELECT * FROM posts
						WHERE post_addressee_id = ' . $addressee_id;

		echo $sql	. '<br>';
		$key = 'SQL:' . $addressee_id . ':' . crc32($sql);
		$mc->unset_key($key);

		$ans = $db->del_post($post_id);
		echo $ans;
		return $ans;
	}
?>