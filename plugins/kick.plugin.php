<?php
	function kickCommand($data) {
		global $bot;

		$info    = explode(" ", $data["message"], 3);
		$user    = $info[1];
		$reason  = $info[2];

		$information = array("reason" => $reason);

		foreach($bot->users as $u) {
			if((string)$u->id == (string)$bot->modules["function"]->purifyXatID($user)) {
				$u->kick($information);
			}
		}
	}
?>