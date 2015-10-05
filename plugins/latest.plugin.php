<?php
	function latestCommand($data) {
		global $bot;

		$pow2    = file_get_contents('http://xat.com/web_gear/chat/pow2.php?');
		$pow2    = json_decode($pow2, true);
		$name    = array_search($pow2['0']['1']['id'], $pow2['5']['1']);
		$message = $pow2[0][1]['text'];

		$message = "The latest power ID is ".$pow2[0][1]["id"]." and is named ".$name;

		$bot->modules["socket"]->write("m", array("t" => $message,
												  "u" => $bot->cid
		));
	}
?>