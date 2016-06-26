<?php
	session_start();

	error_reporting(E_ALL);
	ini_set('display_errors', '1');

	require_once('./core/database.php');
	require_once('./core/redis.php');
	require_once('./core/memcached.php');
	require_once('./core/logic.php');

	// $sql = 'SELECT * FROM posts
	// 		 WHERE post_addressee_id = ' . '1';
	// $key = 'SQL:' . '1' . ':' . crc32($sql);
	// $mc->c->delete($key);
	
if (isset($_GET['path'])) {
		$path = $_GET['path'];
		// echo $path;

		switch ($path) {
			case 'loginpage':
				require('./pages/loginpage.php');
				break;
			case 'logoutpage':
				if (chck()) {
					logout();
					require('./pages/loginpage.php');		
				} else {
					require('./pages/accessdeniedpage.php');
				}
				break;
			case 'registerpage':
				require('./pages/registerpage.php');
				break;
			case (preg_match('#profile/(.*)#i', $path, $matches) ? true : false):
				$user = $matches[1];
				$user_id = $mc->get_user_id_by_name($user);
				$posts = $mc->get_posts_on_user_wall($user_id);
				require('pages/profilepage.php');
				break;
			case 'removepost':
				if (chck()) {
					require ('./pages/removepost.php');
				}
				break;
			case 'upload':
				if (chck()) {
					require('./pages/upload.php');
				}

				break;

			default:
				if (chck()) {
					$users = $mc->get_registered_users();
				}

				require('./pages/landingpage.php');
				break;
		}
	}

?>