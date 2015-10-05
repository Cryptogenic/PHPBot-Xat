<?php
	function clearCommand($data) {
		global $bot;
		
		$bot->modules["socket"]->write("m", array(
	 								   "t" => "The chat has been cleared, refresh for a clean window.",
	 								   "u" => $bot->cid
	 	));
		while($x <= 20){
			$bot->modules["socket"]->write("m", array(
	 									   "t" => "/d".$x,
	 									   "u" => $bot->cid
	 		));
			$x++;
			usleep(100000);
		}
	}
?>