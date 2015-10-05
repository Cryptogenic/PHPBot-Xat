<?php
	function mPacket($data) {
		global $bot;

		/*if(isset($bot->lastMessage)) {
			if($bot->lastMessage > time()) {
				 //<m t="/p3600" d="1472300041" T=" "  />
				$bot->modules["socket"]->write("c", array("p" => "Raid Protection Activated.",
														  "u" => $data["u"],
														  "t" => "/k"
				));
			}
		}
		$bot->lastMessage = time() + 0.5;*/

		if($bot->settings->{"suspended"} == 1) {
			$bot->modules["socket"]->write("m", array(
 										   "t" => "Your bot has been suspended. Please contact an owner at xat.com/programming",
 										   "u" => $bot->cid
 			));
			$bot->modules["console"]->error("Bot has been suspended");
		}

		if(substr($data["t"], 0, 1) == $bot->settings->{"cmdchar"}) {
			$bot->modules["function"]->handleCommand($data["t"], $data["u"]);
			echo "[SERVER] A command has been sent to the bot [".$data["u"].": ".$data["t"]."].".PHP_EOL;
		} else {
			echo "[SERVER] A message has been sent to the chat [".$data["u"].": ".$data["t"]."].".PHP_EOL;
		}
	}
?>
