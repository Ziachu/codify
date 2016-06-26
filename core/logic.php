<?php
	function db_init() {
		global $db;

		$string = file_get_contents("db_init.json");
		$data = json_decode($string, true);

		mysqli_query($db->c, "SET FOREIGN_KEY_CHECKS = 0"); 
    mysqli_query($db->c, "TRUNCATE TABLE posts");
    mysqli_query($db->c, "TRUNCATE TABLE users");
		mysqli_query($db->c, "SET FOREIGN_KEY_CHECKS = 1");

    foreach($data['users'] as $user) {
    	$sql = 'INSERT INTO users (user_id, user_name, user_passwordhash)
    					VALUES ('. $user['user_id'] . ', "'. $user['user_name'] . '", "'. $user['user_passwordhash'] . '")';
    	mysqli_query($db->c, $sql);
    	echo 'User ', $user['user_name'], ' inserted properly.' . "\n";
    }

		$stmt = $db->c->prepare("INSERT INTO posts (post_id, post_author_id, post_addressee_id, post_content)
													 VALUES (?, ?, ?, ?)");

    foreach($data['posts'] as $post) {
	  	$stmt->bind_param('iiis', $post['post_id'], $post['post_author_id'], $post['post_addressee_id'], $post['post_content']);
			// $stmt->bindParam(':post_id', $post['post_id']);
			// $stmt->bindParam(':post_author_id', $post['post_author_id']);
			// $stmt->bindParam(':post_addressee_id', $post['post_addressee_id']);
			// $stmt->bindParam(':post_content', $post['post_content']);

			$stmt->execute();

    	echo 'Post from ', $db->get_user_name_by_id($post['post_author_id']), 
    			 ' to ', $db->get_user_name_by_id($post['post_addressee_id']) . ' inserted properly.' . "\n";
    }

	}

	function auth($name, $pass) {
		global $db, $rd;

		if ($name != "" && $pass != "") {
			$password_hash = $db->get_user_hash_by_name($name);
			
			if ($password_hash != null && password_verify($pass, $password_hash)) {
				$rd->incr('logged_in_users');
				$rd->incr($name . '_log_times');
				return true;
			} else { 
				echo '<script>fail("wrong username and/or password");</script>';
				return false;
			}
		} else {
			echo '<script>fail("no username and/or password given");</script>';
		}
	}

	function logout() {
		global $rd;

		if (isset($_SESSION['user_id'])) {
			unset($_SESSION['user_id']);
			unset($_SESSION['user_name']);

			$rd->decr('logged_in_users', 1);			
		}
	}

	function get_id() {
		global $db;

		if (isset($_SESSION['user_name'])) {
			$id = $db->get_user_id_by_name($_SESSION['user_name']);
			return $id;
		}
	}

	function chck() {
		if (isset($_SESSION['user_id']))
			return true;
		else
			return false;
	}

	function name_is_free($name) {
		global $db;

		$id = $db->get_user_id_by_name($name);

		if ($id == null) {
			return true;
		} else {
			return false;
		}
	}

	function register($name, $pass) {
		global $db, $rd;

		$db->set_new_user($name, password_hash($pass, PASSWORD_BCRYPT));
		$rd->set($name . '_log_times', 0);
	}
?>