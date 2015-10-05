<?php
	function sayCommand($data) {
		global $bot;

		$info    = explode(" ", $data["message"], 2);
		$message = $info[1];

		$bot->modules["socket"]->write("m", array(
 									   "t" => $message,
 									   "u" => $bot->cid
 		));
	}
?>