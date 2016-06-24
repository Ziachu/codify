<?php
	class RedisClient {
		
		private $c;

		public function __construct() {
			$this->c = new Redis();
			$this->c->connect('127.0.0.1', 6379);

			$this->c->setNx('logged_in_usersasdasda', 0);
		}

		public function set($key, $val, $exp=0, $ifexst=false) {
			if ($ifexst) {
				$this->c->setNx($key, $val);
			} else {
				if ($exp > 0) {
					$this->c->set($key, $exp, $val);
				} else {
					$this->c->set($key, $val);
				}
			}
		}

		public function get($key) {
			return $this->c->get($key);
		}

		public function incr($key, $val=1) {
			if (is_float($val)) {
				$this->c->incrByFloat($key, $val);
			} else {
				$this->c->incrBy($key, $val);
			}
		}

		public function decr($key, $val=1) {
			if (is_float($val))
				$this->c->decrByFloat($key, $val);
			else {
				if ($val > 1)
					$this->c->decrBy($key, $val);
				else
					$this->c->decr($key);
			}
		}
	}

	$rd = new RedisClient();
?>