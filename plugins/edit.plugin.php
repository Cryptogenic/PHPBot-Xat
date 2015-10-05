<?php
	function editCommand($data) {
		global $bot;

		$info      = explode(" ", $data["message"], 3);
		$operation = $info[1];
		$parameter = $info[2];

		switch($message) {
			case "nick":
			case "name":
				$bot->settings->{"name"} = $parameter;
				break;
			case "avatar":
			case "pic":
				$bot->settings->{"avatar"} = $parameter;
				break;
			case "home":
			case "link":
				$bot->settings->{"home"} = $parameter;
				break;
			case "automember":
			case "member":
				$bot->settings->{"automember"} = $parameter;
				break;
			case "autowelcome":
			case "welcome":
				$bot->settings->{"autowelcome"} = $parameter;
				break;
			case "cmdchar":
			case "cmd":
				$bot->settings->{"cmdchar"} = $parameter;
				break;
			default:
				$error = "Options: [name/nick], [avatar/pic], [home/link], [automember/member], [autowelcome/welcome], [cmdchar/cmd]";
				break;
		}

		if(!isset($error)) {
			$settings = json_encode($bot->settings);
			$bot->modules["database"]->updateInformation("bots", array("settings" => $settings), "id", $this->bid);
			$bot->modules["function"]->restart();
		} else {
			$bot->modules["socket"]->write("m", array("t" => $error,
													  "u" => $bot->cid
			));
		}
	}
?>