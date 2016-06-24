<?php
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