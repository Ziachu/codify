<?php
	class Database {

		private $c;

		public function __construct() {
			$this->c = new mysqli("localhost", "codify_admin", "asdasd", "codify");
			if ($this->c->connect_error) {
				die("Failed to connect with db: " . $c->connect_error);
			}
		}

		public function get_user_hash_by_name($name) {
			$query = "SELECT user_passwordhash FROM users
								WHERE user_name = '" . $name . "'";
			
			$answer = $this->c->query($query);

			if ($answer->num_rows > 0) {
				$hash = $answer->fetch_assoc()['user_passwordhash'];
				return $hash;
			}

			return null;
		}

		public function get_user_id_by_name($name) {
			$query = "SELECT user_id FROM users
								WHERE user_name = '" . $name . "'";

			$answer = $this->c->query($query);

			if ($answer->num_rows > 0) {
				$id = $answer->fetch_assoc()['user_id'];
			} else {
				return null;
			}

			return $id;
		}

		public function get_user_name_by_id($id) {
			$query = "SELECT user_name FROM users
								WHERE user_id = " . $id;

			$answer = $this->c->query($query);

			if ($answer->num_rows > 0) {
				$name = $answer->fetch_assoc()['user_name'];
			} else {
				return null;
			}

			return $name;
		}

		public function set_new_user($name, $hash) {
			$query = "INSERT INTO users (user_name, user_passwordhash)
								VALUES (\"" . $name . "\", \"" . $hash . "\")";

			$answer = $this->c->query($query);
		}

		public function set_new_post($author_id, $addressee_id, $content) {
			$query = "INSERT INTO posts (post_author_id, post_addressee_id, post_content)
								VALUES (" . $author_id . ", ". $addressee_id . ", \"" . $content . "\")";

			$answer = $this->c->query($query);
			return $answer;
		}

		public function del_post($post_id) {
			$query = "DELETE FROM posts
								WHERE post_id = $post_id";
			echo '3333' . $query . '######3';

			$answer = $this->c->query($query);
			return $answer;
		}

		public function get_posts_on_user_wall($user_id) {
			$query = "SELECT * FROM posts
								WHERE post_addressee_id = '" . $user_id . "'";

			$result = array();
			$answer = $this->c->query($query);

			if ($answer) {
				if ($answer->num_rows > 0) {
					while ($row = $answer->fetch_assoc()) {
						array_push($result, $row);
					}
				}
			}

			return $result;
		}

		public function get_registered_users() {
			$query = "SELECT user_name FROM users";

			$result = array();
			$answer = $this->c->query($query);

			if ($answer) {
				if ($answer->num_rows > 0) {
					while ($row = $answer->fetch_assoc()) {
						array_push($result, $row['user_name']);
					}
				}
			}

			return $result;	
		}

		public function get_addressee_of_post_id($post_id) {
			$query = "SELECT post_addressee_id FROM posts
								WHERE post_id = " . $post_id;

			$answer = $this->c->query($query);

			if ($answer->num_rows > 0) {
				$addressee_id = $answer->fetch_assoc()['post_addressee_id'];
			} else {
				return null;
			}

			return $addressee_id;
		}
	}

	$db = new Database();
?>