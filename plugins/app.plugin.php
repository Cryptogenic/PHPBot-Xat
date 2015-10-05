<?php
	function appCommand($data) {
		global $bot;

		$info    = explode(" ", $data["message"], 2);
		$message = $info[1];

		$i = array(
			"youtube" 			=> "10001",
			"doodle" 			=> "10000",
			"trade" 			=> "30008", 
			"c4" 				=> "20010",
			"connect4" 			=> "20010",
			"grid"				=> "30004",
			"translator" 		=> "20034",
			"spacewar" 			=> "60201",
			"matchrace" 		=> "60193",
			"doodlerace" 		=> "60189",
			"snakerace" 		=> "60195"
		);
		
		if($message == "close") {
			$bot->modules["function"]->restart();
		} else {
			if(array_key_exists($message, $i))
			{
				$uid   = $bot->cid;
				$app = $i[$message];
				$bot->modules["socket"]->write("x", array(
		 									   "i" => $app,
		 									   "u" => $bot->cid
		 		));
			}
		}
	}
?>