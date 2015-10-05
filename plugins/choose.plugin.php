<?php 
	function chooseCommand($data) {
		global $bot;
		
		$info    = explode(" ", $data["message"], 2);
		$message = $info[1];
	
		$params  = array_map("trim", explode(" or ", $message));
		
		$chosen = $params[array_rand($params)];
		$bot->modules["socket"]->write("m", array(
												"t" => "I have chosen ". $params[array_rand($params)] .".",
												"u" => $bot->cid
		));
	}
?>