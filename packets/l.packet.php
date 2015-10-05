<?php
	function lPacket($data) {
		global $bot;

		foreach($bot->users as $u) {
			if((string)$u->id == (string)$bot->modules["function"]->purifyXatID($data["u"])) {
				echo "Unsetting User...".PHP_EOL;
				unset($u);
			}
		}
		$bot->count--;
		echo "[SERVER] A user has left the chat [Users: ".$bot->count."].".PHP_EOL.PHP_EOL;
	}
?>