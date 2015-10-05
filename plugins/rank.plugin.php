<?php
	function rankCommand($data) {
		global $bot;

		$rank = 0;

		foreach($bot->users as $u) {
			if((string)$u->id == (string)$bot->modules["function"]->purifyXatID($data["user"])) {
				$rank = $u->rank;
			}
		}

		$message = "Your access level is currently: ".ucfirst($bot->modules["function"]->purifyRank($rank)).".";

		$bot->modules["socket"]->write("m", array(
 									   "t" => $message,
 									   "u" => $bot->cid
 		));
	}
?>