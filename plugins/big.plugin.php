<?php
	function bigCommand($data) {
		global $bot;

		$chat = $bot->room;
		$link = "http://www.xatech.com/web_gear/chat/chat.swf?id=".$chat;

		$bot->modules["socket"]->write("m", array(
 									   "t" => "To view this chat in fullscreen, click this link: ".$link,
 									   "u" => $bot->cid
 		));
	}
?>