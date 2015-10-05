<?php
	function iPacket($data) {
		global $bot;

		$rank = $data["r"];

		switch($rank) {
			case 1: // Main Owner
				$crank = 4;
				break;
			case 2: // Moderator
				$crank = 2;
				break;
			case 3: // Member
				$crank = 1;
				break;
			case 4: // Owner
				$crank = 4;
				break;
			default: // Guest
				$crank = 0;
				break;
		}

		$bot->crank = $crank;
	}
?>