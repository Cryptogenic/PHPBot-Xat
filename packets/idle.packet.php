<?php
	function idlePacket($data) {
		global $bot;

		echo "[SERVER] Idle packet recieved, restarting bot.".PHP_EOL.PHP_EOL;
		$bot->modules["function"]->restart();
	}
?>