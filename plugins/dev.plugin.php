<?php
	function devCommand($data) {
		global $bot;

		$uid       = $bot->modules["function"]->purifyXatID($data["user"]);
		$info      = explode(" ", $data["message"], 3);
		$operation = $info[1];
		$parameter = $info[2];

		if(!in_array($uid, $bot->admins)) return false;

		switch($operation) {
			case "mem":
			case "memory":
				$memory = round(memory_get_usage(true)/1048576, 2);

				$bot->modules["socket"]->write("m", array(
											   "t" => "[DEBUG] I am using ".$memory."mb of memory.",
											   "u" => $bot->cid
				));

				break;
			case "cmdcount":
				$count = count($bot->commands);

				$bot->modules["socket"]->write("m", array(
											   "t" => "[DEBUG] There are ".$count." commands active.",
											   "u" => $bot->cid
				));

				break;
			case "die":
				$bot->modules["console"]->error("Killed by a developer.");
				break;
			case "botid":
			case "id":
				$bot->modules["socket"]->write("m", array(
											   "t" => "This bot's ID is [".$bot->bid."].",
											   "u" => $bot->cid
				));
				break;
			case "start":
				$id = $parameter;

				$pid     = $bot->bot["pid"];
				$pidTest = exec("ps -p ".$pid);

				$errors = array();

				!is_numeric($id) ? array_push($errors, "Bot ID must be numeric!") : null;
				empty($bot->modules["database"]->fetchInformation("bots", "*", "id", $id)) ? array_push($errors, "Bot ID does not exist!") : null;
				
				if(strpos($pidTest, $pid) !== false) {
					array_push($errors, "Bot [".$id."] is already running.");
				}

				if(empty($errors)) {
					exec("nohup php /bot/v0.2/start.php ".$id." > /dev/null &1 &");
					$write = "Bot [".$id."] has been started.";
				} else {
					$write = $errors[0];
				}

				$bot->modules["socket"]->write("m", array(
											   "t" => $write,
											   "u" => $bot->cid
				));
				break;
			case "kill":
			case "stop":
				$id = $parameter;

				$pid     = $bot->bot["pid"];
				$pidTest = exec("ps -p ".$pid);

				$errors = array();

				!is_numeric($id) ? array_push($errors, "Bot ID must be numeric!") : null;
				empty($bot->modules["database"]->fetchInformation("bots", "*", "id", $id)) ? array_push($errors, "Bot ID does not exist!") : null;
				
				if(strpos($pidTest, $pid) === false) {
					array_push($errors, "Bot [".$id."] isn't running.");
				}

				if(empty($errors)) {
					exec("kill -15 ".$pid);
					$write = "Bot [".$id."] has been killed/stopped.";
				} else {
					$write = $errors[0];
				}

				$bot->modules["socket"]->write("m", array(
											   "t" => $write,
											   "u" => $bot->cid
				));
				break;
			case "restart":
				$id = $parameter;

				$pid     = $bot->bot["pid"];
				$pidTest = exec("ps -p ".$pid);

				$errors = array();

				!is_numeric($id) ? array_push($errors, "Bot ID must be numeric!") : null;
				empty($bot->modules["database"]->fetchInformation("bots", "*", "id", $id)) ? array_push($errors, "Bot ID does not exist!") : null;
				
				if(strpos($pidTest, $pid) === false) {
					array_push($errors, "Bot [".$id."] isn't running.");
				}

				if(empty($errors)) {
					exec("kill -15 ".$info["PID"]);
					exec("nohup php /bot/v0.2/start.php ".$id." > /dev/null &1 &");
					$write = "Bot [".$id."] has been restarted.";
				} else {
					$write = $errors[0];
				}

				$bot->modules["socket"]->write("m", array(
											   "t" => $write,
											   "u" => $bot->cid
				));
				break;
			case "status":
				$id = $parameter;

				$pid     = $bot->bot["pid"];
				$pidTest = exec("ps -p ".$pid);

				$errors = array();

				!is_numeric($id) ? array_push($errors, "Bot ID must be numeric!") : null;
				empty($bot->modules["database"]->fetchInformation("bots", "*", "id", $id)) ? array_push($errors, "Bot ID does not exist!") : null;

				if(strpos($pidTest, $pid) !== false) {
					$status = "Bot [".$id."] is currently online.";
				} else {
					echo "test".PHP_EOL.var_dump($pidTest).PHP_EOL.$pid.PHP_EOL;
					$status = "Bot [".$id."] is currently offline.";
				}

				if(empty($errors)) {
					$write = $status;
				} else {
					$write = $errors[0];
				}

				$bot->modules["socket"]->write("m", array(
											   "t" => $write,
											   "u" => $bot->cid
				));
				break;
			default:
				$bot->modules["socket"]->write("m", array(
											   "t" => "Yes, you have access to developer commands.",
											   "u" => $bot->cid
				));
				break;
		}
	}
?>