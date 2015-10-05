<?php
	define("BANNED",   -1);
	define("GUEST",     0);
	define("MEMBER",    1);
	define("MODERATOR", 2);
	define("OWNER",     3);
	define("MAIN",      4);
	define("VERIFIED",  5);
	define("BOTOWNER",  6);
	define("SUPPORT",   7);
	define("ADMIN",     8);

	class functions {

		public function __construct($parent) {
			$this->parent = &$parent;
		}

		public function fetchRoomDetails($room) {
			srand($room);
	        $json = json_decode(file_get_contents("http://xat.com/web_gear/chat/ip2.htm"), true);
	        $arr  = $json[F0];
	        $dom  = $arr[rand(1, count($arr) - 1)];
	        $ip   = $dom[array_rand($dom)];
	        $port = 10000 + rand(0, 38);

	        if((integer)$arg1 == 8) {
	            $port = 10000;
	        }

	        return array("ip" => $ip, "port" => $port);
		}

		public function buildJ2($handshake, $details, $disabledPowers) {
			$j2 = array();
			$dp = $disabledPowers;

			$disabled = array();

			for($di = 0; $di < 300; $di++) {
				if(isset($dp->{$di})) {
					array_push($disabled, $di);
				}
			}

			$m = $this->verifyPowers($disabled);

			$j2["cb"] = $handshake["c"];
			$j2["y"]  = $handshake["i"];
			$j2["q"]  = 1;
			$j2["k"]  = $details["k1"];
			$j2["k3"] = $details["k3"];
			$j2["p"]  = 0;

			if(isset($details['d1']))
				$j2["d1"] = $details["d1"];

			$j2["c"]  = $this->parent->room;
			$j2["r"]  = "";
			$j2["f"]  = 0;
			$j2["e"]  = "";
			$j2["u"]  = $details["i"];

			for($i = 0; $i <= 25; $i++) {
				if(isset($m[$i])) {
					$j2["m".$i] = $m[$i];
				}
				if(isset($details["d".$i]) && $i != 1) {
					$j2["d".$i] = $details["d".$i];
				}
			}

			if(isset($details['dO']))
				$j2["dO"] = $details["dO"];
			if(isset($details['dx']))
				$j2["dx"] = $details["dx"];
			if(isset($details['dt']))
				$j2["dt"] = $details["dt"];

			$j2["N"]  = $details["n"];
			$j2["n"]  = $this->buildNick($this->parent->settings);
			$j2["a"]  = $this->parent->settings->{'avatar'};
			$j2["h"]  = $this->parent->settings->{'home'};
			$j2["a"]  = "";
			$j2["h"]  = "";
			$j2["v"]  = 0;

			return $j2;
		}

		public function verifyPowers($disabled) {
			foreach($disabled as $d) {
				$section = $d >> 5;
				$subid   = pow(2, $d % 32);

				$m[$section] += $subid;
			}
			return $m;
		}

		public function buildNick($settings) {
			return str_replace(' ', ' ', $settings->{"name"});
		}

		public function restart() {
			$protectPID = $this->parent->bot["pid"];
			$this->parent->bot = $this->parent->modules["database"]->fetchInformation("bots", "*", "id", $bid);
			$this->parent->bot["pid"] = $protectPID;
			$this->disconnect();
			$this->parent->connect();
			$this->parent->login();
			$this->parent->join();
		}

		public function disconnect() {
			if (is_resource($this->parent->modules["socket"]->socket)){
				socket_close($this->parent->modules["socket"]->socket);
				socket_shutdown($this->parent->modules["socket"]->socket, 2);
				$this->parent->modules["socket"]->socket = NULL;
			}
		}

		public function createUser($details) {
			array_push($this->parent->users, new user($this->parent, $details));
		}

		public function convertChatRank($id, $f, $includeAcc) {
			if(in_array($id, $this->parent->admins))
				return ADMIN;

			if(in_array($id, $this->parent->support))
				return SUPPORT;

			if($includeAcc) {
				if($this->parent->acclist->{$id}) {
					return $this->parent->acclist->{$id};
				}
			}

			if(($f & 7) == 1) return MAIN;
			if(($f & 7) == 2) return MODERATOR;
			if(($f & 7) == 3) return MEMBER;
			if(($f & 7) == 4) return OWNER;
			if($f & 16)       return BANNED;
			                  return GUEST;
		}

		public function purifyXatID($id) {
			if(strpos($id, "_")) {
				$newid = explode("_", $id);
				return $newid[0];
			} else {
				return $id;
			}
		}

		public function verifyRank($rank, $command) {
			$verification = $this->parent->minranks->{$command};

			if($rank >= $verification) {
				return true;
			}
			return false;
		}

		public function delistCheck($chat) {
			$res = file_get_contents('http://xat.com/web_gear/chat/promotion.php?YourEmail=testdelisted1&password=testdelisted1&GroupName='.$chat.'&Hours=1&Xats=200&Promote');
			if(stristr($res, '**<span data-localize=buy.promona>Sorry, promotion not available</span>**'))
				return true;
			return false;
		}

		public function purifyRank($rank) {
			switch($rank) {
				case BANNED:
					return "banned";
					break;
				case GUEST:
					return "guest";
					break;
				case MEMBER:
					return "member";
					break;
				case MODERATOR:
					return "moderator";
					break;
				case OWNER:
					return "owner";
					break;
				case MAIN:
					return "main owner";
					break;
				case VERIFIED:
					return "verified";
					break;
				case BOTOWNER:
					return "bot owner";
					break;
				case SUPPORT:
					return "support";
					break;
				case ADMIN:
					return "administrator";
					break;
			}
			return "undetermined";
		}

		public function handlePastUsers($packets) {
			foreach($packets as $p) {
				if($p[2] == "u") {
					$p .= ">".chr(0);

					$nameandnick = $this->stribet($p, "n=\"", '" a="');
					$nameandnick = str_replace("\" n=\"", ":", $nameandnick);
					$nameandnick = explode(":", $nameandnick, 2);

					$name = $nameandnick[0];
					$nick = $nameandnick[1];

					$array = array("id"       => $this->stribet($p, "u=\"", "\""),
								   "username" => $name,
								   "nickname" => $nick,
								   "avatar"   => $this->stribet($p, "a=\"", "\""),
								   "home"     => $this->stribet($p, "h=\"", "\""),
								   "f"        => $this->stribet($p, "f=\"", "\""),
								   "rank"     => $this->convertChatRank($this->stribet($p, "u=\"", "\""), $this->stribet($p, "f=\"", "\""), true),
								   "room"     => $this->parent->room);
					$this->createUser($array);
					$this->parent->count++;
				}
			}
		}

		public function handlePacket($data) {
			$packetTags = $this->parent->packetTags;

			if(is_object($data)) {
				if(in_array($data->getName(), $packetTags)) {
					$function = strtolower($data->getName()).'Packet';
					$function($data);
				}
			}
		}

		public function handleCommand($data, $sender) {
			$commands = $this->parent->commands;

			$info     = explode("!", $data, 2);
			$command  = explode(" ", $info[1]);

			$rank = 0;

			foreach($this->parent->users as $u) {
				if((string)$u->id == (string)$this->purifyXatID($sender)) {
					$rank = $u->rank;
				}
			}

			$data = str_replace($this->parent->settings->{"cmdchar"}, "", $data);
			$data = array("message" => $data, "user" => $sender);

			if(in_array(strtolower($command[0]), $commands)) {
				if($this->verifyRank($rank, $command[0])) {
					$function = strtolower($command[0]).'Command';
					$function($data);
				} else {
					$this->parent->modules["socket"]->write("p", array("u" => $sender,
															  		   "t" => "You are not the required rank to use this command.",
															  		   "d" => $this->parent->cid
					));
				}
			}
		}

		public function stribet($inputstr, $delimiterLeft, $delimiterRight) {
			$posLeft = stripos($inputstr, $delimiterLeft) + strlen($delimiterLeft);
			$posRight = stripos($inputstr, $delimiterRight, $posLeft);
			return substr($inputstr, $posLeft, $posRight - $posLeft);
		}
	}
?>
