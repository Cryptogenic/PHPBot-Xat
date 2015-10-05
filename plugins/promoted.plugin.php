<?php
	function promotedCommand($data) {
		global $bot;
	
		$info    = explode(" ", $data["message"], 2);
		$message = $info[1];

		$promo = json_decode(file_get_contents("http://xat.com/json/promo.php"));

		switch(strtolower(trim($message))) {
			case "english":
			case "en":
				$lang = $promo->en;
				$language = "English";
				break;
			case "spanish":
			case "es":
				$lang = $promo->es;
				$language = "Spanish";
				break;
			case "italian":
			case "it":
				$lang = $promo->it;
				$language = "Italian";
				break;
			case "arabic":
			case "ar":
				$lang = $promo->ar;
				$language = "Arabic";
				break;
			case "french":
			case "fr":
				$lang = $promo->fr;
				$language = "French";
				break;
			default:
				$lang = $promo->en;
				$language = "English";
				break;
		}

		$count = 0;

		foreach($lang as $k=>$Group) {
			$Group->n        = str_replace("Game\n", "Game", $Group->n);
			$promotedTime    = ($Group->t - time());
			$promotedHours   = intval($promotedTime / 3600);
			$promotedMins    = intval(($promotedTime / 60) % 60);

			$m1 = " hours, ";
			$m2 = " minutes left";

			if($promotedTime < 0){
				$promotedMessage = "Auto Promoted";
				$m2 = "";
			}

			if($promotedHours >= 1) {
				$msg .= $Group->n. " [".$promotedHours.$m1.$promotedMins.$m2."] | ";
			} else {
				$msg .= $Group->n. " [".$promotedMins.$m2."] | ";
			}
			
			$count++;
		}

		$msg = trim($msg, " | ");

		$output = ($count > 0) ? $msg : "There are currently no ".$language." promoted chats.";
		
		$bot->modules["socket"]->write("m", array("t" => $output,
												  "u" => $bot->cid
		));
	}
?>