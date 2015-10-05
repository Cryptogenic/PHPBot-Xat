<?php
	function aPacket($data) {
		global $bot;

		if($data["k"] == "t") {
			$sent = $data["b"];
			$from = $data["u"];
			$xats = $data["x"];
			$days = $data["s"];

			if(!is_numeric($xats)) $xats = 0;
			if(!is_numeric($days)) $days = 0;

 			if($bot->room == "24572350" && $sent == "1404875158") {
 				$bot->modules["socket"]->write("m", array(
 											   "t" => $from." has donated ".$xats." and ".$days." to AdvBots!",
 											   "u" => $bot->cid
 											   ));
			} else {
				$bot->modules["socket"]->write("m", array(
 											   "t" => $from." has donated ".$xats." and ".$days." to ".$sent,
 											   "u" => $bot->cid
 											   ));
			}
			echo "[CLIENT] Transfer detected [".$from."->".$sent." ".$xats." xats, ".$days." days].".PHP_EOL.PHP_EOL;
		}
	}
?>