<?php
	function delistcheckCommand($data) {
		global $bot;

		$info = explode(" ", $data["message"], 2);
		$chat = $info[1];

		$message = $bot->modules["function"]->delistCheck($chat) ? "appears to be delisted. You cannot promote the chat." : "is not delisted. You may promote the chat.";
		
		$bot->modules["socket"]->write("m", array("t" => $chat." ".$message,
												  "u" => $bot->cid
		));
	}
?>