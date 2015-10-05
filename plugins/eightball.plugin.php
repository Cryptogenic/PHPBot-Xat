<?php 
	function eightballCommand($data) {
		global $bot;
		
		$info    = explode(" ", $data["message"], 2);
		$message = $info[1];
	
		$options = array("Signs point to yes.","Yes.","Reply hazy, try again.","Without a doubt.","My sources say no.","As I see it, yes.","You may rely on it.","Concentrate and ask again.","Outlook not so good.","It is decidedly so.","Better not tell you now.","Very doubtful.","Yes - definitely.","It is certain.","Cannot predict now.","Most likely.","Ask again later.","My reply is no.","Outlook good.","Don't count on it.");
		
		$chosen = $options[array_rand($options)];
		$bot->modules["socket"]->write("m", array(
												"t" => $chosen,
												"u" => $bot->cid
		));
	}
?>