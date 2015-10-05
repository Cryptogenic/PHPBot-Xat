<?php
	function uPacket($data) {
		global $bot;

		/*if(isset($bot->lastUserJoined)) {
			if($bot->lastUserJoined > time()) {
				 //<m t="/p3600" d="1472300041" T=" "  />
				$bot->modules["socket"]->write("m", array("t" => "/p3600",
														  "d" => $bot->cid,
														  "T" => ""
				));

				$bot->modules["socket"]->write("c", array("p" => "Raid Protection Activated.",
														  "u" => $data["id"],
														  "t" => "/k"
				));
			}
		}
		$bot->lastUserJoined = time() + 2.5;*/

		$id   = $data["u"];
		$name = $data["N"];
		$nick = $data["n"];
		$pic  = $data["a"];
		$home = $data["h"];
		$f    = $data["f"];
		$cb   = $data["cb"];
		$rank = $bot->modules["function"]->convertChatRank($id, $f, true);

		$member = false;

		$welcomeWords = array("[user]" => $name,
							  "[nick]" => $nick,
							  "[users]" => $bot->count,
							  "[home]"  => $home,
							  "[rank]"  => $rank,
							  "[id]"    => $id,
							  "[cb]"    => $cb,
							  "[group]" => $bot->room
		);

		$bot->modules["database"]->updateInformation("userinfo", array("id"       => $id,
																	   "username" => $name,
																	   "nickname" => $nick,
																	   "avatar"   => $pic,
																	   "home"     => $home,
																	   "f"        => $f,
																	   "rank"     => $rank,
																	   "room"     => $bot->room
		));

		if(isset($bot->settings->{"autowelcome"})) {
			if(!strpos($packet, 's="')) {
				$bot->modules["socket"]->write("p", array("u" => $id,
														  "t" => strtr($bot->settings->{'autowelcome'}, $welcomeWords),
														  "d" => $bot->cid
				));
			}
		}

		if(!isset($data["s"])) {
			switch($bot->settings->{"automember"}) {
				case 1:
					if($rank == 0) {
						$member = true;
					}
					break;
				case 2:
					if($rank == 0 && isset($name)) {
						$member = true;
					}
					break;
				case 3:
					if($rank == 0 && isset($name) && isset($data["p0"])) {
						$member = true;
					}
					break;
				default:
					$member = false;
			}
		}

		if($member) {
			$bot->modules["socket"]->write("p", array("u" => $id,
													  "t" => "/e",
													  "s" => "2",
													  "d" => $bot->cid
			));
		}

		$bot->modules["function"]->createUser(array("id"       => $id,
											  		"username" => $name,
											  		"nickname" => $nick,
											  		"avatar"   => $pic,
											  		"home"     => $home,
											  		"f"        => $f,
											  		"rank"     => $rank,
											  		"room"     => $bot->room
		));

		$bot->count++;

		echo "[SERVER] A user has joined the chat [Users: ".$bot->count."].".PHP_EOL.PHP_EOL;
	}
?>