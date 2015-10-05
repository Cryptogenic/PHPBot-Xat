<?php
	class user {

		public $f;
		public $id;
		public $name;
		public $nick;
		public $home;
		public $rank;
		public $room;
		public $avatar;

		public function __construct($parent, $info) {
			$this->parent = &$parent;

			$this->id     = $info["id"];
			$this->name   = $info["username"];
			$this->nick   = $info["nickname"];
			$this->avatar = $info["avatar"];
			$this->home   = $info["home"];
			$this->f      = $info["f"];
			$this->rank   = $info["rank"];
			$this->room   = $info["room"];
		}

		public function ban($info) {
			$this->parent->modules["socket"]->write("c", array("p" => $info["reason"],
															   "u" => $this->id,
															   "t" => "/g".((int)$info["hours"] * 3600)
			));
			return true;
		}

		public function kick($info) {
			$this->parent->modules["socket"]->write("c", array("p" => $info["reason"],
															   "u" => $this->id,
															   "t" => "/k"
			));
			return true;
		}
	}
?>