<?php
	set_time_limit(0);
	error_reporting(E_ALL ^ E_NOTICE);

	class bot {

		public $debug    = true;
		public $secure   = false;
		public $chats    = array("official" => array(), "tribute" => array(), "free" => array());
		public $support  = array();
		public $admins   = array("1472300041", "420100047");

		public function __construct($bid) {
			$this->constructClasses();

			$this->bid      = $bid;

			$this->modules["database"]->updateInformation("bots", array("pid" => getmypid()), "id", $this->bid);

			$this->bot      = $this->modules["database"]->fetchInformation("bots", "*", "id", $bid);
			$this->lists    = json_decode($this->bot["lists"]);
			$this->settings = json_decode($this->bot["settings"]);
			$this->acclist  = json_decode($this->bot["accesslist"]);
			$this->minranks = json_decode($this->bot["minranks"]);
			$this->cryptkey = $this->bot["crypt_key"];
			$this->room     = $this->settings->{'room'};
			$this->time     = time();

			$this->cid      = $this->bot["xat_id"];
			$this->users    = array();

			$this->modules["console"]->inform("INTRO", true);
			$this->connect();
			$this->login();
			$this->join();
			$this->freeMemory();
		}

		public function constructClasses() {
			require("./lib/modules/function.module.php");
			require("./lib/modules/database.module.php");
			require("./lib/modules/console.module.php");
			require("./lib/modules/socket.module.php");
			require("./lib/modules/user.module.php");

			$this->packetTags = array("a", "done", "f", "i", "idle", "l", "m", "u");
			$this->commands = array("say", "app", "time", "rank", "ban", "big", "clear", "choose", "dev",
									"users", "eightball", "edit", "delistcheck", "kick", "latest", "promoted");

			foreach($this->packetTags as $tag) {
				require("./lib/packets/".$tag.".packet.php");
			}

			foreach($this->commands as $command) {
				require("./lib/plugins/".$command.".plugin.php");
			}

			$this->config = simplexml_load_file("./lib/configuration/database.config.xml");

			$this->modules = array("function" => new functions($this),
								   "database" => new database($this->config),
								   "socket"   => new socket($this),
								   "console"  => new console()
			);

			if($this->secure) {
				require('./lib/modules/security.module.php');
				$this->modules["security"] = new security();
			}
		}

		public function connect() {
			$room = $this->modules["function"]->fetchRoomDetails($this->room);
			$this->modules["socket"]->socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
			if(!is_resource($this->modules["socket"]->socket))
				$this->modules["console"]->error("Failed to create a socket.");
			if(!socket_connect($this->modules["socket"]->socket, $room["ip"], $room["port"]))
				$this->modules["console"]->error("Failed to connect socket to ".$room["ip"].":".$room["port"]);
		}

		public function login() {
			/*
			For some reason xat is blocking authentication requests, and returns a bad
			login response, so we'll statically send our details for now

			$this->modules["socket"]->write("y", array("r" => $this->room,
											"m" => 1,
										    "v" => 0,
										    "u" => $this->cid
			));

			$this->handshake = $this->modules["socket"]->listen(true, false);

			$this->modules["socket"]->write("v", array("r" => $this->room,
											"p" => "$".crc32($this->bot["password"]), // custom mcrypt not implemented yet
										    "n" => $this->bot["name"]
			));

			$this->login = $this->modules["socket"]->listen(true, false);
			*/

			$this->login = array("k1" => "", "k3" => "", // removed for security
								 "d0" => "1024", "d2" => "1480821002", "d3" => "5579424", "dt" => "1428282611", "i" => "1404875158",
								 "n" => "TheTestingBotl0l", "");
		}

		public function join() {
			$j2 = $this->modules["function"]->buildJ2($this->handshake, $this->login, $this->lists->{"disabled"});
			$this->modules["socket"]->write("j2", $j2);
			$jnk1  = $this->handshake = $this->modules["socket"]->listen(false, false);
			$past  = $this->handshake = $this->modules["socket"]->listen(false, false);
			$past2 = $this->handshake = $this->modules["socket"]->listen(false, false);
			$past  = explode(">", $past.$past2);
			$this->modules["function"]->handlePastUsers($past);
		}

		public function freeMemory() {
			unset($this->handshake);
			unset($this->cryptkey);
			unset($this->config);
			unset($this->login);
		}

		public function run() {
			do {
				$read = $this->modules["socket"]->listen(true, true);
			} while($read != "");
		}
	}
?>
