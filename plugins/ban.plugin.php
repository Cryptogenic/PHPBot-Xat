<?php
	function banCommand($data) {
		global $bot;

		$info    = explode(" ", $data["message"], 4);
		$user    = $info[1];
		$hours   = $info[2];
		$reason  = $info[3];

		$information = array("hours" => $hours, "reason" => $reason);

		foreach($bot->users as $u) {
			if((string)$u->id == (string)$bot->modules["function"]->purifyXatID($user)) {
				$u->ban($information);
			}
		}
	}
?>