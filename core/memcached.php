<?php
	class MemcachedClient {
		
		public $c;

		public function __construct() {
			$this->c = new Memcached();
			$this->c->addServer('127.0.0.1', 11211);
		}

		public function get_posts_on_user_wall($user_id) {
			global $db;

			$sql = 'SELECT * FROM posts
						 WHERE post_addressee_id = ' . $user_id;
			$key = 'SQL:' . $user_id . ':' . crc32($sql);
			$res = $this->c->get($key);

			// var_dump($res);

			if (!$res) {
				//key doesn't exist in memcache
				echo '<span style="color: red">database</span> used<br>';
				$val = $db->get_posts_on_user_wall($user_id);
				$this->c->set($key, $val, 3);
				return $val;

			} else {
				//key already exists in memcache
				echo '<span style="color: green">memcached</span> used';
				return $res;
			}
		}

		public function get_user_id_by_name($name) {
			global $db;

			$sql = 'SELECT user_id FROM users
						 WHERE user_name = ' . $name;
			$key = 'SQL:' . $name . ':' . crc32($sql);

			$res = $this->c->get($key);
			if (!$res) {
				//key doesn't exist in memcache
				$val = $db->get_user_id_by_name($name);
				$this->c->set($key, $val);
				return $val;

			} else {
				//key already exists in memcache
				return $res;
			}
		}

		public function get_user_name_by_id($id) {
			global $db;

			$sql = 'SELECT user_name FROM users
						 WHERE user_id = ' . $id;
			$key = 'SQL:' . $id . ':' . crc32($sql);

			$res = $this->c->get($key);
			if (!$res) {
				//key doesn't exist in memcache
				$val = $db->get_user_name_by_id($id);
				$this->c->set($key, $val);
				return $val;

			} else {
				//key already exists in memcache
				return $res;
			}
		}

		public function get_registered_users() {
			global $db;

			$sql = 'SELECT user_name FROM users';
			$key = 'SQL:all:' . crc32($sql);

			$res = $this->c->get($key);

			// MEMCACHE TEST
			// var_dump($res);
			if (!$res) {
				//key doesn't exist in memcache
				$val = $db->get_registered_users();
				$this->c->set($key, $val, 2);
				return $val;

			} else {
				//key already exists in memcache
				return $res;
			}
		}

		public function unset_key($key) {
			$this->c->delete($key);
		}
	}

	$mc = new MemcachedClient();
?>