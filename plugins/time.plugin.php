<?php
	function timeCommand($data) {
		global $bot;

		$time = time() - $bot->time;
		echo $time.PHP_EOL;
		$days = intval($time / 86400);
		$hour = intval($time / 3600);
		$min  = intval(($time / 60) % 60);
		$sec  = intval($time % 60);

		$build  = "";
		$build .= $days > 0 ? $days." days, " : "";
		$build .= $hour > 0 ? $hour." hours, " : "";
		$build .= $min > 0 ? $min." minutes, " : "";
		$build .= $sec > 0 ? $sec." seconds." : "";

		$bot->modules["socket"]->write("m", array(
 									   "t" => $build,
 									   "u" => $bot->cid
 		));
	}
?>